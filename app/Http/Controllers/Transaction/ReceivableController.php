<?php

namespace App\Http\Controllers\Transaction;

use App\Transaction\ReceivableRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReceivableController extends Controller
{
    /**
     * @var ReceivableRepositoryInterface
     */
    private $receivableRepository;

    /**
     * ReceivableController constructor.
     * @param ReceivableRepositoryInterface $receivableRepository
     */
    public function __construct(ReceivableRepositoryInterface $receivableRepository)
    {

        $this->receivableRepository = $receivableRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function openList(Request $request)
    {
        $receivables = $this->receivableRepository->findOpen($request);

        $array = [];

        foreach ($receivables as $receivable)
        {
            $item['id'] = $receivable->getKey();
            $item['text'] = $receivable->customer->first_name . ' '. $receivable->customer->name .' ' . $receivable->closing_date .'-ны өдөр '. ($receivable->transaction->account->type == 'active' ? 'авах ' : 'төлөх ') . number_format($receivable->transaction->amount * $receivable->transaction->exchange) .'₮';
            $item['amount'] = $receivable->transaction->amount;
            $item['exchange'] = $receivable->transaction->exchange;
            array_push($array, $item);
        }

        return response()->json([
            'list' => $array
        ]);
    }
}
