<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Category;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('posts.index', ['data'=>'ok']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // $parents=Category::get();
        $parents=Category::whereNull("parent_id")->get();
        $data['parents']=$parents;
        return view("posts.create",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input=$request->all();
        $post= new Post;
        $post->title= $input['title'];
        $post->category_id=  @$input['catygory']? $input['catygory']: @$input['parent_catygory'];
        $post->title= $input['title'];
        $post->content= $input['content'];
        $path=null;
        

        $categoryName=Category::find($post->category_id);
        $post->category_name=$categoryName->name;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalName = $file->getClientOriginalName();
            $cleanName = str_replace(' ', '_', $originalName);
            $filename = time() . '_' . $cleanName;
        
            // Файл хадгалах
            $file->storeAs('images', $filename, 'public');
        
            // Вэб дээр харагдах зам
            $post->image = 'storage/images/' . $filename;
        }
        
        $post->save();

        return "ok";
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
