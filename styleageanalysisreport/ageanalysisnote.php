<?php 
session_start();

include "../Connector.php";
				
		$MainId			= $_GET["MainId"];
		$SubCatID		= $_GET["SubCatID"];
		$MatDetaiID		= $_GET["MatDetaiID"];
		$Color			= $_GET["Color"];
		$Size			= $_GET["Size"];
		$CompanyId		= $_GET["CompanyId"];

				
		$SQL = "Select strName from companies where intCompanyID ='$CompanyId';";
						
				$result = $db->RunQuery($SQL);
				while($row = mysql_fetch_array($result ))
				{  
					$CompanyName	=$row["strName"];
				}
				?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inter Job Transfer :: Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" >
var xmlHttp;

function createXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}

/*function sendEmail()
{
	var year = <?php echo  $_GET["year"];?>;
	var poNo = <?php echo  $_GET["pono"];?>;
	var emailAddress = prompt("Please enter the supplier's email address :");
	if (checkemail(emailAddress))
	{	
		createXMLHttpRequest(emailAddress);
		xmlHttp.onreadystatechange = HandleEmail;
		xmlHttp.open("GET", 'poemail.php?pono=' + poNo + '&year=' + year + '&supplier=' + emailAddress, true);
		xmlHttp.send(null);
	}
}

function checkemail(str)
{
	var filter= /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
	if (filter.test(str))
		return true;
	else
		return false;
}

function HandleEmail()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
		
			if(xmlHttp.responseText == "True")
				alert("The Purchase Order has been emailed to the supplier.");
		}
	}
}*/

</script>
</head>


<body>

<table width="1100" border="0" align="center" cellpadding="0">
  <tr>
    <td width="1101"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="18%"><img src="../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>

              <td width="19%" class="normalfnt">&nbsp;</td>
				  
				   <td width="50%" class="tophead"><p class="topheadBLACK"><?php echo $CompanyName; ?></p></td>
                 <td width="13%" class="tophead">&nbsp;</td>
              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><p class="head2BLCK">STYLE-AGE ANALYSIS REPORT </p>
      <p align="center" class="headRed">&nbsp;</p>
      <table width="100%" border="0" cellpadding="0">
        
     
    </table>      
      <table width="100%" border="0" cellpadding="0">
       
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">

            <tr>
              <td width="20%" height="31"  bgcolor="#CCCCCC" class="bcgl1txt1B">Description </td>
              <td width="4%" bgcolor="#CCCCCC" class="bcgl1txt1B" >Units</td>
              <td width="6%" bgcolor="#CCCCCC" class="bcgl1txt1B" >1-30</td>
              <td width="6%" bgcolor="#CCCCCC" class="bcgl1txt1B" >Val(1-30)</td>
              <td width="6%"  bgcolor="#CCCCCC" class="bcgl1txt1B">31-60</td>
              <td width="6%" bgcolor="#CCCCCC" class="bcgl1txt1B" >Val(31-60)</td>
              <td width="6%"  bgcolor="#CCCCCC" class="bcgl1txt1B">61-90</td>
              <td width="6%"  bgcolor="#CCCCCC" class="bcgl1txt1B">Val(61-90)</td>
			  <td width="6%"  bgcolor="#CCCCCC" class="bcgl1txt1B">91-120</td>
			  <td width="6%"  bgcolor="#CCCCCC" class="bcgl1txt1B">Val(91-120)</td>
			  <td width="7%"  bgcolor="#CCCCCC" class="bcgl1txt1B">More</td>
			  <td width="7%"  bgcolor="#CCCCCC" class="bcgl1txt1B">Value</td>
			  <td width="7%"  bgcolor="#CCCCCC" class="bcgl1txt1B">Total</td>
			  <td width="7%"  bgcolor="#CCCCCC" class="bcgl1txt1B">Tot Val</td>
              </tr>
