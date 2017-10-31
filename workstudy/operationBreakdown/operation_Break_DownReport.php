<?php

 session_start();
 $backwardseperator = "../../";
 include "../../Connector.php";

 $report_companyId = $_SESSION["FactoryID"];
 
  //get variables values from opbdRpt1.php
 $opbdrpt_intStyleID 	= trim($_GET['opbdrpt_intStyleID'],' '); 
 $category	    		= trim($_GET['category'],' '); 
 $scNo 					= trim($_GET['scNo'],' '); 
 $SQL="	SELECT 	componentcategory.strCategory FROM componentcategory WHERE componentcategory.intCategoryNo =  '$category'";
		
	$result = 	$db->RunQuery($SQL);
	$row	 =	mysql_fetch_array($result);
	$cat	 =  $row["strCategory"];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>OPBD Report( <?php echo $cat; ?> )</title>
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


<table width="75%" border='0' align="center">
<tr><td colspan="2">

<?php
// get request variables
 $opbdrpt_intStyleID 	= trim($_GET['opbdrpt_intStyleID'],' '); 
 $category 				= trim($_GET['category'],' '); 

/**
*  Commented and Edited by suMith HarShan  2011-05-04
*  Change to load this all details according to the style No and SCNO
**/


/*$sql = "SELECT 
dblworkinghours,intOperators,strTeams from ws_operationbreakdownheader WHERE strStyleID ='".$opbdrpt_intStyleID."'";*/

		$SQL1="SELECT dblworkinghours,intOperators,strTeams
					FROM
					ws_operationbreakdownheader
					INNER JOIN specification ON specification.intStyleId = ws_operationbreakdownheader.strStyleID
					WHERE
					ws_operationbreakdownheader.strStyleID = '".$opbdrpt_intStyleID."' AND
					specification.intSRNO = '".$scNo."'";
		$result1 	= $db->RunQuery($SQL1);
		$row1    	= mysql_fetch_array($result1);
		$hoursPerDay= $row1["dblworkinghours"];


/**
*  Commented and Edited by suMith HarShan  2011-05-04
*  Change to load this all details according to the style No and SCNO
**/

