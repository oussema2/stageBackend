<?php

namespace App\Http\Controllers;

use App\Models\produit;
use App\Models\catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProduitController extends Controller
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
     * @param  \App\Models\produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show(produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit(produit $produit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, produit $produit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(produit $produit)
    {
        //
    }


    public function addProduit(Request $req)
    {
        $val = Validator::make($req->all() , [
            "nom" => "required",
            "description" => "required",
            "quantite" => "required",
            "description" => "required",
            "prix" => "required",
            "image" => "required",
            "idCatalogue" => "required"
        ]);

        if ($val->fails()) {
            return response([
                "status" => 401 , 
                "message" => $val->errors()
            ]);
        }else {
            $produit = new produit();
            $produit->nom = $req->nom;
            $produit->description = $req->description;
            $produit->quantite = $req->quantite;
            $produit->prix = $req->prix;
            $produit->image = $req->file('image')->store('produitImage',['disk' => 'public']);
            $produit->idCatalogue = $req->idCatalogue;
            $catalogue = catalogue::find($req->idCatalogue);
            $catalogue->nombreProduit =   $catalogue->nombreProduit + 1;
           
            $produit->save();
            $catalogue->save();
            return response([
                "status" => 200, 
                "data" => $produit,
                "catalogue" => $catalogue
            ]);

        }
    }


    public function updateProduit(Request $req , $id)
    {
        $val = Validator::make($req->all() , [
            "nom" => "required",
            "description" => "required",
            "quantite" => "required",
            "description" => "required",
            "prix" => "required",
            "image" => "required",
            "idCatalogue" => "required"
        ]);

        if ($val->fails()) {
            return response([
                "status" => 401 , 
                "message" => $val->errors()
            ]);
        }else {
            $produit =  produit::find($id);
            $produit->nom = $req->nom;
            $produit->description = $req->description;
            $produit->quantite = $req->quantite;
            $produit->prix = $req->prix;
            $produit->image = $req->file('image')->store('produitImage',['disk' => 'public']);
            $produit->idCatalogue = $req->idCatalogue;
           
            $produit->save();
           
            return response([
                "status" => 200, 
                "data" => $produit,
                
            ]);

        }
    }

    public function deleteProduit($id)
    {
            return produit::find($id)->delete();
    }



    public function getProduit($numPage)
    {
        $prod = DB::table('produits')->skip($numPage * 10)->take(10)->get();
        return response([
            "status"=> 200,
            "data" => $prod
        ]);
    }
}
