<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  view('category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents=Category::whereNull("parent_id")->get();
        $data['parents']=$parents;
        return view('category.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $category = new Category;

        $category->name = $input['name'];
        $category->parent_id = $input['parent'];
        $category->save();
        
        return redirect('/category');
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
        $data['category']=$category;
        $parents=Category::whereNull("parent_id")->get();
        $data['parents']=$parents;

        return view('category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $input = $request->all();
        $category->name=  $input['name'];
        $category->parent_id= $input['parent_id'];
        $category->save();
        return $category;
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return "ok";
    }

    public function dataTable(Request $request)
    {
        // $input=$request->all();
        $categyList= Category::query();

        $dataList = DataTables::eloquent($categyList)->filter(function($dt) use ($request){

            if($request->has("parent") && $request->get("parent")=="true")
            {
                $dt->whereNull("parent_id");
            }

        })->addColumn("parent_name", function($dt){
            if(@$dt->parent_id)
            {
                $parent= Category::find(@$dt->parent_id);
                return $parent->name;
            }else {
                return "";
            }
        })->make(true);
        return $dataList;
    }
}
