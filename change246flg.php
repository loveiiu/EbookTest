<?php
require("ebooktest.php");
?>

<script>
$("li:first").addClass("current");
</script>

<?php
$file="D:\\246.txt";
$fp = fopen ($file,"w+");
$aa = "copyto246";
fputs($fp,$aa);
fclose($fp);
if(!$fp)
{
	echo"fail~";
}
else
{
	echo"<h3 style=\"font-family:Microsoft JhengHei;\">複製檔案到工讀生資料夾</h3>";
	echo "<br/>";
	echo date("Y-m-d H:i:s");
	echo"<br/>此步驟將在5分鐘後開始執行。";
}
?>