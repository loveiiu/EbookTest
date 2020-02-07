<?php
$delete = "net use \\192.168.10.246\ebook /delete";
$connect = "net use \\192.168.10.246\ebook /user:ebook 123qweasdzxc";
exec($delete,$output,$return_var);
exec($connect,$output2,$return_var1);
echo $output;
print_r ($output);
echo $output2;
echo $return_var;
echo $return_var1;
$output1 = shell_exec('dir \\192.168.10.246\ebook');
echo $output1;
$file="\\\\192.168.10.246\\ebook\\123.txt";
$fp = fopen ($file,"w+");
$aa = "heyhey";
fputs($fp,$aa);
fclose($fp);
if(!$fp)
{
	echo"<br/>nonono~";
}
?>