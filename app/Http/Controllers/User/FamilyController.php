<?php

namespace App\Http\Controllers\User;

use App\User\Family\Family;
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

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id, Request $request)
    {
        $family = $this->familyRepository->findByUserPaginate($id, $request->get('per_page'), $request->all());

        return response()->json([
            'members' => $family
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id, Request $request)
    {
        $this->valid($request);

        $parameters = $request->all();

        $parameters['user_id'] = $id;

        $family = Family::create($parameters);

        return response()->json(['result' => !is_null($family)]);
    }

    /**
     * @param $id
     * @param $family_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, $family_id, Request $request)
    {
        $family = $this->familyRepository->findById($family_id);

        return response()->json([
            'result'=>$family->update($request->all())
        ]);
    }

    /**
     * @param $id
     * @param $family_id
     * @return \Illuminate\Http\JsonResponse
     */
    public  function destroy($id, $family_id)
    {
        $family=$this->familyRepository->findById($family_id);
        return response()->json(['result'=>$family->delete()]);
    }

    /**
     * @param $request
     */
    private function valid($request)
    {
        $this->validate($request, [
            'phone_number' => 'required',
            'name' => 'required',
            'relation' => 'required',
            'budged'=>'required'
        ]);
    }
}
