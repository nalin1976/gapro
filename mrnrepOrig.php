<?php
session_start();
include "authentication.inc";
include "Connector.php";
$xml = simplexml_load_file('config.xml');
$ReportISORequired = $xml->companySettings->ReportISORequired;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MRN Report</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
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

function sendEmail(email)
{

document.getElementById('progress').style.visibility = "visible";
	var year = <?php echo  $_GET["year"];?>;
	var mrnNo = <?php echo  $_GET["mrnNo"];?>;
	
	
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = HandleEmail;
		xmlHttp.open("GET", 'mrnEmail.php?mrnNo=' + mrnNo + '&year=' + year + '&email=' + email, true);
		xmlHttp.send(null);
	
}

function HandleEmail()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
		document.getElementById('progress').style.visibility = "hidden";
			if(xmlHttp.responseText.indexOf("123")>-1)
			{
					alert("The MRN has been emailed to the stores.");
			}
			else
			{
			alert("Error occur while sending email, please contact your system administrator.");
			}
		}
	}
}


</script>
<body>

<table width="800" border="0" align="center">
 
  <tr>
    <td><span class="topheadBLACK">
      <?php 
	  	$report_companyId  = $_SESSION["FactoryID"];	
		$matreqno=$_GET["mrnNo"];
		$year=$_GET["year"];
		$SQL_matre="SELECT matrequisition.intMatRequisitionNo,matrequisition.dtmDate,
useraccounts.Name AS requested ,department.strDepartment, mainstores.strName AS storeName,matrequisition.intStatus,
matrequisition.intConfirmedBy,date(matrequisition.dtmConfirmDate) as confirmDate,
(select useraccounts.Name from useraccounts 
		where useraccounts.intUserID = matrequisition.intConfirmedBy) as ConfirmedPerson 
FROM matrequisition
left JOIN useraccounts ON useraccounts.intUserID = matrequisition.intRequestedBy
left JOIN department ON matrequisition.strDepartmentCode = department.intDepID
left JOIN mainstores ON matrequisition.strMainStoresID = mainstores.strMainID
 WHERE matrequisition.intMatRequisitionNo ='$matreqno' and matrequisition.intMRNYear=$year;";
		//die($SQL_matre);
		//echo $SQL_matre;
		$result_matre = $db->RunQuery($SQL_matre);

		
		while($row = mysql_fetch_array($result_matre))
		{	
		$MatRequisitionNo=$row["intMatRequisitionNo"];
		$MatRequisitionDate=$row["dtmDate"];
		$MatRequisitionDateNew= substr($MatRequisitionDate,-19,10);
		$MatRequisitionDateNewDate= substr($MatRequisitionDateNew,-2);
		$MatRequisitionDateNewYear=substr($MatRequisitionDateNew,-10,4);
		$MatRequisitionDateNewmonth1=substr($MatRequisitionDateNew,-5);
		$MatRequisitionDateNewmonth=substr($MatRequisitionDateNewmonth1,-5,2);
		$MatReqRequestedBy=$row["requested"];
		$department = $row["strDepartment"];
		$to = $row["storeName"];
		$status	 = $row["intStatus"];
		
		$confirmUserID = $row["intConfirmedBy"];
		$confirmDate   = $row["confirmDate"];
			if($confirmUserID != '' && !is_null($confirmUserID))
			{
				$confirmUser = $row["ConfirmedPerson"];
			} 
			else
			{
				$confirmUser = '';
			} 
		}
		
		
		
		$sql="SELECT companies. intCompanyID, companies.strName, companies.strAddress1, companies.strAddress2, companies.strStreet, 
companies.strCity,companies.strState, companies.strCountry, companies.strZipCode, companies.strPhone, companies.strEMail, 
companies.strFax,companies.strWeb, companies.intCompanyID FROM matrequisition 
INNER JOIN useraccounts ON matrequisition.intUserId = useraccounts.intUserID
INNER JOIN companies ON useraccounts.intCompanyID = companies.intCompanyID 
WHERE intMRNYear='$year' and intMatRequisitionNo='$matreqno';";
	
		$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{	
			$companyID=$row["intCompanyID"];
			echo $row["strName"] ;
			echo "</p><p class=\"normalfnt\">";
			echo $row["strAddress1"]." ".$row["strAddress2"]." ".$row["strStreet"]." ".$row["strCity"]." ".$row["strCountry"]." ".$row["strCountry"].". <br>"." Tel: ".$row["strPhone"]." Fax: ".$row["strFax"]." <br>E-Mail: ".$row["strEMail"]." Web: ".$row["strWeb"] ;
			echo "</p>";
		
		}
		$key="mrnEmail".$companyID;
		$sql="SELECT strValue FROM settings where strKey='$key';";
		$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{	
			$email=$row["strValue"];			
			
		}
		
		
		 ?>
      <?php include "reportHeader.php";?>
	  <?php 
