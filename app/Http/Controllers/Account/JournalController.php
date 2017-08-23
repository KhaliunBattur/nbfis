<?php

namespace App\Http\Controllers\Account;

use App\Account\Journal;
use App\Account\JournalRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JournalController extends Controller
{
    /**
     * @var JournalRepositoryInterface
     */
    private $journalRepository;

    /**
     * JournalController constructor.
     * @param JournalRepositoryInterface $journalRepository
     */
    public function __construct(JournalRepositoryInterface $journalRepository)
    {

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
        $journals = $this->journalRepository->findByPaginate($request->get('per_page'), $request->all());

        return response()->json([
            'model' => $journals
        ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:journal,name,'.$request->get('id')
        ]);

        if($request->has('root'))
        {
            $root = $request->get('root');

            $request->request->add(['root_id' => $root['id']]);
        }

        if($request->get('id') == 0)
        {
            $journal = Journal::create($request->all());

            return response()->json([
                'result' => !is_null($journal)
            ]);

        }else
        {
            $journal = $this->journalRepository->findById($request->get('id'));

            return response()->json([
                'result' => $journal->update($request->all())
            ]);
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
        $journal = $this->journalRepository->findById($id);

        return response()->json(['result' => $journal->delete()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function lists(Request $request)
    {
        $ignore = 0;

        if($request->has('ignore'))
        {
            $ignore = $request->get('ignore');
        }

        $journals = $this->journalRepository->search($request->get('q'), $ignore);

        return response()->json([
            'lists' => $journals
        ]);
    }
}
