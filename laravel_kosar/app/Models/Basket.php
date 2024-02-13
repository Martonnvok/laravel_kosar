<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    
    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('user_id', '=', $this->getAttribute('user_id'))
            ->where('item_id', '=', $this->getAttribute('item_id'));

        return $query;
    }

    public function felhasznalo(){
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function productok(){
        return $this->hasMany(Product::class,'item_id', 'item_id');
    }
}
