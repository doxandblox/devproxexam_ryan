<script src="{{ URL::asset('/js/jquery.js') }}"></script>
<script src="{{ URL::asset('/js/datepicker.js') }}"></script>
<script src="{{ URL::asset('/js/messagebox.js') }}"></script>
<script src="{{ URL::asset('/js/loader.js') }}"></script>
<script src="{{ URL::asset('/js/tabulator.min.js') }}"></script>

<script>
	$(function() {
		$("form").submit(function(event) {
			$.LoadingOverlay("show");
		});
	});
</script>

</body>
</html>