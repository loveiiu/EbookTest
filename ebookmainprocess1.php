<?php
require("ebooktest.php");
include("style.css");
?>
<script>
$("li:first").addClass("current");
</script>

<h3 style="font-family:Microsoft JhengHei;">(1)抓特定出版社excel(會從FTP抓檔，建議週刊或插件使用)</h3>

<?php 
//echo $_POST["ftpaccount"]; 
//system("C:\Users\user\Desktop\aa.bat > a.txt 2>&1", $return_val);
//print_r($return_val);
//echo $return_val;



if(isset($_POST['ftpaccount'])) {
    //echo 'Executing';
	$string = 'C:\ProgramData\Oracle\Java\javapath\java.exe -jar C:\javarun\MainProcess(1-4)\(1)AccessMetaExcels.jar '.$_POST['ftpaccount'];
	echo $string;
	$output = shell_exec($string);
	$output1 = iconv("BIG5", "UTF-8", $output);
	echo "<pre>$output1</pre>";
} else {
    echo '<form action="ebookmainprocess1.php" method="post">', 
           '輸入出版社FTP_ACCOUNT(若有多間請用\',\'隔開):&nbsp; <input type="text" id="border" name="ftpaccount">',
           '&nbsp;<input type="submit" id="submit" value="執行"><font color="#888888">(範例：A出版社\',\'B出版社\',\'C出版社)</font>', 
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
	//echo date("Y-m-d H:i:s");
	//echo "<br/>";
	function post_date($date, $days) {
		$t1 = strtotime($date);
		$t2 = $t1 - $days*3600*24;
		return date("Y-m-d H:i:s", $t2);
	}
	//echo post_date(date("Y-m-d H:i:s"),30);
	//echo "<br/>";
	$today=post_date(date("Y-m-d H:i:s"),61);
	
	/*$Combine1=mysqli_query($my_link, "SELECT XLS_ID,XLS_PATH,PUB_ID,PROCESS_STATUS,XLS_FILE_NAME 
										FROM `publisher_xls` WHERE `PROCESS_STATUS` <> 'Y'");
	//$Combine = mysqli_query($my_link,"SELECT * FROM ebook_meta,publisher_xls WHERE ORG_PROD_ID ='14100039518'LIMIT 0,2");
										
	//echo $Combine;
	$Combinerows1 = mysqli_fetch_all($Combine1);
	echo "</br>共",count($Combinerows1),"筆未處理資料";
	//echo count($Combinerows);
	//echo count($Combine);
?>
	  <table  style="border: 3px; height: 40px; width: 1200px;" cellpadding="5" cellspacing="5" frame="border" rules="all"> 
		<tr>
			<td>EXCEL ID</td>
			<td>路徑</td>
			<td>出版社代碼</td>
			<td>抓取狀態</td>
			<td>檔案名稱</td>
		</tr>
		<?php
		//print_r $Combine;
        foreach($Combinerows1 as $row1) {
            echo "<tr>";
                for($i=0; $i<5; $i++) {
                    echo "<td>", $row1[$i], "</td>";
                }
            echo "</tr>";
        }
        ?>
    </table>*/
?>