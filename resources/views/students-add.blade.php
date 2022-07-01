@include('layouts/header')
<div id="student-form">
  <h2 class="header">Student</h2>
  <div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <br>
    @endif
    <form action="/students/store" method="POST">
     <!--Lets ensure the data has some basic csrf proection-->
     {!! csrf_field() !!}
      <input type="text" name="name" placeholder="Name", value="{!! old('name') !!}">
      <input type="text" name="surname" placeholder="Surname", value="{!! old('surname') !!}">
      <input type="number" name="national_id" placeholder="National ID", value="{!! old('national_id') !!}">
      <input type="text" pattern="^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[13-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$" name="dob" id="dob" placeholder="Date of Birth (dd/mm/yyyy)", value="{!! old('dob') !!}">
      <button type="submit">Add item!</button>
    </form>
  </div>
</div>
@include('layouts/footer')
