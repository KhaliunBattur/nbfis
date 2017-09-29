<?php
/**
 * Created by PhpStorm.
 * User: Munkhsaikhan
 * Date: 9/25/2017
 * Time: 4:57 PM
 */

namespace App\Transaction;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ReceivableRepository implements ReceivableRepositoryInterface
{

    /**
     * @var Receivable
     */
    private $model;

    /**
     * ReceivableRepository constructor.
     * @param Receivable $model
     */
    public function __construct(Receivable $model)
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
     * @param \Illuminate\Http\Request $request
     * @return Collection
     */
    public function findOpen($request)
    {
        return $this->model->whereHas('transaction', function($query) use($request) {
            if($request->get('type') == 'passive')
            {
                $query->where(function($query){
                    $query->where('type', '!=', 'debit')->whereHas('account', function($query){
                        $query->where('type', 'passive');
                    });
                })->orWhere(function($query){
                    $query->whereNull('type')->whereHas('account', function($query){
                        $query->where('type', 'passive');
                    });
                });
            }
            else
            {
                $query->where(function($query){
                    $query->where('type', '!=', 'credit')->whereHas('account', function($query){
                        $query->where('type', 'active');
                    });
                })->orWhere(function($query){
                    $query->whereNull('type')->whereHas('account', function($query){
                        $query->where('type', 'active');
                    });
                });
            }
        })->with(['transaction', 'customer'])->get();
    }
}