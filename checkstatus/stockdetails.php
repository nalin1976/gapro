<?php
	session_start();
	$backwardseperator = "../";
	include "../Connector.php";
	
	$styleID		= $_GET["styleID"];
	$buyerPoNo		= $_GET["buyerPoNo"];		
	$matItemList	= $_GET["matItemList"];
	$color			= $_GET["color"];
	$size			= $_GET["size"];
	$mainStore		= $_GET["mainStore"];
$sqlmainstore="select intCompanyId from mainstores where strMainID=$mainStore";
$result_mainstore=$db->RunQuery($sqlmainstore);
$row_mainstore=mysql_fetch_array($result_mainstore);
$companyId	= $row_mainstore["intCompanyId"];
?>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<table width="800"  align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"> 
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="91%" height="233"><form>
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
           <tr class="mainHeading">
              <td width="97%" height="25" >Bin GRN Details</td>
              <td width="3%"  ><img src="../images/cross.png" alt="close" width="17" height="17" onclick="CloseOSPopUp('popupLayer1');"
				 /></td>
           </tr>
            <tr>
              <td height="17" colspan="2"><table width="100%" border="0">
                <tr>
                  <td><div id="divGrnDetails" style="overflow:scroll; height:150px; width:846px;">
                    <table id="tblGrnDetails" width="825" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                      <tr class="mainHeading4">
                        <td width="150" height="20" >Main Stores</td>
                       <td width="150" >Sub Stores</td>
                        <td width="150" >Location</td>
                        <td width="112" >Bin</td>
                        <td width="40" >Unit</td>
                        <td width="40" >Qty</td>
                        <td width="100" >GRN No</td>
                        </tr>
<?php
$sqlgrn="select (select strName from mainstores MS where MS.strMainID=ST.strMainStoresID)AS MainStore, 
(select strSubStoresName from substores SS where SS.strSubID=ST.strSubStores)AS SubStore, 
(select strLocName from storeslocations SL where SL.strLocID=ST.strLocation)AS Location, 
(select strBinName from storesbins SB where SB.strBinID =ST.strBin)AS Bins,
/*(select materialRatioID from materialratio M where M.strMatDetailID =ST.intMatDetailId)AS MatID,*/
 strUnit, 
ST.dblQty AS StckBal, 
intDocumentNo, 
intDocumentYear
 from 
stocktransactions ST,materialratio M 
where
 ST.intStyleId='$styleID' 
AND 
ST.strBuyerPoNo='$buyerPoNo' 
AND
M.strMatDetailID =ST.intMatDetailId
AND
 materialRatioID='$matItemList' 
AND 
ST.strColor='$color' 
AND 
ST.strSize='$size' 
AND 
strType='GRN' 
AND 
strMainStoresID='$mainStore' 

Group By 
strMainStoresID, strSubStores, strLocation, strBin, intDocumentNo, intDocumentYear ";
		//echo $sqlgrn;
	$result_grn =$db->RunQuery($sqlgrn);		
		while ($row_grn = mysql_fetch_array($result_grn))
		{
?>
                      <tr  class="bcgcolor-tblrowWhite">
                        <td height="20" class="normalfnt"><?php echo $row_grn["MainStore"];?></td>
                        <td class="normalfnt"><?php echo $row_grn["SubStore"];?></td>
                        <td class="normalfnt"><?php echo $row_grn["Location"];?></td>
                        <td class="normalfnt"><?php echo $row_grn["Bins"];?></td>
                        <td class="normalfntMid"><?php echo $row_grn["strUnit"];?></td>
                        <td class="normalfntRite"><?php echo round($row_grn["StckBal"],2);?></td>
                        <td class="normalfntMid"><?php echo $row_grn["intDocumentYear"]."/". $row_grn["intDocumentNo"];?></td>
                        </tr>
<?php
		}
?>
                    </table>
                  </div></td>
                </tr>
                <tr>
                  <td height="25" class="mainHeading">Inter Job Transfers</td>
                </tr>
                <tr>
                  <td><div id="divInterJobTransfer" style="overflow:scroll; height:150px; width:846px;">
                    <table id="tblInterJobTransfer" width="1000" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                      <tr class="mainHeading4">
                        <td width="8%" height="20" >Job No </td>
                        <td width="10%">Style From</td>
                        <td width="6%" >SC From </td>
                        <td width="10%" >Style To</td>
                        <td width="6%" >SC To</td>
                        <td width="18%%" >Description</td>
                        <td width="6%%" >Qty</td>
                        <td width="6%" >Cancel Qty </td>
                        <td width="10%" >User</td>
                        <td width="7%" >Date</td>
                      </tr>
<?php
$sqljob="select intDocumentNo, intDocumentYear, ST.intStyleId AS fromStyle,
 (select intSRNO from specification SP where SP.intStyleId=ST.intStyleId)AS fromSCNO, 
