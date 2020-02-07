<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">刪除重複建檔</h3>

<?php 
//echo $_POST["ftpaccount"]; 
//system("C:\Users\user\Desktop\aa.bat > a.txt 2>&1", $return_val);
//print_r($return_val);
//echo $return_val;
echo "<font style=\"color:#e3007f; font-family:'Open Sans', Microsoft JhengHei, sans-serif\">若為已上架書籍需額外處理(前臺資料不會同步刪除，已上架書籍也無法刪除，需先下架)</font>";


if(isset($_POST['orgprodid'])) {
    //echo 'Executing';
	$string = 'C:\ProgramData\Oracle\Java\javapath\java.exe -jar C:\javarun\MainProcess\deleteDuplicateEbook.jar '.$_POST['orgprodid'];
	echo $string;
	$output = shell_exec($string);
	$output1 = iconv("BIG5", "UTF-8", $output);
	echo "<pre>$output1</pre>";
} else {
    echo '<form action="deleteDuplicateEbook.php" method="post">', 
           '</br>輸入店內碼(若有多本請用半形逗號隔開): <input type="test" id="border" name="orgprodid">',
           '&nbsp;<input type="submit" id="submit" value="執行">', 
         '</form>';
}
?>