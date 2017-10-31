<?php 
	session_start();
 $backwardseperator = "../";
 
// $mainId = $_GET["mainId"];
 $tbl        = $_GET["tbl"];
 $matId	     = $_GET["matId"];
 $fromVal    = $_GET['fromVal'];
 $toVal      = $_GET['toVal'];
 $toDate     = $_GET['toDate'];
 $mainStores = $_GET['mainStores'];
 $color  	 = $_GET['color'];
 $size		 = $_GET['size'];
 
 $report_companyId =$_SESSION["FactoryID"];
 
 $deci = 2; //no of decimal places
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Age Analysis Report</title>
<link href="../css/erpstyle.css" type="text/css" rel="stylesheet" />
</head>

<body>
<?php 
include "../Connector.php";

?>
<table width="1050" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><table width="1050" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include $backwardseperator.'reportHeader.php'; ?></td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <?php
	  	$sqlItem = "select mil.strItemDescription 
from matitemlist mil
WHERE mil.intItemSerial = $matId";
		$resItem = $db->RunQuery($sqlItem);
		$rowItem = mysql_fetch_array($resItem);
	  ?>
      
      <tr>
        <td class="head2BLCK"><?php echo $rowItem['strItemDescription']; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
      <?php
		
		//echo $sql;
        ?>
        <td><table width="1050" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
          <tr bgcolor="#CCCCCC" class="normalfntMid">
            <th width="223"  height="23" >Transaction Type </th>
            <th width="172" >Document No</th>
            <th width="139" >Document Year</th>
            <th width="105" >Qty</th>
            <th width="126" >GRN No</th>
            <th width="138" >GRN Date</th>
            <th width="125" >Year</th>
            </tr>
        <?php 
		$totQty = 0;
			$sql = "select 
					st.dblQty,
					st.strType,
					st.intDocumentNo,
					st.intDocumentYear,
					st.intGrnNo,
					st.intGrnYear,
					gh.dtRecdDate
					from $tbl st inner join grnheader gh on gh.intGrnNo=st.intGrnNo 
		 			and gh.intGRNYear = st.intGrnYear
					where st.intMatDetailId=$matId   and st.strGRNType='S' ";
		if($fromVal == '120')
			$sql .= " and 	(TO_DAYS('$toDate')-TO_DAYS(dtmConfirmedDate) >  $fromVal )";
		else
			$sql .= " and 	(TO_DAYS('$toDate')-TO_DAYS(dtmConfirmedDate) between $fromVal and $toVal )";
			//echo $sql;
		if($tbl == 'stocktransactions_temp')
			$sql .= " and gh.intStatus =1 and st.strType = 'GRN' ";
                
               // echo $sql;
                
			$resultDetail = $db->RunQuery($sql);
		//echo $sql;	
			while($row_det = mysql_fetch_array($resultDetail))
			{
				if($row_det['strType']=='BAlloIn')
					$type = 'Bulk Allocation In';
				else if($row_det['strType']=='ISSUE')
					$type = 'Issue';
				else if($row_det['strType']=='Leftover')
					$type = 'Left Over';
				else if($row_det['strType']=='SRTS')
					$type = 'Stock Return To Store';
				else if($row_det['strType']=='CLeftover')
					$type = 'CLeftover';
					
					$totQty +=  $row_det['dblQty'];
                                        
                                        
                                        
		?>
          <tr bgcolor="#FFFFFF">
            <td class="normalfntMid" nowrap="nowrap" height="20"><?php echo $type; ?></td>
            <td class="normalfntMid" nowrap="nowrap"><?php echo $row_det['intDocumentNo']; ?></td>
            <td class="normalfntMid"><?php echo $row_det['intDocumentYear']; ?></td>
            <td class="normalfntRite"><?php echo $row_det['dblQty']; ?></td>
            <td class="normalfntMid"><?php echo $row_det['intGrnNo']; ?></td>
            <td class="normalfntMid"><?php echo $row_det['dtRecdDate']; ?></td>
            <td class="normalfntMid"><?php echo $row_det['intGrnYear']; ?></td>
          </tr>
          <?php
			}
			
			$sql = "select 
				st.dblQty,
				st.strType,
				st.intDocumentNo,
				st.intDocumentYear,
				st.intGrnNo,
				st.intGrnYear,
				gh.dtRecdDate
				FROM
				$tbl AS st
				INNER JOIN bulkgrnheader AS gh ON gh.intBulkGrnNo = st.intGrnNo AND gh.intYear = st.intGrnYear
				INNER JOIN bulkpurchaseorderheader ON gh.intBulkPoNo = bulkpurchaseorderheader.intBulkPoNo AND gh.intBulkPoYear = bulkpurchaseorderheader.intYear
				where st.intMatDetailId=$matId  and bulkpurchaseorderheader.strBulkPOType!='1'  and st.strGRNType='B' ";
	if($fromVal == '120')
			$sql .= " and (TO_DAYS('$toDate')-TO_DAYS(gh.dtmConfirmedDate) > $fromVal  )";
		else
			$sql .= " and (TO_DAYS('$toDate')-TO_DAYS(gh.dtmConfirmedDate) between $fromVal and $toVal )";
			
	if($mainStores != '')
		$sql .= " and  st.strMainStoresID='$mainStores' ";
	if($color != '')
		$sql .= " and  st.strColor='$color' ";	
	if($size != '')
		$sql .= " and  st.strSize='$size' ";
        

		
		$resultDetail = $db->RunQuery($sql);	
            while($row_det = mysql_fetch_array($resultDetail))
			{
				if($row_det['strType']=='BAlloIn')
					$type = 'Bulk Allocation In';
				else if($row_det['strType']=='ISSUE')
					$type = 'Issue';
				else if($row_det['strType']=='Leftover')
					$type = 'Left Over';
				else if($row_det['strType']=='SRTS')
					$type = 'Stock Return To Store';
				else if($row_det['strType']=='CLeftover')
					$type = 'CLeftover';
					
				$totQty +=  $row_det['dblQty'];
		?>
          <tr bgcolor="#FFFFFF">
            <td class="normalfntMid" nowrap="nowrap" height="20"><?php echo $type; ?></td>
            <td class="normalfntMid" nowrap="nowrap"><?php echo $row_det['intDocumentNo']; ?></td>
            <td class="normalfntMid"><?php echo $row_det['intDocumentYear']; ?></td>
            <td class="normalfntRite"><?php echo $row_det['dblQty']; ?></td>
            <td class="normalfntMid"><?php echo $row_det['intGrnNo']; ?></td>
            <td class="normalfntMid"><?php echo $row_det['dtRecdDate']; ?></td>
            <td class="normalfntMid"><?php echo $row_det['intGrnYear']; ?></td>
          </tr>
         
          <?php
			}
            ?>
             <tr bgcolor="#CCCCCC" class="normalfntMid">
            <td height="20" colspan="3" nowrap="nowrap"><b>Total</b></td>
            <td class="normalfntRite"><b><?php echo $totQty; ?></b></td>
            <td class="normalfntMid">&nbsp;</td>
            <td class="normalfntMid">&nbsp;</td>
            <td class="normalfntMid">&nbsp;</td>
          </tr>
          </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>

</body>
</html>
