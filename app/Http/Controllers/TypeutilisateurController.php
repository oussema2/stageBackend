<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\typeutilisateur;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TypeutilisateurController extends Controller
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
     * @param  \App\Models\typeutilisateur  $typeutilisateur
     * @return \Illuminate\Http\Response
     */
    public function show(typeutilisateur $typeutilisateur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\typeutilisateur  $typeutilisateur
     * @return \Illuminate\Http\Response
     */
    public function edit(typeutilisateur $typeutilisateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\typeutilisateur  $typeutilisateur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, typeutilisateur $typeutilisateur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\typeutilisateur  $typeutilisateur
     * @return \Illuminate\Http\Response
     */
    public function destroy(typeutilisateur $typeutilisateur)
    {
        //
    }

    public function addTypeUtilisateur(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'labeltype' => 'required',
           
        ]);
        if($validator->fails()){
            return response([
                'status'=>401,
                'message' => $validator->errors()
 
            ]);
       }else {
           $typeUser = new typeutilisateur();
           $typeUser->labeltype = $req->labeltype;
           $typeUser->numberUtilisateur = 0;
           $typeUser->save();
           return $typeUser;
       }
    }

    public function getAllTypeUtilisateur()
    {
        return typeutilisateur::all();
    }

    public function deleteTypeUtilisateur($id)
    {
        return typeutilisateur::find($id)->delete();
    }

    static function AddUtilisateurToType($id)
    {
        $typeUtilisateur = typeutilisateur::find($id);
        $typeUtilisateur->numberUtilisateur =   $typeUtilisateur->numberUtilisateur + 1 ;
        $typeUtilisateur->save();
        return $typeUtilisateur;
    }
}
