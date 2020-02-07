<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">匯入ePub(從after將ePub檔案匯入電子書後台)</h3>

<?php

if(isset($_POST['ButtonPushChecker'])) {
    //echo 'Executing';
	$output = shell_exec('C:\ProgramData\Oracle\Java\javapath\java.exe -jar C:\javarun\EpubToDB_new\EpubToDB_new.jar');
	$output1 = iconv("BIG5", "UTF-8", $output);
	echo "<pre>$output1</pre>";
} else {
    echo '<form action="ebookepubtodbnew.php" method="post">', 
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
	
	
	$Combine=mysqli_query($my_link, "select create_time,PUB_ID, PUB_NM_MAIN, ORG_PROD_ID, TITLE_MAIN, AUTHOR_MAIN, PUBLISH_DATE,ORG_FILENAME, produce_status ,remark  from ebook where  EBOOK_FORMAT='epub'  
						 and create_time  > ('$today') and produce_status !='P' and produce_status !='R' order by create_time");
	$Combinerows = mysqli_fetch_all($Combine);
	echo "</br>共",count($Combinerows),"筆資料";
?>
	  <table  style="border: 3px; height: 40px; width: 1200px;" cellpadding="5" cellspacing="5" frame="border" rules="all"> 
		<tr>
			<td>建立時間</td>
			<td>出版社代碼</td>
			<td>出版社名稱</td>
			<td>店內碼</td>
			<td>書名</td>
			<td>作者</td>
			<td>出版日期</td>
			<td>檔案名稱</td>
			<td onmouseover="overShow()"onmouseout="outHide()">狀態</td>
		</tr>
		<?php
        foreach($Combinerows as $index => $row) {
            echo "<tr>";
                for($i=0; $i<9; $i++) {
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
		showDiv.innerHTML = 'F = 取得原始檔';
	}
	function outHide() {
		var showDiv = document.getElementById('showDiv');
		showDiv.style.display = 'none';
		showDiv.innerHTML = '';
		}
	</script>