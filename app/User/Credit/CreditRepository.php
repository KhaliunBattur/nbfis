<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 8/7/2017
 * Time: 3:05 PM
 */

namespace App\User\Credit;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class CreditRepository implements CreditRepositoryInterface
{
    private $model;

    /**
     * CreditRepository constructor.
     * @param Credit $model
     */
    public function __construct(Credit $model)
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

    }

    /**
     * @param $id
     * @param $limit
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findByUserPaginate($id, $limit, $params = [])
    {
        $query = $this->model;

        $search = json_decode($params['search'], true);

        return $query->where(function($query) use($search) {
            if(array_key_exists('organization', $search) && !is_null($search['organization']))
            {
                $query->where('organization', 'LIKE', $search['organization'] . '%');
            }
            if(array_key_exists('loan_amount', $search) && !is_null($search['loan_amount']))
            {
                $query->where('loan_amount', 'LIKE', $search['loan_amount'] . '%');
            }
            if(array_key_exists('loan_usage', $search) && !is_null($search['loan_usage']))
            {
                $query->where('loan_usage', 'LIKE', $search['loan_usage'] . '%');
            }
            if(array_key_exists('loan_date', $search) && !is_null($search['loan_date']))
            {
                $query->where('loan_date', 'LIKE', $search['loan_date'] . '%');
            }
            if(array_key_exists('loan_interest', $search) && !is_null($search['loan_interest']))
            {
                $query->where('loan_interest', 'LIKE', $search['loan_interest'] . '%');
            }
            if(array_key_exists('loan_balance', $search) && !is_null($search['loan_balance']))
            {
                $query->where('loan_balance', 'LIKE', $search['loan_balance'] . '%');
            }
            if(array_key_exists('monthly_pay', $search) && !is_null($search['monthly_pay']))
            {
                $query->where('monthly_pay', 'LIKE', $search['monthly_pay'] . '%');
            }
        })->where('user_id', $id)
            ->orderBy($params['column'], $params['direction'])
            ->paginate($limit);
    }
}