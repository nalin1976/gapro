<?php
session_start();
include "../../Connector.php";
//$id="loadGrnHeader";
$id=$_GET["id"];

$dtmDate       = date("Y/m/d");
$userID        = $_SESSION["UserID"];
$companyID     = $_SESSION["CompanyID"];


$uts['yesterday'] = strtotime( '-20 days' ); // or, strtotime( 'yesterday' );
$echoa = date( 'Y-m-d', $uts['yesterday'] );

if($id=="loadHeaderInfo")
{
		$cboPoNo=$_GET["cboPoNo"];
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<loadHeaderInfo>";
		

	/*$SQL = "SELECT distinct orders.intStyleId,orders.strDescription,orders.strOrderNo,
	        matitemlist.strItemDescription,c.strName,pd.strColor, c.intCompanyID,orders.strStyle
	        FROM orders
		    INNER JOIN orderdetails ON orders.intStyleId = orderdetails.intStyleId 
			--  AND orders.strOrderNo =  orderdetails.strOrderNo
		    INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial
		    INNER JOIN productionfinishedgoodsreceiveheader pr ON pr.intStyleNo = orders.intStyleId
		    inner join companies c on c.intCompanyID = pr.strTComCode
		    inner join productionfinishedgoodsreceivedetails pd on pd.dblTransInNo=pr.dblTransInNo
		    WHERE orders.intStyleId='$cboPoNo' AND orderdetails.intMainFabricStatus=1
		    order BY orders.strDescription ";*/
				
/*		$SQL="SELECT DISTINCT
				orders.intStyleId,
				orders.strDescription,
				orders.strOrderNo,
				matitemlist.strItemDescription,
				orders.strStyle,
				orders.productSubCategory,
				wst.strColor,
				companies.strName,
				matitemlist.intItemSerial,
				companies.intCompanyID
				FROM
				orders
				Inner Join orderdetails ON orders.intStyleId = orderdetails.intStyleId
				Inner Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial
				Inner Join was_stocktransactions wst ON wst.intStyleId = orders.intStyleId
				Inner Join companies ON wst.intFromFactory = companies.intCompanyID
				WHERE orders.intStyleId='$cboPoNo' AND orderdetails.intMainFabricStatus=1
				order BY orders.strDescription;";*/
	
		$SQL="SELECT DISTINCT
				orders.strOrderNo,
				orders.intStyleId,
				orders.strStyle,
				orders.productSubCategory,
				matitemlist.strItemDescription,
				productionbundleheader.strColor,
				productiongpheader.intTofactory,
				companies.intCompanyID,
				companies.strName,
				orders.strDescription
				FROM
				orders
				INNER JOIN orderdetails ON orders.intStyleId = orderdetails.intStyleId
				INNER JOIN matitemlist ON matitemlist.intItemSerial = orderdetails.intMatDetailID
				INNER JOIN productiongpheader ON orderdetails.intStyleId = productiongpheader.intStyleId
				INNER JOIN productionbundleheader ON productionbundleheader.intStyleId = orders.intStyleId
				INNER JOIN companies ON productiongpheader.intTofactory = companies.intCompanyID
				where  orders.intStyleId='$cboPoNo' AND 
				orderdetails.intMainFabricStatus='1'
				order BY orders.strDescription";
			//echo $SQL;	
				
	$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
			 $ResponseXML .= "<intStyleId><![CDATA[" . trim($row["intStyleId"])  . "]]></intStyleId>\n";
    		 $ResponseXML .= "<stylename><![CDATA[" . trim($row["strDescription"])  . "]]></stylename>\n";	
			 $ResponseXML .= "<color><![CDATA[" . trim($row["strColor"])  . "]]></color>\n";	
			 $ResponseXML .= "<styleno><![CDATA[" . trim($row["strStyle"])  . "]]></styleno>\n"; 
			 $ResponseXML .= "<fabric><![CDATA[" . trim($row["strItemDescription"])  . "]]></fabric>\n";
			 $ResponseXML .= "<company><![CDATA[" . trim($row["strName"])  . "]]></company>\n";
			 $ResponseXML .= "<companyId><![CDATA[" . trim($row["intCompanyID"])  . "]]></companyId>\n";
			 $ResponseXML .= "<garment><![CDATA[" . trim($row["productSubCategory"])  . "]]></garment>\n";
			 $ResponseXML .= "<Income><![CDATA[".getWashPrice($row["strColor"],$row["productSubCategory"],$row["strStyle"],$row["intItemSerial"])."]]></Income>\n";
			}
			$ResponseXML .= "</loadHeaderInfo>";
			
		echo $ResponseXML;
}

