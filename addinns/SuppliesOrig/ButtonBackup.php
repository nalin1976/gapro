<?php 
include "../../Connector.php";

$Button = $_GET["q"];
$ComName=$_GET["ComName"];

if($Button=="Save")
{ 
//echo "$Button";supplierCode
	$supplierCode=$_GET["supplierCode"];
  $ComName=$_GET["ComName"];
  $ComName = str_replace("'","''",$ComName);
  $VatReNo=$_GET["VatReNo"];
  $Address1=$_GET["Address1"];
  $Address1 = str_replace("'","''",$Address1);
  $Address2=$_GET["Address2"];
  $Address2 = str_replace("'","''",$Address2);
  $Option1=$_GET["Option1"];
  $Option2=$_GET["Option2"];
  $Option3=$_GET["Option3"];
  $ContactPerson=$_GET["ContactPerson"]; 
  
  $street=$_GET["street"];
  $street = str_replace("'","''",$street);
  $City=$_GET["City"];
  $State=$_GET["State"];
  $Country=$_GET["Country"];
  $ZipCode=$_GET["ZipCode"];
  $Phone=$_GET["Phone"];
  $Fax=$_GET["Fax"];
  $email=$_GET["email"];
  $Web=$_GET["Web"];
  $Remarks=$_GET["Remarks"];
  $Remarks = str_replace("'","''",$Remarks);
  $Keyitems=$_GET["Keyitems"];
  $Currcncy=$_GET["Currcncy"];
  $Origin=$_GET["Origin"];
  $taxenable=$_GET["taxenable"];
  $creditallowed=$_GET["creditallowed"];
  $vatsuspended=$_GET["vatsuspended"];
  $supplierappo=$_GET["supplierappo"];
  $SupplierStatus=$_GET["SupplierStatus"];
  $SupplierID=$_GET["SupplierID"];
  $Taxtype=$_GET["Taxtype"];
  $Creditperi=$_GET["Creditperi"];

  $intShipmentModeId=$_GET["intShipmentModeId"];
  $strShipmentTermId=$_GET["strShipmentTermId"];
  $strPayModeId=$_GET["strPayModeId"];
  $strPayTermId=$_GET["strPayTermId"];
  $txtReason=$_GET["txtReason"];
  $cboSupApp=$_GET["cboSupApp"];//user id
  $appComments=$_GET["txtApprComments"];

 // $SQL_select="SELECT strSupplierID FROM suppliers WHERE strSupplierID=".$SupplierID.";";
  //$result_select = $db->RunQuery($SQL_select);
  //echo $SQL_select; 
  //echo  $result_select;
  //if($row = mysql_fetch_array($result_select))
 // {
 echo  $SQL_update="update suppliers set strTitle='".$ComName."',strAddress1='".$Address1."',strAddress2='".$Address2."',strOption1='".$Option1."',
  strOption2='".$Option2."',strOption3='".$Option3."',strContactPerson='".$ContactPerson."',
  strStreet='".$street."',strCity='".$City."',strState='".$State."',strCountry='".$Country."',strZipCode='".$ZipCode."',strPhone='".$Phone."',strEMail='".$email."',strFax='".$Fax."',strWeb='".$Web."',strRemarks='".$Remarks."',strKeyItems='".$Keyitems."',strOrigin='".$Origin."',strCurrency='".$Currcncy."',strVatRegNo='".$VatReNo."',intTaxEnabled='".$taxenable."',intVATSuspended=".$vatsuspended.",strTaxTypeID='".$Taxtype."',intCreditPeriod='".$Creditperi."',intStatus=1,intApproved=".$supplierappo.",intSupplierStatus=".$SupplierStatus.",intCreditAllowed=".$creditallowed.",strSupplierCode='$supplierCode'
  	,intShipmentModeId='$intShipmentModeId'
	,strShipmentTermId='$strShipmentTermId'
	,strPayModeId='$strPayModeId'
	,strPayTermId='$strPayTermId',strReason='$txtReason',cboSupApp='$cboSupApp',strAppComments='$appComments'
   where strSupplierID = '".$SupplierID."';";
   
   
 // echo $Button;
  		//$db->ExecuteQuery($SQL_update);
		
		$db->ExecuteQuery($SQL_update);
		
		//upload the image
	   echo $newname = dirname(__FILE__).'/BuyerFiles/'.$SupplierID;
	   echo $_FILES["uploaded_file"]['tmp_name'];
	    move_uploaded_file($_FILES["uploaded_file"]['tmp_name'],$newname);
		
		echo "Saved SuccessFully";
				
 // }
  
}

