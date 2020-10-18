<?php

namespace App\Http\Controllers;

use App\Image;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|max:255',
            'code'=> 'required|max:255',
            'image-0' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image-1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image-2' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // saves product
        $product = Product::create([
            'name' => $request->get('name'),
            'code' => $request->get('code'),
        ]);

        // saves images
        $files = $request->file();
        foreach ($files as $inputName => $file) {
            $path = $file->store('products');
            $explode = explode('-', $inputName);
            Image::create([
                'product_id' => $product->id,
                'path' => $path,
                'position' => end($explode),
            ]);
        }

        return redirect('/products')->with('success', 'Product crated successful!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $images = $product->images->mapWithKeys(function ($image) {
            return [$image['position'] => $image];
        });

        return view('products.edit', compact('product', 'images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'=> 'required|max:255',
            'code'=> 'required|max:255',
            'image-0' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image-1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image-2' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // saves images
        $files = $request->file();
        foreach ($files as $inputName => $file) {
            $path = $file->store('products');
            $explode = explode('-', $inputName);
            Image::create([
                'product_id' => $product->id,
                'path' => $path,
                'position' => end($explode),
            ]);
        }

        // update product
        $product->update([
            'name' => $request->get('name'),
            'code' => $request->get('code'),
        ]);

        return redirect('/products')->with('success', 'Product updated successful!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('/products')->with('success', 'Product deleted!');
    }

    /**
     * Deletes image from storage and database.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage(Request $request)
    {
        $post = $request->post();
        $image = Image::find($post['imageId']);

        // deletes image from storage and data base
        $success = false;
        if (Storage::delete($image->path) && $image->delete()) {
            $success = true;
        }

        return response()->json(['success'=> $success], 200);
    }

    public function json(Product $product)
    {
        $json = $product->load('images')->toJson(JSON_PRETTY_PRINT);
        return view('products.json', compact('json'));
    }
}