<?php 
	$sql_details="SELECT ".
				"GD.intMatDetailID, ".
				"GD.dblBalance AS Balance, ".
				"DATEDIFF(now() ,GH.dtmRecievedDate) AS diff, ".
				"MIL.strItemDescription, ".
				"MIL.strUnit, ".
				"POD.dblUnitPrice ".
				"FROM ".
				"grndetails AS GD ".
				"Inner Join grnheader AS GH ON GD.intGrnNo = GH.intGrnNo AND GD.intGRNYear = GH.intGRNYear ".
				"Inner Join matitemlist AS MIL ON MIL.intItemSerial = GD.intMatDetailID ".
				"Inner Join purchaseorderdetails AS POD ON GH.intPoNo = POD.intPoNo AND ".
				"GH.intYear = POD.intYear AND  ".
				"POD.intStyleId = GD.intStyleId AND ".
				"POD.intMatDetailID = GD.intMatDetailID AND ".
				"POD.strColor = GD.strColor AND ".
				"POD.strSize = GD.strSize AND ".
				"POD.strBuyerPONO = GD.strBuyerPONO ".
				"WHERE ".
				"(GH.intStatus =  1) AND ".
				"(GD.dblBalance >  0)";
	if ($MainId!="")
			$sql_details .=" AND (MIL.intMainCatID =  '$MainId')";
			
	if ($SubCatID!="")
			$sql_details .=" AND (MIL.intSubCatID =  '$SubCatID')";
			
	if ($MatDetaiID!="")
		$sql_details .=" AND (GD.intMatDetailID =  '$MatDetaiID')";				
	
	if ($Color!="")
		$sql_details .=" AND (GD.strColor =  '$Color')";
		
	if ($Size!="")
		$sql_details .=" AND (GD.strSize =  '$Size')";
	
	if ($CompanyId!="")
		$sql_details .=" AND (GH.intCompanyID =  '$CompanyId')";
												
	$sql_details .=" ORDER BY ".
				 "GD.intMatDetailID ASC;";			 
	
	$result_details = $db->RunQuery($sql_details);
	$rowcount = mysql_num_rows($result_details);
	
		if($rowcount<=0){		
				echo "<script>alert('No details to load');</script>";
				
		}
	
	while($row_details 	= mysql_fetch_array($result_details)){
	
		$Datediff		= $row_details["diff"];
		$Balance		= $row_details["Balance"];
		$UnitPrice		= number_format($row_details["dblUnitPrice"],4);	
		$MatDetailID	= $row_details["intMatDetailID"];

	$MonthQty1="";
	$MonthVAl1="";
	$MonthQty2="";
	$MonthVAl2="";
	$MonthQty3="";
	$MonthVAl3="";
	$MonthQty4="";
	$MonthVAl4="";
	
	if 		($Datediff >= 0 && $Datediff <= 30){			
				$MonthQty1=$Balance;	
				$MonthVAl1=$Balance*$UnitPrice;		
				}	
	elseif	($Datediff >= 31 && $Datediff <= 60){
				$MonthQty2=$Balance;
				$MonthVAl2=$Balance*$UnitPrice;
				}
	elseif	($Datediff >= 61 && $Datediff <= 90){
				$MonthQty3=$Balance;
				$MonthVAl3=$Balance*$UnitPrice;
				}
	elseif	($Datediff >= 91 && $Datediff <= 120){
				$MonthQty4=$Balance;
				$MonthVAl4=$Balance*$UnitPrice;
				}
	else{
				$MoreQty=$Balance;
				$MoreVal=$Balance*$UnitPrice;			
		}

	$TotQty=$MonthQty1+$MonthQty2+$MonthQty3+$MonthQty4+$MoreQty;
	$TotValue= $MonthVAl1+$MonthVAl2+$MonthVAl3+$MonthVAl4+$MoreVal
?>           
            <tr>
              <td class="normalfntTAB"><?php echo $row_details["strItemDescription"]?></td>
              <td class="normalfntMidTAB"><?php echo $row_details["strUnit"]?></td>
              <td class="normalfntRiteTAB"><?php echo $MonthQty1;?></td>
              <td class="normalfntRiteTAB"><?php echo $MonthVAl1;?></td>
              <td class="normalfntRiteTAB"><?php echo $MonthQty2;?></td>
              <td class="normalfntRiteTAB"><?php echo $MonthVAl2;?></td>
              <td class="normalfntRiteTAB"><?php echo $MonthQty3;?></td>
              <td class="normalfntRiteTAB"><?php echo $MonthVAl3;?></td>
			  <td class="normalfntRiteTAB"><?php echo $MonthQty4;?></td>
			  <td class="normalfntRiteTAB"><?php echo $MonthVAl4;?></td>
			  <td class="normalfntRiteTAB"><?php echo $MoreQty;?></td>
			  <td class="normalfntRiteTAB"><?php echo $MoreVal;?></td>
			  <td class="normalfntRiteTAB"><?php echo $TotQty;?></td>
			  <td class="normalfntRiteTAB"><?php echo $TotValue;?></td>
          </tr>
<?php
}
?>


          </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" cellpadding="0">
      <tr>
        <td width="86%" class="bigfntnm1mid"></td>
        <td width="7%" class="bigfntnm1mid">&nbsp;</td>
        <td width="7%" class="bigfntnm1rite">&nbsp;</td>
		
      </tr>
      <tr>
        <td class="bigfntnm1mid">&nbsp;</td>
        <td class="bigfntnm1mid">&nbsp;</td>
        <td class="bigfntnm1rite">&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
</table>

</body>
</html>
