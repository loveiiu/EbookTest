<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">開購物車</h3>

<?php 
    $my_link = mysqli_connect("ebookdbinstance.cv5po2gprdib.ap-northeast-1.rds.amazonaws.com","taaze","-pl,ki81qazse4","ebook");
	
	//mysqli_query(連結名稱,"SET CHARACTER SET UTF8");
	
	if (!$my_link){
    die('Could not connect: ' . mysqli_error());
	}else{
     echo "connected</br>";
	}
if(isset($_POST['orgprodid'])) {
	
	$orgprodid = $_POST['orgprodid'];
	$Combine=mysqli_query($my_link,"SELECT ORG_PROD_ID,TITLE_MAIN,AUTHOR_MAIN in ebook_meta where (`ORG_PROD_ID`='$orgprodid') ");
    $Combinerows = mysqli_fetch_all($Combine);
	echo "<font style=\"color:#808080;\">您欲開車的資料為:</font>"?>
		  <table  style="border: 3px; height: 40px; width: 1200px;" cellpadding="5" cellspacing="5" frame="border" rules="all"> 
		<tr>
			<td>店內碼</td>
			<td>書名</td>
			<td>作者</td>
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
	<button id="confirm">確認</button>
	<?php
	
	//echo 'Executing';
	//$string = 'C:\ProgramData\Oracle\Java\javapath\java.exe -jar C:\javarun\InfoProcess\StartSale_1.jar '.$_POST['orgprodid'];
	//echo $string;
	//$output = shell_exec($string);
	//$output1 = iconv("BIG5", "UTF-8", $output);
	//echo "<pre>$output1</pre>";
} else {
    echo '<form action="StartSale_1.php" method="post">', 
           '輸入店內碼(若有多本請用半形逗號隔開): <input type="text" id="border" name="orgprodid">',
           '&nbsp;<input type="submit" id="submit" value="執行">', 
         '</form>';
}
?>