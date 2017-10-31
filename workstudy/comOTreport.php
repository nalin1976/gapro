<?php
session_start(); 
include "../../../DBManager.php";

$db = new DBManager();

$companyID = $_SESSION["ComID"];
$cmbCat = $_GET["cmbCategory"];
$cmbVal =  $_GET["cmbSelectCat"];
$rAv = $_GET["rbAvailability"];
$rAtt = $_GET["rbAttendance"];
//$rSal = $_GET["rbSalStatus"];
$rSex = $_GET["rbSex"];
$Dfrom = $_GET["txtDfrom"];
$DTo =  $_GET["txtDTo"];
$AllCat = $_GET["chkAllCategory"];
$EmpCat = $_GET["cmbEmpCat"];
$AllTeam = $_GET["chkAllEmp"];

	$SQL_Com = " SELECT strCompanyName,strAddress,strPhone ".
              " FROM companies " .
              " WHERE intCompanyID='$companyID'";
              
              $result_Com = $db->RunQuery($SQL_Com);
              while($row_Com = mysql_fetch_array($result_Com))
              {
              		$ComName = $row_Com["strCompanyName"];
              		$ComAD = $row_Com["strAddress"];
              		$ComTP = $row_Com["strPhone"];
              }
	
     $DFYear = substr($Dfrom,6,4);
	$DFmonth = substr($Dfrom,3,2);
	$DFDate = substr($Dfrom,0,2);
	$DFdat = $DFDate ;
	$DFdatEnd = $DFDate; 
	$DTYear = substr($DTo,6,4);
	$DTmonth = substr($DTo,3,2);
	$DTDate = substr($DTo,0,2);     
	
	$date2 = mktime(0,0,0,$DFmonth,$DFDate,$DFYear);
	$date1 = mktime(0,0,0,$DTmonth,$DTDate,$DTYear);

//echo $date2;
	$dateDiff = $date1 - $date2;
	$dDate = $DFDate;
	$fullDays = floor($dateDiff/(60*60*24));
	$fullDays = $fullDays+1;  
	
	//GET Team Details
	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Daily OT Report</title>
<link href="../../../css/hrs.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<table width="957" border="0" align="center">
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td width="30"></td>
<table width="855" align="center">
<tr>
<td width="163" rowspan="4"  align="center" class="ReportComName"><img src="../../../images/<?php echo $companyID; ?>.logo.png" height="74" border="0" alt=""></td>
<td width="687"  align="center" class="ReportComName"><?php echo $ComName ?></td>
</tr>
<tr>

<td align="center" clasa="ReportAd"><?php echo $ComAD ?></td>
</tr>
<tr>
<td align="center" class="normalfntCent" ><?php echo $ComTP?></td>
</tr>
<tr>
<td align="center" class="ReportName">OT Report - Company Wise</td>
</tr>
<tr>
<td colspan="2"></td>
</tr>
<tr>
<td colspan="2"><table width="350" align="left">
<tr>
<td width="80" class="normalfnt">Date From :</td>
<td width="100" class="normalfnt" ><?php echo $Dfrom?></td>
<td width="70" class="normalfnt">Date To : </td>
<td width="50" class="normalfnt"><?php echo $DTo?></td>
</tr>
</table></td>
</tr>
<tr>
<td colspan="4"></td>
</tr>

<tr>
<td  colspan="4">
<table width="854"><table width="854" cellspacing="1"  bgcolor="#07437c">
<thead>
<!-- <tr>
<td ><hr color="#fd0e0e"></td>
</tr> -->
<tr bgcolor="#FFFFFF">
<td class="normalfnt" width="50">Emp No</td>
<?php 
	for($i=0;$i<$fullDays;$i++){
	
?>
<td class="normalfnt" width="10"><?php echo $DFmonth.'/'.$DFDate; ?></td>
<?php 
		$DFDate +=1 ;
		}
?>
<td class="normalfnt" width="50">Total</td>
</tr>


