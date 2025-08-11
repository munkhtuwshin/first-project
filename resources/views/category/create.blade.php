@extends("layout.main")
@section("title" , "ангилал шинээр үүсгэх")
@section("content")
<form method="post" action="/category">
    @csrf
    <div class="mb-3">
        <label for="parent" class="form-label">Эцэг ангилал</label>
        <select name="parent" id="parent" class="form-select">
            <option value="">-</option>
            @foreach($parents as $parent)
            <option value="{{$parent->id}}">{{$parent->name}}</option>
            @endforeach
        </select>
      </div>
    <div class="mb-3">
      <label for="name" class="form-label">Ангилал нэр</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Ангилалын нэр оруулна уу">
    </div>
    <div class="d-flex justify-content-center gap-4 m-2">
      <button class="btn btn-success" type="submit"> хадгалах </button>
      <a href="/category" class="btn btn-primary">Буцах </a>
    </div>
  </form>
@endsection
