<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function response;


/**
 * @group Categories
 *
 * Managing Categories
 */
class CategoryController extends Controller
{

    /**
     * Get Categories
     *
     * Display a listing of Categories.
     *
     * @queryParam page Which page to show. Example:12
     */
    public function index(){
        $categories= Category::all();
        return CategoryResource::collection($categories);
    }


    /**
     * Get Specified Category
     *
     * Display the specified category.
     */
    public function show(Category $category){
        return new CategoryResource($category);
    }


    /**
     * POST Category
     *
     * Store a newly created category in storage.
     *
     * @bodyParam name string required Name of the category. Example: "Clothing"
     */
    public function store(Request $request){
        $request->validate([
            'name'=>'required'
        ]);

        $data=$request->all();
        if ($request->hasFile('photo')){
            $file=$request->file('photo');
            $name='categories/'.uniqid().'.'.$file->extension();
            $file->storePubliclyAs('public',$name);
            $data['photo'] = $name;
        }
        $category=Category::create($data);
        return new CategoryResource($category);
    }


    /**
     * PUT Category
     *
     * Update the specified category in storage.
     */
    public function update(Request $request,Category $category){
        $category->update($request->all());
        return new CategoryResource($category);
    }



    /**
     * DELETE Category
     *
     * Remove the specified category from storage.
     */
    public function destroy(Category $category){
        $category->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