if($id=="loadDryProcess")
{

		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<loadDryProcess>";
		

		$SQL = "SELECT DISTINCT intSerialNo,strDescription FROM was_dryprocess WHERE intStatus='1' AND strCategory='DP' ORDER BY strDescription ASC";
				

		$result = $db->RunQuery($SQL);
		//echo $SQL;

			while($row = mysql_fetch_array($result))
			{
    		 $ResponseXML .= "<intSerialNo><![CDATA[" . trim($row["intSerialNo"])  . "]]></intSerialNo>\n";	
			 $ResponseXML .= "<strDescription><![CDATA[" . trim($row["strDescription"])  . "]]></strDescription>\n"; 
			}
			$ResponseXML .= "</loadDryProcess>";
			
		echo $ResponseXML;
}



if($id=="loadDetails")
{

		$cboPoNo		= $_GET["cboPoNo"];
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<loadDetails>";
		

		$SQL ="SELECT DISTINCT was_dryprocess.intSerialNo,was_dryprocess.strDescription,was_washpricedetails.intDryProssId,
		       was_washpricedetails.intStyleId,was_washpricedetails.dblWashPrice	
		       FROM was_dryprocess LEFT JOIN was_washpricedetails ON was_dryprocess.intSerialNo=was_washpricedetails.intDryProssId
			   WHERE  was_washpricedetails.intStyleId='$cboPoNo'
		       ORDER BY strDescription";
			   
		/*$SQL2="SELECT DISTINCT was_dryprocess.intSerialNo,was_dryprocess.strDescription,was_washpricedetails.intDryProssId,
		      was_washpricedetails.dblWashPrice	
		      FROM was_dryprocess LEFT JOIN was_washpricedetails ON was_dryprocess.intSerialNo=was_washpricedetails.intDryProssId
		      WHERE intSerialNo  NOT IN ( SELECT was_washpricedetails.intDryProssId
              FROM  was_washpricedetails INNER JOIN 
              was_dryprocess ON was_washpricedetails.intDryProssId = was_dryprocess.intSerialNo WHERE  was_washpricedetails.intStyleId='$cboPoNo')ORDER BY strDescription";	*/   
		$SQL2="SELECT DISTINCT
				was_dryprocess.intSerialNo,
				was_dryprocess.strDescription
				FROM
				was_dryprocess
				WHERE intSerialNo  NOT IN ( SELECT was_washpricedetails.intDryProssId
							  FROM  was_washpricedetails INNER JOIN 
							  was_dryprocess ON was_washpricedetails.intDryProssId = was_dryprocess.intSerialNo WHERE  was_washpricedetails.intStyleId='159')
				ORDER BY strDescription";		

		$result = $db->RunQuery($SQL);
		//echo $SQL2;

			while($row = mysql_fetch_array($result))
			{

    		 $ResponseXML .= "<intSerialNo><![CDATA[" . trim($row["intSerialNo"])  . "]]></intSerialNo>\n";	
			 $ResponseXML .= "<strDescription><![CDATA[" . trim($row["strDescription"])  . "]]></strDescription>\n"; 
			 $ResponseXML .= "<intDryProssId><![CDATA[" . trim($row["intDryProssId"])  . "]]></intDryProssId>\n"; 
			 $ResponseXML .= "<dblWashPrice><![CDATA[" . trim($row["dblWashPrice"])  . "]]></dblWashPrice>\n"; 

			}
			$result2 = $db->RunQuery($SQL2);
			while($row2 = mysql_fetch_array($result2))
			{
			 $intSerialNo = trim($row2["intSerialNo"]); 
			
    		 $ResponseXML .= "<intSerialNo2><![CDATA[" . trim($row2["intSerialNo"])  . "]]></intSerialNo2>\n";	
			 $ResponseXML .= "<strDescription2><![CDATA[" . trim($row2["strDescription"])  . "]]></strDescription2>\n"; 
			 $ResponseXML .= "<intDryProssId2><![CDATA[" . trim($row2["intDryProssId"])  . "]]></intDryProssId2>\n"; 
			 $ResponseXML .= "<dblWashPrice2><![CDATA[" . trim($row2["dblWashPrice"])  . "]]></dblWashPrice2>\n"; 
          
			}
			$ResponseXML .= "</loadDetails>";
			//echo $SQL2;
		echo $ResponseXML;
		
}

