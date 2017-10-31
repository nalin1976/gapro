<?php 
$msServer = "192.168.1.6";
$msUser = "eplanclient"; 
$msPass = "blueray";
$msDb = "eplan";


//Select DataBase
$msCon = mysql_connect($msServer,$msUser,$msPass) or die("Couldn't connect to Ms SQL Server on $msServer");
$msSelected = mysql_select_db($msDb,$msCon) or die("Couldn't open Ms SQL database $msDb");


$sql = "SELECT
		grndetails.intGrnNo as grnNo,
		grndetails.intGRNYear as grnYear,
		grndetails.intStyleId,
		grndetails.strBuyerPONO,
		grndetails.intMatDetailID,
		grndetails.strColor,
		grndetails.strSize,
		grndetails.dblQty,
		grnheader.intPoNo as poNo,
		grnheader.intYear as poYear
		FROM
		grndetails
		Inner Join grnheader ON grnheader.intGrnNo = grndetails.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear";
//		where dblValueBalance<=0";
$result = mysql_query($sql);

while ($row=mysql_fetch_array($result))
{
	$grnNo 			= $row["grnNo"];
	$grnYear 		= $row["grnYear"];
	$poNo 			= $row["poNo"];
	$poYear 		= $row["poYear"];
	$strStyleID 	= $row["intStyleId"];
	$strBuyerPONO 	= $row["strBuyerPONO"];
	$intMatDetailID = $row["intMatDetailID"];
	$strColor 		= $row["strColor"];
	$strSize 		= $row["strSize"];
	$dblQty 		= $row["dblQty"];
	
	$sql2 = "	SELECT
				purchaseorderdetails.dblUnitPrice
				FROM purchaseorderdetails
				WHERE
				purchaseorderdetails.intPoNo =  '$poNo' AND
				purchaseorderdetails.intYear =  '$poYear' AND
				purchaseorderdetails.intStyleId =  '$strStyleID' AND
				purchaseorderdetails.intMatDetailID =  '$intMatDetailID' AND
				purchaseorderdetails.strColor =  '$strColor' AND
				purchaseorderdetails.strSize =  '$strSize' AND
				purchaseorderdetails.strBuyerPONO =  '$strBuyerPONO'
				";
	$result2 = mysql_query($sql2);
	while ($row2=mysql_fetch_array($result2))
	{
		$dblUnitPrice	= $row2['dblUnitPrice'];
	}
		
	$sql3 = "UPDATE grndetails set
			dblValueBalance = $dblQty * $dblUnitPrice
			WHERE
			grndetails.intGrnNo =  '$grnNo' AND
			grndetails.intGRNYear =  '$grnYear' AND
			grndetails.intStyleId =  '$strStyleID' AND
			grndetails.strBuyerPONO =  '$strBuyerPONO' AND
			grndetails.intMatDetailID =  '$intMatDetailID' AND
			grndetails.strColor =  '$strColor' AND
			grndetails.strSize =  '$strSize'
			";
	$result3 = mysql_query($sql3);
	echo $grnNo.' - '.'<br>';
}

?>