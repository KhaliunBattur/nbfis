<?php

namespace App\Http\Controllers\User;

use App\Events\UserCreated;
use App\Events\UserUpdated;
use App\Support\FileType;
use App\User\User;
use App\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * UserController constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {

        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $users = $this->userRepository->findByPaginate($request->get('per_page'), $request->all());

        return response()->json([
            'model' => $users
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->valid($request);

        $parameters = $request->all();

        if($request->has('image'))
        {
            $url = $request->get('image');

            $file = file_get_contents($url);

            $filename = '/storage/users/' . sha1(pathinfo($url, PATHINFO_FILENAME).date('H:i:s')) . '.' . FileType::getFileType($url);

            $destinationPath = public_path() . $filename;

            $parameters['image'] = $filename;

            file_put_contents($destinationPath, $file);
        }

        $parameters['password'] = \Hash::make($parameters['password']);

        $user = User::create($parameters);

        event(new UserCreated($user, 'хэрэглэгч шинээр бүртгэв', 'info'));

        $user->roles()->attach($request->get('roles'));

        return response()->json([
            'result' => !is_null($user)
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = $this->userRepository->findById($id);

        return response()->json([
            'user' => $user,
            'roles' => $user->roles,
            'owner_type' => \Config::get('enums.owner_type')
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $user = $this->userRepository->findById($id);

        return response()->json([
            'user' => $user,
            'roles' => $user->roles()->pluck('id')
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $this->valid($request);

        $result = false;

        $user = $this->userRepository->findById($id);

        $user->roles()->detach();

        $user->roles()->attach($request->get('roles'));

        $parameters = $request->all();

        if($request->has('image') && !is_null($request->get('image')))
        {
            $url = $request->get('image');

            $file = file_get_contents($url);

            $filename = '/storage/users/' . sha1(pathinfo($url, PATHINFO_FILENAME).date('H:i:s')) . '.' . FileType::getFileType($url);

            $destinationPath = public_path() . $filename;

            $parameters['image'] = $filename;

            file_put_contents($destinationPath, $file);
        }
        else
        {
            unset($parameters['image']);
        }

        if($request->get('user_type') == 'customer')
        {
            $user->roles()->detach();
        }

        if($user->update($parameters))
        {
            event(new UserUpdated($user, 'хэрэглэгчийн мэдээлэл засварлав', 'info'));
            $result = true;
        }

        return response()->json([
            'result' => $result
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = $this->userRepository->findById($id);

        if(!is_null($user->image) && $user->image != '' && file_exists('./'.$user->image))
        {
            unlink('./'.$user->image);
        }

        return response()->json([
            'result' => $user->delete()
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword($id, Request $request)
    {
        $this->validate($request, [
            'password' => 'required|same:confirm_password'
        ]);

        $user = $this->userRepository->findById($id);

        $user->password = \Hash::make($request->get('password'));

        return response()->json(['result' => $user->save()]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveLiveYear($id, Request $request)
    {
        $user = $this->userRepository->findById($id);

        $user->live_year = $request->get('_year');

        return response()->json([
            'result' => $user->save()
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveOwnerType($id, Request $request)
    {
        $user = $this->userRepository->findById($id);

        $user->owner_type = $request->get('_owner_type');

        return response()->json([
            'result' => $user->save()
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveAddress($id, Request $request)
    {
        $user = $this->userRepository->findById($id);

        $user->address = $request->get('_address');

        return response()->json([
            'result' => $user->save()
        ]);
    }

    public function info($id)
    {
        $user = $this->userRepository->findInfoById($id);

        return response()->json([
            'user' => $user,
            'owner_type' => \Config::get('enums.owner_type'),
            'relations' => \Config::get('enums.relation')
        ]);
    }

    /**
     * @param $request
     */
    private function valid($request)
    {
        $rules = [
            'first_name' => 'required',
            'name'       => 'required',
            'email'      => 'required|email|unique:users,email,'.$request->segment(3)
        ];

        if($request->get('user_type') == 'customer')
        {
            $rules['register'] = 'required|unique:users,email,'.$request->segment(3);
        }

        if($request->method() != 'PATCH')
        {
            $rules['password'] = 'required|same:confirm_password';
        }

        $this->validate($request, $rules);
    }
}
