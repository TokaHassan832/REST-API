<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;


/**
 * @group Products
 *
 * Managing Products
 */
class ProductController extends Controller
{
    /**
     * Get Products
     *
     * Display a listing of Products.
     */
    public function index()
    {
        $products= Product::with('category')->paginate(5);
        return ProductResource::collection($products);

    }

    /**
     * POST Product
     *
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'slug'=>'required',
            'price'=>'required',
        ]);
        return Product::create($request->all());
    }

    /**
     * Get Specified Product
     *
     * Display the specified product.
     */
    public function show(string $id)
    {
        return Product::find($id);
    }

    /**
     * PUT Product
     *
     * Update the specified product in storage.
     */
    public function update(Request $request, string $id)
    {
        $product= Product::find($id);
        $product->update($request->all());
        return $product;
    }

    /**
     * DELETE Product
     *
     * Remove the specified product from storage.
     */
    public function destroy(string $id)
    {
        return Product::destroy($id);
    }

    /**
     * Search For Product
     */
    public function search(string $name)
    {
        return Product::where('name','like','%'.$name.'%')->get();
    }
}
