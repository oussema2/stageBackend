<?php

use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\TypeutilisateurController;
use App\Http\Controllers\UtilisateurController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/addTypeUtilisateur', [TypeutilisateurController::class, 'addTypeUtilisateur']);
Route::get('/getAllTypeUtilisateur', [TypeutilisateurController::class, "getAllTypeUtilisateur"]);
Route::delete("/deleteTypeUtilisateur", [TypeutilisateurController::class, "deleteTypeUtilisateur"]);
Route::put("/AddUtilisateurToType", [TypeutilisateurController::class, "AddUtilisateurToType"]);




Route::post('/register', [UtilisateurController::class, 'register']);
Route::post('/logIn', [UtilisateurController::class, 'logIn']);
Route::put('/updateProfile', [UtilisateurController::class, "updateProfile"])->middleware("auth:sanctum");
Route::get("/logOut", [UtilisateurController::class, "logOut"])->middleware("auth:sanctum");


Route::post("/addCatalogue", [CatalogueController::class, 'addCatalogue'])->middleware("auth:sanctum");
Route::delete("/deleteCatalogue", [CatalogueController::class, "deleteCatalogue"])->middleware("auth:sanctum");
Route::get("/getCatalogues", [CatalogueController::class, "getCatalogues"]);



Route::post("/addProduct", [ProduitController::class, 'addProduct'])->middleware("auth:sanctum");
Route::post('/updateProduct', [ProduitController::class, 'updateProduct'])->middleware("auth:sanctum");
Route::delete('/deleteProduct', [ProduitController::class, 'deleteProduct'])->middleware("auth:sanctum");
Route::get("/getProducts", [ProduitController::class, "getProducts"]);
Route::get("/getProductsWithCategorie/{numPage}/{idCategorie}", [ProduitController::class, "getProductsWithCategorie"]);
