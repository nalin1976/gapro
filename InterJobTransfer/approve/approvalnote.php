<?php 
session_start();

include "../../Connector.php";
				
				$intJobNo		= $_GET["InterJobNo"];
				$intJobYear		= $_GET["InterJobYear"];
								
				
		$SQL = "SELECT
				IT.intTransferId,
				IT.intTransferYear,
				IT.intStyleIdFrom,
				IT.intStyleIdTo,
				IT.intStatus,
				IT.strRemarks,
				IT.intUserId,
				IT.dtmTransferDate,
				IT.intApprovedBy,
				IT.dtmApprovedDate,
				IT.intAuthorisedby,
				IT.dtmAuthorisedDate,
				IT.intConfirmedBy,
				IT.dtmConfirmedDate,
				IT.intCancelledBy,
				IT.dtmCancelledDate,
				IT.intFactoryCode,
				IT.intMainStoreID,
				CO.strName,
				CO.strAddress1,
				CO.strAddress2,
				CO.strStreet,
				CO.strCity,
				CO.intCountry,
				CO.strZipCode,
				CO.strPhone,
				CO.strEMail,
				CO.strFax,
				CO.strWeb,
				(select useraccounts.Name from useraccounts where useraccounts.intUserID = IT.intUserId ) as UserId,
				(select useraccounts.Name from useraccounts where useraccounts.intUserID = IT.intApprovedBy ) as ApprovedBy,
				(select useraccounts.Name from useraccounts where useraccounts.intUserID = IT.intAuthorisedby ) as Authorisedby,
				(select useraccounts.Name from useraccounts where useraccounts.intUserID = IT.intConfirmedBy ) as ConfirmedBy,
				(select useraccounts.Name from useraccounts where useraccounts.intUserID = IT.intCancelledBy) as CancelledBy
				FROM
				itemtransfer AS IT
				Inner Join companies AS CO ON CO.intCompanyID = IT.intFactoryCode
				WHERE
				IT.intTransferId =  '$intJobNo' AND
				IT.intTransferYear =  '$intJobYear'";
						
				$result = $db->RunQuery($SQL);
				while($row = mysql_fetch_array($result ))
				{  
					$comName		= $row["strName"];
					$comAddress1	= $row["strAddress1"];
					$comAddress2	= $row["strAddress2"];
					$comStreet		= $row["strStreet"];
					$comCity		= $row["strCity"];
					$comState		= $row["strState"];
					$comCountry		= $row["intCountry"];
					$comZipCode		= $row["strZipCode"];
					$strPhone		= $row["strPhone"];
					$comEMail		= $row["strEMail"];
					$comFax			= $row["strFax"];
					$comWeb			= $row["strWeb"];
					
					$styleFrom		= $row["intStyleIdFrom"];
					$styleTo		= $row["intStyleIdTo"];
					$Status			= $row["intStatus"];
					
					$UserId			= $row["UserId"];
					$TransferDate	= $row["dtmTransferDate"];
					
					$ApprovedBy		= $row["ApprovedBy"];
					$ApprovedDate	= $row["dtmApprovedDate"];
					
					$Authorisedby	= $row["Authorisedby"];
					$AuthorisedDate	= $row["dtmAuthorisedDate"];
									
					$ConfirmedBy	= $row["ConfirmedBy"];
					$ConfirmedDate	= $row["dtmConfirmedDate"];

					$CancelledBy	= $row["CancelledBy"];
					$CancelledDate	= $row["dtmCancelledDate"];
					
				$strAddress1new = trim($comAddress1) == "" ? $comAddress1 : $comAddress1 ;
				$strAddress2new = trim($comAddress2) == "" ? $comAddress2 : "," . $comAddress2;
				$strStreetnew = trim($comStreet) == "" ? $comStreet : "," . $comStreet ;
				$strCitynew = trim($comCity) == "" ? $comCity : "," . $comCity;
				$strStatenew = trim($comState) == "" ? $comState : "," . $comState . "," ;
				}
				?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inter Job Transfer :: Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
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

