<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">從(2.已除錯PDF)抓檔案</h3>
<font style="color:#808080;">抓取已更新PDF及ePub更新檔案至after資料夾</font>
<?php 
if(isset($_POST['ButtonPushChecker'])) {
    //echo 'Executing';
	$output = shell_exec('C:\ProgramData\Oracle\Java\javapath\java.exe -jar C:\javarun\ConvertImageProcess\PrepareToProduce.jar');
	$output1 = iconv("BIG5", "UTF-8", $output);
	echo "<pre>$output1</pre>";
} else {
    echo '<form action="PrepareToProduceStart.php" method="post">', 
           '<input type="hidden" name="ButtonPushChecker" value="1">',
           '</br><input type="submit" id="submit" value="執行">', 
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
	
	
	$Combine=mysqli_query($my_link, "select ORG_PROD_ID,TITLE_MAIN,AUTHOR_MAIN,EBOOK_FORMAT,PRODUCE_STATUS,CREATE_TIME,MDF_TIME from ebook where produce_status in ('G','N')  limit 100");
	$Combinerows = mysqli_fetch_all($Combine);
	echo "</br>共",count($Combinerows),"筆待抓圖資料";
?>
	  <table  style="border: 3px; height: 40px; width: 1200px;" cellpadding="5" cellspacing="5" frame="border" rules="all"> 
		<tr>
			<td>店內碼</td>
			<td>書名</td>
			<td>作者</td>
			<td>格式</td>
			<td onmouseover="overShow()"onmouseout="outHide()">轉製狀態</td>
			<td>建立時間</td>
			<td>修改時間</td>
		</tr>
		<?php
        foreach($Combinerows as $index => $row) {
            echo "<tr>";
                for($i=0; $i<7; $i++) {
                    echo "<td>", $row[$i], "</td>";
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
		showDiv.innerHTML = 'G = PDF-檢查完成</br>N=epub-更新檔案';
	}
	function outHide() {
		var showDiv = document.getElementById('showDiv');
		showDiv.style.display = 'none';
		showDiv.innerHTML = '';
		}
	</script>