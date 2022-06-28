@include('layouts/header')
<br>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
<br>
@endif
<button class="add-student-button" onclick="location.replace('/csv')">Create CSV (Part 2)</button>
<button class="add-student-button" onclick="location.replace('/students/add')">Add a Student!</button>
 <div id="students-table"></div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var data = <?php echo json_encode($students);?>;
  var table = new Tabulator("#students-table", {
    data: data,
    layout:"fitColumns",
    columns:[
      {title:"Name", field:"name", width:200},
      {title:"Surname", field:"surname",  sorter:"number"},
      {title:"National ID", field:"national_id"},
      {title:"Date of Birth", field:"dob"},
      {title:"Date Created", field:"created_at"},
    ]
  });
});
</script>

<script src="{{ URL::asset('vendor/tabulator/dist/js/tabulator.min.js') }}"></script>

@include('layouts/footer')
