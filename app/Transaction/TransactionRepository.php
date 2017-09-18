<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/29/2017
 * Time: 5:23 PM
 */

namespace App\Transaction;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * @var Transaction
     */
    private $model;

    /**
     * TransactionRepository constructor.
     * @param Transaction $model
     */
    public function __construct(Transaction $model)
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
        $query = $this->model
            ->whereNotNull('type')
            ->with(['account', 'toAccount', 'customer', 'user']);

        return $query->paginate($howMany);
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
     * @param $transaction_date
     * @return mixed
     */
    public function getTransactionNumber($transaction_date)
    {
        $last_transaction = $this->model
            ->whereNotNull('type')
            ->where('transaction_date', $transaction_date)
            ->orderBy('transaction_number', 'desc')->first();

        $date = Carbon::createFromFormat('Y-m-d', $transaction_date)->format('ymd');

        if(!is_null($last_transaction))
        {
            return $date . (substr($last_transaction->transaction_number, 0, 6) == $date ? substr((string) (((int) substr($last_transaction->transaction_number, 6, 3) + 1) + 1000), 1, 3) : '001');
        }
        else
        {
            return $date . '001';
        }
    }
}