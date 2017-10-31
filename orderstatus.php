<?php
include "Connector.php";
$StyleIDList = array();
$StyleList = array();
$rowCount=0;
$noFrom=0;
$noTo=15;

$loopingIndex = 0;
		$SQL_styleID="SELECT DISTINCT orders.intStyleId
		FROM (((styleratio INNER JOIN orders ON styleratio.intStyleId = orders.intStyleId) INNER JOIN deliveryschedule ON orders.intStyleId = deliveryschedule.intStyleId) INNER JOIN orderdetails ON orders.intStyleId = orderdetails.intStyleId) INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID
		WHERE (((orders.intCompanyID) = ".$_POST["cboCompanyID"]."));";
		//echo $SQL_styleID;
			if ($_POST["cboCompanyID"] != null || $_POST["cboCompanyID"] != "")
			{
			$result_styleID = $db->RunQuery($SQL_styleID);
			
			while($row_styleID=mysql_fetch_array($result_styleID))
			{
				$StyleIDList[$loopingIndex] = $row_styleID["intStyleId"];
				$StyleList[$loopingIndex] = "'" . $row_styleID["intStyleId"] . "'";
				$loopingIndex ++;
			//$StyleID=$row_styleID["intStyleId"];
			}
			}
?>
<head>
<title>ORDER STATUS</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style1 {color: #FF0000}
.style3 {color: #FFFFFF}
.style4 {color: #FFFF00}
.style5 {color: #000000}
-->
</style>
<script type="text/javascript" src="javascript/orderstatus.js"></script>
<script type="text/javascript">
var noOfRowsFrom=0;
var noOfRowsTo=15;
var noOfStyleRecords;
var currentLeft = 0;

function doWork(e,obj)
{

	var top = obj.scrollTop;
	var left = obj.scrollLeft;
   if (left > 0 && currentLeft != left && top <= 20)
   {
   		document.getElementById('divHeader').style.visibility = 'hidden'; 
		
		currentLeft = left;
	}
	
	if (top > 20)
	{
		document.getElementById('divHeader').scrollLeft = obj.scrollLeft;
		document.getElementById('divHeader').style.visibility = 'visible'; 
		currentLeft = left;
	}
	else
	{
		document.getElementById('divHeader').style.visibility = 'hidden'; 
	}
	
}

function getStyleDeials(possition)
{
var companyid=document.getElementById("cboCompanyID").value;
var buyerid=document.getElementById("cboCustomer").value;
var styleid=document.getElementById("txtstyleid").value;
var check=document.getElementById("chksearch").value;

var row=document.getElementById("tblCaption").getElementsByTagName("TR")
var cell=row[0].getElementsByTagName("TD")
var noOfRocs=cell[1].innerHTML;
var noOfStyleRecords=document.getElementById("txtTotNos").value;

if(possition==1)
	{
		noOfRowsFrom=0
	 	noOfRowsTo=15	//default 15
	}
	else if(possition==2)
	{	if(noOfRowsFrom>0)
		{
			noOfRowsFrom=noOfRowsFrom-15
			noOfRowsTo=noOfRowsTo-15
		}
		else
		{
			noOfRowsFrom=0
			noOfRowsTo=15	//default 15
		}
	}
	else if(possition==3)
	{
		noOfRowsFrom=noOfRowsFrom+15
	 	noOfRowsTo=noOfRowsTo+15
	}
	else if(possition==4)
	{
		var temp=noOfStyleRecords/15
		
		var tempRecSets=(temp-parseInt(temp))

			noOfRowsFrom=parseInt(temp)*15
	 		noOfRowsTo	=Number(tempRecSets*15).toFixed(0);
		
	}


	//cell[3].innerHTML=noOfRowsFrom;
	//cell[5].innerHTML=noOfRowsTo;
	//document.getElementById("txtNoFrom").value=noOfRowsFrom
	//document.getElementById("txtNoTo").value=noOfRowsTo
	document.getElementById("txtNoFrom").value=noOfRowsFrom;
	document.getElementById("txtNoTo").value=noOfRowsTo;
}

function SubmitForm()
{
	var companyID=document.getElementById("cboCompanyID").value;
	var cusID=document.getElementById("cboCustomer").value;
	var styleLike=document.getElementById("txtstyleid").value;


	document.frmStatus.submit();
}




</script>

</head>

<body>
	  <?php
		  $dynamiwidth = 0;
		  $printstyleList = implode(",", $StyleList); 
	   	  $SQL_widthQuery="SELECT DISTINCT matsubcategory.StrCatName,matsubcategory.intSubCatNo FROM matsubcategory INNER JOIN matitemlist ON matsubcategory.intSubCatNo = matitemlist.intSubCatID INNER JOIN orderdetails ON matitemlist.intItemSerial = orderdetails.intMatDetailID INNER JOIN orders ON orderdetails.intStyleId = orders.intStyleId INNER JOIN companies ON companies.intCompanyID = orders.intCompanyID WHERE orders.intStyleId in (" . $printstyleList . ") AND companies.intCompanyID = ".$_POST["cboCompanyID"]." ;";  //
		
		//echo $SQL_widthQuery;			
			if ($_POST["cboCompanyID"] != null || $_POST["cboCompanyID"] != "")
			{
				$result_set = $db->RunQuery($SQL_widthQuery);
				$num_rows = mysql_num_rows($result_set);
				$dynamiwidth +=  ($num_rows * 300);
				
			}
			
	 	$dynamiwidth += 7100;
	  ?>

<form name="frmStatus" id="frmStatus" method="post" action="orderstatus.php">
  <table width="934" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td width="5997"><?php include 'Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
          <tr>
            <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
                <tr>
                  <td height="24" class="normalfnt">Company</td>
                  <td width="23%" class="normalfnt"><select name="cboCompanyID" class="txtbox" id="cboCompanyID" style="width:200px">
                      <?php
	
	$SQL = "SELECT intCompanyID,strName FROM companies  where intStatus='1' order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		if ($_POST["cboCompanyID"] ==  $row["intCompanyID"])
			echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
		else
			echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
                    </select>
                  <span class="normalfntMidTAB"></span>                  </td>
                  <td width="2%" class="normalfnt"><input type="checkbox" name="chksearch" id="chksearch" /></td>
                  <td width="14%" class="normalfnt">Search by Customer</td>
                  <td width="17%" class="normalfnt"><select name="cboCustomer" class="txtbox" id="cboCustomer" style="width:150px">
                      <?php
	
	$SQL_customer = "SELECT buyers.intBuyerID,buyers.strName from buyers WHERE buyers.intStatus='1' order by strName;";
	
	$result_customer = $db->RunQuery($SQL_customer);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result_customer))
	{
		if ($_POST["cboCustomer"] ==  $row["intBuyerID"])
			echo "<option selected=\"selected\" value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		else
			echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="10%" class="normalfnt">Style ID Like</td>
                  <td width="19%" class="normalfnt"><input name="txtstyleid" type="text" class="txtbox" id="txtstyleid" value="<?php echo $_POST["txtstyleid"];?>"/></td>
                  <td width="9%" class="normalfnt"><img src="images/search.png" alt="search" name="search" id="search" width="80" height="24" onClick="SubmitForm();"/></td>
                </tr>
            </table></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td>
	<div id="divmainto" style="width:955px">
	  <table width="934" height="401" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="42%"  height="20"  bgcolor="#9BBFDD" class="normalfnth2"><div align="center" style="width:400px">All 
              Order Details</div></td>
			<td width="58%" bgcolor="#9BBFDD" class="normalfnth2"><div align="center" ><table width="547" border="0" cellpadding="0" cellspacing="0" class="tablezRED" id="tblCaption">
          <tr>
		   <?php
				  
			  $companyid=$_POST["cboCompanyID"];
			  $buyerid=$_POST["cboCustomer"];
			  $styleid=$_POST["txtstyleid"];
			  $check=$_POST["chksearch"];
			 
				
			  $SQL_search= "";
						 
			  if($companyid!="" && $check!=on && $buyerid=="" && $styleid=="")
			  {
	
			  $SQL_search="SELECT styleratio.strBuyerPONO, styleratio.strColor, sum(styleratio.dblQty) as dblQty, 
	orders.intStyleId, orders.strDescription, orders.reaSMV,orders.reaSMVRate, orders.dtmDate, 
	orders.reaFOB, deliveryschedule.dtDateofDelivery, buyers.strName, 
	orders.intCompanyID, buyers.intBuyerID
	FROM  styleratio INNER JOIN orders ON styleratio.intStyleId = orders.intStyleId 
	INNER JOIN deliveryschedule ON orders.intStyleId = deliveryschedule.intStyleId 
	INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID
	WHERE (((orders.intCompanyID)=".$companyid.")) group by styleratio.strBuyerPONO, styleratio.strColor, orders.intStyleId, orders.strDescription, orders.reaSMV,orders.reaSMVRate, orders.dtmDate, orders.reaFOB, deliveryschedule.dtDateofDelivery, buyers.strName, orders.intCompanyID, buyers.intBuyerID ;";
				
			  }
						  
			 if($companyid!="" && $check==on && $buyerid!="" && $styleid=="")
			  {
			  $SQL_search="SELECT styleratio.strBuyerPONO, styleratio.strColor, sum(styleratio.dblQty) as dblQty, 
	orders.intStyleId, orders.strDescription, orders.reaSMV,orders.reaSMVRate, orders.dtmDate, 
	orders.reaFOB, deliveryschedule.dtDateofDelivery, buyers.strName, 
	orders.intCompanyID, buyers.intBuyerID
	FROM  styleratio INNER JOIN orders ON styleratio.intStyleId = orders.intStyleId 
	INNER JOIN deliveryschedule ON orders.intStyleId = deliveryschedule.intStyleId 
	INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID
	WHERE (((orders.intCompanyID)=".$companyid.") AND ((buyers.intBuyerID)=".$buyerid.")) group by styleratio.strBuyerPONO, styleratio.strColor, orders.intStyleId, orders.strDescription, orders.reaSMV,orders.reaSMVRate, orders.dtmDate, orders.reaFOB, deliveryschedule.dtDateofDelivery, buyers.strName, orders.intCompanyID, buyers.intBuyerID ;";
			
			  }
							
			 if($companyid!="" && $check!=on && $buyerid=="" && $styleid!="")
			  {
			  $SQL_search="SELECT styleratio.strBuyerPONO, styleratio.strColor, sum(styleratio.dblQty) as dblQty, 
	orders.intStyleId, orders.strDescription, orders.reaSMV,orders.reaSMVRate, orders.dtmDate, 
	orders.reaFOB, deliveryschedule.dtDateofDelivery, buyers.strName, 
	orders.intCompanyID, buyers.intBuyerID
	FROM  styleratio INNER JOIN orders ON styleratio.intStyleId = orders.intStyleId 
	INNER JOIN deliveryschedule ON orders.intStyleId = deliveryschedule.intStyleId 
	INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID
	WHERE (((orders.intStyleId) like '$styleid%') AND ((orders.intCompanyID)=".$companyid.")) group by styleratio.strBuyerPONO, styleratio.strColor, orders.intStyleId, orders.strDescription, orders.reaSMV,orders.reaSMVRate, orders.dtmDate, orders.reaFOB, deliveryschedule.dtDateofDelivery, buyers.strName, orders.intCompanyID, buyers.intBuyerID ;";
			
			  }
						 //echo $SQL_search;
						
		 if (!$SQL_search=="")
		 {
			$result_search = $db->RunQuery($SQL_search);
			
			$rowCount=mysql_num_rows($result_search);
		 }
?>
			<td width="89"><div align="center">No of Styles :</div></td>
            <td width="77"><input name="txtTotNos" type="text" class="txtbox" disabled="disabled" id="txtTotNos" value="<?php echo $rowCount; ?>" size="13" height="10"></td>
            <td width="49">From :</td>
            <td width="56">
              <input name="txtNoFrom" type="text" class="txtbox" id="txtNoFrom" value="
			  <?php 
			  	if($noFrom!=0)
			  	{
					echo $noFrom;
				}
				else
				{
					echo 0;
				}
			  
			   ?> " size="10" height="10">              </td>
            <td width="30">To :</td>
            <td width="56"><input name="txtNoTo" type="text" class="txtbox" id="txtNoTo"  value="
			<?php 
			  	if($noFrom!=0 && $noTo!=15)
			  	{
					echo $noTo;
				}
				else
				{
					echo 15;
				}
			  
			?>
			" size="10" height="10"></td>
            <td width="23" onClick="getStyleDeials(1)"><img src="images/fb.png" width="18" height="19" /></td>
            <td width="23" onClick="getStyleDeials(2)"><img src="images/fw.png" width="18" height="19" /></td>
            <td width="23" onClick="getStyleDeials(3)"><img src="images/bw.png" width="18" height="19" /></td>
            <td width="18" onClick="getStyleDeials(4)"><img src="images/ff.png" width="18" height="19" /></td>
          </tr>
        </table>
			</div></td>
			
          </tr>
          <tr>
            <td height="380" colspan="2" class="normalfnt"><div id="divcons" onscroll="doWork(event,this);" style="overflow:scroll; height:410px; width:955px;">
                <div id="divHeader" style="position:fixed;width:934px;overflow:hidden;">
                  <table style="visibility:hidden" width="<?php echo $dynamiwidth; ?>" cellpadding="0" cellspacing="0">
                                      <tr class="normaltxtmidb2">
                    <td width="116" height="20" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Customer</td>
                    <td width="116" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Style 
                    ID</td>
                    <td width="137" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
                    <td width="140" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Buyer 
                    PO</td>
                    <td width="100" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">FOB</td>
                    <td width="102" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">SMV</td>
                    <td width="28" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Est. 
                    YY</td>
                    <td width="19" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">CM</td>
                    <td width="41" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Order 
                    Date</td>
                    <td width="104" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
                    <td width="27" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Size</td>
                    <td width="95" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
                    <td width="31" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">GMT 
                    ETD</td>
                    <td width="32" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Rev. 
                    ETD</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">PLND 
                    Cut Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Act 
                    Cut Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">PLND 
                    Input Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Act 
                    Input Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">PLND 
                    Finish Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Act 
                    Shipment Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">Shipment 
                    QTY</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="normaltxtmidb2">+/-</td>
                    <td colspan="3" bgcolor="#498CC2" class="normaltxtmidb2">SAMPLES STATUS </td>
                    <td colspan="5" bgcolor="#498CC2" class="normaltxtmidb2">SIZE</td>
                   <td colspan="5" bgcolor="#498CC2" class="normaltxtmidb2">Gold Seal </td>
                    <td colspan="5" bgcolor="#498CC2" class="normaltxtmidb2">TESTING</td>
                    <td height="20" colspan="23" bgcolor="#498CC2" class="normaltxtmidb2L">FABRIC  STATUS</td>
                    <td height="20" bgcolor="#498CC2" class="normaltxtmidb2L"><span class="normaltxtmidb2 style1"><?php //echo $row["StrCatName"];?></span></td>
                    <td height="20" colspan="2" bgcolor="#498CC2" class="normaltxtmidb2L">&nbsp;</td>
                  </tr>
                  
                  <tr class="normaltxtmidb2">
                   <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">PITN 
                    ORG SMP TGT</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">PTTD 
                    RCVD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">ORG 
                    SMPL RCVD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">QTY</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">SIZE</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">TGT</td>
                    <td width="100" height="20" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2 style3">SENT</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">APVD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">QTY</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">SIZE</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">TGT</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2"><span class="normaltxtmidb2 style3">SENT</span></td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">APVD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">QTY</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">SIZE</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">TGT</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2"><span class="normaltxtmidb2 style3">SENT</span></td>
                    <td rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">APVD</td>
                    <td width="47" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">SUPPLIER</td>
                    <td width="47" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">PO</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">PI #</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">PAY MODE</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">PAY TGT DATE</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">PAY ACT DATE</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">FABRIC</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">COLOR / PRINT / CONTRAST</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">YDG BKD</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">YDG SHPD</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">+/-</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2 style4">PLND ETD</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">ACT ETD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">ACT ETA</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">IH DATE</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">COPY DOCS</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2">ORI DOCS</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">SMPL YDG RCVD Date</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">Lab Dip Aprvd</td>
                    <td colspan="2" bgcolor="#498CC2" class="normaltxtmidb2">Fab Test </td>
                    <td width="73" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">APVD BULK SWT RCVD</td>
                    <td width="34" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2">FAB INS P/F</td>
					  
                                            <?php 
					  $SQL_subcat="SELECT DISTINCT matsubcategory.StrCatName,matsubcategory.intSubCatNo FROM matsubcategory INNER JOIN matitemlist ON matsubcategory.intSubCatNo = matitemlist.intSubCatID INNER JOIN orderdetails ON matitemlist.intItemSerial = orderdetails.intMatDetailID INNER JOIN orders ON orderdetails.intStyleId = orders.intStyleId INNER JOIN companies ON companies.intCompanyID = orders.intCompanyID WHERE orders.intStyleId in (" . $printstyleList . ") AND companies.intCompanyID = ".$_POST["cboCompanyID"]." and matsubcategory.intStatus=1 and matsubcategory.intCatno=2 or matsubcategory.intCatno=3 and matsubcategory.StrCatName<>'';";
					  
					  //$strSQL="select intSubCatNo,StrCatName from matsubcategory where matsubcategory.intStatus=1 and matsubcategory.intCatno=2 or matsubcategory.intCatno=3 and matsubcategory.StrCatName<>'' order by intCatno,StrCatName";
					
								if ($_POST["cboCompanyID"] != null || $_POST["cboCompanyID"] != "")
			{
								$result_subcat = $db->RunQuery($SQL_subcat);
								while($row=mysql_fetch_array($result_subcat))
								{  
					?>
                   <td width="150" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2"><?php //echo $row["StrCatName"];?> BKD</td>
                    <td width="150" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2"><?php //echo $row["StrCatName"];?> <br /> IH</td>
                    <?php
					}
					}
					?>
				    </tr>
                    <tr class="normaltxtmidb2">
                      <td width="400" height="17" bgcolor="#498CC2" class="normaltxtmidb2">Customer</td>
                      <td width="200" bgcolor="#498CC2" class="normaltxtmidb2">Style 
                      ID</td>
                      <td width="300" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
                      <td width="200" bgcolor="#498CC2" class="normaltxtmidb2">Buyer 
                      PO</td>
                      <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">FOB</td>
                      <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">SMV</td>
                      <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">Est. 
                      YY</td>
                      <td width="150" bgcolor="#498CC2" class="normaltxtmidb2">CM</td>
                      <td width="200" bgcolor="#498CC2" class="normaltxtmidb2">Order 
                      Date</td>
                      <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
                      <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">Size</td>
                      <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
                      <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">GMT 
                      ETD</td>
                      <td width="100" bgcolor="#498CC2" class="normaltxtmidb2">Rev. 
                      ETD</td>
                    </tr>
                  </table>
                </div>
              <table width="934" height="115" cellpadding="0" cellspacing="0" class="color2" id="docu">
                  <tr class="normaltxtmidb2">
                    <td height="20" colspan="14" bgcolor="#999999" width="1100" class="tablezRedBorder style5">ORDER PLACEMENT</td>
                    <td colspan="8" bgcolor="#C7BBE8" class="tablezRedBorder style5">PRODUCTION</td>
                    <td colspan="18" bgcolor="#F9D9D5" class="tablezRedBorder style5">SAMPLING</td>
                    <td colspan="23" bgcolor="#DFFFDF" class="tablezRedBorder style5">FABRIC</td>
                    <td height="20" colspan="<?php echo $rowCount*2 ?>" bgcolor="#FFECD9" class="tablezRedBorder style5">TRIMS</td>
					 <?php 
																
						$arrSubCats = array();
						$arrindex = 0;
					  	$SQL_subcat="SELECT DISTINCT matsubcategory.StrCatName,matsubcategory.intSubCatNo FROM matsubcategory INNER JOIN matitemlist ON matsubcategory.intSubCatNo = matitemlist.intSubCatID INNER JOIN orderdetails ON matitemlist.intItemSerial = orderdetails.intMatDetailID INNER JOIN orders ON orderdetails.intStyleId = orders.intStyleId INNER JOIN companies ON companies.intCompanyID = orders.intCompanyID WHERE orders.intStyleId in (" . $printstyleList . ") AND companies.intCompanyID = ".$_POST["cboCompanyID"].";";
					
						if ($_POST["cboCompanyID"] != null || $_POST["cboCompanyID"] != "")
						{
								$result_subcat = $db->RunQuery($SQL_subcat);
								while($row=mysql_fetch_array($result_subcat))
								{  
								
								$arrSubCats[$arrindex] = $row["intSubCatNo"];
								$arrindex  ++;
					?>
                   
                    <?php
						}
						}
					?>
                  </tr>
                  <tr class="normaltxtmidb2">
                    <td width="130" height="20" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Customer</td>
                    <td width="130" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Style 
                    ID</td>
                    <td width="150" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Description</td>
                    <td width="140" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Buyer 
                    PO</td>
                    <td width="100" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">FOB</td>
                    <td width="102" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">SMV</td>
                    <td width="28" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Est. 
                    YY</td>
                    <td width="19" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">CM</td>
                    <td width="41" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Order 
                    Date</td>
                    <td width="104" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Color</td>
                    <td width="27" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Size</td>
                    <td width="95" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Qty</td>
                    <td width="31" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">GMT 
                    ETD</td>
                    <td width="32" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Rev. 
                    ETD</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">PLND 
                    Cut Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Act 
                    Cut Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">PLND 
                    Input Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Act 
                    Input Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">PLND 
                    Finish Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Act 
                    Shipment Date</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">Shipment 
                    QTY</td>
                    <td width="94" rowspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">+/-</td>
                    <td colspan="3" bgcolor="#498CC2" class="tablezWhiteBorder">SAMPLES STATUS </td>
                    <td colspan="5" bgcolor="#498CC2" class="tablezWhiteBorder">SIZE</td>
                   <td colspan="5" bgcolor="#498CC2" class="tablezWhiteBorder">Gold Seal </td>
                    <td colspan="5" bgcolor="#498CC2" class="tablezWhiteBorder">TESTING</td>
                    <td height="20" colspan="23" bgcolor="#498CC2" class="tablezWhiteBorder">FABRIC  STATUS</td>
					
					<?php 
						$SQL_subcat="SELECT DISTINCT matsubcategory.StrCatName,matsubcategory.intSubCatNo FROM matsubcategory INNER JOIN matitemlist ON matsubcategory.intSubCatNo = matitemlist.intSubCatID INNER JOIN orderdetails ON matitemlist.intItemSerial = orderdetails.intMatDetailID INNER JOIN orders ON orderdetails.intStyleId = orders.intStyleId INNER JOIN companies ON companies.intCompanyID = orders.intCompanyID WHERE orders.intStyleId in (" . $printstyleList . ") AND companies.intCompanyID = ".$_POST["cboCompanyID"]." and matsubcategory.intStatus=1 and matsubcategory.intCatno=2 or matsubcategory.intCatno=3 and matsubcategory.StrCatName<>'';";
							
							//echo $SQL_subcat;
												
						if ($_POST["cboCompanyID"] != null || $_POST["cboCompanyID"] != "")
						{
							$result_subcat = $db->RunQuery($SQL_subcat);
							while($row=mysql_fetch_array($result_subcat))
							{  
						?>
					
                    <td height="20" colspan="3" bgcolor="#498CC2" class="tablezWhiteBorder"><div align="center"><span class="normaltxtmidb2"><?php echo $row["StrCatName"];?></span><span class="normaltxtmidb2"></span></div></td>
						<?php
							}
						}
						?>
					
                  </tr>
                  
                  <tr class="normaltxtmidb2">
                   <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">PITN 
                    ORG SMP TGT</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">PTTD 
                    RCVD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">ORG 
                    SMPL RCVD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">QTY</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">SIZE</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">TGT</td>
                    <td width="100" height="20" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder style3">SENT</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">APVD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">QTY</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">SIZE</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">TGT</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder"><span class="normaltxtmidb2 style3">SENT</span></td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">APVD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">QTY</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">SIZE</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">TGT</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder"><span class="normaltxtmidb2 style3">SENT</span></td>
                    <td rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">APVD</td>
                    <td width="47" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">SUPPLIER</td>
                    <td width="47" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">PO</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">PI #</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">PAY MODE</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">PAY TGT DATE</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">PAY ACT DATE</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">FABRIC</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">COLOR / PRINT / CONTRAST</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">YDG BKD</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">YDG SHPD</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">+/-</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder style4">PLND ETD</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">ACT ETD</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">ACT ETA</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">IH DATE</td>
                    <td width="100" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">COPY DOCS</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2">ORI DOCS</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">SMPL YDG RCVD Date</td>
                    <td width="94" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">Lab Dip Aprvd</td>
                    <td colspan="2" bgcolor="#498CC2" class="normaltxtmidb2">Fab Test </td>
                    <td width="73" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">APVD BULK SWT RCVD</td>
                    <td width="34" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder">FAB INS P/F</td>
					
										  
                                            <?php 
					  $SQL_subcat="SELECT DISTINCT matsubcategory.StrCatName,matsubcategory.intSubCatNo FROM matsubcategory INNER JOIN matitemlist ON matsubcategory.intSubCatNo = matitemlist.intSubCatID INNER JOIN orderdetails ON matitemlist.intItemSerial = orderdetails.intMatDetailID INNER JOIN orders ON orderdetails.intStyleId = orders.intStyleId INNER JOIN companies ON companies.intCompanyID = orders.intCompanyID WHERE orders.intStyleId in (" . $printstyleList . ") AND companies.intCompanyID = ".$_POST["cboCompanyID"]." and matsubcategory.intStatus=1 and matsubcategory.intCatno=2 or matsubcategory.intCatno=3 and matsubcategory.StrCatName<>'';";
					  
					  //$strSQL="select intSubCatNo,StrCatName from matsubcategory where matsubcategory.intStatus=1 and matsubcategory.intCatno=2 or matsubcategory.intCatno=3 and matsubcategory.StrCatName<>'' order by intCatno,StrCatName";
					
								if ($_POST["cboCompanyID"] != null || $_POST["cboCompanyID"] != "")
			{
								$result_subcat = $db->RunQuery($SQL_subcat);
								while($row=mysql_fetch_array($result_subcat))
								{  
					?>
                   <td width="150" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder"><?php //echo $row["StrCatName"];?> Ord. Qty </td>
                    <td width="150" rowspan="2" bgcolor="#498CC2" class="tablezWhiteBorder"><?php //echo $row["StrCatName"];?> Rec. Qty </td>
                    <?php
					}
					}
					?>
					
                    <!--<td width="94" rowspan="2" bgcolor="#498CC2" class="normaltxtmidb2"><span class="normaltxtmidb2L"><?php //echo $row["StrCatName"];?></span></td>-->
                  </tr>
                  
                  
                  
                  <tr class="normaltxtmidb2">
                    <td width="94" bgcolor="#498CC2" class="tablezWhiteBorder">QTY</td>
                    <td width="94" bgcolor="#498CC2" class="tablezWhiteBorder">SIZE</td>
                  </tr>
                  <?php
				  
				$companyid=$_POST["cboCompanyID"];
				$buyerid=$_POST["cboCustomer"];
				$styleid=$_POST["txtstyleid"];
				$check=$_POST["chksearch"];
				$noFrom=$_POST["txtNoFrom"];
				$noTo=$_POST["txtNoTo"];
				
				          $SQL_search= "";
						 
				          if($companyid!="" && $check!=on && $buyerid=="" && $styleid=="")
				          {
				
						  $SQL_search="SELECT styleratio.strBuyerPONO, styleratio.strColor, sum(styleratio.dblQty) as dblQty, 
orders.intStyleId, orders.strDescription, orders.reaSMV,orders.reaSMVRate, orders.dtmDate, 
orders.reaFOB, deliveryschedule.dtDateofDelivery, buyers.strName, 
orders.intCompanyID, buyers.intBuyerID
FROM  styleratio INNER JOIN orders ON styleratio.intStyleId = orders.intStyleId 
INNER JOIN deliveryschedule ON orders.intStyleId = deliveryschedule.intStyleId 
INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID
WHERE (((orders.intCompanyID)=".$companyid.")) group by styleratio.strBuyerPONO, styleratio.strColor, orders.intStyleId, orders.strDescription, orders.reaSMV,orders.reaSMVRate, orders.dtmDate, orders.reaFOB, deliveryschedule.dtDateofDelivery, buyers.strName, orders.intCompanyID, buyers.intBuyerID Limit $noFrom,$noTo;";
							
						  }
						  
						 if($companyid!="" && $check==on && $buyerid!="" && $styleid=="")
						  {
						  $SQL_search="SELECT styleratio.strBuyerPONO, styleratio.strColor, sum(styleratio.dblQty) as dblQty, 
orders.intStyleId, orders.strDescription, orders.reaSMV,orders.reaSMVRate, orders.dtmDate, 
orders.reaFOB, deliveryschedule.dtDateofDelivery, buyers.strName, 
orders.intCompanyID, buyers.intBuyerID
FROM  styleratio INNER JOIN orders ON styleratio.intStyleId = orders.intStyleId 
INNER JOIN deliveryschedule ON orders.intStyleId = deliveryschedule.intStyleId 
INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID
WHERE (((orders.intCompanyID)=".$companyid.") AND ((buyers.intBuyerID)=".$buyerid.")) group by styleratio.strBuyerPONO, styleratio.strColor, orders.intStyleId, orders.strDescription, orders.reaSMV,orders.reaSMVRate, orders.dtmDate, orders.reaFOB, deliveryschedule.dtDateofDelivery, buyers.strName, orders.intCompanyID, buyers.intBuyerID Limit $noFrom,$noTo;";
						
						  }
						
						 if($companyid!="" && $check!=on && $buyerid=="" && $styleid!="")
						  {
						  $SQL_search="SELECT styleratio.strBuyerPONO, styleratio.strColor, sum(styleratio.dblQty) as dblQty, 
orders.intStyleId, orders.strDescription, orders.reaSMV,orders.reaSMVRate, orders.dtmDate, 
orders.reaFOB, deliveryschedule.dtDateofDelivery, buyers.strName, 
orders.intCompanyID, buyers.intBuyerID
FROM  styleratio INNER JOIN orders ON styleratio.intStyleId = orders.intStyleId 
INNER JOIN deliveryschedule ON orders.intStyleId = deliveryschedule.intStyleId 
INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID
WHERE (((orders.intStyleId) like '$styleid%') AND ((orders.intCompanyID)=".$companyid.")) group by styleratio.strBuyerPONO, styleratio.strColor, orders.intStyleId, orders.strDescription, orders.reaSMV,orders.reaSMVRate, orders.dtmDate, orders.reaFOB, deliveryschedule.dtDateofDelivery, buyers.strName, orders.intCompanyID, buyers.intBuyerID Limit $noFrom,$noTo;";
						
						  }
						// echo "Limit $noFrom,$noTo";
						
						//$_POST["txtNoFrom"]=2;//$noFrom;
						
						 if (!$SQL_search=="")
						 {
							$result_search = $db->RunQuery($SQL_search);
							
							while($row_search=mysql_fetch_array($result_search))
						 	{
						   	$CM=$row_search["reaSMV"]*$row_search["reaSMVRate"];
						  	
								
						?>
                 
      
                  <tr>
                    <td width="130" height="20" bgcolor="#FFFFFF" class="normalfntTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="25" value="<?php echo $row_search["strName"];?>" /></td>
                    <td width="130" bgcolor="#FFFFFF" class="normalfntTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="25" value="<?php echo $row_search["intStyleId"];?>" /></td>
                    <td width="137" bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="30" value="<?php echo $row_search["strDescription"];?>" /></td>
                    <td width="140" bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="17" value="<?php echo $row_search["strBuyerPONO"];?>" /></td>
                    <td width="100" bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="10" value="<?php echo $row_search["reaFOB"];?>" /></td>
                    <td width="102" bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="10" value="<?php echo $row_search["reaSMV"];?>" /></td>
                    <td width="28" bgcolor="#FFFFFF" class="normalfntMidTAB"><img src="images/add.png" width="16" height="16" onClick="getEstyy(this)"></td>
                    <td width="19" bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="10" value="<?php echo $CM;?>" /></td>
                    <td width="41" bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="10" value="<?php $neworderdate = substr($row_search["dtmDate"],-19,10);
			echo $neworderdate;?>" /></td>
                    <td width="104" bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="15" value="<?php echo $row_search["strColor"];?>" /></td>
                    <td width="27" bgcolor="#FFFFFF" class="normalfntMidTAB"><img src="images/add.png" width="16" height="16" onClick="getSizeRatios(this)" /></td>
                    <td width="95" bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="15" value="<?php echo round($row_search["dblQty"]);?>" /></td>
                    <td width="31" bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="10" value="<?php $newdate = substr($row_search["dtDateofDelivery"],-19,10);
					echo $newdate;?>" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" disabled="disabled" style="background:#FFFFFF" class="txtbox_withoutBorder" size="10" value="<?php echo $newdate;?>" /></td>
                    <td  width="100" bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData17" type="text" id="txtData17" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData5" type="text" id="txtData5" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData4" type="text" id="txtData4" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData3" type="text" id="txtData3" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData6" type="text" id="txtData6" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData7" type="text" id="txtData7" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData8" type="text" id="txtData8" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData9" type="text" id="txtData9" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData10" type="text" id="txtData10" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData11" type="text" id="txtData11" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData2" type="text" id="txtData2" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="20" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData142222222" type="text" id="txtData142222222" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData14222222" type="text" id="txtData14222222" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData1422222" type="text" id="txtData1422222" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData142222" type="text" id="txtData142222" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData14222" type="text" id="txtData14222" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData1422" type="text" id="txtData1422" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData142" type="text" id="txtData142" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData14" type="text" id="txtData14" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData13" type="text" id="txtData13" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData12" type="text" id="txtData12" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB"><input name="txtData" type="text" id="txtData" class="txtbox" size="15" /></td>
                    <?php
					$arrindex = 0;
					$result_subcat = $db->RunQuery($SQL_subcat);
					while($row=mysql_fetch_array($result_subcat))
					{
					 
				    ?>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB">
                    
                      <input name="txtData15" type="text" id="txtData15" class="txtbox" size="15" value="<?php 				


 $catID = $arrSubCats[$arrindex];
						 
					$SQL_po="SELECT SUM(purchaseorderdetails.dblQty)AS pototal FROM purchaseorderdetails  inner join matitemlist on matitemlist.intItemSerial = purchaseorderdetails.intMatDetailID  WHERE purchaseorderdetails.intStyleId = '".$row_search["intStyleId"]."' AND matitemlist.intSubCatID = $catID ;"; // $catID
                    //echo $SQL_po;
							$result1 = $db->RunQuery($SQL_po);
							
								while($row_po=mysql_fetch_array($result1))
								{
								    $poqty = explode(".",$row_po["pototal"],2);
									$firpoqty = ($poqty[0]!=0) ? $poqty[0] : "00";
						            $secpoqty = ($poqty[1]!=0) ? ".".substr($poqty[1],0,2) : ".00";
						
						            echo $firpoqty.$secpoqty;
								   //echo $row_po["pototal"] ;
								 
								}

							

					
					?>" disabled="disabled" style="background:#FFFFCC" />                    </td>
                    <td bgcolor="#FFFFFF" class="normalfntMidTAB">
                                        <input name="txtData16" type="text" id="txtData16" class="txtbox" size="15" value="<?php 
					$SQL_grn="SELECT SUM(grndetails.dblQty)AS grntotal FROM grndetails inner join matitemlist on matitemlist.intItemSerial = grndetails.intMatDetailID WHERE grndetails.intStyleId = '".$row_search["intStyleId"]."' AND matitemlist.intSubCatID = $catID;";
					//echo $SQL_grn;
					 //$catID = $arrSubCats[$arrindex];
						   

				    $result_grn = $db->RunQuery($SQL_grn);
					while($row_grn=mysql_fetch_array($result_grn))
					{
					  
					    $grnqty = explode(".",$row_grn["grntotal"],2);
					    $firgrnqty = ($grnqty[0]!=0) ? $grnqty[0] : "00";
						$secgrnqty = ($grnqty[1]!=0) ? ".".substr($grnqty[1],0,2) : ".00";
						echo $firgrnqty.$secgrnqty;
					}
					$arrindex += 1;
					?>" disabled="disabled" style="background:#CBEFD0" /></td>
                    <?php
						
						}
					?>
                  </tr>
                  <?phP
						}
					}
				  ?>
                </table>
              </div></td>
          </tr>
      </table></div></td>
    </tr>
    <tr>
      <td><table width="96%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
          <tr>
            <td width="58%" height="20"><table width="100%" border="0">
          <tr>
            <td width="5%" ><input type="text" name="textfield" size="3" class="osc1TXT" disabled="disabled"></td>
            <td width="23%" class="normalfnt">Order Placement</td>
            <td width="4%" ><input type="text" name="textfield" size="3" class="osc2TXT" disabled="disabled"></td>
            <td width="23%" class="normalfnt">Fabric Purchase</td>
            <td width="5%" ><input type="text" name="textfield" size="3" class="osc3TXT" disabled="disabled"></td>
            <td width="13%" class="normalfnt">Sample</td>
            <td width="6%" ><input type="text" name="textfield" size="3" class="osc4TXT" disabled="disabled"></td>
            <td width="21%" class="normalfnt">Trim Purchasing</td>
            </tr>
        </table>			</td>
            <td width="3%">&nbsp;</td>
            <td width="7%"><img src="images/ok.png" width="112" height="24" /></td>
            <td width="7%"><img src="images/report.png" width="108" height="24" onClick="ShowPreOrderReport();" /></td>
            <td width="21%"><a href="main.php"><img src="images/close.png" width="97" height="24" border="0" /></a></td>
            <td width="4%">&nbsp;</td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
 </body>
 <?php
 
// print_r($arrSubCats);
 
 ?>
</html>
