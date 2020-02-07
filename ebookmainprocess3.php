<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">(3)下載原始檔</h3>
<?php 
//echo $_POST["ftpaccount"]; 
//system("C:\Users\user\Desktop\aa.bat > a.txt 2>&1", $return_val);
//print_r($return_val);
//echo $return_val;
//$aaa= "�����p�ǥͪ��@�ɦa�z�i���a�x���ơA�^�y�ǲߪ��j-�q�l��";
//echo mb_detect_encoding($aaa);

if(isset($_POST['ButtonPushChecker'])) {
    //echo 'Executing';
	$cmd = 'C:\ProgramData\Oracle\Java\javapath\java.exe -jar C:\javarun\MainProcess(1-4)\(3)DownloadOriginalFile_1.jar';
	$output = shell_exec($cmd);
	$output1 = iconv("BIG5", "UTF-8", $output);
	echo "<pre>$output1</pre>";
} else {
    echo '<form action="ebookmainprocess3.php" method="post">', 
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
	echo "<br/>";
	function post_date($date, $days) {
		$t1 = strtotime($date);
		$t2 = $t1 - $days*3600*24;
		return date("Y-m-d H:i:s", $t2);
	}
	//echo "使用時間:",post_date(date("Y-m-d H:i:s"),1);
	//echo "<br/>";
	$today=post_date(date("Y-m-d"),3);
	
	$Combine=mysqli_query($my_link, "SELECT ORG_PROD_ID,TITLE_MAIN,ebook_format,ORG_FILENAME,XLS_PATH,publisher_xls.LAST_PROCESS_TIME 
										FROM ebook_meta,publisher_xls
										WHERE ebook_meta.ORG_FILE_FLG in (0, 2)
										and ebook_meta.xls_id = publisher_xls.xls_id
										order by LAST_PROCESS_TIME desc
										limit 100");
	//$Combine = mysqli_query($my_link,"SELECT * FROM ebook_meta,publisher_xls WHERE ORG_PROD_ID ='14100039518'LIMIT 0,2");
										
	//echo $Combine;
	$Combinerows = mysqli_fetch_all($Combine);
	echo "</br>共",count($Combinerows),"筆需抓檔資料";
	//echo count($Combinerows);
	//echo count($Combine);
?>
	  <table  style="border: 3px; height: 40px; width: 1200px;" cellpadding="5" cellspacing="5" frame="border" rules="all"> 
		<tr>
			<td>店內碼</td>
			<td>書名</td>
			<td>格式</td>
			<td>原始檔名</td>
			<td>路徑</td>
			<td>建檔時間</td>
		</tr>
		<?php
		//print_r $Combine;
		//echo $Combinerows;
        foreach($Combinerows as $row) {
            echo "<tr>";
                for($i=0; $i<6; $i++) {
                    echo "<td>", $row[$i], "</td>";
                }
            echo "</tr>";
        }
        ?>
    </table>