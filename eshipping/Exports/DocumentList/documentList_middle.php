<?php
session_start();
$backwardseperator = "../../";
include "$backwardseperator"."Connector.php";
header('Content-Type: text/xml'); 

$request=$_GET["request"];



if( $request == "addDocListToGrid" ){
	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	 $ResponceXML = "<DocumentList>\n";	
	 $strInvoiceNo = trim ($_GET["strInvoiceNo"]);
	 

			/*$sql ="SELECT invoice_document_list.strInvoiceNo,
					invoice_document_list.intDocumentFormatId
					FROM
					invoice_document_list
					WHERE
					invoice_document_list.strInvoiceNo =  '$strInvoiceNo';";*/
					
					
			$sql = "SELECT IDL.strInvoiceNo,IDL.intDocumentFormatId,strGpa,strPicNo,strCertOfOrigin
					FROM  invoice_document_list as IDL INNER JOIN invoice_document_list_header as IDLH 
					ON  IDL.strInvoiceNo = IDLH.strInvoiceNo
					WHERE  IDL.strInvoiceNo =  '$strInvoiceNo';";
					//echo $sql;
	 $result = $db -> RunQuery($sql);
	
	 while($row_format=mysql_fetch_array($result))
			{	
						
				$ResponceXML .= "<intDocumentFormatId><![CDATA[".($row_format["intDocumentFormatId"])  . "]]></intDocumentFormatId>\n";
				$ResponceXML .= "<strGpa><![CDATA[".($row_format["strGpa"])  . "]]></strGpa>\n";
				$ResponceXML .= "<strPicNo><![CDATA[".($row_format["strPicNo"])  . "]]></strPicNo>\n";
				$ResponceXML .= "<strCertOfOrigin><![CDATA[".($row_format["strCertOfOrigin"])  . "]]></strCertOfOrigin>\n";
			}
			
			
			
			
			
	 $ResponceXML .= "</DocumentList>\n";		 
     echo $ResponceXML;	
}
elseif( $request =="loadpopupdesc" ){

	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$strDocName = trim($_GET["docName"]);
	$sqlDesc = "select strDocDesc,StrDocument,intDocumentFormatId from document_list where StrDocument = '$strDocName';";
   //echo $sqlDesc;
	$resultDesc = $db-> RunQuery($sqlDesc);
	$ResponceXML = "<DocumentList>\n";	
	while($rowDesc = mysql_fetch_array($resultDesc))
			{				
				$ResponceXML .= "<strDocDesc><![CDATA[".($rowDesc["strDocDesc"])  . "]]></strDocDesc>\n";	
				$ResponceXML .= "<StrDocument><![CDATA[".($rowDesc["StrDocument"])  . "]]></StrDocument>\n";
				$ResponceXML .= "<intDocumentFormatId><![CDATA[".($rowDesc["intDocumentFormatId"])  . "]]></intDocumentFormatId>\n";
			}
	 $ResponceXML .= "</DocumentList>\n";
	 echo $ResponceXML;	
}
elseif($request == 'saveDoc'){
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$docFormatId 	= $_GET["docFormatId"];
	$changeDocName 	= $_GET["changeDocName"];
	$changeDocDesc 	= $_GET["changeDocDesc"];
	$strInvoiceNo	= $_GET["strInvoiceNo"];
	
	$sqlStr ="select intDocumentFormatId from document_list where intDocumentFormatId = '$docFormatId';"; // check if a record exists in document_list table.
	//echo $sqlStr;
	$sqlcompare ="select StrDocument from document_list where StrDocument ='$changeDocName';";  // check if the document name has not changed
	$sqlreturnVal ="SELECT
					intDocumentFormatId,StrDocument,strDocDesc 
					FROM
					document_list
					where StrDocument='$changeDocName'";
					
    $sqlupdate ="UPDATE document_list SET strDocDesc='$changeDocDesc',
					 StrDocument='$changeDocName' WHERE intDocumentFormatId = '$docFormatId';"; 
	//echo $sqlcompare;
	$result = $db->RunQuery($sqlStr);  // check if the document exists with the selected id
	$resultcomp =$db->RunQuery($sqlcompare); // check if it is a duplicated code.

//	echo "xxxx ".mysql_num_rows($result);
	// check if the document exists with the selected id
	if( mysql_num_rows($result)> 0  ){
		
		$status = 2; // set updated success fully
		
		// and if it's not trying to save a duplicate record then update the document list table i.e user has ammended the document name
		if( mysql_num_rows($resultcomp)!= 0	) 
		{
			$result1 = $db->RunQuery($sqlupdate); // run update on document_details table
			
		}
		else $status = 5; //  else set status to "trying to duplicate the document".
		
			 $resultOut=$db->Runquery($sqlreturnVal);
			 $ResponceXML = "<DocumentList>\n";
			 while($row=mysql_fetch_array($resultOut))
			 {
				$ResponceXML .= "<intDocumentFormatId><![CDATA[".($row["intDocumentFormatId"])  . "]]></intDocumentFormatId>\n";
				$ResponceXML .= "<StrDocument><![CDATA[".($row["StrDocument"])  . "]]></StrDocument>\n";
				$ResponceXML .= "<strDocDesc><![CDATA[".($row["strDocDesc"])  . "]]></strDocDesc>\n";
				$ResponceXML .= "<status>".$status."</status>\n";	
			 }
			  	$ResponceXML .= "</DocumentList>\n";
	 			echo $ResponceXML;	

	}
	elseif ( mysql_num_rows($resultcomp)== 0){ // that is a brand new entry.
	
		$sqlInsrt ="INSERT INTO document_list (StrDocument,strDocDesc) VALUES ('$changeDocName','$changeDocDesc');";
		//echo $sqlInsrt;
		$result1 = $db->RunQuery($sqlInsrt); // then insert in to the table document list
		if( $result1 ){
				
				 $resultOut=$db->Runquery($sqlreturnVal);
				 $ResponceXML = "<DocumentList>\n";
			 while($row=mysql_fetch_array($resultOut))
			 {
				$ResponceXML .= "<intDocumentFormatId><![CDATA[".($row["intDocumentFormatId"])  . "]]></intDocumentFormatId>\n";
				$ResponceXML .= "<StrDocument><![CDATA[".($row["StrDocument"])  . "]]></StrDocument>\n";
				$ResponceXML .= "<strDocDesc><![CDATA[".($row["strDocDesc"])  . "]]></strDocDesc>\n";
				$ResponceXML .= "<status>1</status>\n";	
			 }
			  	$ResponceXML .= "</DocumentList>\n";
	 			echo $ResponceXML;	
			
		}
		else
			{	
		 	    $ResponceXML = "<DocumentList>\n";
				$ResponceXML .= "<intDocumentFormatId></intDocumentFormatId>\n";
				$ResponceXML .= "<StrDocument></StrDocument>\n";
				$ResponceXML .= "<strDocDesc></strDocDesc>\n";
				$ResponceXML .= "<status>3</status>\n";
			    $ResponceXML .= "</DocumentList>\n";
	 		    echo $ResponceXML;			
					
		  }
	}
	
}
elseif($request == "updateDeletRcd"){ 
 
	$intDocumentFormatId = $_GET["intDocumentFormatId"];
	$invoiceNo 			 = $_GET["invoiceNo"];
	$sql = "DELETE FROM invoice_document_list WHERE  strInvoiceNo = '$invoiceNo' AND intDocumentFormatId ='$intDocumentFormatId';";#intDocumentFormatId ='$intDocumentFormatId'and
	$result = $db->RunQuery($sql);
	if($result)
		echo 1;
	else 
		echo 0;
	
}
else if($request=="delmaindata"){
 $invoiceno =$_GET["invoiceno"];
 $sql = "DELETE FROM invoice_document_list WHERE  strInvoiceNo='$invoiceno'";
 $result=$db->RunQuery($sql); // deleating all the entries
}