if($Button=="New")
	{
		  $supplierCode=$_GET["supplierCode"];
		  $ComName=$_GET["ComName"];
		  $ComName = str_replace("'","''",$ComName);
		  $VatReNo=$_GET["VatReNo"];
		  $Address1=$_GET["Address1"];
		  $Address1 = str_replace("'","''",$Address1);
		  $Address2=$_GET["Address2"];
		  $Address2 = str_replace("'","''",$Address2);
		  $Option1=$_GET["Option1"];
          $Option2=$_GET["Option2"];
          $Option3=$_GET["Option3"];
          $ContactPerson=$_GET["ContactPerson"]; 
		  $street=$_GET["street"];
		  $street = str_replace("'","''",$street);
		  $City=$_GET["City"];
		  $State=$_GET["State"];
		  $Country=$_GET["Country"];
		  $ZipCode=$_GET["ZipCode"];
		  $Phone=$_GET["Phone"];
		  $Fax=$_GET["Fax"];
		  $email=$_GET["email"];
		  $Web=$_GET["Web"];
		  $Remarks=$_GET["Remarks"];
		  $Remarks = str_replace("'","''",$Remarks);
		  $Keyitems=$_GET["Keyitems"];
		  $Currcncy=$_GET["Currcncy"];
		  $Origin=$_GET["Origin"];
		  $taxenable=$_GET["taxenable"];
		  $creditallowed=$_GET["creditallowed"];
		  $vatsuspended=$_GET["vatsuspended"];
		  $supplierappo=$_GET["supplierappo"];
		  $SupplierStatus=$_GET["SupplierStatus"];
		  $SupplierID=$_GET["SupplierID"];
		  $Taxtype=$_GET["Taxtype"];
		  $Creditperi=$_GET["Creditperi"];
          $txtReason=$_GET["txtReason"];
		  $intShipmentModeId = $_GET["intShipmentModeId"];
		  $strShipmentTermId = $_GET["strShipmentTermId"];
		  $strPayModeId = $_GET["strPayModeId"];
		  $strPayTermId = $_GET["strPayTermId"];
	      $cboSupApp = $_GET["cboSupApp"];
          $appComments=$_GET["txtApprComments"];

     $SQL_checksupp="SELECT strTitle,intStatus FROM suppliers where strTitle = '".$ComName."';";
     $result_checksupp = $db->RunQuery($SQL_checksupp);

	 if($row_supp = mysql_fetch_array($result_checksupp))
	 {
	 	if($row_supp["intStatus"]==0)
		 {
		 echo $SQL_newupdate="update suppliers set strTitle='".$ComName."',strAddress1='".$Address1."',strAddress2='".$Address2."',
		 strOption1='".$Option1."', strOption2='".$Option2."',strOption3='".$Option3."',strContactPerson='".$ContactPerson."',
		 strStreet='".$street."',strCity='".$City."',strState='".$State."',strCountry='".$Country."',strZipCode='".$ZipCode."',strPhone='".$Phone."',strEMail='".$email."',strFax='".$Fax."',strWeb='".$Web."',strRemarks='".$Remarks."',strKeyItems='".$Keyitems."',strOrigin='".$Origin."',strCurrency='".$Currcncy."',strVatRegNo='".$VatReNo."',intTaxEnabled=".$taxenable.",intVATSuspended=".$vatsuspended.",strTaxTypeID='".$Taxtype."',intCreditPeriod='".$Creditperi."',intStatus=1,intApproved=".$supplierappo.",intSupplierStatus=".$SupplierStatus.",intCreditAllowed=".$creditallowed.", strSupplierCode='$supplierCode',strKeyitems='$Keyitems',
		   	,intShipmentModeId='$intShipmentModeId'
			,strShipmentTermId='$strShipmentTermId'
			,strPayModeId='$strPayModeId'
			,strPayTermId='$strPayTermId'
			,strReason='$txtReason',cboSupApp='$cboSupApp',strAppComments='$appComments'
		  where strSupplierID = '".$SupplierID."';";
  
  		$db->ExecuteQuery($SQL_newupdate);

		echo "Saved SuccessFully";
			
		 
		 }
		 else
		 {
		 	echo "Supplier is all ready Exists.";
		 }
	 
	 
	 }
	 else
	 {
	 
	 		       $SQL_MaxID="SELECT CASE WHEN ( MAX(strSupplierID) IS NULL ) THEN 1 ELSE MAX(strSupplierID)+1 END AS strSupplierID  FROM suppliers;";
			   
			   $result_MaxID = $db->RunQuery($SQL_MaxID);
			   
			if($row_MaxID = mysql_fetch_array($result_MaxID))
		    {
			     $strSupplierID=$row_MaxID["strSupplierID"];
		    }
	 
	 echo $SQL_insert="insert into suppliers (strSupplierID,strTitle,strAddress1,strAddress2,strOption1,strOption2,strOption3,strContactPerson,strStreet,strCity,strState,strCountry,strZipCode,strPhone,strEMail,strFax,strWeb,strRemarks,strKeyItems,intStatus,intApproved,strOrigin,strCurrency,intCreditAllowed,strVatRegNo,intTaxEnabled,intVATSuspended,strTaxTypeID,intCreditPeriod,intSupplierStatus,strSupplierCode,intShipmentModeId,strShipmentTermId,strPayModeId,strPayTermId,strReason,cboSupApp,strKeyitems,strAppComments) 
values ('".$strSupplierID."','".$ComName."','".$Address1."','".$Address2."','".$Option1."','".$Option2."','".$Option3."','".$ContactPerson."',
'".$street."','".$City."','".$State."','".$Country."','".$ZipCode."','".$Phone."','".$email."','".$Fax."','".$Web."','".$Remarks."',
'".$Keyitems."',1,".$supplierappo.",'".$Origin."','".$Currcncy."',".$creditallowed.",'".$VatReNo."',".$taxenable.",".$vatsuspended.",'".$Taxtype."',
".$Creditperi.",".$SupplierStatus.",'$supplierCode','$intShipmentModeId','$strShipmentTermId','$strPayModeId','$strPayTermId','$txtReason','$cboSupApp','$Keyitems','$appComments')";
	//echo $SQL_insert;
	        $db->ExecuteQuery($SQL_insert);

			echo "Saved SuccessFully";
			//echo $strSupplierID;
			//echo $Button;
			//echo "Supplier added sucessfully";
			//echo $SQL_insert;
	 
	 }


}
		
		//Delete
			 
		if($Button=="Delete")
		{	
		$strTitle=$_GET["ComName"];	
		 $SQL="UPDATE suppliers SET intStatus=10 WHERE strTitle = '$strTitle';";

		 $db->ExecuteQuery($SQL);		
		 echo "Deleted SuccessFully.";
		 //echo $SQL;
		 
		 }
	



?>
