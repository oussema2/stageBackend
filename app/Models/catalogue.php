<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogue extends Model
{
    use HasFactory;


    public function utilisateur()
    {
        return $this->hasOne(utilisateur::class);
    }
    public function produit()
    {
        return $this->hasMany(produit::class);
    }
}
