<?php
include "../../../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

if($RequestType=="LoadSubcat")
{
	$mainId = $_GET["mainCat"];

	$ResponseXML = "<XMLloadMainCategory>\n";
	
	$sql="SELECT MSC.intSubCatNo, MSC.StrCatName FROM matsubcategory MSC WHERE MSC.intCatNo<>''";
	
	if($mainId!="")
		$sql .=" AND MSC.intCatNo = '$mainId'";
		
	$sql .=" order by MSC.StrCatName";
	$result=$db->RunQuery($sql);
		$str .= "<option value=\"". "" ."\">".""."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$str .= "<option value=\"". $row["intSubCatNo"] ."\">".$row["StrCatName"]."</option>\n";	
	}
	
	$ResponseXML .= "<SubCat><![CDATA[" . $str . "]]></SubCat>\n";
	$ResponseXML .= "</XMLloadMainCategory>\n";
	echo $ResponseXML;
}

if($RequestType=="confirmItem")
{
	$itemID = $_GET["itemID"];
	$ItemName = $_GET["itemName"];
	
	$itemExists = false;
	$sql = "SELECT strItemDescription FROM matitemlist WHERE strItemDescription = '$ItemName'";
	
	$result = $db->RunQuery($sql);	 
	 while($row = mysql_fetch_array($result))
  	 {
  	 	$itemExists = true;
  	 	break;
  	 }
	
	if (!$itemExists)
	{
		$sql = "insert into matitemlist 
	(strItemCode,strItemDescription,	intMainCatID, intSubCatID, strUnit, sngWastage,
	dblUnitPrice, strCoordinator, intStatus, strUserId, dtmDate, strPurchaseUnit, dblLastPrice
	)
	select  strItemCode,strItemDescription,	intMainCatID, intSubCatID, strUnit, sngWastage,
	dblUnitPrice, strCoordinator, intStatus, strUserId, dtmDate, strPurchaseUnit, dblLastPrice
	from matitemlist_temp where intItemSerial='$itemID'";

		$itemSerialNo = $db->AutoIncrementExecuteQuery($sql);
	}
	
	$ResponseXML .= "<RequestDetails>\n";
	if ($itemExists)
	{
		$ResponseXML .= "<Result><![CDATA[false]]></Result>\n";   
		$ResponseXML .= "<Message><![CDATA[The item name already exists.]]></Message>\n";
	}
	else
	{
		
		
		//get property value details from matitem_temp
		
		$sqlItemProp = "SELECT * FROM matpropertyvaluesinitems_temp WHERE intMatItemSerial='$itemID' ";
		$resultProp = $db->RunQuery($sqlItemProp);	
		
		 while($rowp = mysql_fetch_array($resultProp))
		 {
		 		$propID = $rowp["intMatPropertyId"];
				$propValue = $rowp["intMatPropertyValueId"];
				$displaystr = $rowp["strDisplayString"];
				$intBefore = $rowp["intBefore"];
				$intOrder = $rowp["intOrder"];
				
				$propValue_up = strtoupper($propValue);
				
				$sqlPropVal = " SELECT intSubPropertyNo,strSubPropertyCode,strSubPropertyName
								FROM matpropertyvalues
								WHERE UPPER(strSubPropertyName)='$propValue_up'";
				$resPropertyVal = $db->RunQuery($sqlPropVal);
				
				$recCount = mysql_num_rows($resPropertyVal);
				//echo $recCount.' '.$itemID;
				if($recCount == 0)
				{
					$sqlInsertPropVal = "insert into matpropertyvalues 
								(strSubPropertyCode, 
								strSubPropertyName, 
								intStatus, 
								strUserID, 
								dtmDate
								)
								values
								('$propID', 
								'$propValue', 
								1, 
								'$userId', 
								now()
								)";
								
						$res = $db->RunQuery($sqlInsertPropVal);
						
						
				}
				
				$sqlmatPropValID = "select intSubPropertyNo from matpropertyvalues where strSubPropertyName='$propValue'";
				//echo $sqlmatPropValID;
				$resPropValID = $db->RunQuery($sqlmatPropValID);
				$rowPropValID = mysql_fetch_array($resPropValID);
				
				$propValID = $rowPropValID["intSubPropertyNo"];
				
				 $SQL_checkvalue="SELECT matsubpropertyassign.intSubPropertyid FROM matsubpropertyassign WHERE (((matsubpropertyassign.intSubPropertyid)=".$propValID.") AND ((matsubpropertyassign.intPropertyId)=".$propID."));";
   
  //echo $SQL_checkvalue;
        $resultVal = $db->RunQuery($SQL_checkvalue);	
		if($row = mysql_fetch_array($resultVal))
			{
				
				//echo  $SQL_checkvalue;
			}
			else
			{	
				$intSubPropertyNo=0;
				
				$SQL="insert into matsubpropertyassign(intPropertyId,intSubPropertyid) values(".$propID.",".$propValID.")";
			    $db->ExecuteQuery($SQL);
			}
				
			//insert data to matpropertyvaluesinitems
			$sqlInsertMatPropValAssign = "insert into matpropertyvaluesinitems 
							(intMatItemSerial, 
							intMatPropertyId, 
							intMatPropertyValueId, 
							strDisplayString, 
							intBefore, 
							intOrder
							)
							values
							('$itemSerialNo', 
							'$propID', 
							'$propValID', 
							'$displaystr', 
							'$intBefore', 
							'$intOrder'
							)"	;
							
							 $db->ExecuteQuery($sqlInsertMatPropValAssign);
		 }
		//delete matitem temp data & 
		deleteItemtempData($itemID);
		deleteItemPropValueAssignData($itemID);
		
		$ResponseXML .= "<Result><![CDATA[true]]></Result>\n";   
		/*$ResponseXML .= "<Message><![CDATA[The new item added successfully.\nItem Code : $ItemCode \nItem Name :$ItemName]]></Message>\n";*/
	}
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}
if($RequestType=="loadPendingItemReq")
{
	$mainCatgory = $_GET["mainCatgory"];
	$subCategory = $_GET["subCategory"];
	$description = $_GET["description"];

	$sql = " SELECT intItemSerial,strItemDescription,strUnit,dblLastPrice
							from matitemlist_temp 
							where intStatus=1 ";
						if($mainCatgory !=""){
		$sql .= " and intMainCatID='$mainCatgory'";
		}
			
	if($subCategory !=""){
		$sql .= " and intSubCatID='$subCategory'";
		}
	
	if($description !=""){
		$sql .= " and strItemDescription like'%$description%'";
		
		$sql .= " Order By strItemDescription";
		}

	$result = $db->RunQuery($sql);
	
	$rowCount	= mysql_num_rows($result);
	
	$str='';
	while($row = mysql_fetch_array($result))
	{
		
		$itemSerial	= $row["intItemSerial"];
		$str .= " <tr bgcolor=\"#FFFFFF\" class=\"normalfnt\">
                    <td align=\"center\" height=\"20\"><input type=\"checkbox\" name=\"chkitem\" id=\"chkitem\"></td>
                    <td id='$itemSerial'>". $row["strItemDescription"] ."</td>
                    <td>". $row["strUnit"] ."</td>
                    <td>". $row["dblLastPrice"] ."</td>
                  </tr>";
				  
	}
	$ResponseXML = '';
	$ResponseXML = "<XMLItemList>\n";
	$ResponseXML .= "<pendingItem><![CDATA[" . $str . "]]></pendingItem>\n";
	$ResponseXML .= "</XMLItemList>\n";
	echo $ResponseXML;
}
function deleteItemtempData($itemID)
{
	global $db;
	
	$sql = " delete from matitemlist_temp 
	where
	intItemSerial = '$itemID' ";
	 
	 $db->RunQuery($sql);
}

function deleteItemPropValueAssignData($itemID)
{
	global $db;
	
	$sql = "delete from matpropertyvaluesinitems_temp 
	where
	intMatItemSerial = '$itemID' ";
	
	 $db->RunQuery($sql);
}
?>