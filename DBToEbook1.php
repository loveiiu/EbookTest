<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">(1)&nbsp;開始執行</h3>
<?php 
//echo $_POST["ftpaccount"]; 
//system("C:\Users\user\Desktop\aa.bat > a.txt 2>&1", $return_val);
//print_r($return_val);
//echo $return_val;


//$output = shell_exec("C:\Users\user\Desktop\aa.bat > aaaa.txt 2>&1");
//echo "<pre>$output</pre>";

if(isset($_POST['ButtonPushChecker'])) {
    //echo 'Executing';
	$output = shell_exec('C:\ProgramData\Oracle\Java\javapath\java.exe -jar C:\javarun\DBToEbook\(1)createEbookBatch.jar');
	$output1 = iconv("BIG5", "UTF-8", $output);
	echo "<pre>$output1</pre>";
} else {
    echo '<form action="DBToEbook1.php" method="post">', 
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
	
	
	$Combine=mysqli_query($my_link, "select ORG_PROD_ID,TITLE_MAIN, PROD_CAT_ID, EBOOK_FORMAT 
from ebook T1 
where ( EBOOK_FORMAT='epub' or (EBOOK_FORMAT='pdf' and (select WIDTH from ebook_pdf where ORG_PROD_ID=T1.ORG_PROD_ID ) > 0 )) 
and PRODUCE_STATUS='Y' and COVER_STATUS='Y' and METADATA_STATUS='Y' 
and DB_TO_READER IN (0,-1) 
and ORG_PROD_ID <> '25109999999' 
order by ORG_PROD_ID 
");
	$Combinerows = mysqli_fetch_all($Combine);
	echo "</br>共",count($Combinerows),"筆資料";
?>
	  <table  style="border: 3px; height: 40px; width: 1200px;" cellpadding="5" cellspacing="5" frame="border" rules="all"> 
		<tr>
			<td>店內碼</td>
			<td>書名</td>
			<td>業種別</td>
			<td>格式</td>
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