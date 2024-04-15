<?php

namespace App\Http\Controllers;

use App\Models\{Category, Product};
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->has('searchTerm')) {
            return view('products.index', [
                'products' => Product::where('name', 'like', "%".request('searchTerm')."%")->paginate(10)
            ]);
        }
        return view('products.index', [
            'products' => Product::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create',[
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate name unique,required
        $request->validate([
            'name' => 'required|unique:products',
            'category_id' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:8192',
            'description' => 'required'
        ]);

        //store photo
        $photo = $request->file('photo');
        $photo->storeAs('public/products', $photo->hashName());

        //store product
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'photo' => $photo->hashName(),
            'description' => $request->description
        ]);

        return redirect()->route('products.index')->with('success', 'Producto creado con éxito!');


    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
