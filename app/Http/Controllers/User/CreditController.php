<?php

namespace App\Http\Controllers\User;

use App\User\Credit\Credit;

use App\User\Credit\CreditRepositoryInterface;
use App\User\UserRepository;
use App\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreditController extends Controller
{
    private $CreditRepository;

    private $UserRepository;

    /**
     * CreditController constructor.
     * @param CreditRepositoryInterface $creditRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(CreditRepositoryInterface $creditRepository, UserRepositoryInterface $userRepository)
    {
        $this->CreditRepository = $creditRepository;
        $this->UserRepository = $userRepository;
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id, Request $request)
    {
        $credits = $this->CreditRepository->findByUserPaginate($id, $request->get('per_page'), $request->all());
        return response()->json([
            'credits' => $credits
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id, Request $request)
    {
        $this->valid($request);
        $parameters = $request->all();
        $parameters['user_id'] = $id;
        $credit = Credit::create($parameters);
        return response()->json(['result' => !is_null($credit)]);
    }

    /**
     * @param $id
     * @param $credit_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, $credit_id, Request $request)
    {
        $credit = $this->CreditRepository->findById($credit_id);
        return response()->json([
            'result' => $credit->update($request->all())
        ]);
    }

    /**
     * @param $id
     * @param $credit_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, $credit_id)
    {
        $credit = $this->CreditRepository->findById($credit_id);
        return response()->json(['result' => $credit->delete()]);
    }

    /**
     * @param $request
     */
    public function valid($request)
    {
        $this->validate($request, [
            'organization' => 'required',
            'loan_amount' => 'required',
            'loan_date' => 'required',
            'loan_interest' => 'required',
            'loan_balance' => 'required',
            'monthly_pay' => 'required'
        ]);
    }

}
