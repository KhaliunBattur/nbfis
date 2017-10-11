<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/16/2017
 * Time: 6:20 PM
 */

namespace App\Support;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    /**
     * @var Currency
     */
    private $model;

    /**
     * CurrencyRepository constructor.
     * @param Currency $model
     */
    public function __construct(Currency $model)
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
            if(array_key_exists('name', $search) && !is_null($search['name']))
            {
                $query->where('name', 'LIKE', $search['name'] . '%');
            }
        })->orderBy($params['column'], $params['direction'])
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
        // TODO: Implement findByList() method.
    }

    /**
     * @param $id
     * @return Collection|static[]
     */
    public function notIn($id)
    {
        return $this->model
            ->where(function($query) use($id){
                $query->where('id','<>','%'. $id .'%');
            })->get();
    }
    /**
     * @param $get
     * @return mixed
     */
    public function search($get)
    {
        return $this->model
            ->where(function($query) use($get){
                $query->where('name', 'like', '%'. $get .'%');
            })->get();
    }
}