if($status == 1)
{
?>
<div style="position:absolute;top:80px;left:270px">
<img src="images/pending.png">
</div>
<?php
}
?>
    </span></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="head2BLCK">
      <tr>
      	<td width="16%"></td>
        <td width="67%" class="head2BLCK">MATERIAL REQUISITION NOTE</td>
        <td width="17%"><?php
			
   					if($ReportISORequired == "true")
   					{
   						$xmlISO = simplexml_load_file('iso.xml');
   						echo  $xmlISO->ISOCodes->StyleMRNReport;
						}          
         ?></td>
      </tr>
	  
    </table></td>
  </tr>
   
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="50%" ><table width="100%" border="0">
              <tr> 
                <td width="41%" class="normalfnt2bldBLACK">Mat. Requisition No </td>
                <td width="59%" class="normalfnt">: <?php echo $MatRequisitionNo;?></td>
              </tr>
            </table></td>
        <td width="50%" ><table width="100%" border="0">
              <tr> 
                <td width="34%" class="normalfnt2bldBLACK">Requested Date </td>
                <td width="66%" class="normalfnt">: <?php echo $MatRequisitionDateNewDate."/".$MatRequisitionDateNewmonth."/".$MatRequisitionDateNewYear;?></td>
              </tr>
            </table></td>
      </tr>
      <tr>
        <td width="50%" ><table width="100%" border="0">
              <tr> 
                <td width="41%" class="normalfnt2bldBLACK">To </td>
                <td width="59%" class="normalfnt">: <?php echo $to;?></td>
              </tr>
              
            </table></td>
        <td width="50%" ><table width="100%" border="0">
              <tr> 
                <td width="34%" class="normalfnt2bldBLACK">Department (From)</td>
                <td width="66%" class="normalfnt">: <?php echo $department;?></td>
              </tr>
            </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
        <tr> 
          <td width="14%" height="24" class="normalfntBtab">Style No</td>
          <td width="10%" height="24" class="normalfntBtab">SC No</td>
          <td width="10%" class="normalfntBtab">Order No</td>
          <td width="35%" class="normalfntBtab">Item</td>
          <td width="8%" class="normalfntBtab">Wash Color </td>
          <td width="8%" class="normalfntBtab">Color</td>
          <td width="8%" class="normalfntBtab">Size</td>
          <td width="7%" class="normalfntBtab">Unit</td>
          <td width="8%" class="normalfntBtab">Req. Qty</td>
        </tr>
		
		<?php
		$sum = 0;
			$sql = "select  DISTINCT matmaincategory.intID, matmaincategory.strDescription from matrequisitiondetails,matitemlist,matmaincategory  where matrequisitiondetails.intMatRequisitionNo = $matreqno AND matrequisitiondetails.strMatDetailID = matitemlist.intItemSerial AND matitemlist.intMainCatID = matmaincategory.intID";
			$mainresult = $db->RunQuery($sql);
			while($row = mysql_fetch_array($mainresult))
			{	
		?>
		
        <tr> 
          <td colspan="9" class="normalfnt2BITAB"><?php echo  $row["strDescription"]; ?></td>
        </tr>
		<?php
		
		$CatID = $row["intID"];
		//echo $CatID;
		$sql = "SELECT matitemlist.strItemDescription, matrequisitiondetails.intStyleId, specification.intSRNO, matrequisitiondetails.strBuyerPONO, 
matrequisitiondetails.strColor, matrequisitiondetails.strSize, specificationdetails.strUnit ,round(matrequisitiondetails.dblQty,2)as dblQty,orders.strStyle, orders.strOrderNo
FROM matrequisitiondetails INNER JOIN matitemlist ON matrequisitiondetails.strMatDetailID = matitemlist.intItemSerial 
INNER JOIN specification ON matrequisitiondetails.intStyleId = specification.intStyleId 
INNER JOIN specificationdetails ON matrequisitiondetails.intStyleId = specificationdetails.intStyleId 
INNER JOIN orders ON orders.intStyleId = specification.intStyleId 
 AND matrequisitiondetails.strMatDetailID = specificationdetails.strMatDetailID
WHERE matrequisitiondetails.intMatRequisitionNo = '$matreqno' AND intYear='$year'  AND matitemlist.intMainCatID = $CatID";
		//echo $sql;
		$subresult = $db->RunQuery($sql);
			while($row = mysql_fetch_array($subresult))
			{
			$qty= $row["dblQty"]; 
			$sum += $qty;
			
			$buyerPOName = $row["strBuyerPONO"];
			$buyerPOid = $row["strBuyerPONO"];
			$StyleID   = $row["intStyleId"]; 
		?>
        <tr> 
          <td class="normalfntTAB"><?php echo  $row["strStyle"];?></td>
			<td class="normalfntTAB"><?php echo  $row["intSRNO"];?></td>
          <td class="normalfntTAB">
		  <?php /*if($buyerPOid != '#Main Ratio#')
		  			$buyerPOName = getBuerPOName($StyleID,$buyerPOid);*/
		  						 echo  $row["strOrderNo"]; ?></td>
          <td class="normalfntTAB"><?php echo  $row["strItemDescription"]; ?></td>
          <td class="normalfntMidTAB"><?php echo GetWashColor($StyleID);?></td>
          <td class="normalfntMidTAB"><?php echo  $row["strColor"]; ?></td>
          <td class="normalfntMidTAB"><?php echo  $row["strSize"]; ?></td>
          <td class="normalfntMidTAB"><?php echo  $row["strUnit"]; ?></td>
          <td class="normalfntRiteTAB"><?php echo  $row["dblQty"]; ?></td>
        </tr>
		<?php
			}
		}
		
		?>
		
		
        <tr> 
          <td colspan="8" style="text-align:center" ><strong class="normalfnth2Bm">TOTAL</strong></td>
          <td class="normalfntRiteTAB" ><?php echo $sum;?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td class="bcgl1txt1"><?php echo $MatReqRequestedBy;?></td>
        <td>&nbsp;</td>
        <td class="bcgl1txt1"><?php echo $MatReqRequestedBy;?></td>
        <td>&nbsp;</td>
        <td class="bcgl1txt1"><?php echo $confirmUser;?></td>
      </tr>
      <tr>
        <td class="normalfnth2Bm">Requested By</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">Checked By</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">Authorized By</td>
      </tr>
      <tr><td colspan="5">&nbsp;</td></tr>
      <tr>
     
        <td class="normalfnt" colspan="3"><?php 
		
		if($confirmUserID != '' && !is_null($confirmUserID))  
	  {
	  $arrConfirmDate = explode('-',$confirmDate);
	  $dtmConDate     = $arrConfirmDate[2].'/'.$arrConfirmDate[1].'/'.$arrConfirmDate[0];
		echo  'Confirmed Date : '.$dtmConDate; 
		}
		?></td>
        
       
       
        
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
</table>
<div style="left:314px; top:156px; z-index:30; position:absolute; width: 229px; visibility:hidden; height: 54px; background-color: #FFFF00; layer-background-color: #FFFF00; border: 1px none #000000;" id="progress">
  <table width="213" height="55" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><input type="image" name="imageField" src="images/loading.gif" /></td>
          </tr>
  </table>
		
<?php 
function getBuerPOName($StyleID,$buyerPOno)
{
$SQL = " SELECT strBuyerPoName FROM style_buyerponos
	 WHERE intStyleId='$StyleID' AND strBuyerPONO='$buyerPOno'";
	 
	 global $db;
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$BPOname = $row["strBuyerPoName"];
	}
return $BPOname;	 
	 
}

function GetWashColor($StyleID)
{
global $db;
	$sql1 = "select distinct strColor from styleratio where intStyleId=$StyleID ";
	$result1=$db->RunQuery($sql1);
	while($row1=mysql_fetch_array($result1))
	{
		return $row1["strColor"];
	}
}
?>	
</div>
</body>
</html>
