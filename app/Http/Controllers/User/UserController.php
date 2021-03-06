<?php

namespace App\Http\Controllers\User;

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

        return response()->json([
            'result' => !is_null($user)
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $user = $this->userRepository->findById($id);

        return response()->json(['user' => $user]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $this->valid($request);

        $user = $this->userRepository->findById($id);

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

        return response()->json([
            'result' => $user->update($parameters)
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
     * @param $request
     */
    private function valid($request)
    {
        $rules = [
            'first_name' => 'required',
            'name'       => 'required',
            'email'      => 'required|email|unique:users,email,'.$request->segment(3)
        ];

        if($request->method() != 'PATCH')
        {
            $rules['password'] = 'required|same:confirm_password';
        }

        $this->validate($request, $rules);
    }
}
