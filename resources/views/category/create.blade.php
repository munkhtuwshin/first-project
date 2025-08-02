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
    <button type="submit" class="btn btn-primary">Хадгалах</button>
  </form>
@endsection
