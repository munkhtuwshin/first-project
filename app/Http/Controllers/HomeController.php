<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Exports\HomeExport;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('home', ['data'=>'ok']);
        // return "hihi";
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Home $home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Home $home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Home $home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Home $home)
    {
        //
    }

    public function testPdf()
    {
        // return view("home.pdf.test",[]);
       
    
        // $pdf = PDF::loadView('home.pdf.test', [])
        // $pdf = PDF::loadView('home.pdf.test', [])->setPaper('a4', 'landscape')
        $pdf = PDF::loadView('home.pdf.test', [])->setPaper('a4', 'portrait')
        ->setOptions([
            'defaultFont' => 'DejaVu Sans',
            // 'isRemoteEnabled' => true
        ]);
    
    
        // return $pdf->download("downloaded.pdf");
        return $pdf->stream();
    }

    public function testExcel(){
        return Excel::download(new HomeExport, 'posts.xlsx');
    }
}
