<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\User;
use App\UserTypes;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserTypes(){

        $user_types = UserTypes::all();
        $result =[];
        foreach($user_types as $user_type){
            $records =array(
                  "id"=>$user_type->id,
                  "name"=>$user_type->user_name,
                 
              );
             array_push($result,$records);
        }
        //return all userTypes //Doctor,Pharmacist..
        return UserResource::collection($result);
       
    }
    public function index()
    {
        //
       
        $users = User::all();
       
        $result =[];
        foreach($users as $user){

           
            $name = $user->name;
            $email = $user->email;
            $last_logged_in = $user->last_logged_in;
            $user_type = $user->user_type;
            $authorized = $user->authorized;
            $authorized_at = "UNAUTHORIZED" ;
            //get user_name based on the valueuser_type value
            if($user_type > 0){
                $user_types = DB::table('usertypes')
                    ->where('id',$user_type >0 ?"=":"<>",   $user_type )
                    ->first();
                $user_type = strtoupper($user_types->user_name);
                $authorized_at = $user_types->authorized_at;
            }else{
                $user_type ="UNAUTHORIZED";
            }
           if($authorized > 0){
                
                $authorized = $authorized_at;
            }else{
                $authorized =$authorized_at;
            }
            
            //create each user record with user _type and authroized
              $records =array(
                  "id"=>$user->id,
                  "name"=>$name,
                  "email"=>$email,
                  "last_logged_in"=>$last_logged_in,
                  "user_type"=>$user_type,
                  "authorized"=>$authorized,
              );
             array_push($result,$records);
        }
        //send user in an array format
        return UserResource::collection($result);
        
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

    public function userUpdate($userId, $user_type)
    {
        


            $user = User::where(['id'=>$userId])->first();
           
            // dd($user);
            $user->user_type = $user_type;
           
           $user->update();

           return "success";
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
    public function update(Request $request, User $user)
    {
       
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