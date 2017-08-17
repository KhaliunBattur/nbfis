<?php

namespace App\Http\Controllers;

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
}
