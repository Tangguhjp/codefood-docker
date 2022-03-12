<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;
use App\Models\Ingredients;
use App\Models\RecipeSteps;
use DB;

class Recipes extends Model
{
    use HasFactory;

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    protected $table = 'recipes';


    protected $fillable = [
        'name', 'recipeCategoryId', 'image', 'nServing'
    ];

    protected static function boot()
{
        parent::boot();

        static::creating(function ($query) {
            $query->nReactionLike = $query->nReactionNeutral = $query->nReactionDislike = 0;
        });
    }

    public function recipeCategory() {
        return $this->belongsTo(Categories::class, 'recipeCategoryId','id');
    }

    public function getData($query_data){
        $search_query   = $query_data->q;
        $categoryId     = $query_data->categoryId;
        $sort           = $query_data->sort;
        $limit          = $query_data->limit ? $query_data->limit : 10;
        $skip           = $query_data->skip ? $query_data->skip : 0;

        $where_statement = [];
        $search_query ? $where_statement[] = ["name", "LIKE", "%$search_query%"] : null;
        $categoryId ? $where_statement[] = ["recipeCategoryId", "=", $categoryId] : null;

        switch ($sort) {
            case "name_asc":
                $sorting = "name ASC";
                break;
            case "name_desc":
                $sorting = "name DESC";
                break;
            case "like_desc":
                $sorting = "nReactionLike DESC";
                break;
            default:
                $sorting = "id";
        }

        if(!empty($where_statement)){
            $recipes = Self::with('recipeCategory')->where($where_statement)->skip($skip)->take($limit)->orderByRaw($sorting)->get();
        }else{
            $recipes = Self::with('recipeCategory')->orderByRaw($sorting)->get();
        }

        return $recipes;
    }

    public function storeData($data){
        $recipe = Self::create([
            "name"              => $data->name,
            "recipeCategoryId" => $data->recipeCategoryId,
            "image"             => $data->image,
            "nServing"          => $data->nServing
        ]);

        $ingredients = $data->ingredientsPerServing;
        $steps = $data->steps;

        if(!empty($ingredients)){
            Ingredients::storeMultipleData($recipe->id, $ingredients);
        }

        if(!empty($steps)){
            RecipeSteps::storeMultipleData($recipe->id, $steps);
        }

        $recipe->ingredientsPerServing;
        $recipe->steps;
        return $recipe;
    }

    public function ingredientsPerServing(){
        return $this->hasMany(Ingredients::class, 'recipeId', 'id')->select(['item', 'unit', 'value']);
    }

    public function steps(){
        return $this->hasMany(RecipeSteps::class, 'recipeId', 'id')->select(['stepOrder', 'description'])->orderBy('stepOrder');
    }
}
