<?php
 session_start();
 $backwardseperator = "../../";
include "../../Connector.php";
$report_companyId = $_SESSION["FactoryID"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Layout Sheet Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table align="center" width="900" border="0">
<tr>
<?php
		
					$SQL_address="SELECT * FROM 
						companies
						Inner Join useraccounts ON companies.intCompanyID = useraccounts.intCompanyID
						WHERE
						useraccounts.intUserID =  '".$_SESSION["UserID"]."'";
							
						$result_address = $db->RunQuery($SQL_address);
					
					
		while($rows = mysql_fetch_array($result_address))
		{	
		$strName=$rows["strName"];
		$comAddress1=$rows["strAddress1"];
		$comAddress2=$rows["strAddress2"];
		$comStreet=$rows["strStreet"];
		$comCity=$rows["strCity"];
		$comCountry=$rows["strCountry"];
		$comZipCode=$rows["strZipCode"];
		$strPhone=$rows["strPhone"];
		$comEMail=$rows["strEMail"];
		$comFax=$rows["strFax"];
		$comWeb=$rows["strWeb"];
		}			
				?>
<td align="center" style="font-family: Arial;	font-size: 16pt;color: #000000;font-weight: bold;"><?php include "../../reportHeader.php";?></td>				
</tr>

</table>

<table width="100%">
 <tr>
  <td width="100%" align="center" style="font-size:14px;font-weight:bold;font-family:"Courier New", Courier, monospace">Operations Layout Sheet  </td>
 </tr>
</table>
<br/>
<br />

<?php
$style=trim($_GET['styleId'],' ');
$styleName=$_GET['style'];
$order=$_GET['order'];
$category=$_GET['category'];
$operators=$_GET['operators'];
$helpers=$_GET['helpers'];
$machineSMV=$_GET['machineSMV'];
$helperSMV=$_GET['helperSMV'];
$teams=$_GET['teams'];
$hoursPerDay=$_GET['hoursPerDay'];
//$explodeTeams= explode(',',$teams);
//$teams=count($explodeTeams);
 $SQL = "SELECT *
				  FROM `ws_machinesoperatorsassignment`
				  WHERE `strStyle` = '$style'";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result)){
    $issueDate=$row['dblDate'];
	$issueDate=substr($issueDate,0,4)."-".substr($issueDate,5,2)."-".substr($issueDate,8,2);
	}
?>

