<?php

namespace App\Http\Controllers\User;

use App\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\UserCreated;
use App\Events\UserUpdated;
use Illuminate\Support\Facades\Storage;
use App\Support\FileType;
use App\User\UserRepositoryInterface;

class CvController extends Controller
{
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
    }
    public function profileUpload(Request $request)
    {
        if(!$request->hasFile('file'))
            return response()->json([
                'error' => 'No profile Uploaded'
            ]);

        $file = $request->file('file');

        if(!$file->isValid())
            return response()->json([
                'error' => 'profile is not valid!'
            ]);

        $pic=$file->hashName();

        $tempProfilePath=( 'images/profile/user');

        Storage::disk('profile')->put('user',$file);

        return response()->json([
            'success' => 'Profile Uploaded',
            'tempProfPath'=> $tempProfilePath,
            'profPic'=>$pic
        ]);

    }
    public  function fileUpload(Request $request)
    {

           $folder= $request->get('folder');

           if(!$request->hasFile( 'file'))

            return response()->json([
                'error' => 'No File Uploaded'
            ]);

        $file = $request->file('file');

        if(!$file->isValid())
            return response()->json([
                'error' => 'File is not valid!'
            ]);;

        $tempFilePath=('temp_files/' );

        Storage::disk('UpFiles')->put($folder,$file);

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

        $parameters['password'] = \Hash::make('123');

        $user = \DB::transaction(function() use($parameters, $request) {

        $user = User::create($parameters);

            if($request->has('profilePath'))
            {
                Storage::move($parameters['profilePath'],'/images/profile_'.$user['id']);
                $parameters['image']='/images/profile_'.$user['id'].'/'.$parameters['image'];
                $user->update($parameters);
            }

            if($request->has('filePath'))
            {
                Storage::move($parameters['filePath'],'/files/file_'.$user['id'] );
            }
            $user->assets()->createMany($request->get('assets'));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $this->valid($request);
        $result = false;
        $parameters = $request->all();

            $user = $this->userRepository->findById($parameters['id']);
           if($user->update($parameters))
           {
            if($request->has('profilePath'))
            {
                Storage::move($parameters['profilePath'],'/images/profile_'.$user['id']);
                $parameters['image']='/images/profile_'.$user['id'].'/'.$parameters['image'];

            }

            if($request->has('filePath'))
            {
                Storage::move($parameters['filePath'],'/files/file_'.$user['id'] );
            }

            $assets = $request->get('assets');
            $workplaces = $request->get('workplaces');
            $members = $request->get('family');
            $emergencies = $request->get('emergencies');
            $budgets = $request->get('budgets');
            $expenses = $request->get('expenses');
            $activeLoans = $request->get('credits');
            dd($activeLoans);
            $requests = $request->get('request');

            foreach ($assets as $asset)
            {
                $user->assets()->updateOrcreate($asset);
            }
            foreach ($workplaces as $workplace)
            {
                $user->workplaces()->updateOrcreate($workplace);
            }
            foreach ($members as $member)
            {
                $user->family()->updateOrcreate($member);
            }
            foreach ($emergencies as $emergency)
            {
                $user->emergencies()->updateOrcreate($emergency);
            }
            foreach ($budgets as $budget)
            {
                $user->budgets()->updateOrcreate($budget);
            }
            foreach ($expenses as $expens)
            {
                $user->expenses()->updateOrcreate($expens);
            }
            foreach ($activeLoans as $aloan)
            {
                $user->activeLoans()->updateOrcreate($aloan);
            }
            foreach ($requests as $loanrequest)
            {
                $user->Request()->updateOrcreate($loanrequest);
            }

            $result = true;

           }

        return response()->json([
            'result' => $result
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
