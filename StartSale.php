<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">開購物車</h3>

<?php 
if(isset($_POST['orgprodid'])) {
    //echo 'Executing';
	$string = 'C:\ProgramData\Oracle\Java\javapath\java.exe -jar C:\javarun\InfoProcess\StartSale_1.jar '.$_POST['orgprodid'];
	echo $string;
	$output = shell_exec($string);
	$output1 = iconv("BIG5", "UTF-8", $output);
	echo "<pre>$output1</pre>";
} else {
    echo '<form action="StartSale.php" method="post">', 
           '輸入店內碼(若有多本請用半形逗號隔開): <input type="text" id="border" name="orgprodid">',
           '&nbsp;<input type="submit" id="submit" value="執行">', 
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
	
	
	$Combine=mysqli_query($my_link, "select ORG_PROD_ID,(select TITLE_MAIN from ebook where ORG_PROD_ID=T1.ORG_PROD_ID) AS TITLE,(select PUBLISH_DATE from ebook where ORG_PROD_ID=T1.ORG_PROD_ID) AS PUBLISH_DATE from ebook_channel T1 
where CHANNEL_NAME='TAAZE' 
and (select IMPORT_STATUS from ebook where ORG_PROD_ID=T1.ORG_PROD_ID)=1 
and (select PRODUCE_STATUS from ebook where ORG_PROD_ID=T1.ORG_PROD_ID)='Y' 
and (select COVER_STATUS from ebook where ORG_PROD_ID=T1.ORG_PROD_ID)='Y' 
and (select METADATA_STATUS from ebook where ORG_PROD_ID=T1.ORG_PROD_ID)='Y' 
and (select DB_TO_READER from ebook where ORG_PROD_ID=T1.ORG_PROD_ID)=3 
and ( (select ENCODE_STATUS from ebook_pdf where ORG_PROD_ID=T1.ORG_PROD_ID) =3 or EBOOK_FORMAT in ('epub','sub')) 
and SALE_STATUS = 'I'
and ((select PUBLISH_DATE from ebook where ORG_PROD_ID=T1.ORG_PROD_ID) <= '$today')
and (PLANNED_ONSALE_TIME is null or PLANNED_ONSALE_TIME ='0000-00-00 00:00:00')
order by ORG_PROD_ID");
	$Combinerows = mysqli_fetch_all($Combine);
	echo "</br>共",count($Combinerows),"筆目前可開車資料";
?>
	  <table  style="border: 3px; height: 40px; width: 1200px;" cellpadding="5" cellspacing="5" frame="border" rules="all"> 
		<tr>
			<td>店內碼</td>
			<td>書名</td>
			<td>出版日期</td>
		</tr>
		<?php
        foreach($Combinerows as $index => $row) {
            echo "<tr>";
                for($i=0; $i<3; $i++) {
                    echo "<td>", $row[$i], "</td>";
                }
            echo "</tr>";
        }
        ?>
    </table>