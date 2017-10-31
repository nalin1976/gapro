<?php
include('../../Connector.php');
	
	$strgarment=trim($_GET["q"]);
	$cboSearch=trim($_GET["cboSearch"]);
	$strProdDesc=trim($_GET["txtaRemarks"]);
	$strProductName=trim($_GET["txtGarmentName"]);	
	$intStatus=trim($_GET["intStatus"]);
	 
if($strgarment=="New")
{
    $sql_insert="insert into productcategory ( strCatName, strRemarks, intStatus)
  	values
	('$strProductName',	 
	 '$strProdDesc',
	 '$intStatus');"; 
    $db->ExecuteQuery($sql_insert);
    // echo($sql_insert);
    echo "Saved successfully.";
    
}

else if($strgarment=="Save")
{	
    $cboSearch=trim($_GET["cboSearch"]);
	$strProdDesc=trim($_GET["txtaRemarks"]);
	$strProductName=trim($_GET["txtGarmentName"]);	
	$intStatus=trim($_GET["intStatus"]);
	 
    $SQL_Update="UPDATE productcategory SET strRemarks='$strProdDesc',
                                            strCatName='$strProductName',
								 		    intStatus='$intStatus'
						                    where intCatId='$cboSearch'";  
	$db->ExecuteQuery($SQL_Update);
	//echo($SQL_Update);
	echo "Updated successfully.";	
}
else if($strgarment=="Delete")
{	
    $cboSearch=$_GET["cboSearch"];  
	$SQL="delete from productcategory where intCatId='$cboSearch'";
	$db->ExecuteQuery($SQL);
	//echo($SQL);
	echo "Deleted successfully.";
 }
else if($strgarment=="LoadDetails")
{
	$SQL="SELECT intCatId ,strCatName FROM productcategory order by strCatName ASC";
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	    {
	echo "<option value=\"". $row["intCatId"] ."\">" . $row["strCatName"] ."</option>" ;
	    }
	
 }
?>