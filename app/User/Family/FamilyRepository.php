<?php
/**
 * Created by PhpStorm.
 * User: uugan
 * Date: 8/7/2017
 * Time: 3:06 PM
 */

namespace App\User\Family;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class FamilyRepository implements FamilyRepositoryInterface
{
    private $model;

    /**
     * FamilyRepository constructor.
     * @param Family $model
     */
    public function __construct(Family $model)
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
     * @return Collection
     */
    public function findByUserPaginate($id, $limit, $params = [])
    {
        $query = $this->model;

        $search = json_decode($params['search'], true);

        return $query->where(function($query) use($search) {
            if(array_key_exists('name', $search) && !is_null($search['name']))
            {
                $query->where('name', 'LIKE', $search['name'] . '%');
            }
            if(array_key_exists('relation', $search) && !is_null($search['relation']))
            {
                $query->where('relation', 'LIKE', $search['relation'] . '%');
            }
            if(array_key_exists('job', $search) && !is_null($search['job']))
            {
                $query->where('job', 'LIKE', $search['job'] . '%');
            }
            if(array_key_exists('register', $search) && !is_null($search['register']))
            {
                $query->where('register', 'LIKE', $search['register'] . '%');
            }
            if(array_key_exists('phone_number', $search) && !is_null($search['phone_number']))
            {
                $query->where('phone_number', 'LIKE', $search['phone_number'] . '%');
            }
        })->where('user_id', $id)
            ->orderBy($params['column'], $params['direction'])
            ->paginate($limit);
    }
}