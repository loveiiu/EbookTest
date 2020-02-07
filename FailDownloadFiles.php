<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">原始檔下載失敗</h3>

<?php
    $my_link = mysqli_connect("ebookdbinstance.cv5po2gprdib.ap-northeast-1.rds.amazonaws.com","taaze","-pl,ki81qazse4","ebook");
	
	//mysqli_query(連結名稱,"SET CHARACTER SET UTF8");
	
	if (!$my_link){
    die('Could not connect: ' . mysqli_error());
	}else{
     echo "connected</br>";
	}
	//echo date("Y-m-d H:i:s");
	echo "<br/>";
	function post_date($date, $days) {
		$t1 = strtotime($date);
		$t2 = $t1 - $days*3600*24;
		return date("Y-m-d H:i:s", $t2);
	}
	$today=post_date(date("Y-m-d"),3);
    
    if($_POST['filename']!=null&&$_POST['orgprodid']!=null)
    {
        $filename = $_POST['filename'];
        $orgprodid = $_POST['orgprodid'];
        $Update=mysqli_query($my_link,"UPDATE `ebook_meta` SET `ORG_FILENAME`='$filename' WHERE (`ORG_PROD_ID`='$orgprodid')");
	}
	else{
		echo "<font color=\"#e3007f\">欄位不可為空</font>";
	}
	if(mysqli_query($my_link,$Update))
    {
            echo"<script>alert(\"修改成功\")</script>";
            //echo '<meta http-equiv=REFRESH CONTENT=2;url=FailDownloadFiles.php>';
    }
	else{
            echo '<form action="FailDownloadFiles.php" method="post">', 
                 '輸入店內碼: <input type="text" id="border" name="orgprodid">',
                 '&nbsp;輸入欲修改檔名: <input type="text" id="border" name="filename">',
                 '&nbsp;<input type="submit" id="submit" value="送出">', 
                 '</form>';
        }
	echo date("Y-m-d H:i:s");
	$today=date("Y-m-d");
	$Combine=mysqli_query($my_link, "SELECT ORG_PROD_ID,TITLE_MAIN,ebook_format,ORG_FILENAME,XLS_PATH 
										FROM ebook_meta,publisher_xls
										WHERE ebook_meta.ORG_FILE_FLG in (0, 2)
										and publisher_xls.`LAST_PROCESS_TIME` >=  ('$today')
										and ebook_meta.xls_id = publisher_xls.xls_id");
	$Combinerows = mysqli_fetch_all($Combine);
	echo "</br>共",count($Combinerows),"筆資料";
?>
	  <table  style="border: 3px; height: 40px; width: 1200px;" cellpadding="5" cellspacing="5" frame="border" rules="all"> 
		<tr>
			<td>店內碼</td>
			<td>書名</td>
			<td>格式</td>
			<td>原始檔名</td>
			<td>路徑</td>
		</tr>
		<?php
        foreach($Combinerows as $index => $row) {
            echo "<tr>";
                for($i=0; $i<5; $i++) {
                    echo "<td>", $row[$i], "</td>";
                }
            echo "</tr>";
        }
        ?>
    </table>