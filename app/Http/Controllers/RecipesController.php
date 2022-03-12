<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipes;

class RecipesController extends Controller
{
    public function getRecipes(Request $request){
        $recipes = Recipes::getData($request);
        return response()->json([
            "success"   => true,
            "message"   => "Success",
            "data"      => $recipes
        ]);
    }

    public function create(Request $request){
        // return $request->ingredientsPerServing[0]->unit;
        $recipes = Recipes::storeData($request);

        return response()->json([
            "success"   => true,
            "message"   => "Success",
            "data"      => $recipes
        ]);
    }
}
