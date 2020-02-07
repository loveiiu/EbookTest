<?php
require("ebooktest.php");
?>
<script>
$("li:first").addClass("current");
</script>

<h3>(1)抓特定出版社excel</h3>
<form action="ebookmainprocess1-1.php" method="post">
　輸入出版社FTP_ACCOUNT: <input type="test" name="ftpaccount">
　<input type="submit" value="執行">
</form>

