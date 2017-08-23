<?php

namespace App\Http\Controllers\User;

use App\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\UserCreated;
use Illuminate\Support\Facades\Storage;
use App\Support\FileType;


class CvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
    }
    public  function imageUpload(Request $request)
    {

        print_r($request->all());
        if(!$request->hasFile('file'))
            return response()->json([
                'error' => 'No File Uploaded'
            ]);

        $file = $request->file('file');

        if(!$file->isValid())
            return response()->json([
                'error' => 'File is not valid!'
            ]);;

        $file->store('public/images/temp' . date('Y-m-d-H-i-s'));
       
        return response()->json([
            'success' => 'File Uploaded'
        ]);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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

        $parameters['password'] = \Hash::make('123');

        $user = \DB::transaction(function() use($parameters, $request) {
            $user = User::create($parameters);

            $user->assets()->createMany($request->get('assets'));
            $user->workplaces()->create($request->get('workplace'));
            $user->family()->createMany($request->get('family'));
            $user->emergencies()->createMany($request->get('emergencies'));
            $user->budgets()->createMany($request->get('budgets'));
            $user->expenses()->createMany($request->get('expenses'));
            $user->activeLoans()->createMany($request->get('credits'));
            $user->Request()->create($request->get('request'));

            return $user;
        });

        event(new UserCreated($user, 'хэрэглэгч шинээр бүртгэв', 'info'));

        return response()->json([
            'result' => !is_null($user)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

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

        $this->validate($request, $rules);
    }

}
