<?php

namespace App\Http\Controllers\Transaction;

use App\Account\AccountGroupRepositoryInterface;
use App\Account\AccountRepositoryInterface;
use App\Account\JournalRepositoryInterface;
use App\Events\TransactionDestroyed;
use App\Season\Season;
use App\Season\SeasonRepositoryInterface;
use App\Support\AccountBalanceChecker;
use App\Transaction\Property;
use App\Transaction\Receivable;
use App\Transaction\ReceivableRepositoryInterface;
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
     * @var JournalRepositoryInterface
     */
    private $journalRepository;
    /**
     * @var AccountBalanceChecker
     */
    private $checker;
    /**
     * @var ReceivableRepositoryInterface
     */
    private $receivableRepository;

    /**
     * TransactionController constructor.
     * @param TransactionRepositoryInterface $transactionRepository
     * @param AccountGroupRepositoryInterface $groupRepository
     * @param AccountRepositoryInterface $accountRepository
     * @param SeasonRepositoryInterface $seasonRepository
     * @param JournalRepositoryInterface $journalRepository
     * @param AccountBalanceChecker $checker
     * @param ReceivableRepositoryInterface $receivableRepository
     */
    public function __construct(TransactionRepositoryInterface $transactionRepository, AccountGroupRepositoryInterface $groupRepository, AccountRepositoryInterface $accountRepository, SeasonRepositoryInterface $seasonRepository, JournalRepositoryInterface $journalRepository, AccountBalanceChecker $checker, ReceivableRepositoryInterface $receivableRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->groupRepository = $groupRepository;
        $this->accountRepository = $accountRepository;
        $this->seasonRepository = $seasonRepository;
        $this->journalRepository = $journalRepository;
        $this->checker = $checker;
        $this->receivableRepository = $receivableRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('journal_id'))
        {
            $journal_ids = $this->journalRepository->findByIdUse($request->get('journal_id'));

            $request->request->add(['accounts' => $this->accountRepository->findIdsListByJournal($journal_ids)]);
        }

        $transaction = $this->transactionRepository->findByPaginate($request->get('per_page'), $request->all());

        return response()->json([
            'transaction' => $transaction
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function lists(Request $request)
    {
        $journal_ids = null;

        if($request->has('code'))
        {
            $journal_ids = $this->journalRepository->findByCode($request->get('code'));
        }

        $accounts = $this->groupRepository->findByListRawWithAccounts($journal_ids);

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

        if(date_create($season->open_date) <= date_create($request->get('transaction_date')))
        {
            if($request->get('journal') == 0)
            {
                if($request->has('multiple'))
                {
                    if($request->has('receivable'))
                    {
                        return $this->saveReceivable($request, $season);
                    }
                    else
                    {
                        return $this->saveGeneralMulti($request, $season);
                    }
                }
                else
                {
                    if($request->has('property'))
                    {
                        return $this->saveProperty($request, $season);
                    }
                    else
                    {
                        return $this->saveGeneral($request, $season);
                    }
                }
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
    private function saveProperty($request, $season)
    {
        $this->validate($request, [
            'receipt_number' => 'required',
            'transaction_date' => 'required',
            'customer_id' => 'required',
            'account_id' => 'required',
            'to_account_id' => 'required',
            'description' => 'required'
        ]);

        try
        {
            $response = \DB::transaction(function() use ($request, $season){

                $request->request->add(['user_id' => \Auth::user()->getKey()]);
                $request->request->add(['season_id' => $season->getKey()]);

                $parameters = $request->all();

                $account = $this->accountRepository->findById($parameters['account_id']);
                $to_account = $this->accountRepository->findById($parameters['to_account_id']);

                $amount = $parameters['amount'];
                $exchange = $parameters['exchange'];
                $to_exchange = $parameters['to_exchange'];

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

                $this->checker->can_transaction($season->getKey(), $account, $parameters);

                $property = Property::create([
                    'account_id' => $account->getKey(),
                    'branch_id' => $parameters['branch_id'],
                    'code' => $parameters['code'],
                    'name' => $parameters['name'],
                    'owner_id' => $parameters['owner_id'],
                    'unit_amount' => $parameters['unit_amount'],
                    'count' => $parameters['count'],
                    'start_date' => $parameters['start_date'],
                    'use_time_count' => $parameters['use_time_count']
                ]);

                $parameters['transaction_able'] = 'App\Transaction\Property';
                $parameters['transaction_able_id'] = $property->getKey();

                Transaction::create($parameters);

                $parameters['transaction_able'] = null;
                $parameters['transaction_able_id'] = null;

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

                $this->checker->can_transaction($season->getKey(), $to_account, $parameters);

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
     * @param $request
     * @param $season
     * @return \Illuminate\Http\JsonResponse
     */
    private function saveReceivable($request, $season)
    {
        if(!$request->has('account_id'))
        {
            return response()->json(['message' => 'Данс сонгоогүй байна'], 406);
        }

        $rules = [
            'receipt_number' => 'required',
            'transaction_date' => 'required',
            'customer_id' => 'required',
            'account_id' => 'required',
            'to_transaction' => 'required',
            'description' => 'required'
        ];

        $account = $this->accountRepository->findById($request->get('account_id'));

        if(($request->get('type') == 'debit' && $account->type == 'passive') || ($request->get('type') == 'credit' && $account->type == 'active'))
        {
            $rules['receivable_id'] = 'required';
        }

        if(($request->get('type') == 'debit' && $account->type == 'active') || ($request->get('type') == 'credit' && $account->type == 'passive'))
        {
            $rules['closing_date'] = 'required';
        }

        $this->validate($request, $rules);

        try
        {
            $response = \DB::transaction(function() use ($request, $season, $account){

                $request->request->add(['user_id' => \Auth::user()->getKey()]);
                $request->request->add(['season_id' => $season->getKey()]);

                $parameters = $request->all();

                $parameters['transaction_number'] = $this->transactionRepository->getTransactionNumber($parameters['transaction_date']);

                //transaction
                $parameters['amount'] = 0;

                foreach ($request->get('to_transaction') as $transaction)
                {
                    $parameters['amount'] += ($transaction['amount'] * $transaction['to_exchange']);
                }

                $this->checker->can_transaction($season->getKey(), $account, $parameters);

                if(($parameters['type'] == 'debit' && $account->type == 'passive') || ($parameters['type'] == 'credit' && $account->type == 'active'))
                {
                    $receivable = $this->receivableRepository->findById($parameters['receivable_id']);
                    $receivable->update(['is_closed' => 1]);
                    $parameters['transaction_able'] = 'App\Transaction\Receivable';
                    $parameters['transaction_able_id'] = $parameters['receivable_id'];
                }
                else if(($parameters['type'] == 'debit' && $account->type == 'active') || ($parameters['type'] == 'credit' && $account->type == 'passive'))
                {
                    $receivable = Receivable::create([
                        'customer_id' => $parameters['customer_id'],
                        'start_date' => $parameters['transaction_date'],
                        'closing_date' => $parameters['closing_date']
                    ]);
                    $parameters['transaction_able'] = 'App\Transaction\Receivable';
                    $parameters['transaction_able_id'] = $receivable->getKey();
                }
                else
                {
                    throw new \Exception('Алдаа танигдсангүй! Дахин оролдоно уу', 403);
                }

                Transaction::create($parameters);

                //to transaction
                $parameters['type'] = $parameters['type'] == 'credit' ? 'debit' : 'credit';

                $parameters['transaction_able'] = null;
                $parameters['transaction_able_id'] = null;

                foreach($request->get('to_transaction') as $transaction)
                {
                    $to_account = $this->accountRepository->findById($transaction['to_account_id']);

                    $parameters['account_id'] = $to_account->getKey();
                    $parameters['to_account_id'] = $account->getKey();

                    $parameters['amount'] = $transaction['amount'];
                    $parameters['exchange'] = $transaction['to_exchange'];

                    $this->checker->can_transaction($season->getKey(), $to_account, $parameters);

                    Transaction::create($parameters);
                }

                return response()->json(['result' => true]);

            });

            return $response;
        }catch (\Exception $exception)
        {
            return response()->json(['message' => $exception->getMessage()], 406);
        }
    }

    /**
     * @param $request
     * @param $season
     * @return \Illuminate\Http\JsonResponse
     */
    private function saveGeneralMulti($request, $season)
    {
        $this->validate($request, [
            'receipt_number' => 'required',
            'transaction_date' => 'required',
            'customer_id' => 'required',
            'account_id' => 'required',
            'to_transaction' => 'required',
            'description' => 'required'
        ]);

        try
        {
            $response = \DB::transaction(function() use ($request, $season){

                $request->request->add(['user_id' => \Auth::user()->getKey()]);
                $request->request->add(['season_id' => $season->getKey()]);

                $parameters = $request->all();

                $parameters['transaction_number'] = $this->transactionRepository->getTransactionNumber($parameters['transaction_date']);

                $account = $this->accountRepository->findById($parameters['account_id']);

                //transaction
                $parameters['amount'] = 0;

                foreach ($request->get('to_transaction') as $transaction)
                {
                    $parameters['amount'] += (($transaction['amount'] * $transaction['to_exchange']) / $parameters['exchange']);
                }

                $this->checker->can_transaction($season->getKey(), $account, $parameters);

                Transaction::create($parameters);

                //to transaction
                $parameters['type'] = $parameters['type'] == 'credit' ? 'debit' : 'credit';

                foreach($request->get('to_transaction') as $transaction)
                {
                    $to_account = $this->accountRepository->findById($transaction['to_account_id']);

                    $parameters['account_id'] = $to_account->getKey();
                    $parameters['to_account_id'] = $account->getKey();

                    $parameters['amount'] = $transaction['amount'];
                    $parameters['exchange'] = $transaction['to_exchange'];

                    $this->checker->can_transaction($season->getKey(), $to_account, $parameters);

                    Transaction::create($parameters);
                }

                return response()->json(['result' => true]);

            });

            return $response;
        }
        catch (\Exception $exception)
        {
            return response()->json(['message' => $exception->getMessage()], 406);
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

                $this->checker->can_transaction($season->getKey(), $account, $parameters);

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

                $this->checker->can_transaction($season->getKey(), $to_account, $parameters);

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
        $transactions = $this->transactionRepository->findByNumber($id);

        return response()->json([
            'result' => \DB::transaction(function() use($transactions) {

                foreach ($transactions->get() as $transaction)
                {
                    event(new TransactionDestroyed($transaction));
                }

                return $transactions->delete();
            })
        ]);


    }
}
