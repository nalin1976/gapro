<?php
$backwardseperator = "../../";
session_start();

$styleNo = $_GET['styleNo'];
$cboStyles = $_GET['cboStyles'];
$order = $_GET['order'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Report - Thread Consumption</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<?php include "../../Connector.php"; ?>
</head>
<body>
<?php


?>

<table align="center" width="780">
	<thead>
		<tr>
        <td width="25%"><img src="../../images/logo.jpg" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="1%" class="normalfnt">&nbsp;</td>
        <td width="74%" style="font-family: Arial;	font-size: 16pt;	color: #000000;font-weight: bold;"  ><?php
		
		$totMeters=array();	
		$SQL_alldetails="SELECT * FROM 
						companies
						Inner Join useraccounts ON companies.intCompanyID = useraccounts.intCompanyID
						WHERE
						useraccounts.intUserID =  '".$_SESSION["UserID"]."'";
		

$factorArray=array();
$result_alldetails = $db->RunQuery($SQL_alldetails);

		
		while($row = mysql_fetch_array($result_alldetails))
		{		
		$intGrnNo=$row["intGrnNo"];
		$intGRNYear=$row["intGRNYear"];
		$intGRNYearnew= substr($intGRNYear, -2);
		$strInvoiceNo=$row["strInvoiceNo"];
		$strSupAdviceNo=$row["strSupAdviceNo"];
		$dtmAdviceDate=$row["dtmAdviceDate"];
		$dtmAdviceDateNew= substr($dtmAdviceDate,-19,10);
		$dtmAdviceDateNewDate= substr($dtmAdviceDateNew,-2);
		$dtmAdviceDateNewYear=substr($dtmAdviceDateNew,-10,4);
		$dtmAdviceDateNewmonth1=substr($dtmAdviceDateNew,-5);
		$dtmAdviceDateNewMonth=substr($dtmAdviceDateNewmonth1,-5,2);
		$strBatchNO=$row["strBatchNO"];
		$dtmConfirmedDate=$row["dtmConfirmedDate"];
		$dtmConfirmedDateNew= substr($dtmConfirmedDate,-19,10);
		$dtmConfirmedDateNewDate= substr($dtmConfirmedDateNew,-2);
		$dtmConfirmedDateNewYear=substr($dtmConfirmedDateNew,-10,4);
		$dtmConfirmedDateNewmonth1=substr($dtmConfirmedDateNew,-5);
		$dtmConfirmedDateNewMonth=substr($dtmConfirmedDateNewmonth1,-5,2);
		$strName=$row["strName"];
		$comAddress1=$row["strAddress1"];
		$comAddress2=$row["strAddress2"];
		$comStreet=$row["strStreet"];
		$comCity=$row["strCity"];
		$comCountry=$row["strCountry"];
		$comZipCode=$row["strZipCode"];
		$strPhone=$row["strPhone"];
		$comEMail=$row["strEMail"];
		$comFax=$row["strFax"];
		$comWeb=$row["strWeb"];
		$strTitle=$row["strTitle"];
		$strAddress1=$row["strAddress1"];
		$strAddress2=$row["strAddress2"];
		$strStreet=$row["strStreet"];
		$strCity=$row["strCity"];
		$strCountry=$row["strCountry"];
		$ConfirmedPerson=$row["ConfirmedPerson"];
		$ShippingMode=$row["ShippingMode"];
		$ShippingTerm=$row["ShippingTerm"];
		$PmntMode=$row["PmntMode"];
		$PmntTerm=$row["PmntTerm"];
		$dtmDeliveryDate=$row["dtmDeliveryDate"];
		$dtmDeliveryDateNew= substr($dtmDeliveryDate,-19,10);
		$dtmDeliveryDateNewDate= substr($dtmDeliveryDateNew,-2);
		$dtmDeliveryDateNewYear=substr($dtmDeliveryDateNew,-10,4);
		$dtmDeliveryDateNewmonth1=substr($dtmDeliveryDateNew,-5);
		$dtmDeliveryDateNewmonth=substr($dtmDeliveryDateNewmonth1,-5,2);
		$intPONo=$row["intPONo"];
		$intYear=$row["intYear"];
		$intYearnew= substr($intYear,-2);
		$strPINO=$row["strPINO"];
		$preparedperson=$row["preparedperson"];
		$grnStatus = $row["grnStatus"];
		$dtmRecievedDate = $row["dtmRecievedDate"];
		$merchandiser=$row["merchandiser"];
		}
		?>
<?php echo $strName; ?>
<p class="normalfntMid">
		  <?php echo $comAddress1." ".$comAddress2." ".$comStreet."<br>".$comCity." ".$comCountry.".<br>"."Tel:".$comPhone." ".$comZipCode." Fax: ".$comFax."<br> E-Mail: ".$comEMail." Web: ".$comWeb;?></p>		  </td>
      </tr>
      
      
	</thead>
</table>
<hr class="hrline"/>
<table align="center" width="739">
	<thead>
		<tr>
			<td width="84" class="normalfntb">Style Name :</td>
			<td width="181" class="normalfnt"><?php echo $cboStyles; ?></td>
			
			<td width="98" class="normalfntb">Order No :</td>
			<td width="215" class="normalfnt"><?php echo $order; ?></td>

			<td width="79" class="normalfntb">Date :</td>
			<td width="54" class="normalfnt"><?php echo date("Y-m-d"); ?></td>

			
		</tr>
	</thead>
</table>
<br />

<?php
$SQL="SELECT DISTINCT strMachineCode, intMachineTypeId   
	FROM ws_machinetypes where intStatus=1";

$result =$db->RunQuery($SQL);
$cells=0;
while ($row=mysql_fetch_array($result))
{
$cells++;
}

$width=360/$cells;
?>

<table align="center" style='table-layout:fixed' width="40" border="1" cellspacing="1" class="helaworkstudyTable">
	<caption class="table_headers">Thread Consumption Report<br /></caption>
    
    <thead>
    
		<tr class="bgColor">
			<td width="321" class="normalfntb">Operation Description</td>
			<?php
/*		$SQL="	SELECT intID   
				FROM ws_stitchtype  ";*/

			
			
/*		$SQL="	SELECT DISTINCT strMachineCode, intMachineTypeId   
				FROM ws_machinetypes where intStatus=1 order by intMachineTypeId asc";*/
				$SQL = "SELECT DISTINCT
				ws_machinetypes.strMachineCode,
				ws_machinetypes.intMachineTypeId AS M_mtype
				FROM
				ws_machinetypes
				Inner Join ws_threaddetails_combination ON ws_machinetypes.intMachineTypeId =                 							                ws_threaddetails_combination.strMachineTypeId
				WHERE
				ws_machinetypes.intStatus =  1 AND
				ws_threaddetails_combination.strStyleId =  '$styleNo'
				ORDER BY
				M_mtype ASC
				";
			$result =$db->RunQuery($SQL);
			while ($row=mysql_fetch_array($result))
			{
				
				$SQL_col = "SELECT DISTINCT
				ws_stitchtype.intID,
				ws_stitchtype.strStitchType
				FROM
				ws_stitchtype
				Inner Join ws_threaddetails_combination ON ws_stitchtype.intID = ws_threaddetails_combination.strStitchType
				Inner Join ws_machinetypes ON ws_machinetypes.intMachineTypeId = ws_threaddetails_combination.strMachineTypeId
				WHERE
				ws_threaddetails_combination.strStyleId =  '$styleNo' AND
				ws_machinetypes.intMachineTypeId =  '".$row["M_mtype"]."'
				order by  intID asc";
			
			$result_col =$db->RunQuery($SQL_col);
			$colspan=0;
			while ($row_col=mysql_fetch_array($result_col))
			{
			 	$colspan++;
			}
				
				
				
			?>
			<td class="normalfntb" width="160" id="<?php $row["intMachineTypeId"] ?>" colspan="<?php echo $colspan ?>"><?php echo $row["strMachineCode"] ?></td>
			<?php
			}
			?>
			
			
		</tr>
		<tr class="bgColor">
			<td  class="normalfnt"></td>
		<?php
/*		$SQL1="	SELECT DISTINCT strMachineCode, intMachineTypeId   
				FROM ws_machinetypes where intStatus=1 order by intMachineTypeId asc";*/
				$SQL1 = "SELECT DISTINCT
				ws_machinetypes.strMachineCode,
				ws_machinetypes.intMachineTypeId AS M_mtype
				FROM
				ws_machinetypes
				Inner Join ws_threaddetails_combination ON ws_machinetypes.intMachineTypeId = ws_threaddetails_combination.strMachineTypeId
				WHERE
				ws_machinetypes.intStatus =  1 AND
				ws_threaddetails_combination.strStyleId =  '$styleNo'
				ORDER BY
				M_mtype ASC";
			$result1 =$db->RunQuery($SQL1);
			while ($row1=mysql_fetch_array($result1))
			{
/*		$SQL="	SELECT intID, strStitchType   
				FROM ws_stitchtype order by  intID asc ";*/
			$SQL = "SELECT DISTINCT
				ws_stitchtype.intID,
				ws_stitchtype.strStitchType
				FROM
				ws_stitchtype
				Inner Join ws_threaddetails_combination ON ws_stitchtype.intID = ws_threaddetails_combination.strStitchType
				Inner Join ws_machinetypes ON ws_machinetypes.intMachineTypeId = ws_threaddetails_combination.strMachineTypeId
				WHERE
				ws_threaddetails_combination.strStyleId =  '$styleNo' AND
				ws_machinetypes.intMachineTypeId =  '".$row1["M_mtype"]."'";
			$result =$db->RunQuery($SQL);
			while ($row=mysql_fetch_array($result))
			{
			?>
			  <td class="normalfnt"><?php echo $row["strStitchType"] ?></td>
              
             <?php
			 
			    $sqlName = "SELECT
							ws_threaddetails_combination.intFactorNameID
							FROM
							ws_threaddetails_combination
							WHERE
							ws_threaddetails_combination.strStyleId =  '$styleNo' AND
							ws_threaddetails_combination.strStitchType =  '".$row["intID"]."' AND
							ws_threaddetails_combination.strMachineTypeId =  '".$row1["M_mtype"]."'";
							
				$resultNAME = $db->RunQuery($sqlName);
				$rowNAME    = mysql_fetch_array($resultNAME);
										 
		 $SQLee= "SELECT
				ws_machinefactors.dblFactor
				FROM
				ws_machinefactors
				WHERE ws_machinefactors.intMachineTypeId=".$row1["M_mtype"]." AND ws_machinefactors.intStitchTypeId=".$row["intID"]."
				AND ws_machinefactors.intFactorNameID = '". $rowNAME["intFactorNameID"] ."' 
				ORDER BY
				ws_machinefactors.intMachineTypeId ASC,
				ws_machinefactors.intStitchTypeId ASC";
		
			$resultee =$db->RunQuery($SQLee);
			
			while ($rowee=mysql_fetch_array($resultee))
			{
			 
			  	$cnt = count($factorArray);
				$factorArray[$cnt]=$rowee["dblFactor"];
				//echo $cnt;
			
				
			
			}
			?>		
			<?php
			}
			}
			
		?>
		</tr>
	</thead>
	<tbody>
	
		<?php
  $SQLOP="SELECT DISTINCT
ws_threaddetails_combination.strOperationId,
ws_operations.strOperationName
FROM
ws_threaddetails_combination
Inner Join ws_operations ON ws_threaddetails_combination.strOperationId = ws_operations.intId
WHERE
ws_threaddetails_combination.strStyleId ='$styleNo' order by strOperationName ASC";
		
		$resultOP =$db->RunQuery($SQLOP);
		while ($rowOP=mysql_fetch_array($resultOP))
		{
		?>
		<tr><td class="normalfnt" align="left" id="<?php echo $rowOP["strOperationId"]?>"><?php echo $rowOP["strOperationName"]?></td>
		<?php
	//***************************************************************************************************************************************************************************************************8
	
		
/*		$SQL1="	SELECT DISTINCT strMachineCode, intMachineTypeId   
				FROM ws_machinetypes where intStatus=1 order by intMachineTypeId asc";*/
		$SQL1 = "SELECT DISTINCT
				ws_machinetypes.strMachineCode,
				ws_machinetypes.intMachineTypeId AS M_mtype
				FROM
				ws_machinetypes
				Inner Join ws_threaddetails_combination ON ws_machinetypes.intMachineTypeId = ws_threaddetails_combination.strMachineTypeId
				WHERE
				ws_machinetypes.intStatus =  1 AND
				ws_threaddetails_combination.strStyleId =  '$styleNo'
				ORDER BY
				M_mtype ASC
				";
			$result1 =$db->RunQuery($SQL1);
			$j=0;
			while ($row1=mysql_fetch_array($result1))
			{
/*		$SQL="	SELECT intID, strStitchType   
				FROM ws_stitchtype order by  intID asc ";*/
		$SQL = "SELECT DISTINCT
				ws_stitchtype.intID,
				ws_stitchtype.strStitchType,
				ws_threaddetails_combination.intFactorNameID
				FROM
				ws_stitchtype
				Inner Join ws_threaddetails_combination ON ws_stitchtype.intID = ws_threaddetails_combination.strStitchType
				Inner Join ws_machinetypes ON ws_machinetypes.intMachineTypeId = ws_threaddetails_combination.strMachineTypeId
				WHERE
				ws_threaddetails_combination.strStyleId =  '$styleNo' AND
				ws_machinetypes.intMachineTypeId =  '".$row1["M_mtype"]."'
				order by  intID asc
				";
			$result =$db->RunQuery($SQL);
			while ($row=mysql_fetch_array($result))
			{
				?>
				<td class="normalfntRite" align="right" id="<?php echo $rowOP["strOperationId"]."s".$row1["M_mtype"]."s".$row["intID"] ?>">
				<?php
				
			//$totMeters[]=array();	
				
				
			  $SQLOPD="SELECT 
ws_threaddetails_combination.strOperationId,
ws_threaddetails_combination.strMachineTypeId,
ws_threaddetails_combination.strStitchType,
ws_threaddetails.dblOpt_length_inch, 
ws_machinefactors.dblFactor,
ws_threaddetails_combination.dblLength_meters
FROM 
ws_threaddetails_combination
inner join ws_threaddetails on ws_threaddetails_combination.strStyleId= ws_threaddetails.strStyleId
left join ws_machinefactors on ws_threaddetails_combination.strMachineTypeId=ws_machinefactors.intMachineTypeId and ws_threaddetails_combination.strStitchType=ws_machinefactors.intStitchTypeId

WHERE 

ws_threaddetails_combination.strStyleId ='$styleNo' And ws_threaddetails_combination.strOperationId='".$rowOP["strOperationId"]."' And ws_threaddetails_combination.strStitchType='".$row["intID"]."' AND ws_threaddetails.strStyleId='$styleNo' AND ws_threaddetails.strOperationId='".$rowOP["strOperationId"]."' AND  ws_threaddetails_combination.intFactorNameID= '".$row["intFactorNameID"]."' And ws_machinefactors.intFactorNameID='".$row["intFactorNameID"]."' order by strOperationId ASC";
					
					$resultOPD =$db->RunQuery($SQLOPD);
					while ($rowOPD=mysql_fetch_array($resultOPD))
					{
																	// stitch type ID
					if(($rowOP["strOperationId"]."s".$row1["M_mtype"]."s".$row["intID"])==($rowOPD["strOperationId"]."s".$rowOPD["strMachineTypeId"]."s".$rowOPD["strStitchType"]))
					{
                         if($rowOPD["dblOpt_length_inch"]!='') echo round($rowOPD["dblOpt_length_inch"],0); else echo "-";
						$totArray[$j]=$totArray[$j]+$rowOPD["dblOpt_length_inch"]; //************************************************************************************************************************
				    }
					 else
					 {
					  $totArray[$j]=$totArray[$j]+0;
					 }
				}
					?>
				</td>
				<?php
				$j++;
			 	}
			}
			?>
		</tr>
		<?php
			}
		?>
<?php
		/*$SQL1="SELECT
ws_machinefactors.dblFactor
FROM
ws_machinefactors
ORDER BY
ws_machinefactors.intMachineTypeId ASC,
ws_machinefactors.intStitchTypeId ASC";
		
			$result1 =$db->RunQuery($SQL1);
			$j=0;
			while ($row2=mysql_fetch_array($result1))
			{
			$factorArray[$j]=$row2["dblFactor"];
			$j++;
			}*/
?>		
		
		
		
		<tr>
			<td colspan="<?php echo $cells*$colspan+1 ?>" class="normalfnt"><?php echo $total1 ?></td>
		</tr>
		<tr class="bgColor">
			<td class="normalfntb">Total Inches</td>
				<?php
				$arrayLength = count($totArray);
				for ($i=0; $i<$arrayLength; $i++)
				{
				?>
				<td class="normalfntRite" id="<?php echo $i ?>"><?php echo $totArray[$i] ?></td>
				<?php
				}
				?>
		</tr>
		<tr>
			<td colspan="<?php echo $cells*$colspan+1 ?>" class="normalfnt"></td>
		</tr>
		<tr class="bgColor">
			<td class="normalfntb">Factor [Length Per Inch]</td>
				<?php
				//*************************************************************************************************************
/*			    $SQL="	SELECT DISTINCT strMachineCode, intMachineTypeId   
					FROM ws_machinetypes where intStatus=1 order by strMachineCode asc";*/
					$SQL = "SELECT DISTINCT
				ws_machinetypes.strMachineCode,
				ws_machinetypes.intMachineTypeId AS M_mtype
				FROM
				ws_machinetypes
				Inner Join ws_threaddetails_combination ON ws_machinetypes.intMachineTypeId = ws_threaddetails_combination.strMachineTypeId
				WHERE
				ws_machinetypes.intStatus =  1 AND
				ws_threaddetails_combination.strStyleId =  '$styleNo'
				ORDER BY
				M_mtype ASC
				";
				$result =$db->RunQuery($SQL);
				$j=0;
				while ($row=mysql_fetch_array($result))
				{
/*				$SQL2="SELECT intID, strStitchType   
						FROM ws_stitchtype order by  intID asc ";*/
			$SQL2 = "SELECT DISTINCT
				ws_stitchtype.intID,
				ws_stitchtype.strStitchType
				FROM
				ws_stitchtype
				Inner Join ws_threaddetails_combination ON ws_stitchtype.intID = ws_threaddetails_combination.strStitchType
				Inner Join ws_machinetypes ON ws_machinetypes.intMachineTypeId = ws_threaddetails_combination.strMachineTypeId
				WHERE
				ws_threaddetails_combination.strStyleId =  '$styleNo' AND
				ws_machinetypes.intMachineTypeId =  '".$row["M_mtype"]."'
				order by  intID asc";
				
					$result2 =$db->RunQuery($SQL2);
					while ($row1=mysql_fetch_array($result2))
				{
					?>
					<td class="normalfntRite" align="right" id="<?php $row["M_mtype"] ?>"><?php  echo $factorArray[$j];?></td>
					<?php
				    $j++;
				}
				}
				?>
		</tr>
		<tr>
			<td colspan="<?php echo $cells*$colspan+1 ?>" class="normalfnt">&nbsp;</td>
		</tr>
		<tr class="bgColor">
        <?php
		
			$sqlHeader = "SELECT dblWastage FROM ws_threadheader WHERE strStyleId='$styleNo'";
			$resulthead =$db->RunQuery($sqlHeader);
			$rowhead=mysql_fetch_array($resulthead)
		?>
			<td class="normalfntb">Consu. +<?php echo $rowhead['dblWastage'];?>% Allo. In Inch</td>
				<?php
/*			    $SQL="	SELECT DISTINCT strMachineCode, intMachineTypeId   
					FROM ws_machinetypes where intStatus=1 order by strMachineCode asc";*/
					$SQL= "SELECT DISTINCT
				ws_machinetypes.strMachineCode,
				ws_machinetypes.intMachineTypeId AS M_mtype
				FROM
				ws_machinetypes
				Inner Join ws_threaddetails_combination ON ws_machinetypes.intMachineTypeId = ws_threaddetails_combination.strMachineTypeId
				WHERE
				ws_machinetypes.intStatus =  1 AND
				ws_threaddetails_combination.strStyleId =  '$styleNo'
				ORDER BY
				M_mtype ASC
				";
				$result =$db->RunQuery($SQL);
				$j=0;
				while ($row=mysql_fetch_array($result))
				{
/*				$SQL2="SELECT intID, strStitchType   
						FROM ws_stitchtype order by  intID asc ";*/

						$SQL2 = "SELECT DISTINCT
				ws_stitchtype.intID,
				ws_stitchtype.strStitchType
				FROM
				ws_stitchtype
				Inner Join ws_threaddetails_combination ON ws_stitchtype.intID = ws_threaddetails_combination.strStitchType
				Inner Join ws_machinetypes ON ws_machinetypes.intMachineTypeId = ws_threaddetails_combination.strMachineTypeId
				WHERE
				ws_threaddetails_combination.strStyleId =  '$styleNo' AND
				ws_machinetypes.intMachineTypeId =  '".$row["M_mtype"]."'
				order by  intID asc
				";
					$result2 =$db->RunQuery($SQL2);
				while ($row1=mysql_fetch_array($result2))
					{ //echo $row1['dblWast'];


$SQLWast = "SELECT DISTINCT 
ws_threadheader.dblWastage 
FROM ws_threadheader WHERE ws_threadheader.strStyleId = '$styleNo'";
					$resultWast =$db->RunQuery($SQLWast);
				while($rowWast=mysql_fetch_array($resultWast))
					 { 
					 	$tt = $rowWast['dblWastage'];
					 }
					
				?>
				<td class="normalfntRite" align="right" id="<?php $row["M_mtype"] ?>"><?php //echo $factorArray[$j]*$totArray[$j]; 
				echo round(($totArray[$j]*$factorArray[$j])*((100+$tt)/100),2); 
				$totMeters[$j]=round(($totArray[$j]*$factorArray[$j])*((100+$tt)/100),2);
				//echo $totMeters[$j]; 
				?></td> 
				<?php
				$j++; //****************************************
				}
					
				}
				?>
		</tr>
		<tr>
			<td colspan="<?php echo $cells*$colspan+1 ?>" class="normalfnt">&nbsp;</td>
		</tr>
		<tr class="bgColor">
			<td class="normalfntb">Consumption - In Meters</td>
				<?php
/*			    $SQL="	SELECT DISTINCT strMachineCode, intMachineTypeId    
					FROM ws_machinetypes where intStatus=1 order by strMachineCode asc";*/
					$SQL = "SELECT DISTINCT
				ws_machinetypes.strMachineCode,
				ws_machinetypes.intMachineTypeId AS M_mtype
				FROM
				ws_machinetypes
				Inner Join ws_threaddetails_combination ON ws_machinetypes.intMachineTypeId = ws_threaddetails_combination.strMachineTypeId
				WHERE
				ws_machinetypes.intStatus =  1 AND
				ws_threaddetails_combination.strStyleId =  '$styleNo'
				ORDER BY
				M_mtype ASC
				";
				$result =$db->RunQuery($SQL);
				$j=0;
				while ($row=mysql_fetch_array($result))
				{
		$SQL2 = "SELECT DISTINCT
				ws_stitchtype.intID,
				ws_stitchtype.strStitchType
				FROM
				ws_stitchtype
				Inner Join ws_threaddetails_combination ON ws_stitchtype.intID = ws_threaddetails_combination.strStitchType
				Inner Join ws_machinetypes ON ws_machinetypes.intMachineTypeId = ws_threaddetails_combination.strMachineTypeId
				WHERE
				ws_threaddetails_combination.strStyleId =  '$styleNo' AND
				ws_machinetypes.intMachineTypeId =  '".$row["M_mtype"]."'
				order by  intID asc
				";
				
					$result2 =$db->RunQuery($SQL2);
					while ($row1=mysql_fetch_array($result2))
					{
				?>
				<td class="normalfntRite" align="right" id="<?php $row["intMachineTypeId"] ?>"><?php 
				//echo round($factorArray[$j]*$totArray[$j]/39.37,2); 
				//echo $totMeters[$j].",";
				$totmet = round($totMeters[$j]/39,2);
				echo $totmet;
				?></td>
				<?php
				//$totConsump=$totConsump+round($factorArray[$j]*$totArray[$j]/39.37,2);
				$totConsump+=round($totmet,2);
				$j++;
				}
				}
				?>
		</tr>
		<tr>
			<td colspan="<?php echo $cells*$colspan+1 ?>" class="normalfnt">&nbsp;</td>
		</tr>
		<tr class="bgColor">
			<td class="normalfntb">Total Consumption - In Meters</td>
			<td colspan="<?php echo $cells*$colspan ?>" class="normalfntRite" align="right" id="<?php $row["intMachineTypeId"] ?>"><b><?php  echo $totConsump;?></b></td>
		</tr>
	</tbody>
</table>
<br />
<br />
	
    <table align="center" style='table-layout:fixed' width="10" border="1" cellspacing="1" class="helaworkstudyTable">
	
    <thead>
    	<tr class="bgColor">
        
        	<td width="130" class="normalfntb">Color\Ticket</td>
            
            <?php
			
				$sql1 = "SELECT distinct ws_thread.strthread,ws_threaddetails_combination.strThreadType
						 FROM
						 ws_threaddetails_combination
						 Inner Join ws_thread ON ws_threaddetails_combination.strThreadType = ws_thread.intID
						 Where ws_threaddetails_combination.strStyleId='$styleNo' 
						 Order By ws_thread.strthread";
						 
				$result1 =$db->RunQuery($sql1);
				while ($row1=mysql_fetch_array($result1))
				{
			?>
            
            		<td width="110" class="normalfntb"><?php echo $row1['strthread']; ?></td>
            <?php
				}
			?>
   
        </tr>
        
        	<?php
			
				$sql2 = "SELECT DISTINCT ws_threaddetails_combination.strColor
						 FROM
						 ws_threaddetails_combination
						 Where ws_threaddetails_combination.strStyleId='$styleNo'
						 Order By ws_threaddetails_combination.strColor";
				
				$result2 =$db->RunQuery($sql2);
				while ($row2=mysql_fetch_array($result2))
				{
			?>
            		<tr>
                    	<td width="90" class="bgColor" style="text-align:center; font-family:'Times New Roman', Times, serif; font-size:14px" ><?php echo $row2['strColor']; ?></td>
            <?php
					$sql4 = "SELECT distinct ws_thread.strthread,ws_threaddetails_combination.strThreadType
						     FROM
						     ws_threaddetails_combination
						     Inner Join ws_thread ON ws_threaddetails_combination.strThreadType = ws_thread.intID
						     Where ws_threaddetails_combination.strStyleId='$styleNo' 
						     Order By ws_thread.strthread";
				    $result4 =$db->RunQuery($sql4);
					while ($row4=mysql_fetch_array($result4))
					{
					
					$sql3 = "SELECT ifnull(Sum(ws_threaddetails_combination.dblLength_meters),0) AS totsum
							 FROM ws_threaddetails_combination
							 Where ws_threaddetails_combination.strColor='".$row2['strColor']."' 
							 AND ws_threaddetails_combination.strThreadType='".$row4['strThreadType']."'
							 AND ws_threaddetails_combination.strStyleId='$styleNo'";
							 
					$result3 =$db->RunQuery($sql3);
					while ($row3=mysql_fetch_array($result3))
					{
					
			?>
            		
                    	<td width="90" style="text-align:center" class="normalfnt"><?php echo $row3['totsum']; ?></td>
                    
            <?php
					}
					}
			?>
            </tr>
            
            <?php
				}
			?>
          
       
    </thead>
    
	
    </table>
				
</body>
</html>
