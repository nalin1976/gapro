<?php 
session_start();
include("../../../Connector.php");
header('Content-Type: text/xml'); 	
$request=$_GET["request"];

if ($request=='getData')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$customerid=$_GET['customerid'];
	
	
	$str="select ih.intIOUNo,(select sum(dblamount) from advancedetail ad where  ad.intiouno=ih.intIOUNo)as dblamount  from tbliouheader ih  where strCustomerID='$customerid' and intSettled!=2";
	
	$XMLString= "<Data>";
	$XMLString .= "<DeliveryData>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
			
			if($row["dblamount"]=="")
			$row["dblamount"]=0;
		
		
		$XMLString .= "<IOUNo><![CDATA[" . $row["intIOUNo"]  . "]]></IOUNo>\n";		
		$XMLString .= "<amount><![CDATA[" . $row["dblamount"]  . "]]></amount>\n";
		
	}
	
	$XMLString .= "</DeliveryData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}
if($request=='saveHeader')
{

	$rcptSerial=$_GET['rcptSerial'];
	$customer=$_GET['customer'];
	$rcptdate=$_GET['rcptdate'];
	$amount=$_GET['amount'];
	$balance=$_GET['balance'];
	$creditnote=$_GET['creditnote'];
	$bank=$_GET['bank'];
	$chequerefno=$_GET['chequerefno'];
	$type=$_GET['type'];
	if($rcptdate){
	$InvoiceDateArray 	= explode('/',$rcptdate);
	$rcptdate = $InvoiceDateArray[2]."-".$InvoiceDateArray[1]."-".$InvoiceDateArray[0];
	}else $rcptdate=date("y-m-d");
	
	$str="	insert into advanceheader 
						(strAdvanceSerialNo, 
						dtmDate, 
						dblAmount, 
						intCustomerid, 
						dblBalance, 
						strChequeRefNo, 
						intBank, 
						strType
						)
						values
						('$rcptSerial', 
						'$rcptdate', 
						'$amount', 
						'$customer', 
						'$balance', 
						'$chequerefno', 
						'$bank', 
						'$type');";
					 $result=$db->RunQuery($str);
		if( $result)
				{
					$strControl="update syscontrol set dblAdvSerialNo = dblAdvSerialNo+1";
					$resultControl=$db->RunQuery($strControl);				
				}
		if($resultControl)
		echo "successfully saved!";
}

if($request=='newNo')
{
$strSerial="select dblRcptSerialNo from syscontrol";
$resultSerial=$db->RunQuery($strSerial);
$row=mysql_fetch_array($resultSerial);
echo $row["dblRcptSerialNo"];
}

if($request=='saveDetails')
{
	$receiptSerialNo=$_GET['receiptSerialNo'];
	$iouno=$_GET['iouno'];
	$received=$_GET['received'];
	
	$str="insert into advancedetail 
					(strAdvanceSerialNo, 
					intiouno, 
					dblamount
					)
					values
					('$receiptSerialNo', 
					'$iouno', 
					'$received'
					);";


	$result=$db->RunQuery($str);
	if ($result)
		echo "Successfully saved";
}
?>