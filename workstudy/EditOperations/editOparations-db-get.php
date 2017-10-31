
<?php

//**************Created by suMitH HarShan 2011-04-29*************

include "../../Connector.php";

$id=$_GET['id'];

//***************************************load components relevent component catagory*****************************
if($id=='loadComponents')
{
	$intCatId = $_GET['intCatId'];
	if($intCatId!='')
		return loadcomboDetails("SELECT components.intComponentId, components.strComponent FROM components WHERE components.intCategory =  '$intCatId'");
	else
		return loadcomboDetails("SELECT components.intComponentId, components.strComponent FROM components");
}



//*************************load details as a table to the grid, relevent component catagory********************
if($id=='loadComponentsDetails')
{
	$intCataId = $_GET['intCataId'];	
	
	$ResponseXML ="";
		 $ResponseXML .= "<table style=\"width:600px\" id=\"tbloperation\" class=\"thetable\" border=\"1\" cellspacing=\"1\">
        						<caption>
        						Operations Details
</caption>
					<thead>
                    <tr>
								<th width=\"20\">Edit</th>
								<th width=\"20\">Del</th>
								<th width=\"100\">Component Cat.</th>
								<th width=\"108\">Component</th>
								<th width=\"90\">Operation Code</th>
                                <th width=\"160\">Operation</th>
                                <th width=\"10\">Active</th>
					</tr>
                    </thead>			 		
		    <tbody>";
				
	$SQL2="SELECT
				ws_operations.intId,
				ws_operations.strOperationCode,
				ws_operations.intStatus,
				ws_operations.strOperationName,
				componentcategory.strCategory,
				components.strComponent,
                components.intComponentId,
				ws_operations.intCompCatId
				FROM
				ws_operations
				INNER JOIN componentcategory ON componentcategory.intCategoryNo = ws_operations.intCompCatId
				INNER JOIN components ON components.intComponentId = ws_operations.intCompId
				WHERE
				ws_operations.intCompCatId='$intCataId'
				ORDER BY
				ws_operations.strOperationCode ASC";		
			$result2 = $db->RunQuery($SQL2);	 
			$i=0;
			
			while($row2 = mysql_fetch_array($result2))
			{	
			//create dynamically component details grid
			
			 $ResponseXML.="<tr id=\"".$row2["intId"]."\" onclick=\"rowclickColorChangetbl()\">
			 <td><img src=\"../../images/edit.png\" name=\"butEdit\" class=\"mouseover\" id=\"butEdit\" onClick=\"editRowOperation('".$row2["intId"]."','".$row2["intComponentId"]."','".$row2["strOperationCode"]."','".$row2["strOperationName"]."','".$row2["intStatus"]."','".$row2["intCompCatId"]."');\"/></td>
					<td><img src=\"../../images/deletered.png\" name=\"butDel\" width=\"12\" class=\"mouseover\" id=\"butDel\" onClick=\"deleteRowOperation('".$row2["intId"]."');\"/></td>
					<td>".$row2["strCategory"]."</td>
					<td>".$row2["strComponent"]."</td>
					<td>".$row2["strOperationCode"]."</td>
                    <td>".$row2["strOperationName"]."</td>
					<td>";
            if($row2["intStatus"]==1)
			{
				$ResponseXML .="<input type=\"checkbox\" checked=\"checked\" disabled=\"disabled\" class=\"txtbox\" /></td>";	
			} 
			
			else
			{
				$ResponseXML .="<input type=\"checkbox\" disabled=\"disabled\" class=\"txtbox\" /></td>";
			}					
				
			$ResponseXML .="</tr>";
			
		}	//end of the while loop
					 
	$ResponseXML .= "</tbody></table>";
	echo $ResponseXML;
	
 }





