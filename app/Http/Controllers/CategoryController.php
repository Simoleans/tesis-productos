<?php

namespace App\Http\Controllers;

use App\Models\{Category, Log};
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (request()->has('searchTerm')) {
            $query = Category::where('name', 'like', "%".request('searchTerm')."%");

            if($query->count() == 0) {
                return redirect()->route('categories.index')->with('success', 'No se encontraron resultados');
            }else{
                return view('categories.index', [
                    'categories' => $query->paginate(10)
                ]);
            }

        }

        return view('categories.index', [
            'categories' => Category::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate name unique,required
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

        //store category
        $category = Category::create([
            'name' => $request->name
        ]);

        Log::create([
            'message' => 'Se ha creado una nueva categoría',
            'user_id' => auth()->id()
        ]);

        //redirect to categories.index
        return redirect()->route('categories.index')
            ->with('success', 'Categoria creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //validate name unique,required
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id
        ]);

        //update category
        $category->update([
            'name' => $request->name
        ]);

        Log::create([
            'message' => 'Se ha actualizado una categoría',
            'user_id' => auth()->id()
        ]);

        //redirect to categories.index
        return redirect()->route('categories.index')
            ->with('success', 'Categoria actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        //delete
        $category->delete();

        Log::create([
            'message' => 'Se ha eliminado una categoría',
            'user_id' => auth()->id()
        ]);

        //redirect to categories.index
        return redirect()->route('categories.index')
            ->with('success', 'Categoria eliminada correctamente.');
    }
}
