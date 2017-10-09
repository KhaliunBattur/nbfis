<?php

namespace App\Http\Controllers\Season;

use App\Account\AccountGroupRepositoryInterface;
use App\Account\AccountRepositoryInterface;
use App\Season\Season;
use App\Season\SeasonRepositoryInterface;
use App\Support\CurrencyRepositoryInterface;
use App\Transaction\Transaction;
use App\Transaction\TransactionRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeasonController extends Controller
{
    /**
     * @var SeasonRepositoryInterface
     */
    private $seasonRepository;
    /**
     * @var AccountRepositoryInterface
     */
    private $accountRepository;
    /**
     * @var AccountGroupRepositoryInterface
     */
    private $groupRepository;
    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;
    /**
     * @var CurrencyRepositoryInterface
     */
    private $currencyRepository;

    /**
     * SeasonController constructor.
     * @param SeasonRepositoryInterface $seasonRepository
     * @param AccountRepositoryInterface $accountRepository
     * @param AccountGroupRepositoryInterface $groupRepository
     * @param TransactionRepositoryInterface $transactionRepository
     * @param CurrencyRepositoryInterface $currencyRepository
     */
    public function __construct(SeasonRepositoryInterface $seasonRepository, AccountRepositoryInterface $accountRepository, AccountGroupRepositoryInterface $groupRepository, TransactionRepositoryInterface $transactionRepository, CurrencyRepositoryInterface $currencyRepository)
    {
        $this->seasonRepository = $seasonRepository;
        $this->accountRepository = $accountRepository;
        $this->groupRepository = $groupRepository;
        $this->transactionRepository = $transactionRepository;
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $season = $this->seasonRepository->findByPaginate($request->get('per_page'), $request->all());

        $all_season_closed = $this->seasonRepository->findLastClose();

        return response()->json([
            'model' => $season,
            'closed' => $season->count() == 0 ? true : ($all_season_closed != 0)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $season = $this->seasonRepository->findByIdWithCurrencies($id);

        return response()->json([
            'season' => $season
        ]);
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
        $this->validate($request, ['name' => 'required']);

        $season = \DB::transaction(function () use ($request) {
            $parameters = $request->all();
            $parameters['open_user_id'] = \Auth::user()->getKey();
            $parameters['open_date'] = Carbon::now();

            $season = Season::create($parameters);

            $accounts = $this->accountRepository->findAll();

            $currencies = $this->currencyRepository->findAll();

            $is_first = $this->seasonRepository->findAll()->count() == 0 ? true : false;

            $season_key = $is_first ? $season->getKey() : $this->seasonRepository->findLastClose();

            foreach ($accounts as $account) {
                $season->accounts()->attach($account->getKey(), [
                    'exchange' => $account->currency->exchange,
                    'balance' => $account->balance($season_key)
                ]);
            }

            foreach ($currencies as $currency)
            {
                $season->currencies()->attach($currency->getKey(), [
                    'exchange' => $currency->exchange
                ]);
            }

            return $season;
        });

        return response()->json([
            'result' => !is_null($season)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $season = $this->seasonRepository->findById($id);

        $groups = $this->groupRepository->findParents();

        $accounts = $season->accounts()->pluck('exchange', 'id')->toArray();

        $array = [];

        foreach ($groups as $key => $group) {
            $groupArray = $group->toArray();
            $groupArray['balance'] = 0;
            $groupArray['active'] = 0;
            $groupArray['passive'] = 0;
            $groupArray['credit'] = 0;
            $groupArray['debit'] = 0;
            $groupArray['active_total'] = 0;
            $groupArray['passive_total'] = 0;
            $array[$key] = $groupArray;
            if ($group->children->count()) {
                $array[$key]['children'] = $this->recursive($group->children, $accounts, $season);
            }
            if ($group->accounts->count()) {
                $array[$key]['accounts'] = [];
                foreach ($group->accounts()->with(['currency', 'journal', 'group', 'bank', 'breakdown'])->get() as $account) {
                    if (array_key_exists($account->getKey(), $accounts)) {
                        $accountArray = $account->toArray();
                        $accountArray['balance'] = $account->balance($season->getKey());
                        $accountArray['total'] = $account->present()->balance($season->getKey());
                        $accountArray['general_credit'] = $account->sumOfCreditTransaction($season->getKey())->sum('amount');
                        $accountArray['general_credit_currency'] = $account->creditTransaction($season->getKey())->sum('amount');
                        $accountArray['general_debit'] = $account->sumOfDebitTransaction($season->getKey())->sum('amount');
                        $accountArray['general_debit_currency'] = $account->debitTransaction($season->getKey())->sum('amount');
                        $accountArray['exchange'] = $accounts[$account->getKey()];
                        array_push($array[$key]['accounts'], $accountArray);
                    }
                }
            }
        }

        return response()->json([
            'model' => $array
        ]);

    }

    /**
     * @param $children
     * @param $accounts
     * @param $season
     * @return array
     */
    private function recursive($children, $accounts, $season)
    {
        $array = [];
        foreach ($children as $key => $child) {
            $groupArray = $child->toArray();
            $groupArray['balance'] = 0;
            $groupArray['active'] = 0;
            $groupArray['passive'] = 0;
            $groupArray['credit'] = 0;
            $groupArray['debit'] = 0;
            $groupArray['active_total'] = 0;
            $groupArray['passive_total'] = 0;
            $array[$key] = $groupArray;
            if ($child->children->count()) {
                $array[$key]['children'] = $this->recursive($child->children, $accounts, $season);
            }
            if ($child->accounts->count()) {
                $array[$key]['accounts'] = [];
                foreach ($child->accounts()->with(['currency', 'journal', 'group', 'bank', 'breakdown', 'breakdown.transactionAble'])->get() as $account) {
                    if (array_key_exists($account->getKey(), $accounts)) {
                        $accountArray = $account->toArray();
                        $accountArray['balance'] = $account->balance($season->getKey());
                        $accountArray['total'] = $account->present()->balance($season->getKey());
                        $accountArray['general_credit'] = $account->sumOfCreditTransaction($season->getKey())->sum('amount');
                        $accountArray['general_credit_currency'] = $account->creditTransaction($season->getKey())->sum('amount');
                        $accountArray['general_debit'] = $account->sumOfDebitTransaction($season->getKey())->sum('amount');
                        $accountArray['general_debit_currency'] = $account->debitTransaction($season->getKey())->sum('amount');
                        $accountArray['exchange'] = $accounts[$account->getKey()];
                        $accountArray['final_exchange'] = $account->currency->exchange;
                        array_push($array[$key]['accounts'], $accountArray);
                    }
                }
            }
        }

        return $array;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function saveBalance($id, Request $request)
    {
        \DB::transaction(function () use ($request, $id) {
            $accounts = [];

            $accounts = $this->getAccounts($request->all(), $accounts);

            $season = $this->seasonRepository->findById($id);

            foreach ($accounts as $account) {
                $season->accounts()->updateExistingPivot($account['id'], ['balance' => $account['balance']]);

                $syncAccount = $this->accountRepository->findById($account['id']);

                if (array_key_exists('breakdown', $account)) {
                    $syncAccount->syncBreakDowns($account['breakdown'], $season, $account);
                }
            }
        });

        return response()->json([
            'result' => true
        ]);
    }

    public function saveCurrency($id, Request $request)
    {
        $season = $this->seasonRepository->findById($id);

        $season->currencies()->detach();

        $new_currency = [];

        foreach ($request->all() as $currency)
        {
            $season->currencies()->attach($currency['id'], [
                'exchange' => $currency['pivot']['exchange']
            ]);

            $new_currency[$currency['id']] = $currency['pivot']['exchange'];
        }

        foreach ($season->accounts as $account)
        {
            $season->accounts()->updateExistingPivot($account->getKey(), ['exchange' => $new_currency[$account->currency_id]]);
        }
    }

    /**
     * @param $groups
     * @param $accounts
     * @return mixed
     */
    private function getAccounts($groups, $accounts)
    {
        foreach ($groups as $group) {
            if (array_key_exists('accounts', $group)) {
                foreach ($group['accounts'] as $account) {
                    array_push($accounts, $account);
                }
            }

            if (array_key_exists('children', $group)) {
                $accounts = $this->getAccounts($group['children'], $accounts);
            }
        }

        return $accounts;
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function finalBalance(Request $request, $id)
    {
        $season = $this->seasonRepository->findById($id);

        $groups = $this->groupRepository->findParents();

        $accounts = $season->accounts()->pluck('exchange', 'id')->toArray();

        $array = [];

        foreach ($groups as $key => $group) {
            $groupArray = $group->toArray();
            $groupArray['balance'] = 0;
            $groupArray['active'] = 0;
            $groupArray['passive'] = 0;
            $groupArray['credit'] = 0;
            $groupArray['debit'] = 0;
            $groupArray['active_total'] = 0;
            $groupArray['passive_total'] = 0;
            $array[$key] = $groupArray;
            if ($group->children->count()) {
                $array[$key]['children'] = $this->recursive($group->children, $accounts, $season);
            }
            if ($group->accounts->count()) {
                $array[$key]['accounts'] = [];
                foreach ($group->accounts()->with(['currency', 'journal', 'group', 'bank', 'breakdown'])->get() as $account) {
                    if (array_key_exists($account->getKey(), $accounts)) {
                        $accountArray = $account->toArray();
                        $accountArray['balance'] = $account->balance($season->getKey());
                        $accountArray['total'] = $account->present()->balance($season->getKey());
                        $accountArray['general_credit'] = $account->sumOfCreditTransaction($season->getKey())->sum('amount');
                        $accountArray['general_credit_currency'] = $account->creditTransaction($season->getKey())->sum('amount');
                        $accountArray['general_debit'] = $account->sumOfDebitTransaction($season->getKey())->sum('amount');
                        $accountArray['general_debit_currency'] = $account->debitTransaction($season->getKey())->sum('amount');
                        $accountArray['exchange'] = $accounts[$account->getKey()];
                        $accountArray['final_exchange'] = $account->currency->exchange;
                        array_push($array[$key]['accounts'], $accountArray);
                    }
                }
            }
        }

        return response()->json([
            'model' => $array
        ]);
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
        $season = $this->seasonRepository->findById($id);

        return response()->json([
            'result' => $season->delete()
        ]);
    }
}
