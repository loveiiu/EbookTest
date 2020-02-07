<?php
require("ebooktest.php");
?>

<script>
$("li:first").addClass("current");
</script>

<?php
$file="D:\\PrepareToProduce.txt";
$fp = fopen ($file,"w+");
$aa = "PrepareToProduce";
fputs($fp,$aa);
fclose($fp);
if(!$fp)
{
	echo"fail~";
}
else
{
	echo"<h3 style=\"font-family:Microsoft JhengHei;\">從工讀生資料夾抓轉圖檔案</h3>";
	echo "<br/>";
	echo date("Y-m-d H:i:s");
	echo"<br/>此步驟將在5分鐘後開始執行。";
}
?>