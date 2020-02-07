<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">(Mail)寄建檔信</h3>
<?php 
//echo $_POST["ftpaccount"]; 
//system("C:\Users\user\Desktop\aa.bat > a.txt 2>&1", $return_val);
//print_r($return_val);
//echo $return_val;

//$output = shell_exec("C:\Users\user\Desktop\aa.bat > aaaa.txt 2>&1");
//echo "<pre>$output</pre>";

if(isset($_POST['ButtonPushChecker'])) {
    //echo 'Executing';
	$output = shell_exec('C:\ProgramData\Oracle\Java\javapath\java.exe -jar C:\javarun\MainProcess(1-4)\(mail)SendRemindMail.jar');
	$output1 = iconv("BIG5", "UTF-8", $output);
	echo "<pre>$output1</pre>";
} else {
    echo '<form action="ebookmainprocessmail.php" method="post">', 
           '<input type="hidden" name="ButtonPushChecker" value="1">',
           '<input type="submit" id="submit" value="執行">', 
         '</form>';
}

?>