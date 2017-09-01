<?php

namespace App\Http\Controllers\Account;

use App\Account\AccountGroup;
use App\Account\AccountGroupRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    /**
     * @var AccountGroupRepositoryInterface
     */
    private $groupRepository;

    /**
     * GroupController constructor.
     * @param AccountGroupRepositoryInterface $groupRepository
     */
    public function __construct(AccountGroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = $this->groupRepository->findByPaginate($request->get('per_page'), $request->all());

        return response()->json([
            'model' => $groups
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function others($id, Request $request)
    {
        $groups = $this->groupRepository->findByListWhere($id, $request->get('q'));

        return response()->json([
            'lists' => $groups
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->valid($request);

        $parameters = $request->all();

        if($request->has('root'))
        {
            $parameters['root_id'] = $parameters['root']['id'];
        }

        if($parameters['id'] == 0)
        {
            AccountGroup::create($parameters);
        }
        else
        {
            $group = $this->groupRepository->findById($parameters['id']);

            $group->update($parameters);
        }

        return response()->json([
            'result' => true
        ]);
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
        $group = $this->groupRepository->findById($id);

        return response()->json([
            'result' => $group->delete()
        ]);
    }

    public function journalGroups($id)
    {
        $groups = $this->groupRepository->findJournalGroups($id)->toArray();

        return response()->json([
            'groups' => $groups
        ]);
    }

    /**
     * @param $request
     */
    private function valid($request)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required|unique:account_group,code,'.$request->get('id')
        ]);
    }
}
