<?php

namespace App\Http\Controllers;

use App\Models\catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CatalogueController extends Controller
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
     * @param  \App\Models\catalogue  $catalogue
     * @return \Illuminate\Http\Response
     */
    public function show(catalogue $catalogue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\catalogue  $catalogue
     * @return \Illuminate\Http\Response
     */
    public function edit(catalogue $catalogue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\catalogue  $catalogue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, catalogue $catalogue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\catalogue  $catalogue
     * @return \Illuminate\Http\Response
     */
    public function destroy(catalogue $catalogue)
    {
        //
    }

    public function addCatalogue(Request $req)
    {
        $val = Validator::make($req->all(), [
            'nom' => 'required',
            'description' => "required",
            "icon" => "required",

        ]);

        if ($val->fails()) {
            return response([
                "status" => 401,
                "message" => $val->errors()
            ]);
        } else {
            $user = Auth::user();

            $catalogue = new catalogue();
            $catalogue->nom = $req->nom;
            $catalogue->description = $req->description;
            $catalogue->icon = $req->file('icon')->store('CatalogueIcon', ['disk' => 'public']);
            $catalogue->nombreProduit = 0;
            $catalogue->idUtilisateur = $user->id;
            $catalogue->save();
            return $catalogue;
        }
    }

    public function deleteCatalogue($id)
    {
        $res = DB::table('catalogues')->where("id", $id)->delete();
        $resProd = DB::table('produits')->where("idCatalogue", $id)->delete();

        return response([
            "status" => 200,
            "message" => "deleted",
            "resCat" => $res,
            "resProd" => $resProd
        ]);
    }

    public function getCatalogues()
    {
        return response([
            "categorieNumber" => count(catalogue::all()),
            "status" => 200,
            "categories" => catalogue::all()
        ]);
    }

    public function getWithSearchNameCategorie($pattern, $numPage)
    {
        $categorieNumber = count(DB::table("catalogues")->where("nom", "LIKE", "%" . $pattern . "%")->get());
        $categories = DB::table("catalogues")->where("nom", "LIKE", "%" . $pattern . "%")->skip($numPage * 10)->take(10)->get();
        return   response([
            "categorieNumber" => $categorieNumber,
            "categories" => $categories,
            "status" => 200,
            "skipped" => $numPage
        ]);
    }

    public function getCategorieInAdminSide($numPage)
    {
        $categorieNumber = count(catalogue::all());
        $categories = DB::table('catalogues')->select("id", "nom", "description", "nombreProduit")->skip($numPage * 10)->take(10)->get();
        return response([
            "categorieNumber" => $categorieNumber,
            "categories" => $categories,
            "status" => 200,
            "skipped" => $numPage
        ]);
    }
}
