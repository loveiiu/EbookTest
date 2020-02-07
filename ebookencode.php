<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">加密</h3>
<input type="button" id="submit" value="開始加密" onclick="location.href='http://192.168.10.239/ebookapi/EncodeImageLine.aspx'">
</br>
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
	
	
	$Combine=mysqli_query($my_link, "select ORG_PROD_ID,(select TITLE_MAIN from ebook where ORG_PROD_ID=T1.ORG_PROD_ID) AS TITLE,ENCODE_STATUS,ENCODE_TIME 
from ebook_pdf T1 where CONVERT_STATUS=6 and ENCODE_STATUS in('0','1') limit 300");
	$Combinerows = mysqli_fetch_all($Combine);
	echo "</br>共",count($Combinerows),"筆資料";
?>
	  <table  style="border: 3px; height: 40px; width: 1200px;" cellpadding="5" cellspacing="5" frame="border" rules="all"> 
		<tr>
			<td>店內碼</td>
			<td>書名</td>
			<td>加密狀態</td>
			<td>加密時間</td>
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