<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


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
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * PUT Product
     *
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return new ProductResource($product);
    }

    /**
     * DELETE Product
     *
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }

    /**
     * Search For Product
     */
    public function search(string $name)
    {
        return Product::where('name','like','%'.$name.'%')->get();
    }
}
