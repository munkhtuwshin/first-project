
@extends("layout.main")

@section("title", "Нийтлэл шинээр нэмэх")

@section("content")
    <form id="editPost" enctype="multipart/form-data" >
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      
      <div class="mb-3">
        <label for="parent_catygory" class="form-label">Эцэг ангилал</label>
        <select name="parent_catygory" id="parentCatygory" class="form-control">
            <option value="" {{$selectParentCategory? "": "selected"}}></option>
            @foreach($parents as $parent)
            <option value="{{$parent->id}}" {{$parent->id == $selectParentCategory? "selected": ""}}>{{$parent->name}}</option>
            @endforeach
        </select>
      </div>
      <div class="mb-3">
        <label for="catygory" class="form-label">Хүү ангилал</label>
        <select name="catygory" id="catygory" class="form-control">
            <option value="" {{$selectChildCategory? "": "selected"}}></option>
            @foreach($childList as $child)
            <option value="{{$child->id}}" {{@$child->id == @$selectChildCategory?"selected":""}}>{{$child->name}}
            </option>
            @endforeach
        </select>
      </div>
      <div class="mb-3">
        <label for="title"  class="form-label" >гарчиг</label>
        <input type="text" name="title" id="title" class="form-control" value="{{$post->title}}">
      </div>

      
      <div class="mb-3">
        <label for="content" class="form-label">Агуулга</label>
        <textarea name="content" id="content" class="form-control" cols="30" rows="10"> {{$post->content}}</textarea>
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Зураг</label>
        <input type="file" name="image" id="image" class="form-control">
      </div>
      <div class="d-flex justify-content-center gap-4 m-2">
        <button class="btn btn-success" type="submit"> хадгалах </button>
        <a href="/post" class="btn btn-primary">Буцах </a>
      </div>
      </form>
@endsection
@section('js')
<script src="{{asset('ckeditor\ckeditor.js')}}"></script>
<script>
$(document).ready(function(){

      CKEDITOR.replace('content');

      $("#parentCatygory").change(function(e){
        let id= e.target.value;
        $.get("/category/option/tags/"+id).then(e=>{ 
          $("#catygory").html(`<option value="" selected></option> `+e);
        }).catch(e=>{ console.log("aldaa: ", e);})
      })

      $('#editPost').submit(function(event) {
          
      event.preventDefault(); // Prevent default submission
      for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
      }
      let formData = new FormData(this); 

      // // file input авах
      // let fileInput = $("input[name='image']")[0].files[0];
      // if(fileInput){
      //   formData.push({
      //         name: "image",
      //         value: fileInput.name // Зөвхөн файл нэр оруулж байгаа (файлыг дамжуулахгүй)
      //     });
      // }
      console.log([...formData.entries()][0]);
      let csrf = [...formData.entries()][0][1];

      formData.append('_method', 'PUT');
      // delete formData[0];

      $.ajax({
          url: "/post/{{$post->id}}",
          method: "POST", 
          headers: {
          'X-CSRF-TOKEN': csrf
          },      
          data: formData, 
          processData: false, // FormData-г автоматаар хөрвүүлэхгүйa
          contentType: false, // Content-Type-г автоматаар тохируулах
          success: function (response) {
              window.location.href="/post"
          },
          error: function (xhr) {
              console.error("Алдаа:", xhr.responseText);
          }
      });
  });
}); 
</script>
@endsection