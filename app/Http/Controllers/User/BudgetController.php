<?php

namespace App\Http\Controllers\User;

use App\User\Budget\Budget;
use App\User\Budget\BudgetRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BudgetController extends Controller
{
    /**
     * @var BudgetRepositoryInterface
     */
    private $budgetRepository;

    /**
     * BudgetController constructor.
     * @param BudgetRepositoryInterface $budgetRepository
     */
    public function __construct(BudgetRepositoryInterface $budgetRepository)
    {
        $this->budgetRepository = $budgetRepository;
    }

    public function index($id)
    {
        return response()->json([
            'model' => $this->budgetRepository->findByUserAll($id)
        ]);
    }

    public function store($id, Request $request)
    {
        $parameters = $request->all();
        $parameters['user_id'] = $id;

        $budget = Budget::create($parameters);

        return response()->json([
            'result' => !is_null($budget)
        ]);
    }

    public function update($id, $budget_id, Request $request)
    {
        $budget = $this->budgetRepository->findById($budget_id);

        return response()->json([
            'result' => $budget->update($request->all())
        ]);
    }

    public function destroy($id, $budget_id)
    {
        $budget = $this->budgetRepository->findById($budget_id);

        return response()->json([
            'result' => $budget->delete()
        ]);
    }
}