(select strItemDescription from matitemlist MIL where MIL.intItemSerial=ST.intMatDetailId)AS ItemDescription, 
sum(ST.dblQty)AS StckBal, (select UA.Name from useraccounts UA where UA.intUserID=ST.intUser)AS UserName, date(dtmDate) AS dtmDate
 from stocktransactions ST,materialratio M where ST.intStyleId='$styleID'
AND ST.strBuyerPoNo='$buyerPoNo'
AND M.materialRatioID='$matItemList'
AND ST.strColor='$color'
AND ST.strSize='$size'
AND strType='IJTOUT'
AND ST.strMainStoresID='$mainStore'
Group By strMainStoresID,
strSubStores,
strLocation,
strBin,
intDocumentNo,
intDocumentYear,
ST.intStyleId";
$result_job =$db->RunQuery($sqljob);
	while($row_job=mysql_fetch_array($result_job))
	{
	
?>
                      <tr class="bcgcolor-tblrowWhite">
                        <td class="normalfnt" height="20"><?php echo $row_job["intDocumentYear"]."/".$row_job["intDocumentNo"];?></td>
                        <td class="normalfnt"><?php echo $row_job["fromStyle"];?></td>
                        <td class="normalfnt"><?php echo $row_job["fromSCNO"];?></td>
                        <td class="normalfnt">
<?php 
$sqltojob="select intStyleId AS toStyleID ,
(select intSRNO from specification SP where SP.intStyleId=ST.intStyleId)AS toSCNO
from stocktransactions ST
where intDocumentNo='".$row_job["intDocumentNo"]."'
AND intDocumentYear='".$row_job["intDocumentYear"]."'
AND strType='IJTIN'"; 

$result_to_job=$db->RunQuery($sqltojob);
while($row_to_job=mysql_fetch_array($result_to_job))
	{
		$toStyleID	= $row_to_job["toStyleID"];
		$toSCNO		= $row_to_job["toSCNO"];
	}
	echo $toStyleID;
?></td>

                        <td class="normalfnt"><?php echo $toSCNO;?></td>
                        <td class="normalfnt"><?php echo $row_job["ItemDescription"];?></td>
                        <td class="normalfntRite"><?php echo round($row_job["StckBal"]*-1,2);?></td>
                        <td class="normalfntMid">
<?php
 $sqlcanceljob="select sum(ST.dblQty) AS cancelQty
from 
stocktransactions ST,materialratio M 
where intDocumentNo='".$row_job["intDocumentNo"]."' 
AND intDocumentYear='".$row_job["intDocumentYear"]."'
AND strType='CIJTOUT'
AND ST.intStyleId='$styleID'
AND ST.strBuyerPoNo='$buyerPoNo'
AND
M.strMatDetailID =ST.intMatDetailId
AND
 materialRatioID='$matItemList' 
AND ST.strColor='$color'
AND ST.strSize='$size'
group by
ST.intStyleId,ST.strBuyerPoNo,intMatDetailId,ST.strColor,ST.strSize,strType,intDocumentNo,intDocumentYear";
$result_cancel_job=$db->RunQuery($sqlcanceljob);
$cancelQty= 0;
while($row_cancel_job=mysql_fetch_array($result_cancel_job))
{
	$cancelQty	= $row_cancel_job["cancelQty"];
}
echo round($cancelQty,2);
?></td>
                        <td class="normalfntMid"><?php echo $row_job["UserName"];?></td>
                        <td class="normalfntMid"><?php echo $row_job["dtmDate"];?></td>
                      </tr>
<?php
	}
?>
                    </table>
                  </div></td>
                </tr>
                <tr>
                  <td height="25" class="mainHeading">Location Transfers</td>
                </tr>
                <tr>
                  <td><div id="divLocationTransfer" style="overflow:scroll; height:150px; width:846px;">
                    <table id="tblLocationTransfer" width="825" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                      <tr class="mainHeading4">
                        <td width="78" height="20" >TransIn No</td>
                        <td width="108" >Gate Pass no</td>
                        <td width="171" >Description</td>
                        <td width="84" >GP Qty</td>
                        <td width="80" >Trans Qty</td>
                        <td width="86" >User</td>
                        <td width="86" >Main Store</td>
                        <td width="86" >Sub Store</td>
                        <td width="86" >Location</td>
                        <td width="86" >Bin</td>
                        <td width="86" >Bin Qty</td>
                      </tr>
                      <?php
$sqlti="select TIH.intTransferInNo,TIH.intTINYear,sum(TID.dblQty)AS TIQty, TIH.intGatePassNo,TIH.intGPYear,
 (select strItemDescription from matitemlist MIL where MIL.intItemSerial=TID.intMatDetailId)AS ItemDescription, UA.Name AS UserName 
