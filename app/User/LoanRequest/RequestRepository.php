<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 8/22/2017
 * Time: 12:04 PM
 */

namespace App\User\LoanRequest;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class RequestRepository implements RequestRepositoryInterface
{
    /**
     * @var Requests
     */
    private $model;

    /**
     * UserRepository constructor.
     * @param Requests $model
     */
    public function __construct(Requests $model)
    {
        $this->model = $model;
    }
    /**
     * @return Collection
     */
    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    /**
     * @param $id
     * @return Model
     */
    public function findById($id)
    {
        // TODO: Implement findById() method.
    }
    /**
     * @param $howMany
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public  function findByRequestPaginate($howMany, $params = [])
    {
        $query = $this->model;

        $search = json_decode($params['search'], true);

        return $query->join('users','users.id','=','loan_request.user_id')->where(function($query) use($search) {
            if(array_key_exists('name', $search) && !is_null($search['name']))
            {
                $query->where('name', 'LIKE', $search['name'] . '%');
            }
            if(array_key_exists('register', $search) && !is_null($search['register']))
            {
                $query->where('register', 'LIKE','%'. $search['register'] . '%');
            }
            if(array_key_exists('user_type', $search) && !is_null($search['user_type']))
            {
                $query->where('user_type', 'LIKE', $search['user_type'] . '%');
            }
            if(array_key_exists('pledge_type', $search) && !is_null($search['pledge_type']))
            {
                $query->where('pledge_type', 'LIKE', $search['pledge_type'] . '%');
            }
            if(array_key_exists('loan_term', $search) && !is_null($search['loan_term']))
            {
                $query->where('loan_term', 'LIKE', $search['loan_term'] . '%');
            }
            if(array_key_exists('period_time', $search) && !is_null($search['period_time']))
            {
                $query->where('period_time', 'LIKE', $search['period_time'] . '%');
            }
            if(array_key_exists('payment_day', $search) && !is_null($search['payment_day']))
            {
                $query->where('payment_day', 'LIKE','%'. $search['payment_day'] . '%');
            }
            if(array_key_exists('expire_date', $search) && !is_null($search['expire_date']))
            {
                $query->where('expire_date', 'LIKE','%'. $search['expire_date'] . '%');
            }
            if(array_key_exists('description', $search) && !is_null($search['description']))
            {
                $query->where('description', 'LIKE','%'. $search['description'] . '%');
            }
        })->orderBy($params['column'], $params['direction'])
        ->paginate($howMany);
    }
    /**
     * @param $howMany
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function findByPaginate($howMany, $params = [])
    {
        // TODO: Implement findByPaginate() method.
    }

    /**
     * @param $value
     * @param $name
     * @param int $ignoreId
     * @return Collection
     */
    public function findByList($value, $name, $ignoreId = 0)
    {
        // TODO: Implement findByList() method.
    }
}