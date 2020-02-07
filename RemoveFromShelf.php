<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">下架</h3>

<?php 
if(isset($_POST['orgprodid'])) {
    //echo 'Executing';
	$string = 'C:\ProgramData\Oracle\Java\javapath\java.exe -jar C:\javarun\InfoProcess\RemoveFromShelf_1.jar '.$_POST['orgprodid'];
	echo $string;
	$output = shell_exec($string);
	$output1 = iconv("BIG5", "UTF-8", $output);
	echo "<pre>$output1</pre>";
} else {
    echo '<form action="RemoveFromShelf.php" method="post">', 
           '輸入店內碼(若有多本請用半形逗號隔開): <input type="text" id="border" name="orgprodid">',
           '&nbsp;<input type="submit" id="submit" value="執行">', 
         '</form>';
}
?>