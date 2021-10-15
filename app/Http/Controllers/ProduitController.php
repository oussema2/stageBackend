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


    public function addProduct(Request $req)
    {
        $val = Validator::make($req->all(), [
            "nom" => "required",
            "description" => "required",
            "quantite" => "required",
            "prix" => "required",
            "image" => "required",
            "idCatalogue" => "required"
        ]);

        if ($val->fails()) {
            return response([
                "status" => 401,
                "message" => $val->errors()
            ]);
        } else {
            $produit = new produit();
            $produit->nom = $req->nom;
            $produit->description = $req->description;
            $produit->quantite = $req->quantite;
            $produit->prix = $req->prix;
            $produit->image = $req->file('image')->store('produitImage', ['disk' => 'public']);
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


    public function updateProduct(Request $req)
    {
        $val = Validator::make($req->all(), [
            "nom" => "required",
            "description" => "required",
            "quantite" => "required",
            "prix" => "required",


        ]);

        if ($val->fails()) {
            return response([
                "status" => 401,
                "message" => $val->errors()
            ]);
        } else {
            $produit =  produit::find($req->id);
            $produit->nom = $req->nom;
            $produit->description = $req->description;
            $produit->quantite = $req->quantite;
            $produit->prix = $req->prix;


            $produit->save();

            return response([
                "status" => 200,
                "data" => $produit,

            ]);
        }
    }

    public function deleteProduct($id)
    {
        return produit::find($id)->delete();
    }

    public function getProduct($id)
    {
        $product = produit::find($id);
        $product->labelCategorie = catalogue::find($product->idCatalogue)->nom;
        return $product;
    }

    public function getProducts($numpage)
    {


        $productsNumber = count(DB::table('produits')->get());
        $products = DB::table('produits')->skip($numpage * 10)->take(10)->get();
        return response([
            "productsNumber" => $productsNumber,
            "status" => 200,
            "data" => $products
        ]);
    }

    public function getProductsWithCategorie($numPage, $idCategorie)
    {

        $productsNumber = count(DB::table('produits')->where("idCatalogue", $idCategorie)->get());
        $products = DB::table('produits')->where("idCatalogue", $idCategorie)->skip($numPage * 10)->take(10)->get();
        return response([
            "productsNumber" => $productsNumber,
            "status" => 200,
            "data" => $products
        ]);
    }
    /* */
    public function getPoductsInAdminSide($numPage)
    {

        $productsNumber = count(produit::all());
        $products = DB::table('produits')->skip($numPage * 10)->select("id", "nom", "description", "quantite", "prix", "idCatalogue")->take(10)->get();
        for ($i = 0; $i < count($products); $i++) {
            $productTypeLabel = catalogue::find($products[$i]->idCatalogue)->nom;
            $products[$i]->categorie = $productTypeLabel;
        }
        return response([
            "productsNumber" => $productsNumber,
            "products" => $products,
            "status" => 200,
            "skipped" => $numPage
        ]);
    }

    public function getWithSearchName($pattern, $numPage)
    {
        $productsNumber = count(DB::table("produits")->where("nom", "LIKE", "%" . $pattern . "%")->get());
        $searchedProducts = DB::table("produits")->where("nom", "LIKE", "%" . $pattern . "%")->skip($numPage * 10)->take(10)->get();
        return   response([
            "productsNumber" => $productsNumber,
            "products" => $searchedProducts,
            "status" => 200,
            "skipped" => $numPage
        ]);
    }
}
