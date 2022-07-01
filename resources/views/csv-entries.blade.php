@include('layouts.header')
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

 <div id="csv-table"></div>
<script>
$(function(){
  var data = <?php echo json_encode($csvEntries);?>;
  var table = new Tabulator("#csv-table", {
    data: data,
    layout:"fitColumns",
    columns:[
      {title:"Name", field:"name", width:200},
      {title:"Surname", field:"surname",  sorter:"number"},
      {title:"Initials", field:"initials"},
      {title:"Age", field:"age"},
      {title:"Date of Birth", field:"date_of_birth"},
    ]
  });
});
</script>



@include('layouts.footer')
