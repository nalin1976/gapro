<?php
	session_start();
	$backwardseperator = "../../";
	include $backwardseperator.'Connector.php';
	
	header('Content-Type: text/xml'); 
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$company_id = $_SESSION['FactoryID'];
	
##############################################################
/*return_queryStatus() execute the sql query that's passed in
  and if the query fails it passes a value of 0 if it's a succ-
  -ess it passes a 1.
  @$SQL: the sql string that is executed on the data baseserver.
*/

function return_queryStatus($SQL){
	global $db;

	if($db-> RunQuery($SQL))
			$passing_value = 1;
		else
			$passing_value = 0;
	  $ResponseXML="<NextQuery><![CDATA[" . $passing_value . "]]></NextQuery>";
	  return $ResponseXML;	
}
##############################################################################################

function dataBaseReverse($db,$current_sampleNo,$company_id){
	global $company_id;
	global $db;
	$current_sampleNo;
	
	$sql_reverse1="DELETE FROM samplerequestsizes where intSampleNo =$current_sampleNo ;";
	$sql_reverse2="DELETE FROM samplerequestdetails where intSampleNo =$current_sampleNo;";
	$sql_reverse3="DELETE FROM samplerequestheader where intSampleNo =$current_sampleNo;";
	// commented basedon the review made by Line Manager.
	//$sql_reverse4="UPDATE syscontrol SET dblSampleNo= $current_sampleNo WHERE  intCompanyID = '$company_id';";
	

	$db-> RunQuery($sql_reverse1);
	$db-> RunQuery($sql_reverse2);
	$db-> RunQuery($sql_reverse3);
	//$db-> RunQuery($sql_reverse4);
	
}

##############################################################################################
	
	$id =$_GET["id"];
	$stylename=$_GET["stylename"];
	if($id=="loadOrderNo")
{
  $SQL="SELECT * FROM orders WHERE strStyle='$stylename'";

$result = $db->RunQuery($SQL);	
	$html = "<option></option>";			 
	while($row=mysql_fetch_array($result))
	{
		$html .= "<option value=\"".$row['intStyleId']."\">".$row['strOrderNo']."</option>";
		
	}
		echo $html;
}


//Loading the CheckBoxes

else if($id=='loadCheckBox1')
{
$SQL="SELECT * FROM  samplerequestheader WHERE intStyleId='$styleno'";
$result = $db->RunQuery($SQL);	
	$html="";
	while($row=mysql_fetch_array($result))
	{
	$html .="".$row['intOriginalSample']."";
	}
	echo $html;
}

else if($id=='loadCheckBox2')
{
$SQL="SELECT * FROM  samplerequestheader WHERE intStyleId='$styleno'";
$result = $db->RunQuery($SQL);	
	$html="";
	while($row=mysql_fetch_array($result))
	{
	$html .="".$row['intFabric']."";
	}
	echo $html;
}

else if($id=='loadCheckBox3')
{
$SQL="SELECT * FROM  samplerequestheader WHERE intStyleId='$styleno'";
$result = $db->RunQuery($SQL);	
	$html="";
	while($row=mysql_fetch_array($result))
	{
	$html .="".$row['intAccessories']."";
	}
	echo $html;
}

