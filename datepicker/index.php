<head>
	<title>Picker Date</title>
    <script type="text/javascript" src="js/datepicker.js"></script>
    <link href="css/datePicker.css" rel="stylesheet" type="text/css">
</head>

<body>

<h2>JavaScript Date Picker Test</h2>

This is a demonstration of some basic JavaScript DHTML datepicker functionality, allowing you to present a drop-down calendar to your users at the click of a button so they can easily choose a date that will be inserted into a text field.
<p>
There are many other datepickers available on the Internet...this happens to be the one that I wrote. You are free to use it in any way you'd like in your own applications. If you're feeling nice, you could even include my name with the code.
<p>
Please see the JavaScript code on the page source itself for additional information.
<p><hr><p>

<form>
Here's an example of displaying the datepicker below a text field:
<br>
<b>A Date:</b> <input name="ADate"> 
<input type=button value="select" onclick="displayDatePicker('ADate');">
</form>
<p>

<form>
And here's an example of displaying it below the button that was clicked:
<br>
<b>Another Date:</b> <input name="AnotherDate"> 
<input type=button value="select" onclick="displayDatePicker('AnotherDate', this);">
</form>
<p>

<form>
And here's an example of displaying the resulting value with a date format of dd.mm.yyyy:
<br>
<b>Yet Another Date:</b> <input name="YetAnotherDate"> 

<input type=button value="select" onclick="displayDatePicker('YetAnotherDate', false, 'ymd', '/');">
</form>
<p>

The format of the datepicker (color, fonts, etc.) is easily customized using CSS. The date format can be customized using either global variables or each time you call the function that displays the date picker (see the code for more information). Enjoy.
<p><hr><p>

<center><i>
Julian Robichaux<br>
<a href='http://www.nsftools.com'>http://www.nsftools.com</a>
</i></center>
<p>

</body>
</html>