//*****************************load Operations relevent component catagory and component*******************************
if($id=='loadOperations')
{
	$ComponentCatagoryID = $_GET['ComponentCatagory'];
	$ComponentID		 = $_GET['Component'];
	
	
	$ResponseXML ="";
		 $ResponseXML .= "<table style=\"width:600px\" id=\"tbloperation\" class=\"thetable\" border=\"1\" cellspacing=\"1\">
        						<caption>
        						Operations Details
</caption>
					<thead>
                    <tr>
								<th width=\"20\">Edit</th>
								<th width=\"20\">Del</th>
								<th width=\"100\">Component Cat.</th>
								<th width=\"108\">Component</th>
								<th width=\"90\">Operation Code</th>
                                <th width=\"160\">Operation</th>
                                <th width=\"10\">Active</th>
					</tr>
                    </thead>			 		
		    <tbody>";
				
	$SQL2="SELECT
				ws_operations.intId,
				ws_operations.strOperationCode,
				ws_operations.intStatus,
				ws_operations.strOperationName,
				componentcategory.strCategory,
				components.strComponent,
				components.intComponentId,
				ws_operations.intCompCatId
				FROM
				ws_operations
				INNER JOIN componentcategory ON componentcategory.intCategoryNo = ws_operations.intCompCatId
				INNER JOIN components ON components.intComponentId = ws_operations.intCompId
				WHERE
				ws_operations.intCompCatId='$ComponentCatagoryID' AND
				ws_operations.intCompId='$ComponentID'
				ORDER BY
				ws_operations.strOperationCode ASC";		
			$result2 = $db->RunQuery($SQL2);	 
			$i=0;
			
			while($row2 = mysql_fetch_array($result2))
			{	
			//create dynamically machine details grid
			
			 $ResponseXML.="<tr id=\"".$row2["intId"]."\" onclick=\"rowclickColorChangetbl()\">
			 <td><img src=\"../../images/edit.png\" name=\"butEdit\" class=\"mouseover\" id=\"butEdit\" onClick=\"editRowOperation('".$row2["intId"]."','".$row2["intComponentId"]."','".$row2["strOperationCode"]."','".$row2["strOperationName"]."','".$row2["intStatus"]."','".$row2["intCompCatId"]."');\"/></td>
					<td><img src=\"../../images/deletered.png\" name=\"butDel\" width=\"12\" class=\"mouseover\" id=\"butDel\" onClick=\"deleteRowOperation('".$row2["intId"]."');\"/></td>
					<td>".$row2["strCategory"]."</td>
					<td>".$row2["strComponent"]."</td>
					<td>".$row2["strOperationCode"]."</td>
                    <td>".$row2["strOperationName"]."</td>
					<td>";
            if($row2["intStatus"]==1)
			{
				$ResponseXML .="<input type=\"checkbox\" checked=\"checked\" disabled=\"disabled\" class=\"txtbox\" /></td>";	
			} 
			
			else
			{
				$ResponseXML .="<input type=\"checkbox\" disabled=\"disabled\" class=\"txtbox\" /></td>";
			}					
				
			$ResponseXML .="</tr>";
			
		}	//end of the while loop
					 
	$ResponseXML .= "</tbody></table>";
	echo $ResponseXML;
	
 }
 
else if($id=="loadComponentCat")
{
	$cmbProcessId=$_GET["cmbProcessId"];
	//$SQL="SELECT strBuyerPONO from style_buyerponos where strStyleId='$strStyleId'";
	 $SQL="SELECT distinct
			componentcategory.strCategory,
			componentcategory.intCategoryNo
			FROM
			components
			left Join componentcategory ON components.intCategory = componentcategory.intCategoryNo
			left Join ws_processes ON components.intProcessId = ws_processes.intProcessId ";
			
			if($cmbProcessId != ""){
			$SQL .= " where ws_processes.intProcessId='$cmbProcessId'";
			}
	
				$result = $db->RunQuery($SQL);
				$ComboString= "<option value=\"\"></option>" ;
				while($row = mysql_fetch_array($result))
				{
					$ComboString .= "<option value=\"". $row["intCategoryNo"] ."\">" . $row["strCategory"] ."</option>" ;
				}
				echo $ComboString;
} 






//************************************ COMMON COMBO LOAD ***********************************************
function loadcomboDetails($sql)
{
	global $db;
	$result = $db->RunQuery($sql);
	$value = '<option value="0"></option>';
	while($row = mysql_fetch_array($result))
	{
		$id = $row[0];
		$name= $row[1];
		$value.="<option value=\"$id\">$name</option>";
	}
	 
	 echo $value;
}

?>