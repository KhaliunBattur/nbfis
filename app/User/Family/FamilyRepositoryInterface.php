<?php

namespace App\User\Family;

use Illuminate\Database\Eloquent\Collection;
use App\Core\Repository;

interface FamilyRepositoryInterface extends Repository
{

    /**
     * @param $id
     * @param $limit
     * @param array $search
     * @return Collection
     */
    public function findByUserPaginate($id, $limit, $search = []);
}