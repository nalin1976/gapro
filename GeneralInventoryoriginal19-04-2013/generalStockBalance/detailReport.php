<?php
 session_start();
 $backwardseperator = "../../";
include "../../Connector.php";
$report_companyId = $_SESSION["FactoryID"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>General Stock Balance-Detail Report</title>
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
<table width="900" border="0" align="center" cellpadding="0">
  <tr>
    <td width="100%" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%"><?php include "../../reportHeader.php";?></td>

              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="5">
	<table width="100%" border="0" align="center">
	<tr>
	<td align='center'><b><font  style="font-size: 15px;">General Stock Balance-Detail Report</font></b></td></tr></table></td>
  </tr>
  <tr>
    <td colspan="5" align="center"><table width="100%" border="1" cellpadding="3" cellspacing="0" rules="all">

	   <?php

 $cboMainCat = $_GET['cboMainCat']; 
 $cboSubCat  = $_GET['cboSubCat']; 
 $cboMatItem = $_GET['cboMatItem']; 
 $cboCompany = $_GET['cboCompany'];
 $bal        = $_GET['bal']; 
  
      $sql2 = "SELECT
genmatmaincategory.strDescription,
genmatsubcategory.StrCatName,
genmatitemlist.strItemDescription,
genstocktransactions.intMatDetailId,
genstocktransactions.dblQty,
genstocktransactions.strType,
companies.strName, 
genstocktransactions.dtmDate, 
genstocktransactions.intYear, 
genstocktransactions.intDocumentNo  
FROM genmatmaincategory
 Left Join genmatsubcategory ON genmatmaincategory.intID = genmatsubcategory.intCatNo 
Left Join genmatitemlist ON genmatitemlist.intMainCatID = genmatmaincategory.intID AND genmatitemlist.intSubCatID = genmatsubcategory.intSubCatNo 
Left Join genstocktransactions ON genmatitemlist.intItemSerial = genstocktransactions.intMatDetailId 
left Join companies ON genstocktransactions.strMainStoresID = companies.intCompanyID 

where genstocktransactions.dblQty<>0 ";

	 if($cboMainCat != ""){		
	 $sql2 .= " and genmatmaincategory.intID = '$cboMainCat'";		
	 }	
	 if($cboSubCat != ""){		
	 $sql2 .= " and genmatsubcategory.intSubCatNo = '$cboSubCat'";		
	 }	
	 if($cboCompany != ""){		
	 $sql2 .= " and genstocktransactions.strMainStoresID = '$cboCompany'";		
	 }	
	 if($cboMatItem != ""){		
	 $sql2 .= " and genmatitemlist.intItemSerial = '$cboMatItem'";		
	 }	
	 
	$sql2 .= " ORDER BY
genmatmaincategory.strDescription ASC,
genmatsubcategory.StrCatName ASC,
genmatitemlist.strItemDescription ASC,
genstocktransactions.dtmDate ASC,
genstocktransactions.strType ASC;
";	
			
				
  	     
 // echo "3$sql2<br>"; 
  $result2 = $db->RunQuery($sql2);
  
  if(mysql_num_rows($result2))
  {

		$mainCat="";
		$subCat="";
		$itemTmp="";
		$rows=0;
			while($row = mysql_fetch_array($result2))
			{
			if($row["strType"]=='GRN'){
			$transaction="GRN";
			$reportPath = "../GeneralGRN/Details/gengrnReport.php?grnno=".$row["intYear"]."/".$row["intDocumentNo"];
			}
			else if($row["strType"]=='ISSUE'){
			$transaction="ISSUE";
			$reportPath = "../GeneralIssue/genissuenote.php?issueNo=".$row["intYear"]."/".$row["intDocumentNo"];
			}
			else if($row["strType"]=='RSTO'){
			$transaction="Returned to store at ".$row["strName"];
			$reportPath = "../GeneralReturn/genreturnnote.php?issueNo=".$row["intYear"]."/".$row["intDocumentNo"];
			}
			else if($row["strType"]=='RSUP'){
			$transaction="Returned to supplier";
			$reportPath = "../GeneralSupplierReturn/gensupreturnnote.php?issueNo=".$row["intYear"]."/".$row["intDocumentNo"];
			}
			else if($row["strType"]=='GPF'){
			$transaction="Gate Passed from ".$row["strName"];
			$reportPath = "../GeneralGatePass/generalgatepassreport.php?gatePassNo=".$row["intYear"]."/".$row["intDocumentNo"];
			}
			else if($row["strType"]=='GPT'){
			$transaction="Gate Passed to ".$row["strName"];
			$reportPath = "../GeneralGatePass/generalgatepassreport.php?gatePassNo=".$row["intYear"]."/".$row["intDocumentNo"];
			}
			
			$qty= $row["dblQty"]; 
			 $sum += $qty;
		
		if($mainCat!=$row["strDescription"]){
		?>
	<tr>	
     <td colspan='4' class='normalfnt'><b><?php echo "Main Category : ".$row["strDescription"];?></td>;
	</tr>	
		<?php
		$mainCat=$row["strDescription"];
		 }
		if($itemTmp!=$row["intMatDetailId"]){
		 $rows++;
		if($rows!=1){
				//--------------

		?>
        <tr onMouseover="this.bgColor='#CECEFF'" onMouseout="this.bgColor='#FFFFFF'"> 
          <td class="normalfntRite"></td>
          <td class="normalfntRite"></td>
          <td class="normalfntRite" >Total Qty</td>
          <td class="normalfntRite" bgcolor="#EFEFEF"><?php echo  $sum-$row["dblQty"]; ?></td>
        </tr>
		</table></td></tr>
		
		<?php
		$sum=$row["dblQty"];
		}
		?>
		
        <tr bgcolor="#CCCCCC"> 
          <td class="normalfntTAB" width="10%" ><?php echo  $rows; ?></td>
          <td class="normalfntMidTAB" width="20%" ><?php echo  "Sub Category - ".$row["StrCatName"]; ?></td>
          <td class="normalfntMidTAB" width="60%" ><?php echo  "Item Description - ".$row["strItemDescription"]; ?></td>
          <td class="normalfntMidTAB" width="10%" ></td>
        </tr>
		<?php
	//-----------confirmed pos which r relevent to the material-----------	
			  $sql3 = "SELECT
		pd.dblQty ,suppliers.strTitle,pd.intGenPONo,pd.intYear 
		from generalpurchaseorderdetails as pd 
		inner join generalpurchaseorderheader as ph on ph.intGenPONo=pd.intGenPONo and ph.intYear=pd.intYear 
		inner join suppliers on ph.intSupplierID=suppliers.strSupplierID  
		where intMatDetailID='".$row["intMatDetailId"]."' and ph.intStatus='1'";
		  $result3 = $db->RunQuery($sql3);?>
  			<tr><td colspan="4"><table width="100%" border='1' cellpadding="3" cellspacing="0" rules="all">
			        <tr bgcolor="#E6E6E6"> 
          <td class="normalfntMidTAB" width="10%" > </td>
          <td class="normalfntMidTAB" width="20%" >Document No</td>
          <td class="normalfntMidTAB" width="60%" >Transaction</td>
          <td class="normalfntMidTAB" width="10%">Qty</td>
        </tr>

			
			<?php
			while($rowP = mysql_fetch_array($result3))
			{
			$reportPath1 = "../GeneralPO/generalPurchaeOrderReport.php?bulkPoNo=".$rowP["intGenPONo"]."&intYear=".$rowP["intYear"];
			?>
        <tr onMouseover="this.bgColor='#CECEFF'" onMouseout="this.bgColor='#FFFFFF'"> 
          <td class="normalfntRite"></td>
          <td class="normalfntMid"><a target="_blank" href="<?php echo $reportPath1; ?> " width="13%"><?php echo $rowP["intYear"]."/".$rowP["intGenPONo"]; ?></a></td>
          <td align="left" class="normalfnt" ><?php echo  "Purchase Order from ".$rowP["strTitle"]; ?></td>
          <td class="normalfntRite"><?php echo  $rowP["dblQty"]; ?></td>
        </tr>
			<?php 
			}
		//-----------------------
		
		
		
		}
		
		
		?>
		
		<?php
		$itemTmp=$row["intMatDetailId"];
		$stQty=$row["dblQty"];
		if($stQty<0) 
		$stQty=$stQty*(-1);
		?>
        <tr onMouseover="this.bgColor='#CECEFF'" onMouseout="this.bgColor='#FFFFFF'"> 
          <td class="normalfntRite"></td>
          <td class="normalfntMid"><a target="_blank" href="<?php echo $reportPath; ?> " width="13%"><?php echo $row["intYear"]."/".$row["intDocumentNo"]; ?></a></td>
          <td align="left" class="normalfnt"><?php echo  $transaction; ?></td>
          <td class="normalfntRite"><?php echo  $stQty; ?></td>
        </tr>
		<?php
			}
			?>
			
        <tr onMouseover="this.bgColor='#CECEFF'" onMouseout="this.bgColor='#FFFFFF'"> 
          <td class="normalfntRite"></td>
          <td class="normalfntRite"></td>
          <td class="normalfntMidTAB">Total Qty</td>
          <td class="normalfntRite" bgcolor="#EFEFEF"><?php echo  $sum-$row["dblQty"]; ?></td>
        </tr>
  </table></td></tr>
<?php  }
?>
					
    </table></td>
  </tr>
  </table> 
</body>
</html>
