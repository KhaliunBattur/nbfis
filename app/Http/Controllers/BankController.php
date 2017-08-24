<?php

namespace App\Http\Controllers;

use App\Support\Bank;
use App\Support\BankRepositoryInterface;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * @var BankRepositoryInterface
     */
    private $bankRepository;

    /**
     * BankController constructor.
     * @param BankRepositoryInterface $bankRepository
     */
    public function __construct(BankRepositoryInterface $bankRepository)
    {
        $this->bankRepository = $bankRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function lists(Request $request)
    {
        $banks = $this->bankRepository->search($request->get('q'));

        return response()->json([
            'lists' => $banks
        ]);
    }
    public function index(Request $request)
    {
        $banks = $this->bankRepository->findByPaginate($request->get('per_page'), $request->all());

        return response()->json([
            'model' => $banks
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:bank,name,'.$request->get('id')
        ]);

        if($request->get('id') == 0)
        {
            $bank = Bank::create($request->all());

            return response()->json([
                'result' => !is_null($bank)
            ]);

        }else
        {
            $bank = $this->bankRepository->findById($request->get('id'));

            return response()->json([
                'result' => $bank->update($request->all())
            ]);
        }
    }
    public function edit($id,Request $request)
    {

    }
    public function destroy($id)
    {
        $bank = $this->bankRepository->findById($id);
        return response()->json(['result'=>$bank->delete()]);
    }
}
