@extends("layout.main")

@section("title", "Ангилал хуудас")

@section("content")
@csrf
<div class="mb-3">
    <label for="name" class="form-label">Эцэг ангилалаар хайх</label>
    <input type="checkbox" id="parent">
  </div>

<table class="table table-bordered" id="categoryList">
    <a href="category/create" class="btn btn-primary">Шинээр ангилал нэмэх</a>
    <thead> 
        <th> № </th>
        <th> Засах </th>
        <th> Ангилал нэр </th>
        <th> Эцэг ангилал </th>
        <th> засварласан </th>
        <th> үүсгэсэн </th>
        <th> устгах </th>
    </thead>
    <tbody>
    </tbody>
</table>
@endsection


@section("css")
<link href="{{asset('DataTables/datatables.min.css')}}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset('jquery-confirm3.3.4/jquery-confirm.min.css')}}">
@endsection

@section("js")
<script src="{{asset('DataTables/datatables.min.js')}}"></script>
<script src="{{asset('jquery-confirm3.3.4/jquery-confirm.min.js')}}"></script>
<script>

var categoryDt=new DataTable("#categoryList" ,{
    processing: true,
    serverSide: true,
    ajax: {
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: 'category/datalist',
        data: function(d){
            d.parent=$("#parent").is(':checked');
        },
        type: 'POST'
    },
    columns: [
        {data: 'id', default:""},
        {data: '', render:function (data, type, row, meta) {
                return `<a href="/category/${row.id}/edit"><i class="bi bi-pen"></i></a>`;
            }, default:""},
        {data: "name", default:""},
        {data: "parent_name", default: "--"},  
        {data: "created_at", default: "--"},  
        {data: "updated_at", default: "--"}, 
        {data: '', render:function (data, type, row, meta) {
                return `<a href="javascript:deleteCategory(${row.id}, '${row.name}')"><i class="bi bi-trash"></i></a>`;
            }, default:""},
    ]
} )


$("#parent").click(function(){
    categoryDt.draw();
})

function deleteCategory(id,name)
{
    $.confirm({
    title: 'Анхаар!',
    content: `Та ${name} гэсэн нэртэй ангилалыг устгахдаа итгэлтэй байна уу`,
    buttons: {
        confirm: {
            text: "Устгах",
            btnClass: 'btn-red',
            action: function () {
                $.ajax({
                    url: "/category/"+id,
                    method: "DELETE", 
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                        categoryDt.draw();
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
</script>
@endsection