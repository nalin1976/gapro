<?php
 session_start();
 include "../../Connector.php";
$req= $_GET['q'];
if($req == "save")
{
	$strCurrency=$_GET["txtCurrency"];
	//$cboCurr=$_GET["cboCurr"];

	 $strTitle=$_GET["txtTitle"];
	 $dblRate=$_GET["txtRate"];
	 $strFraction = $_GET["txtFraction"];
	 $intStatus=$_GET["chkActive"];
	 $txtExRate = $_GET["txtExRate"];
	 if($intStatus=='on'){
	 $intStatus=1;
	 }
	 else{
	 $intStatus=0;
	 }
	
	 if($dblRate=="")
	 $dblRate=0;
	
		$SQL_CheckData="SELECT strCurrency,intStatus FROM currencytypes where strCurrency='".$strCurrency."';";
		$result = $db->RunQuery($SQL_CheckData);	
	
		if($row = mysql_fetch_array($result))
		{ $strCurrency=$row["strCurrency"];
		
		if($row["intStatus"]==0)
		{
				$SQL_Update="UPDATE currencytypes SET strCurrency='".$strCurrency."',strTitle='".$strTitle."',dblRate=".$dblRate.",intStatus='".$intStatus."', strFractionalUnit='".$strFraction."' where strCurrency='".$strCurrency."';"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Saved SuccessFully";
		}
		else
		{
		$SQL_Update="UPDATE currencytypes SET strCurrency='$strCurrency',strTitle='$strTitle',dblRate='$dblRate',intStatus='$intStatus', strFractionalUnit= '$strFraction' where intCurID='$strCurrency'"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Updated SuccessFully";			
		}
		
		}
	else
	{
	 $SQL = "insert into currencytypes ( strCurrency,strTitle,dblRate,strFractionalUnit,intStatus) values ('".$strCurrency."','".$strTitle."','".$dblRate."','$strFraction','".$intStatus."');";

			$db->ExecuteQuery($SQL);
		    echo "Saved SuccessFully";
	}
	
}
?>