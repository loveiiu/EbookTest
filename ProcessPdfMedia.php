<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">匯入音檔對照表</h3>

<?php 
//echo $_POST["ftpaccount"]; 
//system("C:\Users\user\Desktop\aa.bat > a.txt 2>&1", $return_val);
//print_r($return_val);
//echo $return_val;



if(isset($_POST['orgprodid'])) {
    //echo 'Executing';
	$string = 'C:\ProgramData\Oracle\Java\javapath\java.exe -jar C:\javarun\MediaProcess\ProcessPdfMedia.jar '.$_POST['orgprodid'];
	echo $string;
	$output = shell_exec($string);
	$output1 = iconv("BIG5", "UTF-8", $output);
	echo "<pre>$output1</pre>";
} else {
    echo '<form action="ProcessPdfMedia.php" method="post">', 
           '輸入店內碼: <input type="test" id="border" name="orgprodid">',
           '&nbsp;<input type="submit" id="submit" value="執行">', 
         '</form>';
}
?>
	

<?php
    $my_link = mysqli_connect("ebookdbinstance.cv5po2gprdib.ap-northeast-1.rds.amazonaws.com","taaze","-pl,ki81qazse4","ebook");
	
	
	if (!$my_link){
    die('Could not connect: ' . mysqli_error());
	}else{
     echo "connected</br>";
	}
	echo date("Y-m-d H:i:s");
	echo "<br/>";
	function post_date($date, $days) {
		$t1 = strtotime($date);
		$t2 = $t1 - $days*3600*24;
		return date("Y-m-d H:i:s", $t2);
	}
	echo post_date(date("Y-m-d H:i:s"),1);
	echo "<br/>";
	$today=post_date(date("Y-m-d H:i:s"),1);
	
	$Combine=mysqli_query($my_link, "SELECT ORG_PROD_ID,FILE_NAME,FILE_FORMAT,MAPPING_NO,MAPPING_FILENAME,COPY_TO_MEDIA,download_time FROM ebook_file WHERE file_format = 'mp3' and download_time >= ('$today')");
	//$Combine = mysqli_query($my_link,"SELECT * FROM ebook_meta,publisher_xls WHERE ORG_PROD_ID ='14100039518'LIMIT 0,2");
										
	//echo $Combine;
	$Combinerows = mysqli_fetch_all($Combine);
	echo "</br>共",count($Combinerows),"筆資料";
	//echo count($Combinerows);
	//echo count($Combine);
?>
	  <table  style="border: 3px; height: 40px; width: 1200px;" cellpadding="5" cellspacing="5" frame="border" rules="all"> 
		<tr>
			<td>店內碼</td>
			<td>檔名</td>
			<td>檔案格式</td>
			<td>對應頁碼</td>
			<td>系統檔名</td>
			<td>上傳狀態</td>
			<td>下載時間</td>
		</tr>
		<?php
		//print_r $Combine;
        foreach($Combinerows as $row) {
            echo "<tr>";
                for($i=0; $i<7; $i++) {
                    echo "<td>", $row[$i], "</td>";
                }
            echo "</tr>";
        }
        ?>
    </table>