function UpdateStatus(prmStatus){
	
	
	var _iInterJobNo = document.getElementById('hnd_jobYear').value +"/"+document.getElementById('hnd_jobNo').value;
	
	//alert(_iInterJobNo);
	
	var _strStatus = "";
	
	
	
	if(prmStatus==1){
		_strStatus = "Approved";
	}else if(prmStatus==2){
		_strStatus = "Authorise";
	}else{
		_strStatus = "Confirm";	
	}
	
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleRequest;
	xmlHttp.open("GET",'../materialsTransferXml.php?RequestType='+_strStatus+'&No=' +_iInterJobNo ,true);
	xmlHttp.send(null);
	
	
}

function HandleRequest(){
	
	if(xmlHttp.readyState == 4){
		if(xmlHttp.status == 200){
			if(xmlHttp.responseText!=""){
				document.getElementById("frmApprovalNote").submit();	
			}
			
		}
		
	}
	
}
</script>
</head>


<body>
<form id="frmApprovalNote" method="post" target="_self">
<table width="1100" border="0" align="center" cellpadding="0">
  <tr>
    <td width="1101"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="18%"><img src="../../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>

              <td width="18%" class="normalfnt">&nbsp;</td>
				  
				   <td width="51%" class="tophead"><p class="topheadBLACK"><?php echo $comName; ?></p>
		<p class="normalfnt"><?php echo $strAddress1new.",".$strAddress2new.",".$strStreetnew.",".$strCitynew.",".$comCountry.".";?></p>
		<p class="normalfnt"><?php echo "Tel : "."(".($comZipCode).") ".$strPhone." , Fax : "."(".($comZipCode).") ".$comFax.".";?></p>
        <p class="normalfnt"><?php echo "E-Mail : ".$comEMail." , Web : ".$comWeb ?></p></td>
                 <td width="13%" class="tophead">&nbsp;</td>
              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><p class="head2BLCK">INTER-JOB MATERIAL TRANSFER NOTE </p>
      <p align="center" class="headRed"><?PHP		
			if($Status==10)
				echo "THIS IS NOT A VALID REPORT";			
	?>
	  </p>
      <table width="100%" border="0" cellpadding="0">
        
        <tr>
          <td width="50%" height="53"><table width="100%" border="0">
            <tr>
              <td width="10%" class="normalfnBLD1">SERIAL NO</td>
			  <td width="1%"><span class="normalfnBLD1">:</span></td>
              <td width="10%"><span class="normalfnBLD1"><?php echo $intJobYear."/".$intJobNo; ?></span></td>
              <td width="5%">&nbsp;</td>
			   <td width="16%">&nbsp;</td>
              <td width="9%"><span class="normalfnBLD1"> DATE &amp; TIME </span></td>
			  
              <td width="1%"><span class="normalfnBLD1">:</span></td>		  
              <td width="14%" class="normalfnBLD1"><?php echo $TransferDate ;?></td>
              <td width="4%" class="normalfnBLD1">&nbsp;</td>
              <td width="1%" class="normalfnBLD1">&nbsp;</td>
              <td width="29%" class="normalfnBLD1">&nbsp;</td>
            </tr>
          </table>
            <table width="100%" border="0">
<?php
$sqlfrom="SELECT
		B.strName AS fromBuyerName,
		specification.intSRNO AS fromSRNO
		FROM
		orders AS O
		Inner Join buyers AS B ON O.intBuyerID = B.intBuyerID
		Inner Join specification ON O.intStyleId = specification.intStyleId
		WHERE
		O.intStyleId =  '$styleFrom'";

$resultfrom = $db->RunQuery($sqlfrom);
while($rowfrom = mysql_fetch_array($resultfrom )){
	$fromBuyerName		=$rowfrom["fromBuyerName"];
	$fromSRNO		=$rowfrom["fromSRNO"];
}
?>

<?PHP
$sqlto="SELECT
		B.strName AS toBuyerName,
		specification.intSRNO AS toSRNO
		FROM
		orders AS O
		Inner Join buyers AS B ON O.intBuyerID = B.intBuyerID
		Inner Join specification ON O.intStyleId = specification.intStyleId
		WHERE
		O.intStyleId =  '$styleTo'";

