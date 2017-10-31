<?php
 session_start();
include "../../Connector.php";

$AppDateFrom		= $_GET["dateFrom"];
$AppDateFromArray		= explode('/',$AppDateFrom);
$formatedAppDateFrom = $AppDateFromArray[2]."-".$AppDateFromArray[1]."-".$AppDateFromArray[0];

$AppDateTo   		= $_GET["dateTo"];
$AppDateToArray		= explode('/',$AppDateTo);
$formatedAppDateTo = $AppDateToArray[2]."-".$AppDateToArray[1]."-".$AppDateToArray[0];

$user= $_GET["user"];
$table= $_GET["table"];
$progrm= $_GET["program"];
$operation= $_GET["operation"];
$qryLike= $_GET["querry"];
$ipAddrs= $_GET["ip"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Order Schedule Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style4 {
	font-size: xx-large;
	color: #FF0000;
}
.style3 {
	font-size: xx-large;
	color: #FF0000;
}
-->

</style>

</head>

<body>
<table align="center" width="100%" border="0">
<tr>
<?php
		
					$SQL_address="SELECT * FROM 
						companies
						Inner Join useraccounts ON companies.intCompanyID = useraccounts.intCompanyID
						WHERE
						useraccounts.intUserID =  '".$_SESSION["UserID"]."'";
							
						$result_address = $db->RunQuery($SQL_address);
					
					
		while($rows = mysql_fetch_array($result_address))
		{	
		$strName=$rows["strName"];
		$comAddress1=$rows["strAddress1"];
		$comAddress2=$rows["strAddress2"];
		$comStreet=$rows["strStreet"];
		$comCity=$rows["strCity"];
		$comCountry=$rows["strCountry"];
		$comZipCode=$rows["strZipCode"];
		$strPhone=$rows["strPhone"];
		$comEMail=$rows["strEMail"];
		$comFax=$rows["strFax"];
		$comWeb=$rows["strWeb"];
		}			
				?>
<td align="center" style="font-family: Arial;	font-size: 16pt;color: #000000;font-weight: bold;"><?php echo $strName; ?></td>				
</tr>

<tr>
 <td align="center" style="font-family: Arial;	font-size: 10pt;color: #000000;font-weight: bold;">
<p >
		  <?php echo $comAddress1." ".$comAddress2." ".$comStreet."<br>".$comCity." ".$comCountry.".<br>"."Tel:".$comPhone." ".$comZipCode." Fax: ".$comFax."<br> E-Mail: ".$comEMail." Web: ".$comWeb;?></p></td>
</tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;">
 Audit Trial
 </td>
</table>

<table width="100%" border='0' align='center'>
      <tr>
	  <?php
	  if($AppDateFrom != ""){
	  ?>
	  <td width="100%"  align="left"><font  style='font-size: 9px;' ><b>Date  From: <?php echo $AppDateFrom;?>     To:    <?php echo $AppDateTo;?></font></td>
	  <?php
	  }
	  ?>
	  </tr>
	  
</table>		
	  
<table width="100%" border='1' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX >
      <tr>
	  <td width="10%" class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b>Program</font></td>
	  <td width="10%" class='normalfntBtab' align="center"><font  style='font-size: 9px;' >Table</font></td>
	  <td width="10%" class='normalfntBtab' align="center"><font  style='font-size: 9px;' >Operation</font></td>
	  <td width="10%" class='normalfntBtab' align="center"><font  style='font-size: 9px;' >User</font></td>
	  <td width="10%" class='normalfntBtab' align="center"><font  style='font-size: 9px;' >Date</font></td>
	  <td width="10%" class='normalfntBtab' align="center"><font  style='font-size: 9px;' >Time</font></td>
	  <td width="40%" class='normalfntBtab' align="center"><font  style='font-size: 9px;' >SQL</font></td>
	  </tr>
	  
      <?php

	/*	$SQL_style="SELECT * FROM queries WHERE queries.userID ='$user' AND queries.tableName ='$table' AND queries.form ='$progrm' AND queries.operation ='$operation' AND queries.sqlStatement LIKE '%$qryLike%' AND queries.IP ='$ipAddrs' AND queries.executedTime BETWEEN '$formatedAppDateFrom' AND '$formatedAppDateTo'"; */
	
	$flag="off";
		
	  $SQL_style="SELECT * FROM queries WHERE queries.IP !='0'"; 
		
	  if($AppDateFrom != "" AND $AppDateTo != "" ){
	  $SQL_style .= " AND queries.executedTime BETWEEN '$formatedAppDateFrom' AND '$formatedAppDateTo'";
	  $flag="onn";
	  }	
	  if($user != "" ){
	  $SQL_style .= " AND queries.userID ='$user'";
	  $flag="onn";
	  }	
	  if($table != "" ){
	  $SQL_style .= " AND queries.tableName ='$table'";
	  $flag="onn";
	  }	
	  if($progrm != "" ){
	  $SQL_style .= " AND queries.program ='$progrm'";
	  $flag="onn";
	  }	
	  if($operation != "" ){
	  $SQL_style .= " AND queries.operation ='$operation'";
	  $flag="onn";
	  }	
	  if($qryLike != "" ){
	  $SQL_style .= " AND queries.sqlStatement LIKE '%$qryLike%'";
	  $flag="onn";
	  }	
	  if($ipAddrs != "" ){
	  $SQL_style .= " AND queries.IP ='$ipAddrs'";
	  $flag="onn";
	  }	
	  
	 // echo $SQL_style;
		//if($flag=="onn"){
         $result_alldetails = $db->RunQuery($SQL_style);
		// }
		 
		while($row = mysql_fetch_array($result_alldetails))
		{		
		$programme= $row["program"];
		$table= $row["tableName"];
		$operat = $row["operation"];
		if($operat=='1'){
		$operat = "Insert";
		}
		else if($operat=='2'){
		$operat = "Update";
		}
		else{
		$operat = "Delete";
		}
		$user= $row["userID"];
		$SQL="SELECT * FROM useraccounts WHERE intUserID='$user'";
		$result =$db->RunQuery($SQL);
		$rowU=mysql_fetch_array($result);
		$user= $rowU["Name"];
		
		$date = $row["executedTime"];
		$DateToArray= explode(' ',$date);
		$date= $DateToArray[0];
		$time= $DateToArray[1];
		$sql= $row["sqlStatement"];
								
   	
	    echo "<tr>";	
		echo"<td class='normalfnt'>$programme</td>";
		echo"<td class='normalfnt'>$table</td>";
		echo"<td class='normalfnt'>$operat</td>";
		echo"<td class='normalfnt'>$user</td>";
		echo"<td class='normalfnt'>$date</td>";
		echo"<td class='normalfnt'>$time</td>";
		echo"<td class='normalfnt'>$sql</td>";
	   echo "</tr>";
	?>


	
	<?php	
		}
	?>
		
</table>

</body>
</html>