if($id=="loadGrid")
{
$cat=$_GET['cat'];
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$ResponseXML .="<loadGridOnload>";
		if($cat==0){
		
			$SQL = "SELECT orders.strStyle as PO,orders.strOrderNo,orders.strDescription,orders.intStyleId, 
was_washpriceheader.dblIncome,was_washpriceheader.intGarmentId, was_washpriceheader.dblCost,
productcategory.strCatName,was_washtype.strWasType, was_washpriceheader.strColor,
was_washpriceheader.intWasTypeId,was_washpriceheader.strFabDes,companies.strName,was_washpriceheader.intCompanyId 
FROM orders INNER JOIN was_washpriceheader ON was_washpriceheader.intStyleId = orders.intStyleId 
INNER JOIN productcategory ON productcategory.intCatId = was_washpriceheader.intGarmentId 
INNER JOIN was_washtype ON was_washtype.intWasID = was_washpriceheader.intWasTypeId 
INNER JOIN companies ON was_washpriceheader.intCompanyId = companies.intCompanyID".
					" WHERE was_washpriceheader.dtmDate >= '$echoa' ".
					//"AND was_washpriceheader.intUserID='$userID' ".
					//"-- AND was_washpriceheader.intCompanyId='$companyID' ".
					//"AND was_washpriceheader.intUserCompanyId='$companyID' ".
					"and intCat='$cat' ".
					 "ORDER BY orders.strStyle limit 20";
					
			
			$result = $db->RunQuery($SQL);
			//echo $SQL;
	
				while($row = mysql_fetch_array($result))
				{
				 $ResponseXML .= "<pono><![CDATA[" . trim($row["PO"])  . "]]></pono>\n";	
				 $ResponseXML .= "<intStyleId><![CDATA[" . trim($row["intStyleId"])  . "]]></intStyleId>\n";	
				 $ResponseXML .= "<styleno><![CDATA[" . trim($row["strOrderNo"])  . "]]></styleno>\n"; 
				 $ResponseXML .= "<stylename><![CDATA[" . trim($row["strDescription"])  . "]]></stylename>\n"; 
				 $ResponseXML .= "<washincome><![CDATA[" . trim($row["dblIncome"])  . "]]></washincome>\n";
				 $ResponseXML .= "<costprice><![CDATA[" . trim($row["dblCost"])  . "]]></costprice>\n";
				 $ResponseXML .= "<garment><![CDATA[" . trim($row["strCatName"])  . "]]></garment>\n";
				 $ResponseXML .= "<intGarmentId><![CDATA[" . trim($row["intGarmentId"])  . "]]></intGarmentId>\n";
				 $ResponseXML .= "<washtype><![CDATA[" . trim($row["strWasType"])  . "]]></washtype>\n";
				 $ResponseXML .= "<intWasTypeId><![CDATA[" . trim($row["intWasTypeId"])  . "]]></intWasTypeId>\n";
				 $ResponseXML .= "<color><![CDATA[" . trim($row["strColor"])  . "]]></color>\n";
				 $ResponseXML .= "<strFabDes><![CDATA[" . trim($row["strFabDes"])  . "]]></strFabDes>\n";
				 $ResponseXML .= "<strName><![CDATA[" . trim($row["strName"])  . "]]></strName>\n";
				  $ResponseXML .= "<companyID><![CDATA[" . trim($row["intCompanyId"])  . "]]></companyID>\n";
				}
				
			}
			else{
				$sql="SELECT
					was_outsidepo.intPONo AS PO,
					was_washpriceheader.strColor,
					was_washpriceheader.strFabDes,
					was_washpriceheader.dblCost,
					was_washpriceheader.dblIncome,
					was_outside_companies.strName,
					was_outsidepo.strStyleNo,
					was_outsidepo.strStyleDes,
					was_washpriceheader.intWasTypeId,
					was_washpriceheader.intGarmentId,
					was_washtype.strWasType,
					productcategory.strCatName,
					was_washpriceheader.intStyleId
					FROM
					was_washpriceheader
					Inner Join was_oustside_issuedtowash ON was_washpriceheader.intStyleId = was_oustside_issuedtowash.intPoNo
					Inner Join was_outsidepo ON was_oustside_issuedtowash.intPoNo = was_outsidepo.intId
					Inner Join was_outsidewash_fabdetails ON was_outsidepo.intFabId = was_outsidewash_fabdetails.intId
					Inner Join was_outside_companies ON was_outside_companies.intCompanyID = was_outsidewash_fabdetails.intFactory
					Inner Join was_washtype ON was_washpriceheader.intWasTypeId = was_washtype.intWasID
					INNER JOIN productcategory ON productcategory.intCatId = was_washpriceheader.intGarmentId 
					WHERE
					was_washpriceheader.intCat =  '$cat'"; 
						
						//echo $sql;
						$result = $db->RunQuery($sql);
				while($row = mysql_fetch_array($result))
				{
				 $ResponseXML .= "<pono><![CDATA[" . trim($row["PO"])  . "]]></pono>\n";	
				 $ResponseXML .= "<poId><![CDATA[" . trim($row["intStyleId"])  . "]]></poId>\n";	
				 $ResponseXML .= "<Color><![CDATA[" . trim($row["strColor"])  . "]]></Color>\n";	
				 $ResponseXML .= "<FabDes><![CDATA[" . trim($row["strFabDes"])  . "]]></FabDes>\n"; 
				 $ResponseXML .= "<Cost><![CDATA[" . trim($row["dblCost"])  . "]]></Cost>\n"; 
				 $ResponseXML .= "<Income><![CDATA[" . trim($row["dblIncome"])  . "]]></Income>\n";
				 $ResponseXML .= "<ComName><![CDATA[" . trim($row["strName"])  . "]]></ComName>\n";
				 $ResponseXML .= "<strStyleNo><![CDATA[" . trim($row["strStyleNo"])  . "]]></strStyleNo>\n";
				 $ResponseXML .= "<strStyleDes><![CDATA[" . trim($row["strStyleDes"])  . "]]></strStyleDes>\n";
				 $ResponseXML .= "<WashTypeId><![CDATA[" . trim($row["intWasTypeId"])  . "]]></WashTypeId>\n";
				 $ResponseXML .= "<WasType><![CDATA[" . trim($row["strWasType"])  . "]]></WasType>\n";
				 $ResponseXML .= "<GarmentId><![CDATA[" . trim($row["intGarmentId"])  . "]]></GarmentId>\n";
				 $ResponseXML .= "<Garment><![CDATA[" . trim($row["strGarmentName"])  . "]]></Garment>\n";
				}
			}
			$ResponseXML .= "</loadGridOnload>";
			echo $ResponseXML;
}

