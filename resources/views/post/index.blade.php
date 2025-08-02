
@extends("layout.main")

@section("title", "Нийтлэл хуудас")

@section("content")
<a class="btn btn-primary" href="post/create" >Шинээр нэмэх</a>
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
      </tr>
  </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>үндсэн</td>
            <td>System Architect</td>
            <td>Edinburgh</td>
            <td>61</td>
            <td>2011-04-25</td>
            <td>$320,800</td>
        </tr>
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
                    <label for="title" class="form-label">гарчиг</label>
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
        { data: 'image', default: "" },
        { data: 'created_at', default: "" },
        { data: 'updated_at', default: "" }
    ],
    processing: true,
    serverSide: true
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
</script>



@endsection