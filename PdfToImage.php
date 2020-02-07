<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">轉檔縮圖</h3>

<?php 
if(isset($_POST['ButtonPushChecker'])) {
    //echo 'Executing';
	$output = shell_exec('C:\ProgramData\Oracle\Java\javapath\java.exe -jar C:\javarun\ConvertImageProcess\PdfToImage.jar');
	$output1 = iconv("BIG5", "UTF-8", $output);
	echo "<pre>$output1</pre>";
} else {
    echo '<form action="PdfToImage.php" method="post">', 
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
	
	
	$Combine=mysqli_query($my_link, "select ORG_PROD_ID, TITLE_MAIN, PUB_NM_MAIN, PUBLISH_DATE from ebook T1 
						where PRODUCE_STATUS='Y' and EBOOK_FORMAT='pdf' 	
						and (select CONVERT_STATUS from ebook_pdf where ORG_PROD_ID=T1.ORG_PROD_ID) is null 
					 	and (prod_cat_id <> 17)
					 order by ORG_PROD_ID asc limit 100");
	$Combinerows = mysqli_fetch_all($Combine);
	echo "</br>共",count($Combinerows),"筆待轉檔資料";
?>
	  <table  style="border: 3px; height: 40px; width: 1200px;" cellpadding="5" cellspacing="5" frame="border" rules="all"> 
		<tr>
			<td>店內碼</td>
			<td>書名</td>
			<td>出版社</td>
			<td>出版時間</td>
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
<?php
	$Combine=mysqli_query($my_link, "select org_prod_id 
, (select TITLE_MAIN from ebook where ORG_PROD_ID=T1.ORG_PROD_ID) AS TITLE, 
 (select PUB_NM_MAIN from ebook where ORG_PROD_ID=T1.ORG_PROD_ID) AS PUB_NM_MAIN , TRANSFER_TIME

from ebook_pdf T1 where CONVERT_STATUS=7 and ENCODE_STATUS=0     and (select PUB_ID from ebook where ORG_PROD_ID=T1.ORG_PROD_ID) <>  '1009052' 
and (select PROD_CAT_ID from ebook where ORG_PROD_ID=T1.ORG_PROD_ID)  <>17");
	$Combinerows = mysqli_fetch_all($Combine);
	echo "</br>共",count($Combinerows),"筆待縮圖資料";
?>
	  <table  style="border: 3px; height: 40px; width: 1200px;" cellpadding="5" cellspacing="5" frame="border" rules="all"> 
		<tr>
			<td>店內碼</td>
			<td>書名</td>
			<td>出版社</td>
			<td>轉製時間</td>
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