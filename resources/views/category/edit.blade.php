@extends("layout.main")
@section("title" , "ангилал шинээр үүсгэх")
@section("content")
<form action="/category" id="editCategory">
    @csrf
    <div class="mb-3">
        <label for="parent" class="form-label">Эцэг ангилал</label>
        <select name="parent" id="parent" class="form-select">
            <option value="">сонгоогүй</option>
            @foreach($parents as $parent)
            <option value="{{$parent->id}}">{{$parent->name}}</option>
            @endforeach
        </select>
      </div>
    <div class="mb-3">
      <label for="name" class="form-label">Ангилал нэр</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Ангилалын нэр оруулна уу" value="{{$category->name}}">
    </div>
    <button type="submit" class="btn btn-primary">Хадгалах</button>
  </form>
@endsection


@section("js")
<script>
    $('#editCategory').submit(function(event) {
    event.preventDefault(); // Prevent default submission
    let formData = $(this).serializeArray();
    let csrf = formData[0]['value'];
    delete formData[0];

    $.ajax({
        url: "/category/{{$category->id}}",
        method: "PUT", 
        headers: {
        'X-CSRF-TOKEN': csrf
        },      
        data: { "parent_id":formData[1]['value'], name : formData[2]['value'] },
        success: function (response) {
            window.location.href="/category"
        },
        error: function (xhr) {
            console.error("Алдаа:", xhr.responseText);
        }
    });
});
</script>
@endsection