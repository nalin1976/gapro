<?php
include "../Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CONSUMPTION REPORT</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1100" border="0" align="center">
  <tr>
    <td colspan="10"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="20%"><img src="../images/GaPro_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="6%" class="normalfnt">&nbsp;</td>
        <td width="74%" class="tophead"><p class="topheadBLACK"><?php
	
		/////////////////////////////////// FOR GET FACTORY DETAILS /////////////////////////////////////////////
		
/*			$strStyleId='019-475-0-99';//$_GET["styleid"];
			$matDetailId='6';//$_GET["matDetailId"];
			$strColor='FUEGO RED';//$_GET["color"];*/
			$strStyleId=$_GET["strStyleId"];
			$matDetailId=$_GET["matDetailId"];
			$strColor=$_GET["strColor"];
		
		$strSQL="SELECT
						companies.strName AS strName,
						companies.strAddress1 AS strAddress1,
						companies.strAddress2 AS strAddress2,
						companies.strStreet AS strStreet,
						companies.strCity AS strCity,
						companies.strCountry AS strCountry,
						companies.strPhone AS strPhone,
						companies.strEMail AS strEmail,
						companies.strFax AS strFax,
						companies.strWeb AS strWeb
						FROM
						cadconsumptionheader
						Inner Join useraccounts ON useraccounts.intUserID = cadconsumptionheader.strUserId ,
						companies
						WHERE
						cadconsumptionheader.intStyleId =  '$strStyleId' AND
						cadconsumptionheader.strColor =  '$strColor' AND
						cadconsumptionheader.intMatdetailId =  '$matDetailId'";



					$result = $db->RunQuery($strSQL);

		
		while($row = mysql_fetch_array($result))
		{		
						$strName			=$row["strName"];
						$strAddress1		=$row["strAddress1"];
						$strAddress2		=$row["strAddress2"];
						$strStreet			=$row["strStreet"];
						$strCity			=$row["strCity"];
						$strCountry			=$row["strCountry"];
						$strPhone			=$row["strPhone"];
						$strEmail			=$row["strEmail"];
						$strFax				=$row["strFax"];
						$strWeb				=$row["strWeb"];
						$dtDate				=$row["dtDate"];
						break;
		}
		
			echo $strName ?></p>
          <p class="normalfnt"><?PHP echo "$strAddress1 $strAddress2  $strStreet $strCity $strCountry . Tel: $strPhone  Fax: $strFax" ?> </p>
          <p class="normalfnt"><?php echo "E-Mail: $strEmail Web: $strWeb" ?></p></td>
      </tr>
    </table></td>
  </tr>
  <?php
  /////////////////////////////////// FOR GET HEADER DETAILS /////////////////////////////////////////////
				  $SQL1 = "SELECT distinct
				cadconsumptionheader.intStyleId,
				cadconsumptionheader.dblwidth,
				matitemlist.strItemDescription,
				cadconsumptionheader.strColor,
				cadconsumptionheader.dblQty,
				cadconsumptionheader.dblTotalQty,
				cadconsumptionheader.dtmDate,
				purchaseorderdetails.intPoNo,
				cadconsumptionheader.dblBudgetedPipingConsumption,
				cadconsumptionheader.dblBudgetedConPcs,
				cadconsumptionheader.dblFabricRecievedExpected,
				cadconsumptionheader.dblPipingConsumptionYrd,
				cadconsumptionheader.dblProductionConPcsPercentage,
				cadconsumptionheader.dblProductionConPcsYrd,
				cadconsumptionheader.dblCuttableQtyYrd
				
				FROM
				cadconsumptionheader
				Inner Join matitemlist ON matitemlist.intItemSerial = cadconsumptionheader.intMatdetailId
				Inner Join purchaseorderdetails ON purchaseorderdetails.intStyleId = cadconsumptionheader.intStyleId 
				AND purchaseorderdetails.intMatDetailID = cadconsumptionheader.intMatdetailId
				AND purchaseorderdetails.strColor = cadconsumptionheader.strColor
				WHERE
				cadconsumptionheader.intStyleId =  '$strStyleId' AND
				cadconsumptionheader.strColor =  '$strColor' AND
				cadconsumptionheader.intMatdetailId =  '$matDetailId'
				";
  					$result1 = $db->RunQuery($SQL1);

		
		while($row = mysql_fetch_array($result1))
		{		
						$strStyleId			=$row["strStyleId"];
						$dblwidth			=$row["dblwidth"];
						$strItemDescription	=$row["strItemDescription"];
						$strColor			=$row["strColor"];
						$dblQty				=$row["dblQty"];
						$dblTotalQty		=$row["dblTotalQty"];
						$dtmDate			=$row["dtmDate"];
						$intPoNo			=$row["intPoNo"];
						
						$dblBudgetedPipingConsumption	=$row["dblBudgetedPipingConsumption"];
						$dblBudgetedConPcs				=$row["dblBudgetedConPcs"];
						$dblFabricRecievedExpected		=$row["dblFabricRecievedExpected"];
						$dblPipingConsumptionYrd		=$row["dblPipingConsumptionYrd"];
						$dblProductionConPcsPercentage	=$row["dblProductionConPcsPercentage"];
						$dblProductionConPcsYrd			=$row["dblProductionConPcsYrd"];
						$dblCuttableQtyYrd				=$row["dblCuttableQtyYrd"];
						break;
		}
  
  ?>
  <tr>
    <td colspan="10"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="36" colspan="5" class="head2">CONSUMPTION REPORT </td>
      </tr>
      <tr>
        <td class="normalfnth2B">STYLE NO </td>
        <td class="normalfnt">: <?PHP echo $strStyleId; ?> </td>
        <td width="9%">&nbsp;</td>
        <td width="16%" class="normalfnth2B">QTY</td>
        <td width="27%" valign="top" class="normalfnt">: <?PHP echo $dblQty; ?></td>
      </tr>
      <tr>
        <td width="12%" class="normalfnth2B">WIDTH</td>
        <td width="36%" class="normalfnt">: <?PHP echo $dblwidth; ?> </td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">TOTAL QTY </td>
        <td width="27%" valign="top" class="normalfnt">: <?PHP echo $dblTotalQty; ?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">FABRIC</td>
        <td class="normalfnt">: <?PHP echo $strItemDescription; ?> </td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">DATE</td>
        <td width="27%" valign="top" class="normalfnt">: <?PHP echo substr($dtmDate,0,10); ?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">COLOR</td>
        <td class="normalfnt">: <?PHP echo $strColor; ?> </td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">PO NO </td>
        <td width="27%" valign="top" class="normalfnt">: <?PHP echo $intPoNo; ?></td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td colspan="10" class="normalfnth2B">&nbsp;</td>
  </tr>
 
  <tr>
    <td colspan="10"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
      <tr>
        <td width="97" height="25" class="normalfntBtab">MARKER NAME </td>
        <td width="66" class="normalfntBtab">COPY</td>
        <td width="66" class="normalfntBtab">LAYERS</td>
			   <?php
  /////////////////////////////////// FOR GET SIZE HEADER DETAILS /////////////////////////////////////////////
