<?php

namespace App\Http\Controllers\User;

use App\User\PermissionRepositoryInterface;
use App\User\RoleRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepository;
    /**
     * @var PermissionRepositoryInterface
     */
    private $permissionRepository;

    /**
     * PermissionController constructor.
     * @param RoleRepositoryInterface $roleRepository
     * @param PermissionRepositoryInterface $permissionRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param $role_id
     * @param Request $request
     */
    public function store($role_id, Request $request)
    {
        $role = $this->roleRepository->findById($role_id);

        foreach ($permissions = json_decode($request->get('_data')) as $permission)
        {
            try
            {
                $role->perms()->attach($permission->id);
            }catch (\Exception $exception)
            {
                continue;
            }
        }
    }

    /**
     * @param $role_id
     * @param $permission_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($role_id, $permission_id)
    {
        $role = $this->roleRepository->findById($role_id);

        $role->perms()->detach($permission_id);

        return response()->json([
            'result' => true
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $permissions = $this->permissionRepository->search($request->get('role'), $request->get('q'));

        return response()->json([
            'permissions' => $permissions
        ]);
    }
}