/*$sql = "SELECT 
intOperators,strTeams,intHelpers from ws_stylecategorydetails WHERE strStyle ='".$opbdrpt_intStyleID."' and intCategory='".$category."'";*/

		$SQL2="SELECT 
					intOperators,strTeams,intHelpers
					FROM
					ws_stylecategorydetails
					INNER JOIN specification ON specification.intStyleId = ws_stylecategorydetails.strStyle
					WHERE
					ws_stylecategorydetails.strStyle = '".$opbdrpt_intStyleID."' AND
					ws_stylecategorydetails.intCategory = '".$category."' AND
					specification.intSRNO = '".$scNo."";

		$result_main 	= $db->RunQuery($SQL2);
		$row2 		= mysql_fetch_array($result_main);
		$noOfOperators=$row2["intOperators"];
		$teams		= $row2["strTeams"];
						 
		$smvRatio   = 1667;
	     
 // echo"$SQL2<br>"; 
  
  if(mysql_num_rows($result1))  // query of the $SQL1
  {
	//echo "RR";  
   $new_CategoryBegining  	= ""; 
   $new_compBegining 		= "";
   $temp_category 			= "";
   $temp_component   		= ""; 
   $flg_firstyn  			= "";
  	
   $te_totsubsmv 			= 0;
   $te_totsubsmvHelp 		= 0;
   $te_totsubtmvHelp 		= 0;
   $j = 0;

/**
*  Commented and Edited by suMith HarShan  2011-05-04
*  Change to load this all details according to the style No and SCNO
**/

/* $sql1 = "SELECT DISTINCT components.intComponentId 
from ws_operationbreakdowndetails 
LEFT JOIN ws_operations ON ws_operationbreakdowndetails.intOperationID = ws_operations.intOpID 
LEFT JOIN components ON ws_operations.intComponent = components.intComponentId 
WHERE ws_operationbreakdowndetails.strStyleId='$opbdrpt_intStyleID' and components.intCategory =  '$category' order by intSerial ";*/
/*$sql1 = "SELECT distinct ws_operations.intCompId FROM ws_operationbreakdowndetails Inner Join ws_operations ON 
		ws_operations.intId = ws_operationbreakdowndetails.intOperationID WHERE ws_operations.intCompCatId =  '$category' 
		AND ws_operationbreakdowndetails.strStyleID = '$opbdrpt_intStyleID' order by intSerial ASC";*/

              $SQL3="SELECT distinct ws_operations.intCompId
						FROM
						ws_operationbreakdowndetails
						INNER JOIN ws_operations ON ws_operations.intId = ws_operationbreakdowndetails.intOperationID
						INNER JOIN specification ON specification.intStyleId = ws_operationbreakdowndetails.strStyleID
						WHERE
						ws_operations.intCompCatId = '$category' AND
						ws_operationbreakdowndetails.strStyleID = '$opbdrpt_intStyleID' AND
						specification.intSRNO = '$scNo'
						order by intSerial ASC";		
		
			$result3 = $db->RunQuery($SQL3);
			while($row3 = mysql_fetch_array($result3))   {
 
	//$component=1;				
			 $component = $row3['intCompId'];				
					
/*    $sql = "SELECT ws_operationbreakdowndetails.dblSMV,ws_operations.dblTMU,ws_operations.strOperation,ws_operationbreakdowndetails.intOperationID,ws_operationbreakdowndetails.intMachineTypeId,ws_machinetypes.strMachineName,
componentcategory.strCategory,components.strComponent,ws_operationbreakdowndetails.intMachineType,ws_operationbreakdownheader.dtmDate  
FROM ws_operationbreakdowndetails 
inner JOIN ws_operationbreakdownheader ON ws_operationbreakdowndetails.strStyleID = ws_operationbreakdownheader.strStyleID
LEFT JOIN ws_operations ON ws_operationbreakdowndetails.intOperationID = ws_operations.intOpID
                               LEFT JOIN components ON ws_operations.intComponent = components.intComponentId
							   LEFT JOIN componentcategory ON intCategoryNo = components.intCategory 
							   LEFT JOIN ws_machinetypes ON ws_operationbreakdowndetails.intMachineTypeId = ws_machinetypes.intMachineTypeId 
WHERE ws_operationbreakdowndetails.strStyleID = '$opbdrpt_intStyleID' and components.intComponentId = '$component' order by ws_operationbreakdowndetails.intSerial";	*/




/**
*  Commented and Edited by suMith HarShan  2011-05-04
*  Change to load this all details according to the style No and SCNO
**/

			
	
		/*$SQL4="SELECT
				ws_operationbreakdowndetails.dblSMV,
				ws_operations.strOperationName,
				ws_operationbreakdowndetails.intOperationID,
				ws_operationbreakdowndetails.intMachineTypeId,
				ws_machinetypes.strMachineName,
				components.strComponent,
				components.intComponentId,
				componentcategory.strCategory,
				ws_operationbreakdowndetails.intMachineType,
				ws_operationbreakdownheader.dtmDate,
				(round(ws_operationbreakdowndetails.dblSMV*1667)) AS dblTMU,
				ws_operationbreakdownheader.strTeams
				FROM
				ws_operationbreakdowndetails
				INNER JOIN ws_operations ON ws_operationbreakdowndetails.intOperationID = ws_operations.intId
				INNER JOIN ws_machinetypes ON ws_machinetypes.intMachineTypeId = ws_operationbreakdowndetails.intMachineTypeId
				INNER JOIN componentcategory ON componentcategory.intCategoryNo = ws_operations.intCompCatId
				INNER JOIN components ON components.intComponentId = ws_operations.intCompId AND components.intCategory = ws_operations.intCompCatId AND componentcategory.intCategoryNo = components.intCategory
				INNER JOIN ws_operationbreakdownheader ON ws_operationbreakdownheader.strStyleID = ws_operationbreakdowndetails.strStyleID
				INNER JOIN specification ON specification.strStyleID = ws_operationbreakdowndetails.strStyleID
				WHERE
				ws_operationbreakdowndetails.strStyleID = '$opbdrpt_intStyleID' AND
				ws_operations.intCompId = '$component' AND
				specification.intSRNO = '$scNo'
				order by intSerial ASC ";*/
		// get strTeam   2011-05-13 sumith*************************************		
				$SQL4="SELECT
					ws_operationbreakdowndetails.dblSMV,
					ws_operations.strOperationName,
					ws_operationbreakdowndetails.intOperationID,
					ws_operationbreakdowndetails.intMachineTypeId,
					ws_machinetypes.strMachineName,
					components.strComponent,
					components.intComponentId,
					componentcategory.strCategory,
					ws_operationbreakdowndetails.intMachineType,
					ws_operationbreakdownheader.dtmDate,
					(round(ws_operationbreakdowndetails.dblSMV*1667)) AS dblTMU,
					ws_stylecategorydetails.strTeams,
					ws_stylecategorydetails.intHelpers,
					ws_stylecategorydetails.intOperators
					FROM
					ws_operationbreakdowndetails
					INNER JOIN ws_operations ON ws_operationbreakdowndetails.intOperationID = ws_operations.intId
					left JOIN ws_machinetypes ON ws_machinetypes.intMachineTypeId = ws_operationbreakdowndetails.intMachineTypeId
					INNER JOIN componentcategory ON componentcategory.intCategoryNo = ws_operations.intCompCatId
					INNER JOIN components ON components.intComponentId = ws_operations.intCompId AND components.intCategory = ws_operations.intCompCatId AND componentcategory.intCategoryNo = components.intCategory
					INNER JOIN ws_operationbreakdownheader ON ws_operationbreakdownheader.strStyleID = ws_operationbreakdowndetails.strStyleID
					INNER JOIN specification ON specification.intStyleId = ws_operationbreakdowndetails.strStyleID
					INNER JOIN ws_stylecategorydetails ON ws_stylecategorydetails.strStyle = ws_operationbreakdownheader.strStyleID AND ws_stylecategorydetails.intCategory = componentcategory.intCategoryNo
					WHERE
									ws_operationbreakdowndetails.strStyleID = '$opbdrpt_intStyleID' AND
									ws_operations.intCompId = '$component' AND
									specification.intSRNO = '$scNo'
					order by intSerial ASC";	
			
  $result4 = $db->RunQuery($SQL4);

   while($fields = mysql_fetch_array($result4, MYSQL_BOTH)) 
   { 
    $strCategory   	= $fields["strCategory"];
	$intCompId 		= $fields["intComponentId"];
    $strComponent   = $fields['strComponent'];	
    $totsmv         = $fields['dblSMV'];
	$totsmv 		= number_format($totsmv,2);
	$strOperation   = $fields['strOperationName'];  
    $intOperationID = $fields['intOperationID'];
    $intMachineTypeId = $fields['intMachineTypeId']; 
	$machine        = $fields['strMachineName']; 
    $strCategory    = $fields['strCategory'];
	$intMachineType = $fields['intMachineType']; 
	$date1        	= $fields['dtmDate'];
	$date=substr($date1,0,4)."-".substr($date1,5,2)."-".substr($date1,8,2);
	$te_totsubsmv 	+= $totsmv;
    $tottmu         = round($totsmv*$smvRatio,0);
    $tottgt         = round(60/$fields['dblSMV'],0);
	$te_totsubtmu 	+= $tottmu; 
	  
    $te_totamtTMU   += $tottmu;
    $te_totamt   += $totsmv;
	$strTeams   = $fields['strTeams'];
	
	$intOperators   = $fields['intOperators'];
	$intHelpers     = $fields['intHelpers'];
	
	$noOfOperators=$intOperators+$intHelpers;
	
	if($machine == ''){
	 $machine = 'MANUAL';
	}

    
   if($j == 0 )
   {	    
    echo "<br><table width='100%' border='0' align='center'>";
    echo "<tr align='center'>";
    echo "<td align='center' style='font-size:15px;font-weight:bold'>OPERATION BREAKDOWN SHEET</td>";
    echo "</tr>";
    echo "</table>";?>
	

	<table width='100%'  border='0' align='center'>
	<tr align='center' >
	<td width="45%">
	<table width='100%' border='3' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX  id="table1">
	<tr>
	<td class='bcgl1txt1NB'>Style No</td>
	<td class="normalfnt"><font  style='font-size: 12px;'><?php echo $opbdrpt_intStyleID ?></font></td>
	</tr>
	<tr>
	<td class='bcgl1txt1NB'>Item</td>
	<td class="normalfnt"><font  style='font-size: 12px;'></font></td>
	</tr>
	<tr>
	<td class='bcgl1txt1NB'>Team</td>
	<td class="normalfnt"><font  style='font-size: 12px;'><?php echo $strTeams ?></font></td>
	</tr>
	<tr>
	<td class='bcgl1txt1NB'>Date</td>
	<td><font  style='font-size: 12px;'></font></td>
	</tr>
	</table>
	
	</td>
	<td class='bcgl1txt1NB' width="10%"></td>
	<td width="45%">
	<table width='100%' border='3' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX  id="table2">
	<tr>
	<td class='bcgl1txt1NB' colspan="2"># Operators</td>
	<td align="right"><font  style='font-size: 12px;'><?php echo $noOfOperators ?></font></td>
	<td  class='bcgl1txt1NB' rowspan="2">TARGET PER DAY</td>
	</tr>
	<tr>
	<td class='bcgl1txt1NB'>S.M.V</td>
	<td align="right" class="normalfntRite"></td>
	<td align="right" bgcolor='#E2E2E2' ><font  style='font-size: 12px;'></font></td>
	</tr>
	<tr>
	<td class='bcgl1txt1NB' rowspan="2">Target</td>
	<td align="right" class="normalfntRite">100%</td>
	<td align="right"><font  style='font-size: 12px;'></font></td>
	<td align="right"><font  style='font-size: 12px;'></font></td>
	</tr>
	<tr>
	<td align="right" class="normalfntRite">75%</td>
	<td align="right"><font  style='font-size: 12px;'></font></td>
	<td align="right"><font  style='font-size: 12px;'></font></td>
	</tr>
	</table>
	</td></tr>
	
	<tr height="15"><td colspan="3"></td></tr>
	
	
	<?php
   
    echo "<br><table id='table3' width='100%' border='3' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX >";
    echo "<tr align='center' bgcolor='#E2E2E2'>";
    echo "<td class='normalfntBtab' align='center' width='6%'>NO</td>";
    echo "<td class='normalfntBtab' align='center' width='40%'>OPERATION</td>";
	echo "<td class='normalfntBtab' align='center' width='15%'>M\C TYPE</td>";
    echo "<td class='normalfntBtab' align='center' width='9%'>T.M.U</td>";
    echo "<td class='normalfntBtab' align='center' width='9%'>S.M.V</td>";
    echo "<td class='normalfntBtab' align='center' width='10%'>TGt</td>";
    echo "<td class='normalfntBtab' align='center' width='11%'>No.M\C Req</td>";
    echo "</tr>";   
   }
    
	#----------check for new category--------------------
    if($temp_category != $strCategory)
    {
     $new_CategoryBegining = "y";
    }
    else
    {
     $new_CategoryBegining = "n";  
    }
    $temp_category = $strCategory; 
   #--------check for new component-------------------
    if($temp_component != $strComponent)
    {
     $new_compBegining = "y";
    }
    else
    {
     $new_compBegining = "n";  
    }
    $temp_component = $strComponent; 
         
    #---------------------------[ subtotal ]------------------------------
    if($new_compBegining== "y")//new component
    {
 	 if($flg_firstyn  == "n")//existing previous component
	 {	  
	    //echo $strComponent;
		$ArraySubtotTMU=$ArraySubtotTMU.$te_totsubtmvHelp.",";
		$ArraySubtotSMV=$ArraySubtotSMV.$te_totsubsmvHelp.",";
		$te_totsubtmu = 0;
		$te_totsubsmv = 0;
		$te_totsubsmvHelp = 0;
		$te_totsubtmvHelp = 0;
     }	    
    }     
	
    if($intMachineType == "1"){ 
    $te_totsubsmv += $totsmv;
	}
	
	if($intMachineType == "0"){ 
    $te_totsubsmvHelp += $totsmv;
    $te_totsubtmvHelp += $tottmu;
	}

    if($new_CategoryBegining == "y")
    {
		echo "<tr bgcolor=\"#F0F0F0\">";
		echo "<td  align='center' ></td>";
		echo "<td class='normalfnt' align='left'><b><font  style='font-size: 10px;'>$strCategory</font></b></td>";
		echo "<td  align='center' ></td>";
		echo "<td  align='center' ></td>";
		echo "<td  align='center' ></td>";
		echo "<td  align='center' ></td>";
		echo "<td  align='center' ></td>";
		echo "</tr>"; 
		}

    if($new_compBegining== "y")
    {
		echo "<tr>";
		echo "<td  align='center' ></td>";
		echo "<td class='normalfnt' align='left'><b><font  style='font-size: 10px;'>$strComponent</font></b></td>";
		echo "<td  align='center' ></td>";
		echo "<td  align='center' ></td>";
		echo "<td  align='center' ></td>";
		echo "<td  align='center' ></td>";
		echo "<td  align='center' ></td>";
		echo "</tr>"; 
	  $ArrayCategory=$ArrayCategory.$strCategory.",";
	  $ArrayComponent=$ArrayComponent.$strComponent.",";
    }  
	
		echo "<tr>";
		echo "<td align='center' class='normalfntMid'>".($j+1)."."."</td>";   
		echo "<td align='left' class='normalfnt'>$strOperation</td>";
		echo "<td align='center' class='normalfnt'>$machine</td>";
		if($intMachineType == "1"){
		echo "<td align='right'width='' class='normalfntRite'>$tottmu</td>"; 
		echo "<td align='right' width='' class='normalfntRite'>$totsmv</td>"; 
		}
         
    if($intMachineType == "0"){
		echo "<td align='right'width='' class='normalfntRite'>$tottmu</td>"; 
		echo "<td align='right' width='' class='normalfntRite'>$totsmv</td>"; 
		}  
		echo "<td align='right'width='' class='normalfntRite'>$tottgt</td>";  
		echo "<td align='right'width='' class='normalfntRite'>0.00</td>";       
		echo "</tr>";  

     $flg_firstyn  = "n";
     $j++;    
   }//end while 
   
   }//end while
	   $ArraySubtotTMU=$ArraySubtotTMU.$te_totsubtmvHelp.",";
	   $ArraySubtotSMV=$ArraySubtotSMV.$te_totsubsmvHelp.",";
  
   echo "<tr  bgcolor='#E2E2E2'>";

   echo "<td  align='center' ></td>";
   echo"<td align='center' ><font  style='font-size: 12px;'><b>  TOTAL SMV </b></font></td>";
   echo "<td  align='center' ></td>";
   echo "<td  align='right' ><font  style='font-size: 12px;'><b>  ".number_format($te_totamtTMU,0)."</b></font></td>";
   echo "<td  align='right' ><font  style='font-size: 12px;'><b>  ".number_format($te_totamt,2)."</b></font></td>";
   echo "<td  align='right' ><font  style='font-size: 12px;'><b> </b></font></td>"; 
   echo "<td  align='right' ><font  style='font-size: 12px;'><b> </b></font></td>";
   echo"</tr>";

  }
  else
  {
   echo "<br><table width='100%' border='0'>";
   echo "<tr class='lbl'>";
   echo"<td align='center'><font  size='3'>No Records</font></td>";
   echo"</tr>";  
   echo "</table>";
  }
  /*
   echo "<br><table width='50%' border='0'>";
   echo "<tr class='lbl'>";
   echo"<td align='left' width='50%'> <font  size='3'><b>TOTAL S.M.V</font></td>";
   echo"<td align='left'> <font  size='3'><b>  ".number_format($te_totamt,2)."</b></font></td>";
   echo"</tr>";  
   echo "</table>";*/
   //	 $ArraySubtotSMV, $ArrayComponent,$ArraySubtotTMU

