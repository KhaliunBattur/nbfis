<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/16/2017
 * Time: 10:54 AM
 */

namespace App\Account;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class AccountRepository implements AccountRepositoryInterface
{

    /**
     * @var Account
     */
    private $model;

    /**
     * AccountRepository constructor.
     * @param Account $model
     */
    public function __construct(Account $model)
    {
        $this->model = $model;
    }

    /**
     * @return Collection
     */
    public function findAll()
    {
        return $this->model->all();
    }

    /**
     * @param $id
     * @return Model
     */
    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param $howMany
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function findByPaginate($howMany, $params = [])
    {
        return $this->model->paginate($howMany);
    }

    /**
     * @param $value
     * @param $name
     * @param int $ignoreId
     * @return Collection
     */
    public function findByList($value, $name, $ignoreId = 0)
    {
        return $this->model->where('id', '!=', $ignoreId)->pluck($name, $value);
    }

    /**
     * @return Collection
     */
    public function findAllIdList()
    {
        return $this->model->pluck('id');
    }

    /**
     * @return Collection
     */
    public function findByListRaw()
    {
        return $this->model
            ->join('currency', 'account.currency_id', '=', 'currency.id')
            ->select('account.id', \DB::raw("CONCAT(account_number, ' - ', account.name) as text"), 'currency.exchange', 'currency.is_current', 'currency.marker', 'account.currency_id')->get();
    }

    /**
     * @param $get
     * @return array
     */
    public function findIdsListByJournal($get)
    {
        return $this->model->whereIn('journal_id', $get)->pluck('id')->toArray();
    }
}