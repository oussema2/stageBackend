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
Route::get("/getUser", [UtilisateurController::class, "getUser"])->middleware("auth:sanctum");
Route::get("/getUsersForAdmin/{numPage}", [UtilisateurController::class, "getUsersForAdmin"]);
Route::delete("/deleteUser/{id}", [UtilisateurController::class, "deleteUser"])->middleware("auth:sanctum");
Route::get("/getSearchedUsers/{pattern}/{numPage}", [UtilisateurController::class, "getSearchedUsers"])->middleware("auth:sanctum");
Route::get("/getUSerForAdmin/{id}", [UtilisateurController::class, "getUSerForAdmin"])->middleware("auth:sanctum");

Route::post("/addCatalogue", [CatalogueController::class, 'addCatalogue'])->middleware("auth:sanctum");
Route::delete("/deleteCatalogue/{id}", [CatalogueController::class, "deleteCatalogue"])->middleware("auth:sanctum");
Route::get("/getCatalogues", [CatalogueController::class, "getCatalogues"]);
Route::get("/getWithSearchNameCategorie/{pattern}/{numPage}", [CatalogueController::class, "getWithSearchNameCategorie"])->middleware("auth:sanctum");
Route::get("/getCategorieInAdminSide/{numPage}", [CatalogueController::class, "getCategorieInAdminSide"]);


Route::post("/addProduct", [ProduitController::class, 'addProduct'])->middleware("auth:sanctum");
Route::put('/updateProduct', [ProduitController::class, 'updateProduct'])->middleware("auth:sanctum");
Route::delete('/deleteProduct/{id}', [ProduitController::class, 'deleteProduct'])->middleware("auth:sanctum");
Route::get("/getProducts/{numpage}", [ProduitController::class, "getProducts"]);
Route::get("/getProductsWithCategorie/{numPage}/{idCategorie}", [ProduitController::class, "getProductsWithCategorie"]);
Route::get("/getPoductsInAdminSide/{numPage}", [ProduitController::class, "getPoductsInAdminSide"]);
Route::get("/getWithSearchName/{pattern}/{numPage}", [ProduitController::class, "getWithSearchName"]);
Route::get("/getProduct/{id}", [ProduitController::class, "getProduct"]);
