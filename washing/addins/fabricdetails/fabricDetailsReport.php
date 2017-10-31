<?php
session_start();
$backwardseperator = "../../../";
include "../../../Connector.php";
$report_companyId=$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type"content="text/html; charset=utf-8"/>
<title>Garment Type Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
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
<table width="1000" border="0" align="center" cellpadding="0">
  <tr>
    <td width="100%" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%"><?php include "../../../reportHeader.php";?></td>
              </tr>
          </table></td>
		 </tr>
    </table></td>
  </tr>
  <tr>
  <td colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" style="text-align:center">
<table width="100%" border='1' cellpadding="0" cellspacing="0" rules="all">
<thead style="height:25px">
  <tr>
      <td colspan="11" class="normalfnt2bldBLACKmid">Fabric Details  Report</td>
      </tr>
      <tr>
	  <td width="3%" align="center" class='normalfntBtab'><b>No</b></td>
	  <td width="6%" align="center" class='normalfntBtab'><b>Fabric  Name</b></td>
	  <td width="11%" align="center" class='normalfntBtab'><b>Fabric Description </b></td>
      <td width="7%" align="center" class='normalfntBtab'>Fabric Content</td>
	  <td width="10%" align="center" class='normalfntBtab'>Style Name</td>
	  <td width="10%" align="center" class='normalfntBtab'>Division</td>
	  <td width="11%" align="center" class='normalfntBtab'>Mill</td>
	  <td width="8%" align="center" class='normalfntBtab'>Color</td>
	  <td width="10%" align="center" class='normalfntBtab'>Wash Type</td>
	  <td width="10%" align="center" class='normalfntBtab'>Garment</td>
	  <td width="14%" align="center" class='normalfntBtab'>Factory</td>
	  <td width="14%" align="center" class='normalfntBtab'>Status</td>
	  </tr>
	  </thead>
	  <?php        
		$SQL="SELECT DISTINCT
			was_outsidewash_fabdetails.strColor,
			was_outsidewash_fabdetails.strFabricDsc,
			was_outsidewash_fabdetails.strFabricId,
			was_outsidewash_fabdetails.strFabricContent,
			was_outsidewash_fabdetails.strStyle,
			was_washtype.strWasType,
			buyers.strName,
			buyerdivisions.strDivision,
			suppliers.strTitle,
			was_garmenttype.strGarmentName,
			was_outside_companies.strName,
			was_outsidewash_fabdetails.intStatus
			FROM
			was_outsidewash_fabdetails
			Inner Join was_washtype ON was_washtype.intWasID = was_outsidewash_fabdetails.intWashType
			Inner Join buyers ON was_outsidewash_fabdetails.intBuyer = buyers.intBuyerID
			Inner Join buyerdivisions ON buyers.intBuyerID = buyerdivisions.intBuyerID AND was_outsidewash_fabdetails.intDivision = buyerdivisions.intDivisionId
			Inner Join suppliers ON suppliers.strSupplierID = was_outsidewash_fabdetails.strMill
			Inner Join was_garmenttype ON was_outsidewash_fabdetails.intGarment = was_garmenttype.intGamtID
			Inner Join was_outside_companies ON was_outside_companies.intCompanyID = was_outsidewash_fabdetails.intFactory order by strFabricId";	
			//echo $SQL;		
        $result=$db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$GamtID=$row["intGamtID"];
		$GarmentName=$row["strFabricId"];
		$Descrtiption=$row["strFabricDsc"];
		$FabricContent=$row["strFabricContent"];
		$Style=$row["strStyle"];
		$Division=$row["strDivision"];
		$Title=$row["strTitle"];
		$Color=$row["strColor"];
		$WasType=$row["strWasType"];
		$GarmentName=$row["strGarmentName"];
		$strName=$row["strName"];
		$intStatus=$row["intStatus"];
		
		if($intStatus==1)
		{
			$intStatus='Yes';
		}
		else
		{
			$intStatus='No';
		}	
	  echo "<tr>";
	  echo"<td class='normalfnt'>$i</td>";
	  echo"<td class='normalfnt'>$GarmentName</td>";
	  echo"<td class='normalfnt'>$Descrtiption</td>";
	  echo"<td class='normalfnt'>$FabricContent</td>"; 
	  echo"<td class='normalfnt'>$Style</td>";
	  echo"<td class='normalfnt'>$Division</td>"; 
	  echo"<td class='normalfnt'>$Title</td>"; 
	  echo"<td class='normalfnt'>$Color</td>";
	  echo"<td class='normalfnt'>$WasType</td>";
	  echo"<td class='normalfnt'>$GarmentName</td>";
	  echo"<td class='normalfnt'>$strName</td>";
	  echo"<td class='normalfnt'>$intStatus</td>"; 
	  echo"</tr>";	
      $i++;	
  } 
   ?>						
   </table></td>
  </tr>
 </table>
</body>
</html>