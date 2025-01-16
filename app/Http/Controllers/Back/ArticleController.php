<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest; // Pastikan ArticleRequest diimpor
use Illuminate\Support\Str; // Tambahkan untuk fungsi Str::slug

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $article = Article::with('Category')->latest()->get();

            return DataTables::of($article)
                -> addIndexColumn()
                ->addColumn('category_id', function ($article) {
                    return $article->Category->name;
                })
                ->addColumn('status', function ($article) {
                    if ($article->status == 0) {
                        return '<span class="badge bg-danger">Private</span>';
                    } else {
                        return '<span class="badge bg-success">Published</span>';
                    }
                })
                ->addColumn('button', function ($article) {
                    return '<div class="text-center">
                                <a href="article/'.$article->id.'" class="btn btn-secondary">Detail</a>
                                <a href="" class="btn btn-primary">Edit</a>
                                <a href="" class="btn btn-danger">Delete</a>
                            </div>';
                })
                ->rawColumns(['category_id', 'status'])
                ->make();
        }

        return view('back.article.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.article.create', [
            'categories' => Category::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        $data = $request->validated();

        $file = $request->file('img'); // img
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension(); // jpg, jpeg

        $file->storeAs('public/back/', $fileName); // public/back/126783gh.jpg

        $data['img'] = $fileName;
        $data['slug'] = Str::slug($data['title']);

        Article::create($data);

        return redirect(url('article'))->with('success', 'Data article has been created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('back.article.show', [
            'article' => Article::find($id)
          ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('back.article.update', [
            'article' => Article::find($id),
            'categories' => Category::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
