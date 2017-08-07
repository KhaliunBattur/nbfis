<?php

namespace App\Http\Controllers\User;

use App\User\Family;
use App\User\FamilyRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User\ContactRepositoryInterface;
class FamilyController extends Controller
{
    /**
     * @var FamilyRepositoryInterface
     */
    private $FamilyRepository;

    /**
     * FamilyController constructor.
     * @param FamilyRepositoryInterface $familyRepository
     */
    public function __construct(FamilyRepositoryInterface $familyRepository)
    {
        $this->FamilyRepository = $familyRepository;
    }
}
