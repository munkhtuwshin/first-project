<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Category;

use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;



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
    public function edit(Request $request,post $post)
    {
        $data['post']=$post;
        $parents=Category::whereNull("parent_id")->get();
        $selectParentCategory= null;
        $selectChildCategory= null;
        $childList=[];
        if($post->category)
        {
        
            $selectParentCategory= @$post->category->parent_id !=null ? $post->category->parent_id: $post->category->id;
            $selectChildCategory=@$post->category->parent_id !=null ? $post->category->id : null;

            if(@$post->category)
            {
                 $childList= Category::where("parent_id",$selectParentCategory)->get();
            }
        }

        $data['selectParentCategory']=$selectParentCategory;
        $data['selectChildCategory']=$selectChildCategory;
        $data['childList']=$childList;
        $data['parents']=$parents;

        return view('posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, post $post)
    {
        $input=$request->all();
        // $post= new Post;
        $post->title= $input['title'];
        $post->category_id=  @$input['catygory']? $input['catygory']: @$input['parent_catygory'];
        // $post->category_id=  @$input['category_id'];
        $post->content= $input['content'];
        $path=null;
        

        $categoryName=Category::find($post->category_id);
        $post->category_name=@$categoryName->name;

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

        return $post;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(post $post)
    {
        $post->delete();
        return "ok";
    }

    public function dataTable(Request $request)
    {
        
        $model = Post::get();
        // dd('edm', $model);
        return DataTables::make($model)
                    ->make(true);
    }

    public function wordGenerate(Post $post)
    {   
        
        //  $date = Carbon::now();
        // dd($date->format('Y-m-d H:i:s'));

           // QR кодыг үүсгэж хадгалах
        $qrPath = public_path('qrcode.png');
        \QrCode::format('png')
            ->size(300)
            ->generate('http://192.168.1.6:8000/post/4/word', $qrPath);

        // Template зам
        $templatePath = storage_path('app/templates/test.docx');
    
        // TemplateProcessor үүсгэхУУ
        $templateProcessor = new TemplateProcessor($templatePath);
        
        // Placeholder-уудыг солих
        $templateProcessor->setValue('ovog', 'Сэргэлэнбаяр');
        $templateProcessor->setValue('ner', 'Мөнхтүвшин');
        $templateProcessor->setValue('id',$post->id ?? "олсонгүй");
        $templateProcessor->setValue('category_name',$post->category_name ?? "олсонгүй");
        $templateProcessor->setValue('title',$post->title ?? "олсонгүй");
        $content = strip_tags($post->content ?? "Олдсонгүй");
        $templateProcessor->setValue('content',$content);
        // $templateProcessor->setValue('image', "hooson");
        // dd(public_path($post->image));
        $templateProcessor->setImageValue('image', [
            'path' => public_path($post->image),
            'width' => 400,
            'height' => 400,
            'ratio' => true
        ] ?? "олдсонгүй");

            // QR кодыг зураг болгон оруулах
        $templateProcessor->setImageValue('qr', [
            'path' => $qrPath,
            'width' => 150,
            'height' => 150,
            'ratio' => true
        ]);
        //  $templateProcessor->setValue('image',$post->image);
        //  dd($post);

        // Шинэ Word файл хадгалах
        $outputPath = storage_path('app/public/generated.docx');
        $templateProcessor->saveAs($outputPath);

        

        // Файлыг татуулах
        return response()->download($outputPath)->deleteFileAfterSend(true);
        
    }

    public function generate()
    {
        // Шууд текстээс QR code үүсгэх
        return QrCode::size(300)->generate('https://www.google.com/');
    }
    public function pdfgenerate($id)
    {
        $post = Post::findOrFail($id);
       
        $pdf = PDF::loadView('posts.pdf', ['post' => $post])
                  ->setOptions(['defaultFont' => 'DejaVu Sans']);
    
        return $pdf->download("downloaded.pdf");
    }
}
