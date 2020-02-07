<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">上架</h3>
<font style="color:#808080;">當meta及書封狀態為完成時皆會一併上架(無法單書處理)</font>
<?php 
if(isset($_POST['ButtonPushChecker'])) {
    //echo 'Executing';
	$string = 'C:\ProgramData\Oracle\Java\javapath\java.exe -jar C:\javarun\InfoProcess\PutOnShelf.jar ';
	echo $string;
	$output = shell_exec($string);
	$output1 = iconv("BIG5", "UTF-8", $output);
	echo "<pre>$output1</pre>";
} else {
    echo '<form action="PutOnShelf.php" method="post">', 
           '<input type="hidden" name="ButtonPushChecker" value="1">',
           '</br>&nbsp;<input type="submit" id="submit" value="執行">', 
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
	
	
	$Combine=mysqli_query($my_link, "select ORG_PROD_ID,TITLE_MAIN,AUTHOR_MAIN,ISBN,LIST_PRICE,SALE_PRICE from ebook where IMPORT_STATUS = 0 and COVER_STATUS='Y' and METADATA_STATUS='Y'");
	$Combinerows = mysqli_fetch_all($Combine);
	echo "</br>共",count($Combinerows),"筆可上架資料";
?>
	  <table  style="border: 3px; height: 40px; width: 1200px;" cellpadding="5" cellspacing="5" frame="border" rules="all"> 
		<tr>
			<td>店內碼</td>
			<td>書名</td>
			<td>作者</td>
			<td>ISBN</td>
			<td>定價</td>
			<td>售價</td>
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