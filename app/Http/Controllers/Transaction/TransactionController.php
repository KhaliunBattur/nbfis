<?php

namespace App\Http\Controllers\Transaction;

use App\Account\AccountGroupRepositoryInterface;
use App\Account\AccountRepositoryInterface;
use App\Account\JournalRepository;
use App\Season\Season;
use App\Season\SeasonRepositoryInterface;
use App\Transaction\Transaction;
use App\Transaction\TransactionRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;
    /**
     * @var AccountGroupRepositoryInterface
     */
    private $groupRepository;
    /**
     * @var AccountRepositoryInterface
     */
    private $accountRepository;
    /**
     * @var SeasonRepositoryInterface
     */
    private $seasonRepository;
    /**
     * @var JournalRepository
     */
    private $journalRepository;

    /**
     * TransactionController constructor.
     * @param TransactionRepositoryInterface $transactionRepository
     * @param AccountGroupRepositoryInterface $groupRepository
     * @param AccountRepositoryInterface $accountRepository
     * @param SeasonRepositoryInterface $seasonRepository
     * @param JournalRepository $journalRepository
     */
    public function __construct(TransactionRepositoryInterface $transactionRepository, AccountGroupRepositoryInterface $groupRepository, AccountRepositoryInterface $accountRepository, SeasonRepositoryInterface $seasonRepository, JournalRepository $journalRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->groupRepository = $groupRepository;
        $this->accountRepository = $accountRepository;
        $this->seasonRepository = $seasonRepository;
        $this->journalRepository = $journalRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transaction = $this->transactionRepository->findByPaginate($request->get('per_page'), $request->all());

        return response()->json([
            'transaction' => $transaction
        ]);
    }

    public function lists()
    {

        $accounts = $this->accountRepository->findByListRaw();

        return response()->json([
            'model' => $accounts
        ]);

//        $groups = $this->groupRepository->findParents();
//
//        $accounts = $this->accountRepository->findAll()->groupBy('id')->toArray();
//
//        $season = $this->seasonRepository->findCurrent();
//
//        $array = [];
//
//        foreach ($groups as $key => $group)
//        {
//            $groupArray = $group->toArray();
//            $groupArray['balance'] = 0;
//            $groupArray['active'] = 0;
//            $groupArray['passive'] = 0;
//            $array[$key] = $groupArray;
//            if($group->children->count())
//            {
//                $array[$key]['children'] = $this->recursive($group->children, $accounts, $season);
//            }
//            if($group->accounts->count())
//            {
//                $array[$key]['accounts'] = [];
//                foreach ($group->accounts()->with(['currency', 'journal', 'group', 'bank', 'breakdown'])->get() as $account)
//                {
//                    if(array_key_exists($account->getKey(), $accounts))
//                    {
//                        $accountArray = $account->toArray();
//                        $accountArray['balance'] = $account->balance($season);
//                        $accountArray['exchange'] = $accounts[$account->getKey()][0];
//                        array_push($array[$key]['accounts'], $accountArray);
//                    }
//                }
//            }
//        }
//
//        return response()->json([
//            'model' => $array
//        ]);
    }

    private function recursive($children, $accounts, $season)
    {
        $array = [];
        foreach ($children as $key => $child)
        {
            $groupArray = $child->toArray();
            $groupArray['balance'] = 0;
            $groupArray['active'] = 0;
            $groupArray['passive'] = 0;
            $array[$key] = $groupArray;
            if($child->children->count())
            {
                $array[$key]['children'] = $this->recursive($child->children, $accounts, $season);
            }
            if($child->accounts->count())
            {
                $array[$key]['accounts'] = [];
                foreach ($child->accounts()->with(['currency', 'journal', 'group', 'bank', 'breakdown', 'breakdown.transactionAble'])->get() as $account)
                {
                    if(array_key_exists($account->getKey(), $accounts))
                    {
                        $accountArray = $account->toArray();
                        $accountArray['balance'] = $account->balance($season);
                        $accountArray['exchange'] = $accounts[$account->getKey()][0];
                        array_push($array[$key]['accounts'], $accountArray);
                    }
                }
            }
        }

        return $array;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $season = $this->seasonRepository->findCurrentByObject();

        if(date_create($season->open_date) < date_create($request->get('transaction_date')))
        {
            if($request->get('journal') == 0)
            {
                return $this->saveGeneral($request, $season);
            }
            else
            {

            }
        }
        else
        {
            throw new \Exception('Тайлант үеийн огноо таарахгүй байна', 403);
        }
    }


    /**
     * @param Request $request
     * @param Season $season
     * @return \Illuminate\Http\JsonResponse
     */
    private function saveGeneral($request, $season)
    {
        $this->validate($request, [
            'receipt_number' => 'required',
            'transaction_date' => 'required',
            'customer_id' => 'required',
            'account_id' => 'required',
            'to_account_id' => 'required',
            'description' => 'required',
            'amount' => 'required|greater_than_zero'
        ]);

        try{

            $response = \DB::transaction(function() use ($request, $season){

                $request->request->add(['user_id' => \Auth::user()->getKey()]);
                $request->request->add(['season_id' => $season->getKey()]);

                //to transaction
                $parameters = $request->all();

                $account = $parameters['account_id'];
                $to_account = $parameters['to_account_id'];

                $parameters['account_id'] = $to_account;
                $parameters['to_account_id'] = $account;
                $parameters['type'] = $parameters['type'] == 'credit' ? 'debit' : 'credit';
                $parameters['transaction_number'] = $this->transactionRepository->getTransactionNumber($parameters['transaction_date']);

                $request->request->replace($parameters);
                Transaction::create($request->all());

                //transaction

                $parameters['account_id'] = $account;
                $parameters['to_account_id'] = $to_account;
                $parameters['amount'] = $parameters['amount'] * $parameters['exchange'] / $parameters['to_exchange'];
                $parameters['exchange'] = $parameters['to_exchange'];
                $parameters['type'] = $parameters['type'] == 'credit' ? 'debit' : 'credit';

                $request->request->replace($parameters);
                Transaction::create($request->all());

                return response()->json(['result' => true]);

            });

            return $response;

        }catch (\Exception $exception)
        {
            return response()->json(['message' => $exception->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
