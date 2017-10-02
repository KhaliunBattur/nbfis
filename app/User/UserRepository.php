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
                $query->where('phone_number', 'LIKE', '%' . $search['phone_number'] . '%');
            }
            if(array_key_exists('register', $search) && !is_null($search['register']))
            {
                $query->where('register', 'LIKE', $search['register'] . '%');
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
            'family', 'workplaces', 'emergencies', 'activeLoans', 'budgets', 'assets', 'expenses','Request','Apartment','Car','Other','Credit'
        ])->first();
    }

    /**
     * @param $register
     * @return Model|null|static
     */
    public  function findByRegister($register)
    {
        return $this->model->where('register',$register)->with([
            'family','workplaces','emergencies','activeLoans','budgets','assets','expenses','Request','Apartment','Car','Other','Credit'
        ])->first();
    }

    /**
     * @return Collection
     */
    public function findByCustomerListRaw()
    {
        return $this->model->where('user_type', 'customer')->select('id', \DB::raw("CONCAT(first_name, ' ', name) as text"))->get();
    }

    /**
     * @return Collection
     */
    public function findByUserListRaw()
    {
        return $this->model->where('user_type', 'staff')->select('id', \DB::raw("CONCAT(first_name, ' ', name) as text"))->get();
    }
}