
@extends("layout.main")

@section("title", "Нийтлэл шинээр нэмэх")

@section("content")
    <form id="PostCreate" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="mb-3">
        <label for="parent_catygory" class="form-label">Эцэг ангилал</label>
        <select name="parent_catygory" id="parentCatygory" class="form-control">
            <option value="" selected></option>
            @foreach($parents as $parent)
            <option value="{{$parent->id}}">{{$parent->name}}</option>
            @endforeach
        </select>
      </div>
      <div class="mb-3">
        <label for="catygory" class="form-label">Хүү ангилал</label>
        <select name="catygory" id="catygory" class="form-control">
            <option value="" ></option>
        </select>
      </div>
      <div class="mb-3">
        <label for="title"  class="form-label" >гарчиг</label>
        <input type="text" name="title" id="title" class="form-control">
      </div>

      
      <div class="mb-3">
        <label for="content" class="form-label">Агуулга</label>
        <textarea name="content" id="content" class="form-control" cols="30" rows="10"></textarea>
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
    CKEDITOR.replace( 'content' );

    $("#parentCatygory").change(function(e){
        let id= e.target.value;
        $.get("/category/option/tags/"+id).then(e=>{ 
          // console.log(e) 
          $("#catygory").html(`<option value="" selected></option> `+e);
        }).catch(e=>{ console.log("aldaa: ", e);})
        // e.target.value
      })


    $("#PostCreate").on("submit",function(e){
      e.preventDefault();
       // CKEditor утгыг textarea руу шинэчилнэ
      for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
      }
      let formData = new FormData(this); 

      // var content = CKEDITOR.instances.content.getData()


      console.log([...formData.entries()]);

      // validation
      if(formData["title"]=="")
      {
        $("#title").focus();
        $.toast({ 
                          text : "Гарчиг хоосон байж болохгүй заавал оруулна уу!!!", 
                          showHideTransition : 'slide',  
                          bgColor : 'red',              
                          textColor : '#eee',            
                          allowToastClose : false,       
                          hideAfter : 5000,              
                          stack : 5,                     
                          textAlign : 'left',            
                          position : 'top-right'       
                        })

        return;
      }


      
      $.ajax({
        url: "/post",
        type: "POST",
        data: formData,
        contentType: false, // FormData-д шаардлагатай
        processData: false, // FormData-г өөрчлөхгүй
        success: function (response) {
          console.log("Амжилттай:", response);
          $.toast({ 
                          text : "Амжилттай хадгалагдлаа", 
                          showHideTransition : 'slide',  
                          bgColor : 'green',              
                          textColor : '#eee',            
                          allowToastClose : false,       
                          hideAfter : 5000,              
                          stack : 5,                     
                          textAlign : 'left',            
                          position : 'top-right'       
                        })

          window.location.href="/post";
        },
        error: function (xhr) {
          console.log("Алдаа:", xhr.responseText);
          $.toast({ 
                          text : "Хадгалхад алдаа гарлаа", 
                          showHideTransition : 'slide',  
                          bgColor : 'red',              
                          textColor : '#eee',            
                          allowToastClose : false,       
                          hideAfter : 5000,              
                          stack : 5,                     
                          textAlign : 'left',            
                          position : 'top-right'       
                        })
        }
      });
    })

  });
</script>

@endsection