<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Profiles;
use Auth;
use Response;
use App\User;


use DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $profileData = Profiles::where('user_id',Auth::user()->id)->first();
        // $profileData = User::with(['Profiles' => function($query){
        //     $query->where('user_id', Auth::user()->id)->take(1);
        // }])->where('id', Auth::user()->id)->get();
     
        // $profileData= $profileData[0];
        return view('profile',compact('profileData'));
    }
    public function editProfile(Request $request){
        $profileData = Profiles::where('user_id',$request->cust_id)->first();
        
        return view('common.customer-edit',compact('profileData'));
    }
    public function getUsersList(Request $request){
        // $userList = Profiles::orderBy('user_id','DESC')->get();

        // $userList = User::leftJoin('profiles', function($join) {
        //     $join->on('users.id', '=', 'profiles.user_id');
        //   });
        
        $userList = DB::table('users')
        ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
        ->select('users.email AS uemail','users.name','users.id AS uid','profiles.*')
        ->where('users.is_admin','!=','1')
        ->get();
        $response= array();
        $response['status'] = true;
        $response['data'] = $userList;
        return $response;
    }
    public function deleteUser(Request $request){
       $user =User::find($request->user_id);
       $user->delete();
       $response= array();
       $response['status'] = true;
       $response['data'] =null;
       return $response;
    }
    public function updatePassword(Request $request){
       
        // $this->validate($request, [
        //     'password' => 'required',
        //     'new_password' => 'confirmed|max:8|different:password',
        // ]);
        $response = array();
        $respons['status'] = false;
        $respons['message'] = "";
        $respons['data'] = null;

        $user = User::findOrFail($request->userId);
        if (Hash::check($request->oldpassword, $user->password)) { 
           $user->fill([
            'password' => Hash::make($request->newpassword)
            ])->save();
        
             $respons['status'] = true;
             $respons['message'] = "Password changed";
            return $respons;
        
        } else {
            $respons['message'] = "Password does not match";
            return $respons;
     
        }
      return $respons;
    }
    public function updateProfile(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required'  
            
           
            ]);
        if ($validator->fails()){
           return Response::json(array(
               'success' => false,
               'errors' => $validator->getMessageBag()->toArray()
        
           ), 200); // 400 being the HTTP code for an invalid request.
        }else{
            $user_id = $request->user_id;
            if(isset($request->uid)){
                $user_id =$request->uid;
            }
            $customerObj = Profiles::where('user_id',$user_id)->first();
            $profilePic = "";
           
            $userObject = User::where('id',$user_id)->first();

            if($request->hasFile('image')){

                if($customerObj != null && $customerObj->profile_pic != ''){
                //    unlink('assets/images/'.$customerObj->profile_pic);
                }
                $profilePic = rand(999,99999).'_'.time().'.'.$request->image->getClientOriginalExtension();
                
                $request->image->move('assets/images/', $profilePic);
            }
            if($customerObj == null){
                $customerObj = new  Profiles;
            }
            $customerObj->user_id =  $user_id;
            $customerObj->user_name  = $request->name;
            $customerObj->email  = $userObject->email;
            $customerObj->phone = $request->phone;
            $customerObj->gender = $request->gender;
            $customerObj->address = $request->address;
            if($request->hasFile('image')){
            $customerObj->profile_pic = $profilePic;
            }
            $customerObj->save();           
            $userObject->name = $request->name;
            $userObject->save();  
             return Response::json(array('success' => true,'userinfo'=> $customerObj), 200);


        }
           
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}
