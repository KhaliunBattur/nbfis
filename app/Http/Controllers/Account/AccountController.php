<?php

namespace App\Http\Controllers\Account;

use App\Account\Account;
use App\Account\AccountGroupRepositoryInterface;
use App\Account\AccountRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    /**
     * @var AccountRepositoryInterface
     */
    private $accountRepository;
    /**
     * @var AccountGroupRepositoryInterface
     */
    private $groupRepository;

    /**
     * AccountController constructor.
     * @param AccountRepositoryInterface $accountRepository
     * @param AccountGroupRepositoryInterface $groupRepository
     */
    public function __construct(AccountRepositoryInterface $accountRepository, AccountGroupRepositoryInterface $groupRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->groupRepository = $groupRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $groups = $this->groupRepository->findParents();
        $array = [];
        foreach ($groups as $key => $group)
        {
            $array[$key] = $group->toArray();
            if($group->children->count())
            {
                $array[$key]['children'] = $this->recursive($group->children);
            }
            if($group->accounts->count())
            {
                $array[$key]['accounts'] = $group->accounts()->with(['currency', 'journal', 'group', 'bank'])->get()->toArray();
            }
        }

        return response()->json([
            'model' => $array
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $parameters = $request->all();

//        $request->request->add(['account_number' => $parameters['group']['code'] . $parameters['code']]);

        $this->valid($request);

        $parameters['account_number'] = $request->get('account_number');

        $parameters['group_id'] = $parameters['group']['id'];
        $parameters['journal_id'] = $parameters['journal']['id'];
        $parameters['currency_id'] = $parameters['currency']['id'];

        if($request->has('bank'))
        {
            $parameters['bank_id'] = $parameters['bank']['id'];
        }

        if($parameters['id'] == 0)
        {
            $account = Account::create($parameters);
        }
        else
        {
            $account = $this->accountRepository->findById($parameters['id']);
            $account->update($parameters);
        }

        return response()->json([
            'result' => !is_null($account)
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $account = $this->accountRepository->findById($id);

        return response()->json([
            'result' => $account->delete()
        ]);
    }

    /**
     * @param $children
     * @return array
     */
    private function recursive($children)
    {
        $array = [];
        foreach ($children as $key => $child)
        {
            $array[$key] = $child->toArray();
            if($child->children->count())
            {
                $array[$key]['children'] = $this->recursive($child->children);
            }
            if($child->accounts->count())
            {
                $array[$key]['accounts'] = $child->accounts()->with(['currency', 'journal', 'group', 'bank'])->get()->toArray();
            }
        }

        return $array;
    }

    /**
     * @param $request
     */
    private function valid($request)
    {
        $roles = [
            'name' => 'required',
            'account_number' => 'required|unique:account,account_number,'.$request->get('id'),
            'journal' => 'required',
            'currency' => 'required',
            'group' => 'required'
        ];

        if($request->has('bank'))
        {
            $roles['bank_account_number'] = 'required';
        }

        $this->validate($request, $roles);
    }
}
