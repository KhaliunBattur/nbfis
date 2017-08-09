<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/7/2017
 * Time: 3:38 PM
 */

namespace App\User\Workplace;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkplaceRepository implements WorkplaceRepositoryInterface
{
    /**
     * @var Workplace
     */
    private $model;

    /**
     * WorkplaceRepository constructor.
     * @param Workplace $model
     */
    public function __construct(Workplace $model)
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
     * @param $id
     * @param $limit
     * @param $params
     * @return Collection
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
            if(array_key_exists('date_employment', $search) && !is_null($search['date_employment']))
            {
                $query->where('date_employment', 'LIKE', $search['date_employment'] . '%');
            }
            if(array_key_exists('position', $search) && !is_null($search['position']))
            {
                $query->where('position', 'LIKE', $search['position'] . '%');
            }
            if(array_key_exists('activity', $search) && !is_null($search['activity']))
            {
                $query->where('activity', 'LIKE', $search['activity'] . '%');
            }
            if(array_key_exists('address', $search) && !is_null($search['address']))
            {
                $query->where('address', 'LIKE', $search['address'] . '%');
            }
        })->where('user_id', $id)
            ->orderBy($params['column'], $params['direction'])
            ->paginate($limit);
    }
}