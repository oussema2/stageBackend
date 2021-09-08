<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\catalogue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UtilisateurController extends Controller
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
     * @param  \App\Models\utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */
    public function show(User $utilisateur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */
    public function edit(User $utilisateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $utilisateur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $utilisateur)
    {
        //
    }

    public function register(Request $req)
    {
       $val = Validator::make($req->all() , [
        'name' => 'required|max:20',
        'email' =>'required|email',
        'password' =>'min:6',
        'dateDeNaissance' =>'required'
       ]);

       if ($val->fails()) {
           return response ([
               "status"=> 401, 
               "messages" => $val->errors()
           ]);
       }else {
           $utilisateur = new User();
           $utilisateur->name = $req->name;
           $utilisateur->email = $req->email;
           $hashed = Hash::make($req->password, [
            'rounds' => 12,
        ]);
           $utilisateur->password =  $hashed ;
           $utilisateur->Idtype = 2;
           $utilisateur->dateDeNaissance = $req->dateDeNaissance;
            $utilisateur->save();
           return response([
               "status"=> 200, 
               "data"=>   $utilisateur
           ]);
       }
    }

    public function logIn(Request $req)
    {
        $val = Validator::make($req->all() , [
           
            'email' =>'required|email',
            'password' =>'min:6',
           
           ]);
        if ($val->fails()) {
            return response([
                "status" => 401,
                "message" => $val->errors()
            ]);
        }else {
            $user =  User::where('email' ,$req->email)->first();
            if(!$user || !Hash::check($req->password , $user->password)){
                return response([
                    'status'=>401,
                    'message' => 'Invalid Email OR Password'
     
                ]);
            }else {
                $token = $user->createToken($user->email.'_Token')->plainTextToken;
               
                $user->remember_token = $token;
                $user->save() ; 
                return response([
                    'user' => $user,
                    'token' => $token,
                    'status' => 200,
                    'message' => 'logged in',
                ]);
            }
        }
    }

    public function updateProfile(Request $req)
    {
     
        $id = Auth::user()->id;
        $user = User::find($id);


        $user->name = $req->name;
        $user->email = $req->email;
        $hashed = Hash::make($req->password, [
            'rounds' => 12,
        ]);
        $user->password = $hashed;
        $user->name = $req->Idtype;
        $user->name = $req->dateDeNaissance;
        $user->save();
        return $user;
    }

    public function logOut(Request $req)
    {
        $userX = request()->user();
        $id = Auth::user()->id;
        $user = User::find($id);
      
        $userX->tokens()->where('tokenable_id', $user->id)->delete();
        
        $user->remember_token = null;
        $user->save();
        return response([
            "status"=> 200,
            "message" => "loggedOut"
        ]);
    }

  

    
}
