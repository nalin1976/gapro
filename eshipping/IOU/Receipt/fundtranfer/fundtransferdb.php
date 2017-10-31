<?php
	session_start();
	include "../../../Connector.php";	
	header('Content-Type: text/xml'); 	
	$request=$_GET["request"];

if ($request=='newNo')
{
			$str="select dblFundTransferNo from syscontrol ";
			$results = $db->RunQuery($str); 
			$row= mysql_fetch_array($results);
			echo $row["dblFundTransferNo"];
}
if ($request=='saveHeader')
{	
	$formSerial=$_GET['formSerial'];
	$bank=$_GET['bank'];
	$rcptdate=$_GET['formDate'];
	$chequerefno=$_GET['chequerefno'];
	$totamt=$_GET['totamt'];
	if($rcptdate){
	$InvoiceDateArray 	= explode('/',$rcptdate);
	$rcptdate = $InvoiceDateArray[2]."-".$InvoiceDateArray[1]."-".$InvoiceDateArray[0];
	}else $rcptdate=date("y-m-d");
	
	$str="insert into fundtransferheader 
								(strFTserial, 
								intbankId, 
								dtmDate, 
								dblTotal
								)
								values
								('$formSerial', 
								'$bank', 
								'$rcptdate', 
								'$totamt'
								);	";
					 $result=$db->RunQuery($str);
		if( $result)
				{
					$strControl="update syscontrol set dblFundTransferNo = dblFundTransferNo+1";
					$resultControl=$db->RunQuery($strControl);				
				}
		if($resultControl)
		echo "successfully saved!";
	
}
if ($request=='saveDetail')
{
	$frmSerial=$_GET['frmSerial'];
	$accountno=$_GET['accountno'];
	$amount=$_GET['amount'];
	$warfclerk=$_GET['warfclerk'];
	$accountname=$_GET['accountname'];
	
	
	$str="insert into fundtransferdetail 
						(strFTserial, 
						intWharfNo, 
						strAccountName, 
						strAccountNo, 
						dblAmount
						)
						values
						('$frmSerial', 
						'$warfclerk', 
						'$accountname', 
						'$accountno', 
						'$amount'
						);";


	$result=$db->RunQuery($str);
	if ($result)
		echo "Successfully saved";
}

?>