if($id =="pono")
{
$mode	= $_GET["Mode"];
	
	/*$SQL="SELECT orders.intStyleId,orders.strStyle FROM orders WHERE intStyleId  NOT IN ( SELECT              orders.intStyleId
		  FROM  orders INNER JOIN 
		  was_washpriceheader ON orders.intStyleId = was_washpriceheader.intStyleId)";*/
	
	$SQL="SELECT DISTINCT
			o.strOrderNo,
			o.intStyleId
			FROM
			orders AS o
			WHERE
			o.intStyleId NOT IN (select intStyleId from was_washpriceheader)
			AND
			o.intStatus='11'
			order by o.strOrderNo;";
	if($mode=='0')
	{
		/*$SQL = "SELECT DISTINCT
				orders.strOrderNo,
				orders.intStyleId
				FROM
				was_issuedtowashheader
				Inner Join orders ON was_issuedtowashheader.intStyleNo = orders.intStyleId
				WHERE orders.intStyleId  NOT IN ( SELECT was_washpriceheader.intStyleId from was_washpriceheader) order by orders.strOrderNo";*/
	}
	else
	{
		$SQL ="select distinct wopo.intId as intStyleId,wopo.intPoNo as strOrderNo  from  was_oustside_issuedtowash woi inner join was_outsidepo wopo on wopo.intId=woi.intPoNo and woi.intPoNo not in(SELECT was_washpriceheader.intStyleId FROM was_washpriceheader) order by wopo.intPOno;";
	}
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
}
	
