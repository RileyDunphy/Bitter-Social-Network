<?php
//chapter 15 file uploads (sprint #3)
?>
<form action="chap15_proc.php" method="post" enctype="multipart/form-data">
	Select your image (Must be under 1MB in size): 
	<input type="file" name="pic" accept="image/*" required><br><br>
	<input id="button" type="submit" name="submit" value="Submit">
</form>
