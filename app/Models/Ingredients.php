<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'recipeId', 'item', 'unit', 'value'
    ];

    public static function storeMultipleData($recipeId, $datas){
        $collected_ingredients = [];
        foreach($datas as $data){
            $ingredient = [
                "recipeId"  => $recipeId,
                "item"      => $data['item'],
                "unit"      => $data['unit'],
                "value"     => $data['value'],
            ];
            $collected_ingredients[] = $ingredient;
        }

        Self::insert($collected_ingredients);
    }
}
