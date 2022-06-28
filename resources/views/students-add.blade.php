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
      <input type="date" name="dob" placeholder="Date of Birth", value="{!! old('dob') !!}">
      <button type="submit">Add item!</button>
    </form>
  </div>
</div>
@include('layouts/footer')
