<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/15/2017
 * Time: 2:31 PM
 */

namespace App\Account;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class AccountGroupRepository implements AccountGroupRepositoryInterface
{
    /**
     * @var AccountGroup
     */
    private $model;

    /**
     * AccountRepository constructor.
     * @param AccountGroup $model
     */
    public function __construct(AccountGroup $model)
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
        return $this->model->whereNull('root_id')->paginate($howMany);
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
     * @param $search
     * @return mixed
     */
    public function findByListWhere($id, $search)
    {
        return $this->model
            ->where('id', '!=', $id)
            ->where(function($query) use($search){
                $query
                    ->where('name', 'like', '%'. $search .'%')
                    ->orWhere('code', 'like', '%'. $search .'%');
            })->get();
    }

    /**
     * @return mixed
     */
    public function findParents()
    {
        return $this->model->whereNull('root_id')->get();
    }
}