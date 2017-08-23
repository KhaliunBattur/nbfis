<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/2/2017
 * Time: 6:37 PM
 */

namespace App\User;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    private $model;

    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
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
        $query = $this->model;

        $search = json_decode($params['search'], true);

        return $query->where(function($query) use($search) {
            if(array_key_exists('first_name', $search) && !is_null($search['first_name']))
            {
                $query->where('first_name', 'LIKE', $search['first_name'] . '%');
            }
            if(array_key_exists('name', $search) && !is_null($search['name']))
            {
                $query->where('name', 'LIKE', $search['name'] . '%');
            }
            if(array_key_exists('email', $search) && !is_null($search['email']))
            {
                $query->where('email', 'LIKE', $search['email'] . '%');
            }
            if(array_key_exists('phone_number', $search) && !is_null($search['phone_number']))
            {
                $query->where('phone_number', 'LIKE', $search['phone_number'] . '%');
            }
        })->where(function($query) use($params){
            if($params['type'] != 'all')
            {
                $query->where('user_type', $params['type']);
            }
        })->orderBy($params['column'], $params['direction'])
            ->with('roles')
            ->paginate($howMany);
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
     * @param $id
     * @return User
     */
    public function findInfoById($id)
    {
        return $this->model->where('id', $id)->with([
            'family', 'workplaces', 'emergencies', 'activeLoans', 'budgets', 'assets', 'expenses','pledge_types','owner_types'
        ])->first();
    }
}