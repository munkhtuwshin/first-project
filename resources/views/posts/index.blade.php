a
@extends("layout.main")

@section("title", "Нийтлэл хуудас")

@section("content")
<a class="btn btn-primary" href="post/create" >Шинээр нэмэх</a>
<input type="hidden" name="csrf-token" id="csrf-token" value="{{ csrf_token() }}">
<table id="postDataList" class="display">
  <thead>
      <tr>
          <th>Д/д</th>
          <th>Төрлийн нэр</th>
          <th>Гарчиг</th>
          <th>Агуулга</th>
          <th>Зураг</th>
          <th>Бүртгэсэн</th>
          <th>Засварласан</th>
          <th>Засварлах</th>
          <th>устгах</th>
          <th>хэвлэх(docx)</th>
          <th>хэвлэх(pdf)</th>
      </tr>
  </thead>
    <tbody>
        
    </tbody>
</table>


<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalToggleLabel">шинээр нэмэх</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" action="/post/store">
                <fieldset >
                  <legend>Нийтлэл шинээр нэмэх</legend>
                  <div class="mb-3">
                    <label for="title" id="title" class="form-label">гарчиг</label>
                    <input type="text" id="title" class="form-control" placeholder="Гарчиг оруул">
                  </div>
                  <div class="mb-3">
                    <label for="disabledSelect" class="form-label">нийтлэл</label>
                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                  </div>
                  <div class="mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="disabledFieldsetCheck" disabled>
                      <label class="form-check-label" for="disabledFieldsetCheck">
                        Can’t check this
                      </label>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Хадгалах</button>
                </fieldset>
              </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Open second modal</button>
        </div>
      </div>
    </div>
  </div>

 

@endsection

@section("css")
<link href="{{asset('DataTables/datatables.min.css')}}" rel="stylesheet">
@endsection

@section("js")
<script src="{{asset('DataTables/datatables.min.js')}}"></script>

<script>
//   new DataTable('#post')
var mydata= new DataTable('#postDataList', {
    ajax: {
        url: 'post/datalist',
        type: 'GET'
    },
    columns: [
        { data: 'id', default: "" },
        { data: 'category_name', default: "" },
        { data: 'title', default: "" },
        { data: 'content', default: "" },
        { data: 'image', render:(data, type, row, meta)=>{
           if(row.image){
             return `<img src="/${row.image}" width="200" height="200"/>`
           }else{
            return "";
           }
        } },
        { data: 'created_at', default: "" },
        { data: 'updated_at', default: "" },
        { name: "edit", render:(data, type, row, meta)=>{
          return `<a href="/post/${row.id}/edit"> <i class="bi bi-pen"></i></a>`;
        }, default:""},
        {data: '', render:function (data, type, row, meta){
          return `<a href="javascript:deleteCategory(${row.id}, '${row.title}')"> <i class="bi bi-trash"></i></a>`;
        }},
        {
  data: '',
  render: function(data, type, row, meta) {
    return `<a href="javascript:wordCreate(${row.id}, '${row.category_name}', '${row.title}', '${row.content}', '${row.image}')">
              <i class="bi bi-printer-fill"></i></a>`;
  }},
  {
  data: '',
  render: function(data, type, row, meta) {
    return `<a href="javascript:pdfCreate(${row.id})">
              <i class="bi bi-filetype-pdf"></i></a>`;
  }},
    ],
    processing: true,
    serverSide: true,
    order:[[6,"desc"]],
});

// $.toast({ 
//   text : "Let's test some HTML stuff... <a href='#'>github</a>", 
//   showHideTransition : 'slide',  // It can be plain, fade or slide
//   bgColor : 'blue',              // Background color for toast
//   textColor : '#eee',            // text color
//   allowToastClose : false,       // Show the close button or not
//   hideAfter : 5000,              // `false` to make it sticky or time in miliseconds to hide after
//   stack : 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
//   textAlign : 'left',            // Alignment of text i.e. left, right, center
//   position : 'top-right'       // bottom-left or bottom-right or bottom-center or top-left or top-right or 
// })
function deleteCategory(id,title)
{
    $.confirm({
    title: 'Анхаар!',
    content: `Та ${title} гэсэн нэртэй ангилалыг устгахдаа итгэлтэй байна уу`,
    buttons: {
        confirm: {
            text: "Устгах",
            btnClass: 'btn-red',
            action: function () {
                $.ajax({
                    url: "/post/"+id,
                    method: "DELETE", 
                    headers: {
                    'X-CSRF-TOKEN': $('#csrf-token').val()
                    },      
                    data: null,
                    success: function (response) {
                        $.toast({ 
                          text : "Амжилттай устгагдлаа", 
                          showHideTransition : 'slide',  
                          bgColor : 'green',              
                          textColor : '#eee',            
                          allowToastClose : false,       
                          hideAfter : 5000,              
                          stack : 5,                     
                          textAlign : 'left',            
                          position : 'top-right'       
                        })
                        mydata.draw();

                    },
                    error: function (xhr) {
                        // console.error("Алдаа:", xhr.responseText);
                        $.toast({ 
                          text : "Алдаа:"+ xhr.responseText, 
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
            }
        },
        cancel: {
            text: "Болих",
            btnClass: 'btn-blue',
        },
    }
});
}
function wordCreate(id,category_name, title,content,image) {
    // console.log("Printing:", id,category_name, title,content,image);
    
    window.location.href = `/post/${id}/word`;
}
function pdfCreate (id,category_name, title,content,image){
  console.log("Printing:", id,category_name, title,content,image);
   window.location.href = `/post/${id}/pdf`;
}


</script>



@endsection