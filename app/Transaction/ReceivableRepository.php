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
//        return $this->model->with(['transactions', 'customer'])->paginate($howMany);
        $query=$this->model->with(['transactions','customer']);

        $search = json_decode($params['search'],true);

        return $query->join('users','users.id','=','receivable.customer_id')
            ->where(function ($query) use($search){
            if(array_key_exists('name', $search) && !is_null($search['name']))
            {
                $query->where('name', 'LIKE', '%' . $search['name'] . '%');
            }
            if(array_key_exists('start_date', $search) && !is_null($search['start_date']))
            {
                $query->where('start_date', 'LIKE', '%' . $search['start_date'] . '%');
            }
            if(array_key_exists('closing_date', $search) && !is_null($search['closing_date']))
            {
                $query->where('closing_date', 'LIKE', '%' . $search['closing_date'] . '%');
            }
            if(array_key_exists('amount', $search) && !is_null($search['amount']))
            {
                $query->where('amount', 'LIKE', '%' . $search['amount'] . '%');
            }
            if(array_key_exists('created_at', $search) && !is_null($search['created_at']))
            {
                $query->where('receivable.created_at', 'LIKE', '%' . $search['created_at'] . '%');
            }
        })->paginate($howMany);
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
                    $query->whereHas('account', function($query){
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
                    $query->whereHas('account', function($query){
                        $query->where('type', 'active');
                    });
                })->orWhere(function($query){
                    $query->whereNull('type')->whereHas('account', function($query){
                        $query->where('type', 'active');
                    });
                });
            }
        })->where('is_closed', 0)->with(['transaction', 'customer'])->get();
    }
}