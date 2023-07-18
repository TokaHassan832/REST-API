<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index(){
        $categories= Category::all();
        return CategoryResource::collection($categories);
    }

    public function show(Category $category){
        return new CategoryResource($category);
    }

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

    public function update(Request $request,Category $category){
        $category->update($request->all());
        return new CategoryResource($category);
    }

    public function destroy(Category $category){
        $category->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
