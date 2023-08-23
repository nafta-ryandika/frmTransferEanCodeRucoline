<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>jQuery UI Datepicker - Default functionality</title>
	<link rel="stylesheet" href="../../theme/ui-lightness/jquery-ui-1.8.13.custom.css">
	<script src="../../js/jquery-1.5.1.js"></script>
	<script src="../../js/ui/jquery.ui.core.js"></script>
	<script src="../../js/ui/jquery.ui.widget.js"></script>
	<script src="../../js/ui/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="css/demos.css">
	<script>
	$(function() {
		$( "#datepicker" ).datepicker();
	});
	$(function() {
		$( "#datepicker1" ).datepicker();
	});
	</script>
</head>
<body>

<div class="demo">

<p>Date: <input type="text" id="datepicker"></p>
<p>Date1: <input type="text" id="datepicker1"></p>

</div><!-- End demo -->



<div class="demo-description">
<p>The datepicker is tied to a standard form input field.  Focus on the input (click, or use the tab key) to open an interactive calendar in a small overlay.  Choose a date, click elsewhere on the page (blur the input), or hit the Esc key to close. If a date is chosen, feedback is shown as the input's value.</p>
</div><!-- End demo-description -->

</body>
</html>
