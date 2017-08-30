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

           if(!$request->hasFile('file'))
            return response()->json([
                'error' => 'No File Uploaded'
            ]);

        $file = $request->file('file');

        if(!$file->isValid())
            return response()->json([
                'error' => 'File is not valid!'
            ]);;
        $tempFilePath=('public/images/temp' . date('Y-m-d-H-i-s'));
        $file->store($tempFilePath);
        return response()->json([
            'success' => 'File Uploaded',
            'tempPath'=> $tempFilePath
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
            $exploded = explode(',',$request->get('image'));

            $decoded= base64_decode($exploded[1]);
            if(str_contains($exploded[0],'jpeg'))

                $extension = 'jpg';
            else
                $extension = 'png';

            $filename = str_random() . '.' . $extension;

            $destinationPath = public_path() .'/images/profile/'. $filename;

            $parameters['image'] = $filename;

            file_put_contents($destinationPath, $decoded);
        }

        $parameters['password'] = \Hash::make('123');

        $user = \DB::transaction(function() use($parameters, $request) {
            $user = User::create($parameters);
            Storage::move($parameters['filePath'],'public/images/file_'.$user['id'] );
//            $user->assets()->createMany($request->get('assets'));
//            $user->workplaces()->create($request->get('workplace'));
//            $user->family()->createMany($request->get('family'));
//            $user->emergencies()->createMany($request->get('emergencies'));
//            $user->budgets()->createMany($request->get('budgets'));
//            $user->expenses()->createMany($request->get('expenses'));
//            $user->activeLoans()->createMany($request->get('credits'));
//            $user->Request()->create($request->get('request'));
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
