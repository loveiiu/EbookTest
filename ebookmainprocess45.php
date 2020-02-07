<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">(4)(5)寫入電子書後台及審核模組，建立書封</h3>
<?php 
//echo $_POST["ftpaccount"]; 
//system("C:\Users\user\Desktop\aa.bat > a.txt 2>&1", $return_val);
//print_r($return_val);
//echo $return_val;


//$output = shell_exec("C:\Users\user\Desktop\aa.bat > aaaa.txt 2>&1");
//echo "<pre>$output</pre>";

if(isset($_POST['ButtonPushChecker'])) {
    //echo 'Executing';
	$output = shell_exec('C:\ProgramData\Oracle\Java\javapath\java.exe -jar C:\javarun\MainProcess(1-4)\(4)(5)InsertToEbook.jar');
	$output1 = iconv("BIG5", "UTF-8", $output);
	echo "<pre>$output1</pre>";
} else {
    echo '<form action="ebookmainprocess45.php" method="post">', 
           '<input type="hidden" name="ButtonPushChecker" value="1">',
           '<input type="submit" id="submit" value="執行">', 
         '</form>';
}

?>
<?php
    $my_link = mysqli_connect("ebookdbinstance.cv5po2gprdib.ap-northeast-1.rds.amazonaws.com","taaze","-pl,ki81qazse4","ebook");
	
	//mysqli_query(連結名稱,"SET CHARACTER SET UTF8");
	
	if (!$my_link){
    die('Could not connect: ' . mysqli_error());
	}else{
     echo "connected</br>";
	}
	echo date("Y-m-d H:i:s");
	$today=date("Y-m-d");
	
	
	$Combine=mysqli_query($my_link, "select ORG_PROD_ID,TITLE_MAIN,AUTHOR_MAIN,isbn from ebook_meta T1 where (select COVER_STATUS  from ebook where ORG_PROD_ID=T1.ORG_PROD_ID) is null  and ORG_FILE_FLG =1 and  IMPORT_EBOOK_FLG = 0");
	$Combinerows = mysqli_fetch_all($Combine);
	echo "</br>共",count($Combinerows),"筆預備建入後台資料";
?>
	  <table  style="border: 3px; height: 40px; width: 1200px;" cellpadding="5" cellspacing="5" frame="border" rules="all"> 
		<tr>
			<td>店內碼</td>
			<td>書名</td>
			<td>作者</td>
			<td>ISBN</td>
		</tr>
		<?php
        foreach($Combinerows as $index => $row) {
            echo "<tr>";
                for($i=0; $i<4; $i++) {
                    echo "<td>", $row[$i], "</td>";
                }
            echo "</tr>";
        }
        ?>
    </table>