<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>{{ $post->title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>
    <p<{{ $post->category_id }}</p>
        <p<{{ $post->title }}</p>
         <p>Төрөл: {{ $post->category_name }}</p>
         <p>{{$post->content}}</p>
         @if($post->image && file_exists(public_path($post->image)))
    @php
        $path = public_path($post->image);
        $base64 = 'data:image/' . pathinfo($path, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($path));
    @endphp
    <img src="{{ $base64 }}" width="300" />
    <p<{{ $post->created_at }}</p>
    <p<{{ $post->updated_at}}</p>
@endif

     
</body>
</html>
