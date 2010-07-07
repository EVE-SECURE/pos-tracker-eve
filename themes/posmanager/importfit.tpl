<!--[include file='header.tpl']-->
<form enctype="multipart/form-data" action="importfit.php" method="POST">
<input type="hidden" name="pos_id" value="<!--[$tower.pos_id]-->">
Fitting Style:<br>
<Select name="xmlstyle">
<option value="tracker">POS-Tracker Fitting</option>
<option value="mypos">MyPOS Fitting</option>
</select><br>
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- Name of input element determines name in $_FILES array -->
    Send this file: <br>
	<input name="fitimport" type="file" />
    <input type="submit"  name="action" value="Send File" />
</form>
<!--[include file='footer.tpl']-->