from gategasstransferinheader TIH inner join gategasstransferindetails TID ON TIH.intTransferInNo=TID.intTransferInNo AND TIH.intTINYear=TID.intTINYear 
Inner Join useraccounts UA ON UA.intUserID=TIH.intUserid
Inner Join materialratio M ON M.strMatDetailID=TID.intMatDetailId where TID.intStyleId ='$styleID'
AND TID.strBuyerPONO='$buyerPoNo' AND materialRatioID='$matItemList '
AND TID.strColor='$color' AND TID.strSize='$size' AND TIH.intStatus=1  Group By intTransferInNo, intTINYear, intMatDetailId ";

$result_ti =$db->RunQuery($sqlti);
	while($row_ti=mysql_fetch_array($result_ti))
	{
?>
                      <tr class="bcgcolor-tblrowWhite">
                        <td class="normalfnt"><?php echo $row_ti["intTINYear"]."/".$row_ti["intTransferInNo"];?></td>
                        <td class="normalfnt"><?php echo $row_ti["intGPYear"]."/".$row_ti["intGatePassNo"]?></td>
                        <td class="normalfnt"><?php echo $row_ti["ItemDescription"];?></td>
                        <td class="normalfntRite"><?php
$sqlgpqty="select sum(GD.dblQty)AS GPQty
FROM
gatepassdetails AS GD
Inner Join gatepass AS GH ON GH.intGatePassNo = GD.intGatePassNo AND GH.intGPYear = GD.intGPYear
Inner Join materialratio ON GD.intMatDetailId = materialratio.strMatDetailID
where GD.intStyleId='$styleID'
AND GD.strBuyerPONO='$buyerPoNo'
AND materialRatioID=$matItemList
AND GD.strColor='$color'
AND GD.strSize='$size'
AND GH.intStatus=1
AND GH.intGatePassNo='".$row_ti["intGatePassNo"]."'
AND GH.intGPYear='".$row_ti["intGPYear"]."';";

$result_gpqty =$db->RunQuery($sqlgpqty);
	while($row_gpqty=mysql_fetch_array($result_gpqty))
		{
			$GPQty = $row_gpqty["GPQty"];
		}
		echo round($GPQty,2);
?></td>
                        <td class="normalfntRite"><?php echo round($row_ti["TIQty"],2);?></td>
                        <td class="normalfntMid"><?php echo $row_ti["UserName"];?></td>
                        <?php
$boocheck = false;
$sqltistock="select ST.strMainStoresID,
MS.strName,
ST.strSubStores,
SS.strSubStoresName,
ST.strLocation,
SL.strLocName,
ST.strBin,
SB.strBinName,
ST.dblQty
from 
stocktransactions ST
Inner Join mainstores MS On MS.strMainID=ST.strMainStoresID
Inner Join substores SS On SS.strMainID=ST.strMainStoresID and SS.strSubID=ST.strSubStores
Inner Join storeslocations SL On SL.strMainID=ST.strMainStoresID and SL.strSubID=ST.strSubStores AND SL.strLocID=ST.strLocation
Inner Join storesbins SB On SB.strMainID=ST.strMainStoresID and SB.strSubID=ST.strSubStores and SB.strLocID=ST.strLocation AND SB.strBinID=ST.strBin
Inner Join materialratio ON ST.intMatDetailId = materialratio.strMatDetailID
where ST.intStyleId='$styleID'
AND ST.strBuyerPoNo='$buyerPoNo'
AND materialratio.materialRatioID='$matItemList'
AND ST.strColor='$color'
AND ST.strSize='$size'
AND ST.intDocumentNo='".$row_ti["intTransferInNo"]."'
AND ST.intDocumentYear='".$row_ti["intTINYear"]."'
AND strType='TI'";
$result_ststock=$db->RunQuery($sqltistock);
	while($row_ststock=mysql_fetch_array($result_ststock))
	{

if($boocheck)
{
?>
                      </tr>
                      <tr class="bcgcolor-tblrowWhite">
                        <td class="normalfntMid">&nbsp;</td>
                        <td class="normalfntMid">&nbsp;</td>
                        <td class="normalfntMid">&nbsp;</td>
                        <td class="normalfntMid">&nbsp;</td>
                        <td class="normalfntMid">&nbsp;</td>
                        <td class="normalfntMid">&nbsp;</td>
                        <?php
}
$boocheck = true;
?>
                        <td class="normalfntMid"><?php echo $row_ststock["strName"];?></td>
                        <td class="normalfntMid"><?php echo $row_ststock["strSubStoresName"];?></td>
                        <td class="normalfntMid"><?php echo $row_ststock["strLocName"];?></td>
                        <td class="normalfntMid"><?php echo $row_ststock["strBinName"];?></td>
                        <td class="normalfntMid"><?php echo round($row_ststock["dblQty"],2);?></td>
                      </tr>
                      <?php
	}
	
?>
                      <?php
	}
?>
                    </table>
                  </div></td>
                </tr>
              </table></td>
            </tr>
            
          </table>
        </form></td>
        </tr>
    </table></td>
  </tr>
</table>