<div align="center" class="LayoutSheetReportContainer">
	<div class="doublelineBorder">
	<table align="center" width="900">
		<tbody>
			<tr>
				<td>
					<table width="438" align="left">
						<tbody>
							<tr>
								<td width="74" class="normalfntb">Style No</td>
								<td width="143" class="normalfnt"><?php echo $styleName; ?></td>
								<td width="91" class="normalfntb">Order No</td>
								<td width="110" class="normalfnt"><?php echo $order ?></td>
							</tr>
							<tr>
								<td width="74" class="normalfntb">Description</td>
								<td width="143" class="normalfnt"><?php echo $_GET['style']; ?></td>
								<td width="91" class="normalfntb">SMV of gmt</td>
								<td width="110" class="normalfnt"><?php echo $machineSMV+$helperSMV; ?></td>
							</tr>
							<tr>
								<td width="91" class="normalfntb">Date of Issue</td>
								<td width="110" class="normalfnt"><?php echo $issueDate ?></td>
								<td width="91" class="normalfntb">Line Team</td>
								<td width="110" class="normalfnt"><?php echo $teams; ?></td>
							</tr>
							<tr>
								<td colspan="4" class="normalfnt">&nbsp;</td>
							</tr>
						</tbody>
				  </table>				
				</td>
				<td>
					<table width="438" align="left">
						<tbody>
							<tr>
								<td width="244" class="normalfntb">Total Meaning In Line</td>
								<td width="65" class="normalfntb">M/O's</td>
								<td width="49" class="normalfntb">Help's</td>
								<td width="60" class="normalfntb">Total</td>
							</tr>
							<tr>
								<td width="244" class="normalfntb">(With Ab%)</td>
								<td width="65" class="normalfntborder"><?php echo $operators; ?></td>
								<td width="49" class="normalfntborder"><?php echo $helpers; ?></td>
								<td width="60" class="normalfntborder"><?php echo $operators+$helpers; ?></td>
							</tr>
							<tr>
								<td colspan="1" width="244" class="normalfntb"></td>
								<td colspan="3" width="244" class="normalfntb">Final /Press Folders</td>
							</tr>
							<tr>
								<td width="244" class="normalfntb"></td>
								<td width="65" class="normalfntborder"></td>
								<td width="49" class="normalfntborder"></td>
								<td width="60" class="normalfntborder">0</td>
							</tr>
							<tr>
								<td width="244" class="normalfntb">Tack Time</td>
								<td width="65" colspan="3" class="normalfnt"><?php echo round(($machineSMV+$helperSMV)/$operators,2); ?></td>
							</tr>
						</tbody>
				  </table>				
				</td>
			</tr>
		</tbody>
	</table>
	<br />
	<table align="center" width="900">
		<tbody>
			<tr>
				<td>
					<table class="normalfntborderTable" border="1" cellspacing="1" width="438" align="left">
						<thead class="normalfntb">
							<tr>
								<td colspan="3" width="59" class="normalfntMid">M/C Configuration</td>
							</tr>
							<tr>
								<td width="59" class="normalfntMid">M/C</td>
								<td width="127" class="normalfntMid">Type</td>
								<td width="95" class="normalfntMid">Req. No's</td>
                                
							</tr>
						</thead>	
						<?php
						$SQL="SELECT
						ws_machines.strName, 
						ws_machinetypes.intMachineId, 
						ws_machinetypes.intMachineTypeId, 
						ws_machinetypes.strMachineName
						FROM
						ws_machinetypes
						Inner Join ws_machines ON ws_machinetypes.intMachineId = ws_machines.intMacineID ORDER BY ws_machines.strName, ws_machinetypes.strMachineName ASC
						";
					$result = $db->RunQuery($SQL);
					while($row = mysql_fetch_array($result))
					{
					$machine=$row["intMachineTypeId"];
					 $sqlCountQuery = "SELECT count(*) AS count
									  FROM
ws_machinesoperatorsassignment
Inner Join ws_operations ON ws_machinesoperatorsassignment.intOperation = ws_operations.intOpID 
Inner Join components ON ws_operations.intComponent = components.intComponentId  
									  WHERE `strStyle` = '$style' AND `intMachineTypeId`='$machine' AND components.intCategory ='$category' ";
					$recordCount 	= $db->RunQuery($sqlCountQuery);
					$reCount 		= mysql_fetch_array($recordCount);
					$resCount 		= $reCount['count'];
					?>				
						<tbody class="normalfnt">
							<tr>
								<td width="59"><?php echo $row["strName"] ?></td>
								<td width="127"><?php echo $row["strMachineName"] ?></td>
								<td width="95"><?php echo $resCount ?></td>
							</tr>
						</tbody>
					<?php
					}
					?>
					</table>
				</td>
				<td>
					<table width="438" align="left">
						<tbody>
							<tr>
								<td colspan="2" class="normalfntb">Req. out put tgt at</td>
								<td width="51" class="normalfntb">day</td>
								<td width="43" class="normalfntb">hour</td>
							</tr>
							<tr>
								<td colspan="2" class="normalfnt">@ 100% Required out put</td>
								<td width="51" class="normalfnt"><?php echo round(60/($machineSMV+$helperSMV)*($operators+$helpers)*$hoursPerDay*1,2); ?></td>
								<td width="43" class="normalfnt"><?php echo round(60/($machineSMV+$helperSMV)*($operators+$helpers)*1,2); ?></td>
							</tr>
							<tr>
								<td colspan="2" class="normalfnt">@ 70% Required out put</td>
								<td width="51" class="normalfnt"><?php echo round(60/($machineSMV+$helperSMV)*($operators+$helpers)*$hoursPerDay*0.7,2); ?></td>
								<td width="43" class="normalfnt"><?php echo round(60/($machineSMV+$helperSMV)*($operators+$helpers)*0.7,2); ?></td>
							</tr>
							<tr>
								<td colspan="2" class="normalfnt">@ 60% Required out put</td>
								<td width="51" class="normalfnt"><?php echo round(60/($machineSMV+$helperSMV)*($operators+$helpers)*$hoursPerDay*0.6,2); ?></td>
								<td width="43" class="normalfnt"><?php echo round(60/($machineSMV+$helperSMV)*($operators+$helpers)*0.6,2); ?></td>
							</tr>
							<tr>
								<td colspan="2" class="normalfnt">@ 50% Required out put</td>
								<td width="51" class="normalfnt"><?php echo round(60/($machineSMV+$helperSMV)*($operators+$helpers)*$hoursPerDay*0.5,2); ?></td>
								<td width="43" class="normalfnt"><?php echo round(60/($machineSMV+$helperSMV)*($operators+$helpers)*0.5,2); ?></td>
							</tr>
							<tr>
								<td width="268" class="normalfntb">Required out put @</td>
								<td width="56" class="normalfntborder">75%</td>
								<td width="51" class="normalfnt"><?php echo round(60/($machineSMV+$helperSMV)*($operators+$helpers)*$hoursPerDay*0.75,2); ?></td>
								<td width="43" class="normalfnt"><?php echo round(60/($machineSMV+$helperSMV)*($operators+$helpers)*0.75,2); ?></td>
							</tr>
							<tr>
								<td colspan="4" width="268" class="normalfntb">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="4" width="268" class="normalfntb">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" class="normalfntb">No of Operation</td>
								<?php
					 $sqlCountQuery = "SELECT count(*) AS count
									  FROM `ws_machinesoperatorsassignment`
									  WHERE `strStyle` = '$style'";
					$recordCount 	= $db->RunQuery($sqlCountQuery);
					$reCount 		= mysql_fetch_array($recordCount);
					$resCount 		= $reCount['count'];
					?>
								<td colspan="2" width="51" class="normalfnt"><?php echo $resCount ?></td>
							</tr>
						</tbody>
					</table>	
				</td>			
			</tr>
		</tbody>
	</table>

	</div>
