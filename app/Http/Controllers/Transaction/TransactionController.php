<?php

namespace App\Http\Controllers\Transaction;

use App\Account\AccountGroupRepositoryInterface;
use App\Account\AccountRepositoryInterface;
use App\Account\JournalRepository;
use App\Season\Season;
use App\Season\SeasonRepositoryInterface;
use App\Support\AccountBalanceChecker;
use App\Transaction\Transaction;
use App\Transaction\TransactionRepositoryInterface;
use Dompdf\Exception;
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
     * @var AccountBalanceChecker
     */
    private $checker;

    /**
     * TransactionController constructor.
     * @param TransactionRepositoryInterface $transactionRepository
     * @param AccountGroupRepositoryInterface $groupRepository
     * @param AccountRepositoryInterface $accountRepository
     * @param SeasonRepositoryInterface $seasonRepository
     * @param JournalRepository $journalRepository
     * @param AccountBalanceChecker $checker
     */
    public function __construct(TransactionRepositoryInterface $transactionRepository, AccountGroupRepositoryInterface $groupRepository, AccountRepositoryInterface $accountRepository, SeasonRepositoryInterface $seasonRepository, JournalRepository $journalRepository, AccountBalanceChecker $checker)
    {
        $this->transactionRepository = $transactionRepository;
        $this->groupRepository = $groupRepository;
        $this->accountRepository = $accountRepository;
        $this->seasonRepository = $seasonRepository;
        $this->journalRepository = $journalRepository;
        $this->checker = $checker;
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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function lists()
    {

        $accounts = $this->groupRepository->findByListRawWithAccounts();

        return response()->json([
            'model' => $accounts
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

                $parameters = $request->all();

                $account = $this->accountRepository->findById($parameters['account_id']);
                $to_account = $this->accountRepository->findById($parameters['to_account_id']);

                $amount = $parameters['amount'];
                $exchange = $parameters['exchange'];
                $to_exchange = $parameters['to_exchange'];

                if(!$this->checker->can_transaction($season->getKey(), $account, $to_account, $parameters['amount'], $parameters['type'], $parameters['exchange'], $parameters['to_exchange']))
                {
                    throw new Exception('Дансны үлдэгдэл хүрэлцэхгүй байна', 403);
                }

                if($account->currency->is_current == 1)
                {
                    $parameters['amount'] = $amount * $exchange;
                    $parameters['exchange'] = 1;
                }
                else
                {
                    $parameters['amount'] = $amount;
                    $parameters['exchange'] = $exchange;
                }

                $parameters['transaction_number'] = $this->transactionRepository->getTransactionNumber($parameters['transaction_date']);

                Transaction::create($parameters);

                $parameters['account_id'] = $to_account->getKey();
                $parameters['to_account_id'] = $account->getKey();
                $parameters['type'] = $parameters['type'] == 'credit' ? 'debit' : 'credit';

                if($to_account->currency->is_current == 1)
                {
                    $parameters['amount'] = $amount * $exchange;
                    $parameters['exchange'] = 1;
                }
                else
                {
                    $parameters['amount'] = $amount;
                    $parameters['exchange'] = $exchange;
                }

                Transaction::create($parameters);

                return response()->json(['result' => true]);

            });

            return $response;

        }catch (\Exception $exception)
        {
            return response()->json(['message' => $exception->getMessage()], 406);
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
        $transaction = $this->transactionRepository->findByNumber($id);

        return response()->json([
            'result' => $transaction->delete()
        ]);
    }
}