<!-- <tr>
<td colspan="10"><hr  color="#000000"></td>
</tr> -->
</thead>
<tr class="otRrtTotRw">
<td class="normalfnt" width="50">Total</td>
			<?php 
			$totOT = 0;
			for($i=0;$i<$fullDays;$i++){
			
		?>
		<td class="normalfntCent" width="10"><?php 
		//echo $DFmonth.'/'.$DFdatEnd; 
		$odate = $DFYear.'-'.$DFmonth.'-'.$DFdatEnd;
		$SQL_OT = " SELECT SUM(attendence.dblOT) AS dayOT ". 
					 "	FROM attendence inner join employee on ". 
					 " attendence.strEmpNo = employee.strEmpNo AND ".
					  " attendence.bytCompanyCode = employee.bytCompany ".
					 "	WHERE attendence.bytCompanyCode='$companyID' AND attendence.dtmDate='$odate '";
					 //" AND employee.bytCompany ='$cmbVal'";
					 
					  switch($rAv)
			 {
					case 0:
					{
						$SQL_OT = $SQL_OT." AND employee.booActive = '0' ";
						break; 
					}
					case 1:
					{
						$SQL_OT = $SQL_OT." AND employee.booActive = '1'";
						break;					
					}
					case 2:
					{
						break;					
					}			 
			 }
			 
			 
					 $result_OT = $db->RunQuery($SQL_OT);
              while($row_OT = mysql_fetch_array($result_OT))
              {
              $dayOTtot =  $row_OT["dayOT"];
              echo  $dayOTtot;
              $totOT +=  $dayOTtot;
		?></td>
		<?php 
		}
				$DFdatEnd +=1 ;
				}
		?>
