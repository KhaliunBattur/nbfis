<?php

namespace App\Http\Controllers\User;

use App\User\Family\FamilyRepositoryInterface;
use App\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FamilyController extends Controller
{
    /**
     * @var FamilyRepositoryInterface
     */
    private $familyRepository;
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * FamilyController constructor.
     * @param FamilyRepositoryInterface $familyRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(FamilyRepositoryInterface $familyRepository, UserRepositoryInterface $userRepository)
    {
        $this->familyRepository = $familyRepository;
        $this->userRepository = $userRepository;
    }

    public function index($id, Request $request)
    {
        $family = $this->familyRepository->findByPaginate($request->get('per_page'), $request->all());

        return response()->json([
            'members' => $family
        ]);
    }
}
