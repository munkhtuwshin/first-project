<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use DataTables;
// use App\Models\Category;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('post.index', ['data'=>'ok']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // $parents=Category::get();

        return view("post.create",[]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        dd('emd');
        // dd($post);
        return view('category.edit', ['post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(post $post)
    {
        //
    }

    public function dataTable(Request $request)
    {
        
        $model = Post::get();
        // dd('edm', $model);
        return DataTables::make($model)
                    ->make(true);
    }
}
