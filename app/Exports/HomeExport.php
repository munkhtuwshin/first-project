<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\Post;



class HomeExport implements FromView
{
    public function view(): View
    {
        return view('home.excel.test', [
            'post' => Post::all()
        ]);
    }
}

// use Maatwebsite\Excel\Concerns\FromArray;

// class HomeExport implements FromArray
// {
//     public function array(): array
//     {
//         return [
//             ['name', 'email'],
//             ['John', 'john@example.com'],
//             ['Jane', 'jane@example.com'],
//         ];
//     }
// }