else if($id == "buyerUpdate"){
		$StyleNo = $_GET["StyleNo"];
	  	$SQL = "SELECT BYR.strName FROM orders AS ODR Inner Join buyers AS BYR ON ODR.intBuyerID = BYR.intBuyerID WHERE ODR.intStyleid = '$StyleNo';";
		
		$result = $db-> RunQuery($SQL);
		$row=mysql_fetch_array($result);
		$ResponseXML .= "<strName><![CDATA[" . $row["strName"]  . "]]></strName>\n";

		echo $ResponseXML;
	}
	else if($id == "gridLoad"){
###########################################################################################
# if the id = gridLoad , the system is trying to load sample type field of the grid       #
# rest of the fields respectively required date no of peaces and colour kept empty.       #
###########################################################################################
			
		$SQL = "SELECT sampletypes.intSampleId,sampletypes.strDescription FROM sampletypes;";
		$ResponseXML .="<Sampletypes>";  #generating the XML opening tag where the out  put data is held
		$result1 = $db-> RunQuery($SQL);
		$count=0;
		while($row = mysql_fetch_array($result1))
		{
			# the XML tags will be created for each data value in the column 
			# eg: <intSampleId0>,<intSampleId1>,<intSampleId2>..etc.
			# the strDescription is passed to browser as the value of the XML tag.
			
			$ResponseXML .= "<intSampleId{$count}><![CDATA[" . $row["strDescription"]  . "]]></intSampleId{$count}>\n";
			$count ++;
		}
		
		$ResponseXML .="</Sampletypes>"; 
		echo $ResponseXML;
	}
	else if($id == "samplNoSet"){
################################################################
# retrieving sample number from the database and increment the #
# sample number in the data base by 1.                         #
################################################################
	
		//$company_id = $_GET["company_id"];
		
		$sql_cmpId="SELECT syscontrol.dblSampleNo  FROM syscontrol WHERE intCompanyID ='$company_id';";
		$result9 = $db-> RunQuery($sql_cmpId);
		$row = mysql_fetch_array($result9);
		$current_smplNo=$row["dblSampleNo"];
		// increment the dblSampleNo in syscontrol by 1
		$sql_next__smplNo ="UPDATE syscontrol SET dblSampleNo=dblSampleNo+1 WHERE  intCompanyID = '$company_id';";
		$db-> RunQuery($sql_next__smplNo);
		echo $ResponseXML="<CurrentSampleNo><![CDATA[" . $current_smplNo . "]]></CurrentSampleNo>"; 
		 
	}
	else if($id == "samplerequestsizes"){
#########################################################
# SAVING DATA TO SAMPLE REQUISITION SIZES TABLE			#						
#########################################################
	
	 	$sample_type=$_GET["sample_type"];
		$style_no=$_GET["style_no"];
		$sample_no=$_GET["sample_no"]; 
		$smpl_req_date=$_GET["smpl_req_date"];
		
		$smpl_pcs=$_GET["smpl_pcs"];
		$colour=$_GET["colour"];
		$smpl_size=$_GET["smpl_size"];
		
		$sql_tmp1="SELECT sampletypes.intSampleId FROM sampletypes WHERE sampletypes.strDescription ='$sample_type';";
		$result2= $db-> RunQuery($sql_tmp1);	
		$row = mysql_fetch_array($result2);
		$intSampleId = $row["intSampleId"];
		
				
		$sql_tmp2="SELECT orders.intStyleId FROM orders WHERE orders.strStyle='$style_no';";
		$result3= $db-> RunQuery($sql_tmp2);
		$row = mysql_fetch_array($result3);
		$intStyleId = $row["intStyleId"]; 
		
				
		$SQL="INSERT INTO samplerequestsizes(intStyleID,intSampleNo,intSampleType,strColor,strSize,dblQty)
			VALUES('$intStyleId','$sample_no','$intSampleId','$colour','$smpl_size','$smpl_pcs'); ";
		
		//echo $SQL;
		$ResponseXML=return_queryStatus($SQL);
		
		if( $ResponseXML == '<NextQuery><![CDATA[0]]></NextQuery>'){
			dataBaseReverse($db,$sample_no,$company_id);
		 }
		echo $ResponseXML;
		
	}
	else if($id == "samplerequestheader"){	
#########################################################
# SAVING DATA TO SAMPLE REQUEST HEADER TABLE		    #						
#########################################################

	$userId = $_SESSION['UserID'];		
	$date_requested=$_GET["date_requested"];	
	$original_sample=$_GET["original_sample"];
	$fabric=$_GET["fabric"];
	$date_fabric_requested=$_GET["date_fabric_requested"];
	$accessories=$_GET["accessories"];
	$date_access_requested=$_GET["date_access_requested"];//--------
	$sample_no=$_GET["sample_no"];
	$style_no=$_GET["style_no"];
	
	$sql_tmp2="SELECT orders.intStyleId FROM orders WHERE orders.strStyle='$style_no';";
		
	$result5= $db-> RunQuery($sql_tmp2);
	while($row = mysql_fetch_array($result5)){
	 $intStyleId = $row["intStyleId"]; 	
	}
	
	// converting the boolean values to 1 and 0 .
	($fabric == 'true' )?$fabric = 1: $fabric = 0;
	($original_sample == 'true' )?$original_sample = 1: $original_sample = 0;
	($accessories == 'true' )?$accessories = 1: $accessories = 0;


	$SQL="INSERT INTO samplerequestheader (intStyleId,intSampleNo,
		dtmDateRequest,intUserId,intOriginalSample,intFabric,intAccessories,dtmFabRecDate,dtmAccRecDate,intStatus)
		VALUES('$intStyleId','$sample_no','$date_requested','$userId','$original_sample',
		'$fabric','$accessories','$date_fabric_requested','$date_access_requested','1');";
	
	$ResponseXML=return_queryStatus($SQL);
	if( $ResponseXML == '<NextQuery><![CDATA[0]]></NextQuery>'){
		dataBaseReverse($db,$sample_no,$company_id);
	 }
	echo $ResponseXML;
}
else if($id =="samplerequestdetails"){
#########################################################
# SAVING DATA TO SAMPLE REQUEST DETAILS TABLE     		#						
#########################################################

	$sample_type=$_GET["sample_type"];
	$smpl_req_date=$_GET["smpl_req_date"];
	$sample_no=$_GET["sample_no"];
	$style_no=$_GET["style_no"];
	
	// deriving intStyleId field
	$sql_tmp3="SELECT orders.intStyleId FROM orders WHERE orders.strStyle='$style_no';";
	
	$result7= $db-> RunQuery($sql_tmp3);
	while($row = mysql_fetch_array($result7)){
	 $intStyleId = $row["intStyleId"]; 	
	}
	
	// deriving intSampleType field
	$sql_tmp4="SELECT sampletypes.intSampleId FROM sampletypes WHERE sampletypes.strDescription ='$sample_type';";
	$result8= $db-> RunQuery($sql_tmp4);	
		
	while($row = mysql_fetch_array($result8)){
	  $intSampleType = $row["intSampleId"];
	 }
	 
	 $SQL = "INSERT INTO samplerequestdetails (intStyleID,intSampleNo,intSampleType,dtmDateRequired)
			VALUES ('$intStyleId','$sample_no','$intSampleType','$smpl_req_date');";
	
	 $ResponseXML=return_queryStatus($SQL);
	 if( $ResponseXML == '<NextQuery><![CDATA[0]]></NextQuery>'){
		dataBaseReverse($db,$sample_no,$company_id);
	 }
	 echo $ResponseXML;
 }


?>