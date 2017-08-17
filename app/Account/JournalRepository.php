<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/17/2017
 * Time: 10:06 AM
 */

namespace App\Account;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class JournalRepository implements JournalRepositoryInterface
{
    /**
     * @var Journal
     */
    private $model;

    /**
     * JournalRepository constructor.
     * @param Journal $model
     */
    public function __construct(Journal $model)
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
     * @param $get
     * @return Collection
     */
    public function search($get)
    {
        return $this->model
            ->where(function($query) use($get){
                $query->where('name', 'like', '%'. $get .'%');
            })->get();
    }
}