elseif( $request=="savemaindata"){
	
	$intDocumentFormatId = $_GET["intDocumentFormatId"];
	$invoiceno =$_GET["invoiceno"];
	//echo $sql;
	
	$sqlinsrt ="INSERT INTO invoice_document_list (invoice_document_list.strInvoiceNo,
				invoice_document_list.intDocumentFormatId)
				VALUES('$invoiceno','$intDocumentFormatId');";
	//echo $sqlinsrt;
	
	$result2 = $db->Runquery($sqlinsrt); // inserting the selected entries
	
	if($result2==1) echo "Saved successfuly"; else echo "Saving Error!";
	
}
elseif($request== "getdocs"){
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$intDocumentFormatId1 =$_GET["intDocumentFormatId1"];
		$sql = "SELECT
			document_list.intDocumentFormatId,
			document_list.StrDocument,
			document_list.strDocDesc
			FROM
			document_list
			WHERE intDocumentFormatId ='$intDocumentFormatId1'
			";
			
		//echo $sql;	
	$result = $db -> RunQuery($sql);
	 $ResponceXML = "<DocumentList>\n";
	 while($row=mysql_fetch_array($result))
		 {
			$ResponceXML .= "<StrDocument><![CDATA[".($row["StrDocument"])  . "]]></StrDocument>\n";
			$ResponceXML .= "<strDocDesc><![CDATA[".($row["strDocDesc"])  . "]]></strDocDesc>\n";
		 }
			$ResponceXML .= "</DocumentList>\n";
			echo $ResponceXML;	
	
}
elseif($request=="deleRecord")
{
	$intDocumentFormatId = $_GET["docid"];
	
	$sqlVarify ="SELECT
				invoice_document_list.intDocumentFormatId,
				document_list.StrDocument,
				document_list.strDocDesc,
				document_list.strStatus
				FROM
				document_list
				Inner Join invoice_document_list ON document_list.intDocumentFormatId = invoice_document_list.intDocumentFormatId
				WHERE				
				invoice_document_list.intDocumentFormatId =  '$intDocumentFormatId';";
				
				//echo $sqlVarify;
				
				$recinInvoiceDetails = $db->RunQuery($sqlVarify);
				//echo $recinInvoiceDetails;
				if(mysql_num_rows($recinInvoiceDetails)>0)
				{
					echo " Dcument has allocated to invoices can't be deleted";
					
				}
				else
				{
					$deletequery = "Update document_list
									SET
									document_list.strStatus = '1'
									WHERE document_list.intDocumentFormatId='$intDocumentFormatId';";
									 $db->RunQuery($deletequery);
										
					echo " Document has been Successfuly Deleted";
				}
				
}
elseif($request=="saveHeader")
{
	$invoiceno =$_GET["invoiceno"];
	$gpaNo	= $_GET["gpaNo"];
	$picNo	= $_GET["picNo"];
	$certOrigin =$_GET["certOrigin"];
	
	$sqlCheckHeader ="select strInvoiceNo from invoice_document_list_header where strInvoiceNo ='$invoiceno';";
	//echo 	$sqlCheckHeader;		
	$sqlInsertHeader ="INSERT INTO invoice_document_list_header (strInvoiceNo,strGpa,strPicNo,strCertOfOrigin)
					   VALUES ('$invoiceno','$gpaNo','$picNo','$certOrigin');";
	//echo 	$sqlInsertHeader;
	$sqlUpdateHeader ="UPDATE invoice_document_list_header 
						SET strGpa ='$gpaNo',strPicNo='$picNo',strCertOfOrigin='$certOrigin' WHERE strInvoiceNo ='$invoiceno';";
	//echo 	$sqlUpdateHeader;
	
	
	$resultChkHeader =$db->Runquery($sqlCheckHeader);
	
	if(mysql_num_rows($resultChkHeader) > 0){ // if there is a record for a given invoice number its an update
		
		$result3 = $db->Runquery($sqlUpdateHeader);	
	}else
	{
		$result3 = $db->Runquery($sqlInsertHeader);	
	}
		
}
									  
									  
?>