?>
    </table>
	</td>
  </tr>
	<tr height="15"><td colspan="3"></td></tr>
  <tr>
  <td width="50%">
<!--  Dynamic table -->
<table width='100%' border='3' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX  id="table4"> 
<tr>
<td colspan="2" width="55%" class='normalfntBtab' align='center'>Component</td>
<td width="9%" class='normalfntBtab' align='center' >TMU</td>
<td width="9%" class='normalfntBtab' align='center' >SMV</td>
</tr>

 <?php
//echo $ArraySubtotTMU;
 $temp_Cat="";
 $explodeCategory = explode(',', $ArrayCategory) ; 
 $explodeComponent = explode(',', $ArrayComponent) ; 
 $explodeCompSMVTotal = explode(',', $ArraySubtotSMV) ; 
 $explodeCompTMUTotal = explode(',', $ArraySubtotTMU) ; 
 
 
 $components = count($explodeComponent)-1;
		for ($i = 0;$i < $components;$i++)
		{
		
		if($temp_Cat!=$explodeCategory[$i])
		{
/*   echo "<tr bgcolor=\"#F0F0F0\">";
     echo "<td class='normalfnt' align='left' colspan='2'><b><font  style='font-size: 10px;'>$explodeCategory[$i]</font></b></td>";
     echo "<td class='normalfntRite'  align='right' ><b><font  style='font-size: 10px;'></font></b></td>";
     echo "<td class='normalfntRite' align='right'><b><font  style='font-size: 10px;'></font></b></td>";
     echo "</tr>"; */
		}
}		
/* echo $sql_query 	="SELECT round(sum(ws_operationbreakdowndetails.dblSMV),1) as smv,  round(sum(ws_operationbreakdowndetails.dblSMV*1667),1) as tmu
FROM ws_operationbreakdowndetails Inner Join ws_operations ON ws_operationbreakdowndetails.intOperationID = ws_operations.intOpID Inner Join components ON ws_operations.intComponent = components.intComponentId
WHERE ws_operationbreakdowndetails.strStyleID = '$opbdrpt_intStyleID' AND components.intCategory = '$category' AND components.strComponent = '$explodeComponent[$i]'
GROUP BY
ws_operationbreakdowndetails.strStyleID,
components.intComponentId";		*/
		/*	echo $sql_query 	="SELECT
ws_operationbreakdowndetails.dblSMV
FROM
ws_operationbreakdowndetails
Inner Join ws_operations ON ws_operationbreakdowndetails.intOperationID = ws_operations.intOpID
Inner Join components ON ws_operations.intComponent = components.intComponentId
WHERE
ws_operationbreakdowndetails.strStyleID =  '$opbdrpt_intStyleID' AND
components.intCategory =  '$category' AND
components.strComponent =  '$explodeComponent[$i]'";*/

