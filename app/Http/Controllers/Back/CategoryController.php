<?php

namespace App\Http\Controllers\Back;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;  // Add this line to import the Category model
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Bagian ini tetap seperti yang Anda isi
        return view('back.category.index', [
            'categories' => Category::latest()->get()
        ]);
    }


    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3'
        ]);
        $data['slug'] = Str::slug($data['name']);
        
        Category::create($data);
        return back()->with('success', 'Categories has been created');
    }

   


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|min:3'
        ]);
        $data['slug'] = Str::slug($data['name']);
        
        Category::find($id)->update($data);
        return back()->with('success', 'Categories has been created');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Kosong
    }
}