if($id=="searchGrid")
{
 $poNoLike = $_GET["poNoLike"];

		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<loadGridOnload>";
		

		$SQL = "SELECT orders.strStyle,orders.strOrderNo,orders.strDescription,orders.intStyleId, 
				was_washpriceheader.dblIncome,
				was_washpriceheader.intGarmentId, 
				was_washpriceheader.dblCost,
				productcategory.strCatName,
				was_washtype.strWasType, 
				was_washpriceheader.strColor,
				was_washpriceheader.intWasTypeId,
				was_washpriceheader.strFabDes,
				companies.strName,
				was_washpriceheader.intCompanyId,
				productcategory.strCatName
				FROM orders INNER JOIN was_washpriceheader ON was_washpriceheader.intStyleId = orders.intStyleId 
				INNER JOIN productcategory ON productcategory.intCatId = was_washpriceheader.intGarmentId 
				INNER JOIN was_washtype ON was_washtype.intWasID = was_washpriceheader.intWasTypeId 
				INNER JOIN companies ON was_washpriceheader.intCompanyId = companies.intCompanyID 
				WHERE orders.strOrderNo LIKE '%$poNoLike%'
				ORDER BY orders.strStyle limit 20";
				
		$result = $db->RunQuery($SQL);
		//echo $SQL;

			while($row = mysql_fetch_array($result))
			{
  		     $ResponseXML .= "<pono><![CDATA[" . trim($row["strOrderNo"])  . "]]></pono>\n";	
			 $ResponseXML .= "<intStyleId><![CDATA[" . trim($row["intStyleId"])  . "]]></intStyleId>\n";	
			 $ResponseXML .= "<styleno><![CDATA[" . trim($row["strStyle"])  . "]]></styleno>\n"; 
 			 $ResponseXML .= "<stylename><![CDATA[" . trim($row["strDescription"])  . "]]></stylename>\n"; 
			 $ResponseXML .= "<washincome><![CDATA[" . trim($row["dblIncome"])  . "]]></washincome>\n";
 			 $ResponseXML .= "<costprice><![CDATA[" . trim($row["dblCost"])  . "]]></costprice>\n";
  			 $ResponseXML .= "<garment><![CDATA[" . trim($row["strCatName"])  . "]]></garment>\n";
			 $ResponseXML .= "<intGarmentId><![CDATA[" . trim($row["intGarmentId"])  . "]]></intGarmentId>\n";
			 $ResponseXML .= "<washtype><![CDATA[" . trim($row["strWasType"])  . "]]></washtype>\n";
			 $ResponseXML .= "<intWasTypeId><![CDATA[" . trim($row["intWasTypeId"])  . "]]></intWasTypeId>\n";
     		 $ResponseXML .= "<color><![CDATA[" . trim($row["strColor"])  . "]]></color>\n";
			 $ResponseXML .= "<strFabDes><![CDATA[" . trim($row["strFabDes"])  . "]]></strFabDes>\n";
			 $ResponseXML .= "<strName><![CDATA[" . trim($row["strName"])  . "]]></strName>\n";
			 $ResponseXML .= "<companyID><![CDATA[" . trim($row["intCompanyId"])  . "]]></companyID>\n";
			 $ResponseXML .= "<intCat><![CDATA[" . trim($row["intCat"])  . "]]></intCat>\n";
				  
			}
			$ResponseXML .= "</loadGridOnload>";
			
		echo $ResponseXML;
}
if($id=="loadOrderNolist")
{
 	
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<loadOrderNolist>";
		
		/*$SQL="SELECT DISTINCT
				orders.strOrderNo,
				orders.intStyleId
				FROM
				was_issuedtowashheader
				Inner Join orders ON was_issuedtowashheader.intStyleNo = orders.intStyleId
				WHERE orders.intStyleId  NOT IN ( SELECT orders.intStyleId
				FROM  orders INNER JOIN 
				was_washpriceheader ON orders.intStyleId = was_washpriceheader.intStyleId) order by orders.strOrderNo;";*/
		$SQL="SELECT DISTINCT
				o.strOrderNo,
				o.intStyleId
				FROM
				orders AS o
				WHERE
				o.intStyleId NOT IN (select intStyleId from was_washpriceheader)
				AND
				o.intStatus='11'
				order by o.strOrderNo";
			$result =$db->RunQuery($SQL);
		
		$str = "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				$str .= "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
			}
			
		 $ResponseXML .= "<orderNo><![CDATA[" . $str  . "]]></orderNo>\n";
		$ResponseXML .= "</loadOrderNolist>";
		
		echo $ResponseXML;
}

function getWashPrice($color,$garment,$style,$matId){
	global $db;
	$sql="SELECT
			sph.dblIncome,
			orders.strStyle,
			orderdetails.intMatDetailID
			FROM
			was_washpriceheader AS sph
			INNER JOIN orders ON sph.intStyleId = orders.intStyleId
			INNER JOIN orderdetails ON orderdetails.intStyleId = orders.intStyleId
			WHERE
			sph.strColor = '$color' AND
			sph.intGarmentId = '$garment' AND
			orders.strStyle = '$style' AND
			orderdetails.intMatDetailID = '$matId'";	
			//echo $sql;
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['dblIncome'];
}
?>
