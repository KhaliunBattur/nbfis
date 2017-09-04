<?php

namespace App\Http\Controllers\User;

use App\User\Expense\Expense;
use App\User\Expense\ExpenseRepositoryInterface;
use App\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpenseController extends Controller
{
    /**
     * @var ExpenseRepositoryInterface
     */
    private $expenseRepository;

    /**
     * ExpenseController constructor.
     * @param ExpenseRepositoryInterface $expenseRepository
     */
    public function __construct(ExpenseRepositoryInterface $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    public function index($id)
    {
        return response()->json([
            'model' => $this->expenseRepository->findByUserAll($id)
        ]);
    }

    public function store($id, Request $request)
    {
        $parameters = $request->all();
        $parameters['user_id'] = $id;

        $expense = Expense::create($parameters);

        return response()->json([
            'result' => !is_null($expense)
        ]);
    }

    public function update($id, $expense_id, Request $request)
    {
        $expense = $this->expenseRepository->findById($expense_id);

        return response()->json([
            'result' => $expense->update($request->all())
        ]);
    }

    public function destroy($id, $expense_id)
    {
        $expense = $this->expenseRepository->findById($expense_id);

        return response()->json([
            'result' => $expense->delete()
        ]);
    }
}
