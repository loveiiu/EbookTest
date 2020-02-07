<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">找不到對應雜誌</h3>

<?php
    $my_link = mysqli_connect("ebookdbinstance.cv5po2gprdib.ap-northeast-1.rds.amazonaws.com","taaze","-pl,ki81qazse4","ebook");
	
	//mysqli_query(連結名稱,"SET CHARACTER SET UTF8");
	
	if (!$my_link){
    die('Could not connect: ' . mysqli_error());
	}else{
     echo "connected</br>";
	}
    if(isset($_POST['title']) && isset($_POST['orgprodid']) && !empty($_POST['title']) && !empty($_POST['orgprodid']))
    {
        $title = $_POST['title'];
        $orgprodid = $_POST['orgprodid'];
        $Update=mysqli_query($my_link,"UPDATE `ebook_meta` SET `TITLE_MAIN`='$title' WHERE (`ORG_PROD_ID`='$orgprodid') ");
	}
	else{
		echo "<font color=\"#e3007f\">欄位不可為空</font>";
	}
	if(mysqli_query($my_link,$Update))
        {
            echo "<script>alert(\"修改成功\")</script>";
            //echo '<meta http-equiv=REFRESH CONTENT=2;url=MagzMetaMap.php>';
        }
    
    else{
            echo '<form action="MagzMetaMap.php" method="post">', 
                '輸入店內碼: <input type="text" id="border" name="orgprodid">',
                '&nbsp;輸入欲修改標題: <input type="text" id="border" name="title">',
                '&nbsp;<input type="submit" id="submit" value="送出">', 
                '</form>';
        }

	echo date("Y-m-d H:i:s");
	$today=date("Y-m-d");
	$Combine=mysqli_query($my_link, "SELECT ORG_PROD_ID,TITLE_MAIN,TITLE_EXCEL,author_main,REMARK_B,ebook_meta.xls_id FROM ebook_meta,publisher_xls WHERE publisher_xls.XLS_DOWNLOAD_DATE = ('$today') and ebook_meta.xls_id = publisher_xls.xls_id and (prod_cat_id in (25,26) || TITLE_EXCEL like '%套書%') and ebook_meta. PRINTING_TYPE = 'N'  and ebook_meta.REMARK_B like '%no magazine!%'");
	$Combinerows = mysqli_fetch_all($Combine);
	echo "</br>共",count($Combinerows),"筆資料";
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