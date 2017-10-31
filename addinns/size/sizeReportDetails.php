<?php
 session_start();
include "../../Connector.php";

$buyerID  	= $_GET["cboBuyer"];
$cboDiv   	    = $_GET["cboDiv"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Size's Details Report</title>
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
		$status=$rows["intStatus"];
		if($status == 1){
		$status='Active';
		}else{
		$status='Inactive';
		}	
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
 Size's Details
 </td>
</table>

	   <?php

		$SQL="	SELECT b.strName ,D.strDivision
				FROM 
				buyers b
				INNER JOIN buyerdivisions AS d ON b.intBuyerID = d.intBuyerID
				WHERE b.intBuyerID = $buyerID;"; 
			 		   			    
        $result = $db->RunQuery($SQL);

		while($row = mysql_fetch_array($result))
		{	
		$strName      = $row["strName"];
		$strDivision = $row["strDivision"];
		}
		?>


<table width="800" border='1' align='center' cellpadding="3" cellspacing="1"  >	  
	  <tr>
	  <td width="181" align="center" class='normalfntBtab'><font  style='font-size: 9px;' ><b> Name</font></td>
	  <td width="598" align="center" class='normalfnt'><font  style='font-size: 9px;' ><b><?php echo $strName;?></font></td>
	  </tr>
	  
	  <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Division</font></td>
	  <td class='normalfnt' align="center"><font  style='font-size: 9px;' ><b><?php echo $strDivision;?></font></td>
	  </tr>		
		<tr>
        <td>&nbsp;</td>
        <td>
            <table style="border:solid #CCC 1px;" border="1" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b>Size</b></font></td>
                <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b>Description</b></font></td>
            </tr>
          <?php 
          $sql_dets="select distinct strSize,strDescription from sizes where intCustomerId = " . $buyerID . " AND intDivisionID = " . $cboDiv .  " AND intStatus=1;"; 
         // echo $sql_dets;
          $res=$db->RunQuery($sql_dets);
          while($row=mysql_fetch_array($res))
          {?>
                    
                        <tr>
                            <td class='normalfnt' align="center" width="30%"><?php echo $row['strSize'];?></td>
                            <td class='normalfnt' align="center" width="70%"><?php echo $row['strDescription'];?></td>
                        </tr>
                
         <?php }
          ?>		
          </table>
      </td>
      </tr>			
</table>		
</body>
</html>
