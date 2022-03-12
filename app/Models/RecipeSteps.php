<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeSteps extends Model
{
    use HasFactory;

    protected $table = 'recipe_steps';
    public $timestamps = false;
    protected $fillable = [
        'recipeId', 'stepOrder', 'description'
    ];

    public static function storeMultipleData($recipeId, $datas){
        $collected_steps = [];
        foreach($datas as $data){
            $step = [
                "recipeId"      => $recipeId,
                "stepOrder"     => $data['stepOrder'],
                "description"   => $data['description'],
            ];
            $collected_steps[] = $step;
        }

        Self::insert($collected_steps);
    }
}
