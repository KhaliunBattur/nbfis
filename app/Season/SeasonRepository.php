<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 8/22/2017
 * Time: 11:37 AM
 */

namespace App\Season;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class SeasonRepository implements SeasonRepositoryInterface
{
    /**
     * @var Season
     */
    private $model;

    /**
     * SeasonRepository constructor.
     * @param Season $model
     */
    public function __construct(Season $model)
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
        return $this->model
            ->orderBy($params['column'], $params['direction'])
            ->with(['openUser', 'closeUser'])
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
     * @return mixed
     */
    public function findLastClose()
    {
        $season = $this->model->whereNotNull('close_date')->orderBy('close_date', 'desc')->first();

        return is_null($season) ? 0 : $season->getKey();
    }
}