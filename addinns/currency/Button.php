<?php
	include "../../Connector.php";
	
	$strButton=trim($_GET["q"],' ');
	$strCurrency=trim($_GET["strCurrency"],' ');
	$cboCurr=$_GET["cboCurr"];
		
	//New & Save------------------------------------------------------------
if($strButton=="New")
{
	 $strTitle=trim($_GET["strTitle"],' ');
	 //$dblRate=trim($_GET["dblRate"],' ');
	 $strFraction = trim($_GET["strFraction"],' ');
	 $intStatus=trim($_GET["intStatus"],' ');
	 $intConID=trim($_GET["intConID"],' ');
	// $txtExRate = trim($_GET["txtExRate"],' ');
	 
	 if($dblRate=="")
	 $dblRate=0;
	 
	// if($txtExRate=="")
	// $txtExRate=0;
	 
	
/*     $SQL_Check="SELECT intCurID,strCurrency,strTitle,intStatus FROM currencytypes where                          strCurrency='$strCurrency' AND intStatus != '10'";
	 $result_check = $db->RunQuery($SQL_Check);	
	 
       $SQL_Check1="SELECT intCurID,strCurrency,strTitle,intStatus FROM currencytypes where                          strTitle='$strTitle' AND intStatus != '10'";
	$result_check1 = $db->RunQuery($SQL_Check1);
	
       $SQL_Check2="SELECT intCurID,strCurrency,strTitle,intStatus FROM currencytypes where                          strCurrency='$strCurrency' AND intStatus == '10'";
	$result_check2 = $db->RunQuery($SQL_Check2);
	
       $SQL_Check3="SELECT intCurID,strCurrency,strTitle,intStatus FROM currencytypes where                          strTitle='$strTitle' AND intStatus == '10'";
	$result_check3 = $db->RunQuery($SQL_Check3);
	 
	 
	if(mysql_num_rows($result_check)){
		echo "Currency Already Exists.";
	}
    else if(mysql_num_rows($result_check1)){
		echo "Currency Name Already Exists.";
	}
	else{*/
	 	$SQL = "insert into currencytypes ( strCurrency,strTitle,strFractionalUnit,intStatus,intConID) values ('".$strCurrency."','".$strTitle."','$strFraction','".$intStatus."','".$intConID."')";

		$db->ExecuteQuery($SQL);
		echo "Saved successfully.";
	//}	
} 
	//Update----------------------------------------------------------------------------------------------------------
	if($strButton=="Save")
	{
	 $strTitle=trim($_GET["strTitle"],' ');
	 $dblRate=trim($_GET["dblRate"],' ');
	 $strFraction = trim($_GET["strFraction"],' ');
	 $intStatus=trim($_GET["intStatus"],' ');
	 $intConID=trim($_GET["intConID"],' ');
    // $txtExRate = trim($_GET["txtExRate"],' ');
	 
	if($dblRate=="")
	$dblRate==0;
	
/*     $SQL_Check="SELECT strCurrency,strTitle,dblRate,intStatus,strFractionalUnit,dblExRate,intCurID FROM currencytypes where strCurrency='$strCurrency' AND intStatus != '10'";
	 //echo $SQL_Check;
	 $result_check = $db->RunQuery($SQL_Check);	
	 
       $SQL_Check1="SELECT strCurrency,strTitle,dblRate,intStatus,strFractionalUnit,dblExRate,intCurID FROM currencytypes where strTitle='$strTitle' AND intStatus != '10'";
	 $result_check1 = $db->RunQuery($SQL_Check1);	
	
	 $SQL = "SELECT strCurrency,strTitle,dblRate,intStatus,strFractionalUnit,dblExRate,intCurID FROM currencytypes where intCurID='$cboCurr' AND intStatus != '10'";
	$result = $db->RunQuery($SQL);
	$row = mysql_fetch_array($result);
	
	 if((mysql_num_rows($result_check)>0) AND ($cboCurr!=$row['intCurID'])){
		echo "Currency Already Exists.";
		}
      else if((mysql_num_rows($result_check1)>0) AND ($strTitle!=$row['strTitle'])){
		echo "Currency Title Already Exists.";
	  }else{*/
		$SQL_Update="UPDATE currencytypes SET strCurrency='$strCurrency',strTitle='$strTitle',intStatus='$intStatus', strFractionalUnit= '$strFraction',intConID= '$intConID' where intCurID='$cboCurr'"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Updated successfully";			
	 //}
  }

		//Delete--------------------------------------------------------------------------------------
			 
if($strButton=="Delete" & $cboCurr != null)
{
	$SQL ="delete from currencytypes where intCurID='$cboCurr';";		 		
	$booAvailable = true;	
	$result = $db->RunQuery2($SQL);
	if(gettype($result)=='string')
	{
		$booAvailable = false;
		echo $result;
		return;
	}	
	echo "Deleted successfully.";
	 
	if($booAvailable)
	{
		$SQL1 ="delete from exchangerate where currencyID='$cboCurr';";		 	
		$db->ExecuteQuery($SQL1);
	}
			
 }
if($strButton=="clearReq")
{
	$sql="SELECT currencytypes.strCurrency,currencytypes.intCurID FROM currencytypes WHERE (((currencytypes.intStatus)<>10)) order by strCurrency asc;;";
	$res=$db->ExecuteQuery($sql);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row=mysql_fetch_array($res))
	{
		echo "<option value='".$row['intCurID']."'>".$row['strCurrency']."</option>";
	}
}
else if($strButton=="LoadCountryMode")
{
	$SQL="SELECT country.strCountry,country.intConID FROM country WHERE country.intStatus<>10 order by country.strCountry;";
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intConID"] ."\">" . $row["strCountry"] ."</option>" ;
	}
}
?>

