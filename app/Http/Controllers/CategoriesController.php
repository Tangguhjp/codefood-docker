<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;

class CategoriesController extends Controller
{
    public function __construct(){
        $this->categories = new Categories();
    }

    public function listCategories(){
        $dataCategories = Categories::all();
        return response()->json([
            "success"   => true,
            "message"   => "Success",
            "data"      => $dataCategories
        ]);
    }

    public function create(Request $request){
        $category = Categories::create([
            "name" => $request->name
        ]);

        return response()->json([
            "success"   => true,
            "message"   => "Success",
            "data"      => $category
        ]);
    }

    public function update(Request $request, $id){
        $category = Categories::find($id);
        $category->name = $request->name;

        if($category->save()){
            return response()->json([
                "success"   => true,
                "message"   => "Success",
                "data"      => $category
            ]);
        }

        return response()->json([
            "success"   => true,
            "message"   => "Failed",
        ]);
    }

    public function delete(Request $request, $id){
        $category = Categories::where([
            "id"    => $id,
            "name"  => $request->name
        ])->delete();

        if($category){
            return response()->json([
                "success"   => true,
                "message"   => "Success",
                "data"      => array()
            ]);
        }

        return response()->json([
            "success"   => true,
            "message"   => "Failed",
        ]);
    }
}