//echo "xxxxxxxxxxxxxxxxx ======= ";


/**
*  Commented and Edited by suMith HarShan  2011-05-04
*  Change to load this all details according to the style No and SCNO
**/


			//intComponentId
/*$sql_query = "	SELECT
				Sum(round(ws_operationbreakdowndetails.dblSMV,2)) AS smv,
				Sum(round(ws_operationbreakdowndetails.dblSMV*1667,2)) AS tmu,
				components.strComponent
				FROM
				ws_operationbreakdowndetails
				Inner Join ws_operations ON ws_operations.intId = ws_operationbreakdowndetails.intOperationID
				Inner Join components ON components.intComponentId = ws_operations.intCompId
				WHERE ws_operationbreakdowndetails.strStyleID = '$opbdrpt_intStyleID' and components.intCategory = '".trim($_GET['category'],' ')."'
				GROUP BY ws_operations.intCompId, ws_operations.intCompCatId";*/
				
			$sql_query="SELECT
				Sum(round(ws_operationbreakdowndetails.dblSMV,2)) AS smv,
				Sum(round(ws_operationbreakdowndetails.dblSMV*1667,2)) AS tmu,
				components.strComponent
				FROM
				ws_operationbreakdowndetails
				INNER JOIN ws_operations ON ws_operations.intId = ws_operationbreakdowndetails.intOperationID
				INNER JOIN components ON components.intComponentId = ws_operations.intCompId
				INNER JOIN specification ON specification.intStyleId = ws_operationbreakdowndetails.strStyleID
				WHERE
				ws_operationbreakdowndetails.strStyleID = '$opbdrpt_intStyleID' AND
				components.intCategory = '".trim($_GET['category'],' ')."' AND
				specification.intSRNO = '".trim($_GET['scNo'],' ')."'
				GROUP BY ws_operations.intCompId, ws_operations.intCompCatId";	
				
			$result   = $db->RunQuery($sql_query);
            $rowCount = mysql_num_rows($result);
			if($rowCount>0)
			{
				?>

                <?php
				while($row=mysql_fetch_array($result))	
				{
				$name = $row['strComponent'];
				$smv  = $row["smv"];
				$smv2 = number_format($smv,2);
				$tmu  = round($row["tmu"],0);
					
				 echo "<tr>";
				 echo "<td class='normalfnt' align='left' colspan='2'><b><font  style='font-size: 10px;'>$name</font></b></td>";
				 echo "<td class='normalfntRite'  align='right' ><b><font  style='font-size: 10px;'>$tmu</font></b></td>";
				 echo "<td class='normalfntRite' align='right'><b><font  style='font-size: 10px;'>$smv2</font></b></td>";
				 echo "</tr>"; 
			 //$temp_Cat=$explodeCategory[$i];
			     }
			}
  ?>
  
  </table>
  </td>
  <td></td>
  </tr>
  
  </table>
  
  <script type="text/javascript">
   // if(document.getElementById('table1').tBodies[0]!='')
	//{
	var tbl1 = document.getElementById('table1');	
		tbl1.rows[1].cells[1].childNodes[0].innerHTML='<?php echo $strCategory; ?>';
		tbl1.rows[3].cells[1].childNodes[0].innerHTML='<?php echo $date; ?>';
		
	var tbl2 = document.getElementById("table2");	
		tbl2.rows[1].cells[2].childNodes[0].innerHTML=<?php echo round($te_totamt,2); ?>;
		tbl2.rows[2].cells[2].childNodes[0].innerHTML=<?php echo round(60*$noOfOperators/$te_totamt,0); ?>;
		tbl2.rows[3].cells[1].childNodes[0].innerHTML=<?php echo round(60*$noOfOperators*0.75/$te_totamt,0); ?>;
		tbl2.rows[2].cells[3].childNodes[0].innerHTML=<?php echo round(60*$noOfOperators*1*$hoursPerDay/$te_totamt,0); ?>;
		tbl2.rows[3].cells[2].childNodes[0].innerHTML=<?php echo round(60*$noOfOperators*0.75*$hoursPerDay/$te_totamt,0); ?>;
		
		
		
	
	var totNoMacReq=0;	
	var totSMV ='<?php echo $te_totamt; ?>';
	//alert(totSMV);
	var operators ='<?php echo $noOfOperators; ?>';

	var tbl3 = document.getElementById("table3");	
	for ( var loop = 1 ;loop < tbl3.rows.length-1 ; loop ++ )
	{
	if(tbl3.rows[loop].cells[4].innerHTML!=''){
			var smv=parseFloat(tbl3.rows[loop].cells[4].innerHTML);
			//alert(tbl3.rows.length);
			//alert(tbl3.rows[8].cells[4].innerHTML);
			
			var noMacReq1=smv*operators/totSMV;
			noMacReq=Math.round(noMacReq1*100)/100;
			noMacReq=noMacReq.toFixed(2);
		
			tbl3.rows[loop].cells[6].innerHTML=noMacReq;
			totNoMacReq=parseFloat(totNoMacReq)+parseFloat(noMacReq);
			totNoMacReq=Math.round(totNoMacReq*100)/100;
			}
	}
tbl3.rows[tbl3.rows.length-1].cells[6].childNodes[0].childNodes[0].innerHTML=totNoMacReq;

	//}
</script>	

</body>
</html>