$resultto = $db->RunQuery($sqlto);
while($rowto = mysql_fetch_array($resultto )){
	$toBuyerName		=$rowto["toBuyerName"];
	$toSRNO		=$rowto["toSRNO"];
}
?>
              <tr>
                <td width="10%" class="normalfnBLD1">FROM STYLE</td>
                <td width="1%"><span class="normalfnBLD1">:</span></td>
                <td width="10%"><span class="normalfnt"><?php echo $styleFrom;?></span></td>
                <td width="5%"><span class="normalfnBLD1">BUYER :</span></td>
                <td width="16%"><span class="normalfnt"><?php echo $fromBuyerName ;?></span></td>
               
                <td width="9%" class="normalfnBLD1">TO STYLE</td>
                <td width="1%"><span class="normalfnBLD1">:</span></td>
                <td width="14%"><span class="normalfnt"><?php echo $styleTo;?></span></td>
                <td width="4%"><span class="normalfnBLD1">BUYER</span></td>
				<td width="1%"><span class="normalfnBLD1">:</span></td>
                <td width="29%"><span class="normalfnt"><?php echo $toBuyerName;?></span></td>
              </tr>
			   <tr>
                <td width="10%" class="normalfnBLD1">FROM SC</td>
                <td width="1%"><span class="normalfnBLD1">:</span></td>
                <td width="10%"><span class="normalfnt"><?php echo $fromSRNO ;?></span></td>
                <td width="5%">&nbsp;</td>
                <td width="16%">&nbsp;</td>
                
                <td width="9%" class="normalfnBLD1">TO SC </td>
                <td width="1%"><span class="normalfnBLD1">:</span></td>
                <td width="14%"><span class="normalfnt"><?php echo $toSRNO;?></span></td>
                <td width="4%">&nbsp;</td>
                <td width="1%">&nbsp;</td>
				<td width="29%">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
    </table>      
      <table width="100%" border="0" cellpadding="0">
        <tr>
          <td width="10%" class="normalfnBLD1">REPORT STATUS</td>		  
          <td width="1%" class="normalfnBLD1">:</td>
          <td width="10%" bgcolor="#CCCCCC" class="normalfnBLD1TAB">
		    <div align="center">
		      <?PHP
		  if($Status==0)echo "SAVED";
		  elseif($Status==1)echo "APPROVED";
		  elseif($Status==2)echo "AUTHORISED";
		  elseif($Status==3)echo "CONFIRMED";
		  elseif($Status==10)echo "CANCELED";
		  ?>
          </div></td>
          <td width="79%" class="normalfnBLD1" >&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">

            <tr>
              <td width="8%" height="31"  bgcolor="#CCCCCC" class="bcgl1txt1B">Item Code </td>
              <td width="35%"  bgcolor="#CCCCCC" class="bcgl1txt1B">Description </td>
              <td width="10%" bgcolor="#CCCCCC" class="bcgl1txt1B" >BuyerPoNo</td>
              <td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B" >Color</td>
              <td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B" >Size</td>
              <td width="8%"  bgcolor="#CCCCCC" class="bcgl1txt1B">Transfer Qty </td>
              <td width="7%" bgcolor="#CCCCCC" class="bcgl1txt1B" >UOM</td>
              <td width="8%"  bgcolor="#CCCCCC" class="bcgl1txt1B">Unit Price </td>
              <td width="8%"  bgcolor="#CCCCCC" class="bcgl1txt1B">Value</td>
              </tr>
