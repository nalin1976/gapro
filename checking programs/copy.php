<?php
include "../Connector.php";	
$sql="select glcode,gl,accountType,glType,glcategory,factory from zoooooo;";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$glcode			= $row["glcode"];
	$desc 			= trim($row["gl"]);
	$accountType	= $row["accountType"];
	$glType			= $row["glType"];
	$glcategory		= $row["glcategory"];
	$factory		= $row["factory"];
	$gCode			= substr($glcode,0,-3);
	$fCode			= substr($glcode,-3,30);
	
	echo $glcode.'/'.$desc.'/'.$accountType.'/'.$glType.'/'.$glcategory.'/'.$factory.'/'.$gCode.'/'.$fCode;
	echo "<br/>";
	$sql1="insert into zoooooo_copy (glcode,gl,accountType,glType,glcategory,factory,gCode,fCode)values ('$glcode','$desc','$accountType','$glcategory','$glcategory','$factory','$gCode','$fCode');";
	$result1=$db->RunQuery($sql1);
}

/*$q = 'weedfweCLER330';
echo substr($q,-3,30);*/
?>