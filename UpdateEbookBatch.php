<?php
require("ebooktest.php");
?>

<script>
$("li:first").addClass("current");
</script>

<?php
$file="D:\\UpdateEbookBatch.txt";
$fp = fopen ($file,"w+");
$aa = "checkUpdateEbookBatch";
fputs($fp,$aa);
fclose($fp);
if(!$fp)
{
	echo"fail~";
}
else
{
	echo"<h3 style=\"font-family:Microsoft JhengHei;\">掃描哪些有需要重新打包的，並搬移上次打包的檔案</h3>";
	echo "<br/>";
	echo date("Y-m-d H:i:s");
	echo"<br/>此步驟將在5分鐘後開始執行。";
}
?>

