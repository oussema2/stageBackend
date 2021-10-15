<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\typeutilisateur;
use Facade\FlareClient\Http\Response;
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
    public function getUser()
    {
        $user = Auth::user();
        $typeName = typeutilisateur::find($user->Idtype)->labeltype;
        $user->typeLabel = $typeName;
        return Response([
            "user" => $user,
            "status" => 200
        ]);
    }

    public function deleteUser($id)
    {
        return User::find($id)->delete();
    }


    public function getSearchedUsers($pattern, $numPage)
    {
        $userNumber = count(DB::table("users")->where("name", "LIKE", "%" . $pattern . "%")->get());
        $searchedUsers = DB::table("users")->where("name", "LIKE", "%" . $pattern . "%")->skip($numPage * 10)->take(10)->get();
        return   response([
            "userNumber" => $userNumber,
            "users" => $searchedUsers,
            "status" => 200,
            "skipped" => $numPage
        ]);
    }
    public function getUSerForAdmin($id)
    {
        return User::find($id);
    }
    /*  */
    public function getUsersForAdmin($numPage)
    {
        $usersNumber = count(User::all());
        $users = DB::table('users')->select("id", "name", "email", "Idtype", "dateDeNaissance")->skip($numPage * 10)->take(10)->get();
        for ($i = 0; $i < count($users); $i++) {
            $typeName = typeutilisateur::find($users[$i]->Idtype)->labeltype;
            $users[$i]->Type = $typeName;
        }
        return response([
            "userNumber" => $usersNumber,
            "users" => $users,
            "status" => 200,
            "skipped" => $numPage
        ]);
    }

    public function register(Request $req)
    {
        $val = Validator::make($req->all(), [
            'name' => 'required|max:20',
            'email' => 'required|email',
            'password' => 'min:6',
            'dateDeNaissance' => 'required'
        ]);

        if ($val->fails()) {
            return response([
                "status" => 401,
                "messages" => $val->errors()
            ]);
        } else {
            $utilisateur = new User();
            $utilisateur->name = $req->name;
            $utilisateur->email = $req->email;
            $hashed = Hash::make($req->password, [
                'rounds' => 12,
            ]);
            $utilisateur->password =  $hashed;
            $utilisateur->Idtype = 1;
            $utilisateur->dateDeNaissance = $req->dateDeNaissance;
            $utilisateur->save();
            return response([
                "status" => 200,
                "data" =>   $utilisateur
            ]);
        }
    }

    public function logIn(Request $req)
    {

        $user =  User::where('email', $req->email)->first();
        if (!$user || !Hash::check($req->password, $user->password)) {
            return response([
                'status' => 401,
                'message' => 'Invalid Email OR Password'

            ]);
        } else {
            $token = $user->createToken($user->email . '_Token')->plainTextToken;

            $user->remember_token = $token;
            $user->save();
            return response([
                'user' => $user,
                'token' => $token,
                'status' => 200,
                'message' => 'logged in',
            ]);
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
        $user->Idtype = $user->Idtype;
        $user->dateDeNaissance = $req->dateDeNaissance;
        $user->save();
        return response([
            "user" => $user,
            "status" => 200
        ]);
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
            "status" => 200,
            "message" => "loggedOut"
        ]);
    }



    public function FunctionName($i)
    {
        dd("oussema");
    }
}
