<?php

namespace App\Http\Controllers;

use App\Models\{Category, Product, Log, Stock};
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->has('searchTerm')) {
            $query = Product::where('name', 'like', "%".request('searchTerm')."%");

            if($query->count() == 0) {
                return redirect()->route('products.index')->with('success', 'No se encontraron resultados');
            }else{
                return view('products.index', [
                    'products' => $query->paginate(10)
                ]);
            }

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
            'description' => 'required',
            'stock' => 'required'
        ]);

        //store photo
        $photo = $request->file('photo');
        $photo->storeAs('public/products', $photo->hashName());

        //store product
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'photo' => $photo->hashName(),
            'description' => $request->description,
            'stock' => $request->stock
        ]);

        Log::create([
            'message' => 'Se ha creado un nuevo producto',
            'user_id' => auth()->id()
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
        return view('products.edit', [
            'product' => $product,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //validate name unique,required
        $request->validate([
            'name' => 'required|unique:products,name,'.$product->id,
            'category_id' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8192',
            'description' => 'required'
        ]);

        //update photo
        if ($request->hasFile('photo')) {
            $photoFile = $request->file('photo');
            //dd($photo->hashName());
            $photoFile->storeAs('public/products', $photoFile->hashName());
            $photo = $photoFile->hashName();
        } else {
            $photo = $product->photo;
        }

        //update product
        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'photo' => $photo,
            'description' => $request->description
        ]);

        Log::create([
            'message' => 'Se ha actualizado un producto',
            'user_id' => auth()->id()
        ]);

        return redirect()->route('products.index')->with('success', 'Producto actualizado con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //delete
        $product->delete();

        Log::create([
            'message' => 'Se ha eliminado un producto',
            'user_id' => auth()->id()
        ]);

        return redirect()->route('products.index')->with('success', 'Producto eliminado con éxito!');
    }

    //stock}
    public function stock(Product $product)
    {
        return view('products.stock', [
            'product' => $product
        ]);
    }

    //stock store
    public function stockStore(Request $request)
    {
        //validate
        $request->validate([
            'quantity' => 'required',
            'type' => 'required',
            'description' => 'required'
        ]);

        $product = Product::find($request->id);

        //stock validation}
        if ($request->type == 2 && $product->stock < $request->quantity) {
            return redirect()->route('products.index')->with('success', 'No hay suficiente stock para realizar la salida');
        }

        //store
        Stock::create([
            'quantity' => $request->quantity,
            'type' => $request->type,
            'user_id' => auth()->id(),
            'product_id' => $request->id,
            'description' => $request->description
        ]);

        $text = '';
        if ($request->type == 1) {
            $text = 'entrada';
            $product->update([
                'stock' => $product->stock + $request->quantity
            ]);
        } else {
            $text = 'salida';
            $product->update([
                'stock' => $product->stock - $request->quantity
            ]);
        }

        Log::create([
            'message' => 'Se ha actualizado el stock de un producto con una '.$text.' de '.$request->quantity.' unidades',
            'user_id' => auth()->id()
        ]);

        return redirect()->route('products.index')->with('success', 'Stock actualizado con éxito!');
    }

    //stockReport
    public function stockReport(Request $request)
    {
        if ($request->type == 3) {
            $stocks = Stock::where('product_id',$request->product_id)->get();
        }else{
            $stocks = Stock::where('product_id',$request->product_id)->where('type',$request->type)->get();
        }


        /* return view('products.stockReport', [
            'stocks' => $stocks
        ]); */

        $pdf = Pdf::loadView('pdf.inventario', [
            'stocks' => $stocks

        ]);
        return $pdf->download('inventario.pdf');
    }
}