<td class="normalfntCent" width="50"><?php echo  $totOT; ?></td>
</tr>
<tbody>
	<?php 
		$AtDfrom = substr($Dfrom,6,4).'-'.substr($Dfrom,3,2).'-'.substr($Dfrom,0,2);
		$AtDTo = substr($DTo,6,4).'-'.substr($DTo,3,2).'-'.substr($DTo,0,2);	
		$Fdate = $DFdat;
		$SQL = " SELECT DISTINCT  attendence.strEmpNo ".
				 "	FROM attendence INNER JOIN employee ON ".
				 "	attendence.strEmpNo = employee.strEmpNo AND " .
				  " attendence.bytCompanyCode = employee.bytCompany ".
				 "	WHERE attendence.dtmDate BETWEEN '$AtDfrom' AND '$AtDTo'  ".
				 "  AND attendence.bytCompanyCode ='$companyID' ";
				// " AND employee.bytTeam ='$cmbVal'";
				
			 
			 switch($rAv)
			 {
					case 0:
					{
						$SQL = $SQL." AND employee.booActive = '0' ";
						break; 
					}
					case 1:
					{
						$SQL = $SQL." AND employee.booActive = '1'";
						break;					
					}
					case 2:
					{
						break;					
					}			 
			 }
			 
			 switch($rSex)
			 {
					case 0:
					{
						$SQL = $SQL." AND employee.strSex = 'M' ";
						break; 
					}
					case 1:
					{
						$SQL = $SQL." AND employee.strSex = 'F'";
						break;					
					}
					case 2:
					{
						break;					
					}			 
			 }
			 
			 if($AllCat == 'on')
			 {
			 
			 }
			 else{
					$SQL = $SQL." AND employee.intEmpCategory = '$EmpCat'";
											 
			 }
				 $SQL = $SQL." ORDER BY attendence.strEmpNo ";
				 
				  $result = $db->RunQuery($SQL); 
				  while($row = mysql_fetch_array($result))
						 {
					$EmpNo = $row["strEmpNo"];
					$Fdate = $DFdat;
	?>
			<tr class="OTreportTblrow">
			<td class="normalfnt" width="50"><?php echo $EmpNo; ?></td>
			<?php
				$SQL_Emp = " SELECT attendence.strEmpNo,attendence.dtmDate,attendence.intLeaveID," .
							  " attendence.dblOT, leavetype.strDescription  ".
							  " FROM attendence INNER JOIN leavetype ON " .
							  " attendence.intLeaveID = leavetype.bytCode " .
							  " WHERE attendence.dtmDate BETWEEN '$AtDfrom' AND '$AtDTo' " .
							  " AND attendence.strEmpNo = '$EmpNo' AND attendence.bytCompanyCode='1' ";
							  
		/*	 switch($rAtt)
			 {
					case 0:
					{
						$SQL_Emp = $SQL_Emp." AND attendence.strTimeIn = '00:00' AND attendence.strTimeOut = '00:00'";
						break; 
					}
					case 1:
					{
						$SQL_Emp = $SQL_Emp." AND attendence.strTimeIn <> '00:00' AND attendence.strTimeOut <> '00:00'";
						break;					
					}
					case 2:
					{
						break;					
					}			 
			 } */ 
							  $SQL_Emp = $SQL_Emp." ORDER BY attendence.dtmDate " ;
							  
							  $result_Emp = $db->RunQuery($SQL_Emp);
							  $fistRow = true;
							$EmpOT = 0.0; 
							$frow = 0; 
							   while($row_Emp  = mysql_fetch_array($result_Emp))
						 {
						 
						 $LType = $row_Emp["intLeaveID"];
						 $OT = $row_Emp["dblOT"];
						 $atDate = $row_Emp["dtmDate"];
						 
						 $atDay = substr($atDate,8,2);
						 $EmpOT += $OT;
						 
						 //$Leave =  $row_Emp["strDescription"];	
						 switch($LType)
						 {
								case 1:
								{
									$Leave = 'A';
									break;
								}
								case 2:
								{
									$Leave = 'C';
									break;
								}	
								case 3:
								{
									$Leave = 'M';
									break;
								}	
								case 4:
								{
									$Leave = 'S';
									break;
								}	
								case 5:
								{
									$Leave = 'N';
									break;
								}
								case 6:
								{
									$Leave = 'L';
									break;
								}								 
						 } 
						 
						 if($LType != 0)
						 {
						 	if($OT > 0)
						 	{
								$OTVal = $OT; 						 	
						 	}
						 	else
						 	{
								$OTVal = '';						 	
						 	}
							$val = $Leave.' '.$OTVal;
							$clsval = 'normalfntRed';			 
						 }
						 else
						 {
						 	$val = $OT;
						 	$clsval = 'normalfntCent';		
						 }
						if( $fistRow == true){
							$rwCnt = $atDay;
						}
						//for($j=0;$j<fullDays;$j++){
							if($atDay == $Fdate)
							{
			?>
						<td class="<?php echo  $clsval;?>" 
						><?php
							
							echo $val;					
						  ?></td>
							<?php 
							$Fdate +=1;
							$frow  = $Fdate;
							}//end of if 
							else {
							?>
									<?php 
										if( $fistRow == true){
										for($i=$DFdat;$i<=$rwCnt-1;$i++){
										
									?>
									<td class=<?php echo  $clsval;?>
									 width="10"></td>
									<?php 
											
											}//end of for loop 
											}//end of if
									?>
									<td class="<?php echo  $clsval;?>" width="10"><?php 
								echo $val;			
								$rwCnt++;
								$frow  = $rwCnt;
									?></td>
							<?php 
							}//end of else 
							
							?>
					<?php 
					$fistRow = false;
					}//end of 2nd while
					 if($frow < $DTDate){
					 
					 for($a=0;$a<=$DTDate-$frow;$a++){
					?>
					<td class="normalfnt" width="10"></td>
					<?php
					} 
					}
					?>
			<td class="normalfntCent" width="50"><?php 
			echo $EmpOT;
			?>
			</td>		
			</tr>
			
			<?php 
			
			}//end of first while 
			?>
</tbody>
</table></td>
</tr>
</table></td>
<td width="30"></td>
</tr>
</table>
</body>