</div>
<!-- End of the border-->
<br />

<?php
$styleNo = trim($_GET['styleId'], ' ');

$sqlCountQuery = "SELECT count(*) AS count
				  FROM `machinesoperatorsassignment`
				  WHERE `strStyle` = '$styleNo'";
$recordCount 	= $db->RunQuery($sqlCountQuery);
$reCount 		= mysql_fetch_array($recordCount);
$resCount 		= $reCount['count'];
		 		
 /*  echo $sqlQuery = "SELECT
			MP.id AS id,
			MP.styleNo AS styleNo,
			MP.L_R as L_R,
			MP.operationId AS operationId,
			MP.location AS location,
			MP.intMachineTypeId AS intMachineTypeId,
			MP.smv AS smv,
			MP.r AS r,
			MP.tgt AS tgt,
			MP.mr AS mr,
			MP.eff AS eff,
			MP.totTarget AS totTarget,
			MP.nos AS nos,
			MP.lineNo AS lineNo,
			OP.strOperation AS strOperation, 
			ws_machinetypes.strMachineName 
			FROM
			ws_machinesoperatorsassignment AS MP
			INNER JOIN ws_operations AS OP ON MP.operationId = OP.intOpID 
			Inner Join ws_machinetypes ON MP.intMachineTypeId = ws_machinetypes.intMachineTypeId 
			WHERE MP.styleNo = '$styleNo'
			ORDER BY MP.id DESC";*/
			
			 /*  $sqlQuery ="SELECT * FROM
ws_machinesoperatorsassignment AS MP
Inner Join ws_operations ON MP.intOperation = ws_operations.intId
Inner Join components ON ws_operations.intCompId = components.intComponentId
WHERE
MP.strStyle =  '$styleNo' AND
components.intCategory =  '$category'
GROUP BY
MP.strStyle,
MP.intOperation,
MP.intEPFNo
ORDER BY MP.intEPFNo DESC";*/
// sumith 2011-05-13**********************************************
$sqlQuery="SELECT *
				FROM
				ws_machinesoperatorsassignment AS MP
				INNER JOIN ws_operations ON MP.intOperation = ws_operations.intId
				INNER JOIN components ON ws_operations.intCompId = components.intComponentId
				INNER JOIN ws_smv ON ws_smv.intOperationId = MP.intOperation
				left JOIN ws_machinetypes ON ws_smv.intMachineTypeId = ws_machinetypes.intMachineTypeId
				WHERE
				MP.strStyle =  '$styleNo' AND
				components.intCategory =  '$category'
				GROUP BY
				MP.strStyle,
				MP.intOperation,
				MP.intEPFNo
				ORDER BY MP.intEPFNo DESC";
				
$recordSet = $db->RunQuery($sqlQuery); 
?>


<table align="center" width="900" height="auto">
<tbody>
		
