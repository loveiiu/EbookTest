<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">(2)寫入ebook_meta，設定書籍出版形式&雜誌meta</h3>
<!--<form action="ebookmainprocess2.php" method="post">
　<input type="submit" value="執行">
</form>-->
<?php 
//echo $_POST["ftpaccount"]; 
//system("C:\Users\user\Desktop\aa.bat > a.txt 2>&1", $return_val);
//print_r($return_val);
//echo $return_val;


//$output = shell_exec("C:\Users\user\Desktop\aa.bat > aaaa.txt 2>&1");
//echo "<pre>$output</pre>";

if(isset($_POST['ButtonPushChecker'])) {
    //echo 'Executing';
	$output = shell_exec('C:\ProgramData\Oracle\Java\javapath\java.exe -jar C:\javarun\MainProcess(1-4)\(2-1)ParseExcelsSaveToMeta.jar');
	$output1 = iconv("BIG5", "UTF-8", $output);
	echo "<pre>$output1</pre>";
	$output2 = shell_exec('C:\ProgramData\Oracle\Java\javapath\java.exe -jar C:\javarun\MainProcess(1-4)\(2-2)SetBookTypeAndMagzMeta.jar');
	$output3 = iconv("BIG5", "UTF-8", $output2);
	echo "<pre>$output3</pre>";
} else {
    echo '<form action="ebookmainprocess2.php" method="post">', 
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
	
	
	$Combine=mysqli_query($my_link, "SELECT ORG_PROD_ID,TITLE_MAIN,TITLE_EXCEL,author_main,REMARK_B,ebook_meta.xls_id
FROM ebook_meta,publisher_xls
WHERE publisher_xls.XLS_DOWNLOAD_DATE = ('$today')
and ebook_meta.xls_id = publisher_xls.xls_id
and (prod_cat_id in (25,26) || TITLE_EXCEL like '%套書%') and
ebook_meta. PRINTING_TYPE = 'N'  and ebook_meta.REMARK_B like '%no magazine!%'");
	$Combinerows = mysqli_fetch_all($Combine);
	echo "</br>共",count($Combinerows),"筆找不到對應雜誌";
?>
	  <table  style="border: 3px; height: 40px; width: 1200px;" cellpadding="5" cellspacing="5" frame="border" rules="all"> 
		<tr>
			<td>店內碼</td>
			<td>書名</td>
			<td>EXCEL內檔名</td>
			<td>作者</td>
			<td>錯誤訊息</td>
			<td>EXCEL ID</td>
		</tr>
		<?php
        foreach($Combinerows as $index => $row) {
            echo "<tr>";
                for($i=0; $i<6; $i++) {
                    echo "<td>", $row[$i], "</td>";
                }
            echo "</tr>";
        }
        ?>
    </table>
<?php
	$Combine1=mysqli_query($my_link, "SELECT XLS_ID,XLS_PATH,PUB_ID,PROCESS_STATUS,XLS_FILE_NAME 
										FROM `publisher_xls` WHERE `PROCESS_STATUS` <> 'Y'");
	//$Combine = mysqli_query($my_link,"SELECT * FROM ebook_meta,publisher_xls WHERE ORG_PROD_ID ='14100039518'LIMIT 0,2");
										
	//echo $Combine;
	$Combinerows1 = mysqli_fetch_all($Combine1);
	echo "</br>共",count($Combinerows1),"筆未處理資料";
	//echo count($Combinerows);
	//echo count($Combine);
?>

	  <table  style="border: 3px; height: 40px; width: 1200px;" cellpadding="5" cellspacing="5" frame="border" rules="all"> 
		<tr>
			<td>EXCEL ID</td>
			<td>路徑</td>
			<td>出版社代碼</td>
			<td onmouseover="overShow()"onmouseout="outHide()">抓取狀態</td>
			<td>檔案名稱</td>
		</tr>
		<?php
		//print_r $Combine;
        foreach($Combinerows1 as $row1) {
            echo "<tr>";
                for($i=0; $i<5; $i++) {
                    echo "<td>", $row1[$i], "</td>";
                }
            echo "</tr>";
        }
        ?>
    </table>
	<div id="showDiv"></div>
	<script>
	function overShow() {
		var showDiv = document.getElementById('showDiv');
		showDiv.style.left = event.clientX;
		showDiv.style.top = event.clientY;
		showDiv.style.display = 'block';
		showDiv.innerHTML = 'N = 未下載excel</br>F = 已下載excel</br>E = 有錯誤</br>Y = 已處理</br>X= 暫不處理';
	}
	function outHide() {
		var showDiv = document.getElementById('showDiv');
		showDiv.style.display = 'none';
		showDiv.innerHTML = '';
		}
	</script>