/*				$SQL3 = "SELECT DISTINCT
						cadconsumptionsizedetails.strSize
						FROM
						cadconsumptionsizedetails
						WHERE
						intStyleId =  '$strStyleId' AND
						strColor =  '$strColor' AND
						intMatdetailId =  '$matDetailId'";
						
  					$result3 = $db->RunQuery($SQL3);
					$count = mysql_num_rows($result3);
					$x = 50/(int)$count;
				while($row2 = mysql_fetch_array($result3))
				{		
					$strSize				= $row2["strSize"];
					$dblQty					= $row2["dblQty"];*/
					
					$SQL3="	SELECT 	strSize, dblQty FROM styleratio
					WHERE intStyleId = '$strStyleId' 
					AND strColor = '$strColor' order by strSize ";
					
    				$result3 = $db->RunQuery($SQL3);
					$count = mysql_num_rows($result3);
					$x = 50/(int)$count;
				$y=0;
				while($row2 = mysql_fetch_array($result3))
				{		
					$strSize				= $row2["strSize"];
					$dblQty					= $row2["dblQty"];
					$Tsize[++$y]=$dblQty;
  		 ?>
        <td width="<?php $x?>%" class="normalfntBtab"><?PHP echo "$strSize<br>($dblQty)"  ?></td>
		<?PHP 
		}
		?>
        <td width="86" class="normalfntBtab">MARKER LENGTH YRD </td>
        <td width="89" class="normalfntBtab">MARKER LENGTH INCH </td>
        <td width="49" class="normalfntBtab">EFF</td>
        <td width="93" class="normalfntBtab">TOTAL YRD </td>
      </tr>
	   <?php
  /////////////////////////////////// FOR GET MARKER DETAILS /////////////////////////////////////////////
				$SQL2 = "SELECT
						cadconsumptionmarkerdetails.strMarkerName,
						cadconsumptionmarkerdetails.dblCopy,
						cadconsumptionmarkerdetails.dblLayers,
						cadconsumptionmarkerdetails.dblMarKerLengthYrd,
						cadconsumptionmarkerdetails.dblMarKerLengthInch,
						cadconsumptionmarkerdetails.dblEFF,
						cadconsumptionmarkerdetails.dblTotalYrd
						FROM cadconsumptionmarkerdetails
						WHERE
						intStyleId =  '$strStyleId' AND
						strColor =  '$strColor' AND
						intMatdetailId =  '$matDetailId'";
						
  					$result2 = $db->RunQuery($SQL2);

		
				while($row2 = mysql_fetch_array($result2))
				{		
					$strMarkerName			= $row2["strMarkerName"];
					$dblCopy				= $row2["dblCopy"];
					$dblLayers				= $row2["dblLayers"];
					$dblMarKerLengthYrd		= $row2["dblMarKerLengthYrd"];
					$dblMarKerLengthInch	= $row2["dblMarKerLengthInch"];
					$dblEFF					= $row2["dblEFF"];
					$dblTotalYrd			= $row2["dblTotalYrd"];
				
  
  ?>
      <tr>
        <td class="normalfntTAB"><?php echo $strMarkerName; ?></td>
        <td class="normalfntTAB"><?php echo $dblCopy; ?></td>
        <td class="normalfntMidTAB"><?php echo $dblLayers; ?></td>
		
			<?php
  			/////////////////////////////////// FOR GET SIZE HEADER DETAILS /////////////////////////////////////////////
				$SQL4 = "SELECT 
						cadconsumptionsizedetails.dblQty
						FROM
						cadconsumptionsizedetails
						WHERE
						intStyleId =  '$strStyleId' AND
						strColor =  '$strColor' AND
						intMatdetailId =  '$matDetailId' AND
						strMarkerName =  '$strMarkerName' order by strSize";
						
  					$result4 = $db->RunQuery($SQL4);
					$sizeCount = mysql_num_rows($result4);
					//$x = 50/(int)$count;
				$A_dblQty=0;
				$x=0;
				while($row4 = mysql_fetch_array($result4))
				{		
					$dblQty					= $row4["dblQty"];
  					$Size[++$x] += $dblQty*$dblLayers;
 			 ?>
			 
        <td class="normalfntMidTAB"><?PHP echo $dblQty; ?></td>
		
		
					<?PHP 
					
					}
					
					?>
        <td class="normalfntMidTAB"><?php echo $dblMarKerLengthYrd; ?></td>
        <td class="normalfntMidTAB"><?php echo $dblMarKerLengthInch; ?></td>
        <td class="normalfntMidTAB"><?php echo $dblEFF; ?></td>
        <td class="normalfntRiteTAB"><?php echo $dblTotalYrd; ?></td>
      </tr>
  <?PHP 
  
  	}
  
  ?>
      <tr>
        <td class="normalfntBtab" height="25">TOTAL</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
		<?php 
			for($i=1;$i<=count($Size);$i++)
			{
		?>
        <td class="normalfntBtab"><?php echo $Size[$i]; ?></td>
		<?php 
		}
		?>
		
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">3000.00</td>
      </tr>
      <tr>
        <td class="normalfntBtab">VARIATION</td>
        <td class="normalfntBtab" height="25">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
		<?php 
			for($i=1;$i<=count($Tsize);$i++)
			{
		?>
        <td class="normalfntBtab"><?php echo ($Size[$i]-$Tsize[$i]); ?></td>
		<?php 
		}
		?>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">3000.00</td>
      </tr>
    </table></td>
  </tr>

  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  
  <tr><td><table class="bcgl1">
    <tr>
    <td width="249" class="normalfnt">BUDGETED PIPING CONSUMPTION (YRD) </td>
    <td width="13" class="normalfnt">:</td>
    <td width="134" class="normalfnt"><?php echo $row["dblBudgetedPipingConsumption"];  ?></td>
    <td width="87" class="normalfnt">&nbsp;</td>
    <td colspan="3" class="normalfnt">PIPING CONSUMPTION (YRD) </td>
    <td width="24" class="normalfnt">:</td>
    <td width="205" class="normalfnt">&nbsp;</td>
    <td width="68" class="normalfnt">&nbsp;</td>
  </tr>
      <tr>
    <td class="normalfnt">BUDGETED CON/PCS (YRD) </td>
    <td class="normalfnt">:</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td width="185" class="normalfnt">PRODUCTION CON/PCS WITH </td>
    <td width="38" class="normalfnt">&nbsp;</td>
    <td width="55" class="normalfnt">% (YRD) </td>
    <td class="normalfnt">:</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
  </tr>
      <tr>
    <td class="normalfnt">FABRIC RECIEVED - EXPECTED </td>
    <td class="normalfnt">:</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
    <td colspan="3" class="normalfnt">CUTTABLE QTY (YR) </td>
    <td class="normalfnt">:</td>
    <td class="normalfnt">&nbsp;</td>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  </table>
  </td>
  </tr>
  <tr>
    <td colspan="10" class="normalfnBLD1">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="10"><table width="100%" border="0">
      <tr>
        <td width="8%" class="normalfnt">&nbsp;</td>
        <td width="19%" class="bcgl1txt1">&nbsp;</td>
        <td width="5%">&nbsp;</td>
        <td width="39%" class="bcgl1txt1">&nbsp;</td>
        <td width="4%">&nbsp;</td>
        <td width="16%" class="bcgl1txt1">&nbsp;</td>
        <td width="9%">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnth2Bm" >PREPARED BY</td>
        <td>&nbsp;</td>
        <td class="normalfnth2Bm">(Q/C AND CUTTING INCHARGE APPROVAL PATTERNS &amp; PARTS ) </td>
        <td>&nbsp;</td>
        <td class="normalfnth2Bm" >CHECKED BY</td>
        <td>&nbsp;</td>
      </tr>

    </table></td>
  </tr>
</table>
</body>
</html>