<?php
		$tmpID = 0; 	
		$i=0;
		$side1Count=0;
		$side2Count=0;
		$recordSet = $db->RunQuery($sqlQuery); 
		
		while( $record = mysql_fetch_array($recordSet))
		{   
		$i++;
		
		if(($i==1) and ($record['intEPFNo']%2!=0))
		{
?>
<tr><td><div class="container1"></div></td>


<?php
		}
if($record['intEPFNo']%2==0)
{ 
		$side1Count++;
		 $side="1";
?>

		<?php
	//	echo $side;
		if(($tmpID!=$record['intEPFNo']) and ($side2Count!=0))
		{//end of 2nd cell
		?>
  </tbody>
</table>
			</td>
		<?php
		}
		?>

		<?php
		if($tmpID!=$record['intEPFNo'])
		{
		?>
		<tr><td>
		<?php
		}
		?>
			
			
		<?php
		if($tmpID!=$record['intEPFNo'])
		{
		?>
<div class="container1" >
	<table align="center" class="normalfntborderTable" border="1" cellspacing="1" width="100%">
	 <tbody class="normalfnt">	
       <tr>
			<td width="9%" class='bcgl1txt1NB'>Eff</td>
			<td width="9%" class='bcgl1txt1NB'>EPF No</td>
			<td width="10%" class='bcgl1txt1NB' align="right"><?php echo $record['intEPFNo']; ?></td>
			<td width="39%" class='bcgl1txt1NB'><?php echo $record['strMachineName']; ?></td>
			<td width="12%" class='bcgl1txt1NB'>SMV</td>
			<td width="12%" class='bcgl1txt1NB'>Tgt%</td>
			<td width="12%" class='bcgl1txt1NB'>Bal%</td>
	  </tr>
		<?php
		}
		?>
	 <tr>
            <td></td>
            <td colspan="3"><?php echo $record['strOperationName']; ?></td>
            <td><?php echo $record['dblSMV']; ?></td>
            <td><?php echo round(60/$record['dblSMV'],2); ?></td>
            <td></td>
	 </tr>
<?php
 }//end if($record['id']%2==0)
?>			
			
			
   <?php
			if($record['intEPFNo']%2!=0)
			{ 
			$side2Count++;
			$side="2";
   ?>

		<?php
	//	echo $side;
		if(($tmpID!=$record['intEPFNo']) and ($side1Count!=0) )
		{
		?>
	    </tbody>
	  </table>
		</div>
        </td>
		<?php
		}
		?>

		<?php
		if($tmpID!=$record['intEPFNo'])
		{
		?>
		<td>
		<?php
		}
		?>
		
		<?php
			if($tmpID!=$record['intEPFNo'])
			{
		?>
<div class="container1" >
	<table align="center" class="normalfntborderTable" border="1" cellspacing="1" width="100%">
		<tbody class="normalfnt">						
        <tr>
			<td width="9%" class='bcgl1txt1NB'>Eff</td>
			<td width="9%" class='bcgl1txt1NB'>EPF No</td>
			<td width="10%" class='bcgl1txt1NB' align="right"><?php echo $record['intEPFNo']; ?></td>
			<td width="39%" class='bcgl1txt1NB'><?php echo $record['strMachineName']; ?></td>
			<td width="12%" class='bcgl1txt1NB'>SMV</td>
			<td width="12%" class='bcgl1txt1NB'>Tgt%</td>
			<td width="12%" class='bcgl1txt1NB'>Bal%</td>
		</tr>
						<?php
						}
						?>
		<tr>
            <td></td>
            <td colspan="3"><?php echo $record['strOperationName']; ?></td>
            <td><?php echo $record['dblSMV']; ?></td>
            <td><?php echo round(60/$record['dblSMV'],2); ?></td>
            <td></td>
		</tr>
<?php
$side2Count++;

}//end if($record['id']%2==0)
$tmpID=$record['intEPFNo'];
}//end while
?>			
</tbody>
</table>
</div>
</td>
</tr>

<table align="center" width="900">
	<tbody class="normalfntC">
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
        <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
        <tr>
			<td>............................................</td>
			<td>............................................</td>
			<td>............................................</td>
			<td>............................................</td>
		</tr>
		<tr>
			<td>Prepared By</td>
			<td>Agreed By</td>
			<td>Approved By</td>
			<td>Authorised By</td>
		</tr>
		<tr>
			<td>(W.S.O)</td>
			<td>(P.A)</td>
			<td>(P.M)</td>
			<td>(I.E. Manager)</td>
		</tr>
	</tbody>
</table>
</td>
</tr>
</table>

</body>
</html>
