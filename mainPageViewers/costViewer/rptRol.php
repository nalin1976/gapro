<?php
	session_start();
	include "../../Connector.php";
	$companyId = $_SESSION["FactoryID"];
	$userid    = $_SESSION["UserID"];	
	$costCenter  = $_GET["CostCenter"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<title>ROL</title>
<style type="text/css">

</style>
</head>

<body>

<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="3" class="head2" >ORIT APPARELS LANKA (PVT)LTD.</td>
  </tr>
 </tr>
   <tr>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  
    <td colspan="3" class="tophead3"><div align="center" ><b>Materials Reorder Level Rrport as at <?php echo date("Y-m-d"); ?></b></div></td>
 </tr>  <tr>
    <td colspan="3"><div align="center" ><b><?php $sql="select strDescription from costcenters where intCostCenterId='$costCenter'";
	 $results_details=$db->RunQuery($sql);
	  while($row=mysql_fetch_array($results_details))
	  {
		$strDescription=$row["strDescription"];
	echo $strDescription;
	  }
		?>  </b></div></td>
  </tr>
  <tr><!--class="border-All-fntsize12"-->
   
    
  </tr>
   <tr>
     <td height="10" colspan="3" >&nbsp;</td>
   </tr>
   <tr>
    <td height="10" colspan="3" class="border-top">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
      
	  
	  
	  
    </table></td>
  </tr>
   <tr>
     <td colspan="3"><table width="100%" border="1" cellspacing="0" cellpadding="0">
     <thead>
       <tr>
        
         <td width="41%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Item Description</strong></div></td>
         <td width="30%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Reorder Level</strong></div></td>
         <td width="28%" class="border-top-bottom-left-fntsize12"><div align="center"><strong>Current Stock</strong></div></td>
         
       </tr>
       </thead>
       
        <?php
	  $Sql="SELECT
genitemwisereorderlevel.dblReorderLevel,
genmatitemlist.strItemDescription,
COALESCE(Sum(stocktransactions.dblQty),0) AS stockQty,
stocktransactions.dtmDate,
genitemwisereorderlevel.intMatDetailID,
genitemwisereorderlevel.intCostCenterId,
genmatitemlist.dblLastPrice,
costcenters.intFactoryId
FROM
genitemwisereorderlevel
INNER JOIN genmatitemlist ON genmatitemlist.intItemSerial = genitemwisereorderlevel.intMatDetailID
LEFT JOIN stocktransactions ON stocktransactions.intMatDetailId = genitemwisereorderlevel.intMatDetailID 
INNER JOIN costcenters ON genitemwisereorderlevel.intCostCenterId = costcenters.intCostCenterId
INNER JOIN usercompany ON costcenters.intFactoryId = usercompany.companyId
AND costcenters.intFactoryId = $companyId AND usercompany.userId = $userid";
        if($costCenter!=''){
            $Sql.= " AND genitemwisereorderlevel.intCostCenterId='$costCenter'";
        }
        $Sql.= " GROUP BY genitemwisereorderlevel.intMatDetailID";
					
	  $results_details=$db->RunQuery($Sql);
	  while($row=mysql_fetch_array($results_details))
	  {	
		?>
       <tr>
         <td class="border-left-fntsize12"><?php echo $row["strItemDescription"];?></td>
         <td class="border-left-fntsize12"><?php echo $row["dblReorderLevel"];?></td>
         <td class="border-left-fntsize12"><?php echo $row["stockQty"];?></td>
         
       </tr>
       
        
        
    
       
     
        <?php }	
		$previous =$current;
		$temp_cut =$c_cut;
		$tmpSize  =$size_break;
		$no_sizes++;
		$cut_tot+=$row["dblQty"];
		$size_qty+=$row["dblQty"];
			
		?>
       
      
       
       
     <br>
     </table></td>
   </tr>
   <tr>
    <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="1" class="normalfntMid">
      <tr>
        <td class="reportBottom"><table width="100%" border="0" cellpadding="0" cellspacing="1" class="normalfntMid">
          <tr height="10"></tr>
          <tr>
            <td width="25%" class="bcgl1txt1" height="25" colspan="2"><?php echo date("Y-m-d"); ?></td>
            
            <td width="25%" class="bcgl1txt1">&nbsp;</td>
            <td width="25%" class="bcgl1txt1">&nbsp;</td>
          </tr>
          <tr >
            <td class="reportBottom" colspan="2">Date</td>
            <td class="reportBottom">Signature of stockManager</td>
            <td class="reportBottom">Signature of stock keeper</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><div align="center"></div></td>
  </tr>
</table>
</body>
</html>
<?php
function GetColor($styleId)
{
global $db;
	$sql="select distinct strColor from styleratio where intStyleId='$styleId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strColor"];
	}
}
function GetDivision($styleId)
{
global $db;
	$sql="select distinct BD.strDivision from orders O inner join buyerdivisions BD on BD.intDivisionId=O.intDivisionId where O.intStyleId='$styleId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strDivision"];
	}
}

function GetMainFabric($styleId)
{
global $db;
	$sql="select distinct MIL.strItemDescription from matitemlist MIL inner join orderdetails OD on OD.intMatDetailID=MIL.intItemSerial where OD.intMainFabricStatus=1 and intStyleId=$styleId";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strItemDescription"];
	}
}

function getFacId($gp,$year){
global $db;
	$sql="SELECT DISTINCT productionwashreadyheader.intFactory
			FROM
			productionfggpheader
			INNER JOIN productionwashreadyheader ON productionwashreadyheader.intStyleId = productionfggpheader.intStyleId
			WHERE
			productionfggpheader.intGPnumber='$gp' AND
			productionfggpheader.intGPYear='$year';";
			//echo $sql;

	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["intFactory"];
}
function getWashReadyComapny($ComId)
{
global $db;
	$sql="select c.strCity from companies c where c.intCompanyID='$ComId'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strCity"];

}
function getUserName($userid)
{
global $db;
	$sql="select u.Name from useraccounts u where u.intUserID='$userid'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["Name"];

}
?>