<?php 
	$sql_details="SELECT
		ITD.strBuyerPoNo,
		ITD.strColor,
		ITD.strSize,
		ITD.strUnit,
		ITD.dblQty,
		ITD.dblUnitPrice,
		MIL.strItemDescription,
		MR.materialRatioID
		FROM
		itemtransferdetails AS ITD
		Inner Join matitemlist AS MIL ON ITD.intMatDetailId = MIL.intItemSerial
		Inner Join itemtransfer IT ON IT.intTransferId=ITD.intTransferId and IT.intTransferYear=ITD.intTransferYear
		LEFT Join materialratio MR ON MR.intStyleId=IT.intStyleIdFrom and MR.strBuyerPONO=ITD.strBuyerPoNo and 
		MR.strMatDetailID=ITD.intMatDetailId and MR.strColor=ITD.strColor and MR.strSize=ITD.strSize
		WHERE
		ITD.intTransferId =  '$intJobNo' AND
		ITD.intTransferYear =  '$intJobYear'";
		
	$result_details = $db->RunQuery($sql_details);
	while($row_details = mysql_fetch_array($result_details )){
?>           
            <tr>
              <td class="normalfntTAB"><?php echo $row_details["materialRatioID"]?></td>
              <td class="normalfntTAB"><?php echo $row_details["strItemDescription"]?></td>
              <td class="normalfntTAB"><?php echo $row_details["strBuyerPoNo"]?></td>
              <td class="normalfntTAB"><?php echo $row_details["strColor"]?></td>
              <td class="normalfntTAB"><?php echo $row_details["strSize"]?></td>
              <td class="normalfntRiteTAB"><?php echo $row_details["dblQty"]?></td>
              <td class="normalfntTAB"><?php echo $row_details["strUnit"]?></td>
              <td class="normalfntRiteTAB"><?php echo number_format($row_details["dblUnitPrice"],4)?></td>
              <td class="normalfntRiteTAB"><?php echo number_format(($row_details["dblUnitPrice"]*$row_details["dblQty"]),2)?></td>
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
        <td width="86%" class="bigfntnm1mid">&nbsp;</td>
        <td width="7%" class="bigfntnm1mid">&nbsp;</td>
        <td width="7%" class="bigfntnm1rite">&nbsp;</td>
      </tr>
      <tr>
        <td class="bigfntnm1mid">&nbsp;</td>
        <td class="bigfntnm1mid">&nbsp;</td>
        <td class="bigfntnm1rite">&nbsp;</td>
      </tr>
    </table>
      <table width="100%" border="0">
        <tr>          
			<td width="20%" class="bcgl1txt1"><?php echo $UserId ;?></td>       
		 	<td width="20%" class="bcgl1txt1"><?php echo $ApprovedBy ;?></td>
			<td width="20%" class="bcgl1txt1"><?php echo $Authorisedby ;?></td>
			<td width="20%" class="bcgl1txt1"><?php echo $ConfirmedBy ;?></td>
			<td width="20%" class="bcgl1txt1"><?php echo $CancelledBy ;?></td>    
        </tr>
        <tr>
          <td width="20%" class="normalfntMid"><?php echo $TransferDate ;?></td>
          <td width="20%" class="normalfntMid"><?php echo $ApprovedDate ;?></td>
          <td width="20%" class="normalfntMid"><?php echo $AuthorisedDate ;?></td>
          <td width="20%" class="normalfntMid"><?php echo $ConfirmedDate ;?></td>
          <td width="20%" class="normalfntMid"><?php echo $CancelledDate ;?></td>
        </tr>
        <tr>
          <td width="20%" class="normalfntMid">PrePaird By/Date</td>
          <td width="20%" class="normalfntMid">Approved By/Date</td>
          <td width="20%" class="normalfntMid">Authorise By/Date</td>
          <td width="20%" class="normalfntMid">ConfirmedBy/Date</td>
          <td width="20%" class="normalfntMid">Canceled By/Date</td>
        </tr>
        <tr>
          <td width="20%" class="normalfntMid">&nbsp;</td>
          <td width="20%" class="normalfntMid">&nbsp;</td>
          <td width="20%" class="normalfntMid">&nbsp;</td>
          <td width="20%" class="normalfntMid">&nbsp;</td>
          <td width="20%" class="normalfntMid">&nbsp;</td>
        </tr>
        <tr>
          <td width="20%" class="normalfntMid">&nbsp;</td>
          <td width="20%" class="normalfntMid">&nbsp;</td>
          <td width="20%" class="normalfntMid">&nbsp;</td>
          <td width="20%" class="normalfntMid">&nbsp;</td>
          <td width="20%" class="normalfntMid">
          <?php 
		  	if($Status == 0){
			?>
            	<img src="../../images1/approve.png" onclick="UpdateStatus(1)" />
           <?php 	
			}elseif($Status == 1){
		  ?>
          	<img src="../../images1/AUTHORISE.png" onclick="UpdateStatus(2)" />
          <?php
          }
		  ?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
<input type="hidden" id="hnd_jobNo" value="<?php echo $intJobNo; ?>" />
<input type="hidden" id="hnd_jobYear" value="<?php echo $intJobYear; ?>" />
</form>
<?php 
if($Status==10)
{
	echo " <style type=\"text/css\"> body {background-image: url(../images/not-valid.png);} </style>";
}
?>
</body>
</html>
