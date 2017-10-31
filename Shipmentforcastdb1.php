<?php
header('Content-type: text/xml');
	session_start();
	include "Connector.php";
	$request = $_GET['REQUEST'];
	
	
	if($request == "adddata"){
	$sc_no 		 	 =  $_GET['SCNO'];
	$buyer 		 	 =  $_GET['Buyer'];
	$drop_no 	 	 =  $_GET['Delivery'];
	$po_no 		 	 =  $_GET['PoNo'];	
	$StyleNo	 	 =  $_GET['StyleNo'];
	$DeptNo		 	 =  $_GET['DeptNo'];
	$season 	 	 =  $_GET['Season'];
	$GOH 		 	 =  $_GET['GOH'];
	$CTNS 		 	 =  $_GET['CTNS'];
	$packType	 	 = 	$_GET['PackType'];
	$Qty 		 	 =  $_GET['QTY'];
	$NET_wt		 	 =  $_GET['NetWeight'];
	$GRS_Wt      	 =  $_GET['GrossWeight'];
	$Ctn_L		 	 =  $_GET['CTNL'];
	$Ctn_W       	 =  $_GET['CTNW'];
	$Ctn_H       	 =  $_GET['CTNH'];
	$U_PRICE     	 =  $_GET['UnitPrice'];
	$GSP_STATUS  	 =  $_GET['GSPApproval'];
	$DESC         	 =  $_GET['Description'];
	$fabric		 	 =  $_GET['Fabric'];
	$Country 		 = 	$_GET['Country'];
	$FACTORY     	 =  $_GET['Factory'];
	$SHIP_MODE       =  $_GET['ShipMode'];
	
	$EX_FTY          =  $_GET['EXFTY'];
	$DateArrry= explode('/',$EX_FTY);
	$EX_FTY			 = $DateArrry[2].'-'.$DateArrry[1].'-'.$DateArrry[0];
	
	$FOB_DATE        =  $_GET[''];
	$PO_Des			 =  $_GET['PODesc'];
	$ITEM_No       	 =  $_GET['ItemNo'];
	$Knit_Woven      =  $_GET['KnitWoven'];
	$CONTRACT        =  $_GET['ContractNo'];
	$RETEK_NO        =  $_GET[''];
	$ORMS_PORD_No    =  $_GET['PordNo'];
	$IMAN_Code       =  $_GET['IMANCode'];
	$Criterion_No    =  $_GET['Criterion'];
	$TU_PONO		 =  $_GET['TuPoNo'];
	$TU_STY      	 =  $_GET['TuStyle'];
	$PLANT    	     =  $_GET[''];
	$CUSTOMER        =  $_GET[''];
	$PO_HIT_NO		 =  $_GET[''];
	$FCL_LCL      	 =  $_GET['FCLLCL'];
	$VCP    	     =  $_GET[''];
	$PRODUCT_NO      =  $_GET[''];
	$SALES_ORDER_NO	 =  $_GET[''];
	$ITEM_COLOR      =  $_GET['Color'];
	$CTNS_TYPE    	 =  $_GET[''];
	$UNITE       	 =  $_GET['UnitPCSSETS'];
	$SCF_STATUS		 =  $_GET[''];
	$Destination     =  $_GET['Destination'];
	$Product_Code    =  $_GET[''];
	$Marsks_Numbers  =  $_GET[''];
	$PCS_Per_CTNS	 =  $_GET['PCSPerCTNS'];
	$NetWT_Ppcs      =  $_GET['NETWTPPC'];
	$GrsWT_Ppcs    	 =  $_GET['GRSWTPPc'];
	$BLUES_PO_NO     =  $_GET[''];
	$OTHER_REF	     =  $_GET['Reference'];
	$CBM			 =  $_GET['CBM'];
	$MRP_Price       =  $_GET[''];
	$PbarQty      	 =  $_GET[''];
	
	$FactoryDate   	 =  $_GET['FactoryDate'];
	$sailingDateArrry= explode('/',$FactoryDate);
	$FactoryDate	 = $sailingDateArrry[2].'-'.$sailingDateArrry[1].'-'.$sailingDateArrry[0];
	

					if($buyer == ""){
					$buyer = "n/a";
					}
					if($drop_no == ""){
					$drop_no = 0;
					}
					if($po_no == ""){
					$po_no = 0;
					}
					if($StyleNo == ""){
					$StyleNo = 0;
					}
					if($DeptNo == ""){
					$DeptNo = 0;
					}
					if($season == ""){
					$season = 0;
					}
					if($GOH == ""){
					$GOH = 0;
					}
					if($CTNS == ""){
					$CTNS = 0;
					}
					if($packType == ""){
					$packType = 0;
					}
					if($Qty == ""){
					$Qty = 0;
					}
					if($NET_wt == ""){
					$NET_wt = 0;
					}
					if($GRS_Wt == ""){
					$GRS_Wt = 0;
					}
					if($Ctn_L == ""){
					$Ctn_L = 0;
					}
					if($Ctn_W == ""){
					$Ctn_W = 0;
					}
					if($Ctn_H == ""){
					$Ctn_H = 0;
					}
					if($U_PRICE == ""){
					$U_PRICE = 0;
					}
					if($GSP_STATUS == ""){
					$GSP_STATUS = 0;
					}
					if($DESC == ""){
					$DESC = 0;
					}
					if($fabric == ""){
					$fabric = 0;
					}
					if($Country == ""){
					$Country = 0;
					}
					if($FACTORY == ""){
					$FACTORY = 0;
					}
					if($SHIP_MODE == ""){
					$SHIP_MODE = 0;
					}
					if($EX_FTY == ""){
					$EX_FTY = 0;
					}
					if($FOB_DATE == ""){
					$FOB_DATE = 0;
					}
					if($PO_Des == ""){
					$PO_Des = 0;
					}
					if($ITEM_No == ""){
					$ITEM_No = 0;
					}
					if($Knit_Woven == ""){
					$Knit_Woven = 0;
					}
					if($CONTRACT == ""){
					$CONTRACT = 0;
					}
					if($RETEK_NO == ""){
					$RETEK_NO = 0;
					}
					if($ORMS_PORD_No == ""){
					$ORMS_PORD_No = 0;
					}
					if($IMAN_Code == ""){
					$IMAN_Code = 0;
					}
					if($Criterion_No == ""){
					$Criterion_No = 0;
					}
					if($TU_PONO == ""){
					$TU_PONO = 0;
					}
					if($TU_STY == ""){
					$TU_STY = 0;
					}
					if($PLANT == ""){
					$PLANT = 0;
					}
					if($CUSTOMER == ""){
					$CUSTOMER = 0;
					}
					if($PO_HIT_NO == ""){
					$PO_HIT_NO = 0;
					}
					if($FCL_LCL == ""){
					$FCL_LCL = 0;
					}
					if($VCP == ""){
					$VCP = 0;
					}
					if($PRODUCT_NO == ""){
					$PRODUCT_NO = 0;
					}
					if($SALES_ORDER_NO == ""){
					$SALES_ORDER_NO = 0;
					}
					if($ITEM_COLOR == ""){
					$ITEM_COLOR = 0;
					}
					if($CTNS_TYPE == ""){
					$CTNS_TYPE = 0;
					}
					if($UNITE == ""){
					$UNITE = 0;
					}
					if($SCF_STATUS == ""){
					$SCF_STATUS = 0;
					}
					if($Destination == ""){
					$Destination = 0;
					}
					if($Product_Code == ""){
					$Product_Code = 0;
					}
					if($Marsks_Numbers == ""){
					$Marsks_Numbers = 0;
					}
					if($PCS_Per_CTNS == ""){
					$PCS_Per_CTNS = 0;
					}
					if($NetWT_Ppcs == ""){
					$NetWT_Ppcs = 0;
					}
					if($GrsWT_Ppcs == ""){
					$GrsWT_Ppcs = 0;
					}
					if($BLUES_PO_NO == ""){
					$BLUES_PO_NO = 0;
					}
					if($OTHER_REF == ""){
					$OTHER_REF = 0;
					}
					if($CBM == ""){
					$CBM = 0;
					}
					if($MRP_Price == ""){
					$MRP_Price = 0;
					}
					if($PbarQty == ""){
					$PbarQty = 0;
					}
					if($FactoryDate == ""){
					$FactoryDate = 0;
					}
					
					
					
		$SQL_add="INSERT INTO shipmentforecast_detail
							(
							strSC_No,
							strBuyer,
							strDrop_No,
							strPoNo,
							strStyleNo,
							strDeptNo,
							strSeason,
							strGOH_No,
							strPackType,
							strQty,
							intNOF_Ctns,
							intNetWt,
							intGrsWt,
							intCtnsL,
							intCtnsW,
							intCtnsH,
							intUnitPrice,
							intGSP_status,
							strDesc,
							strFabric,
							strCountry,
							strFactory,
							strShipMode,
							dtmEX_FTY_Date,
							dtmFOBdate,
							strPo_des,
							strItemNo,
							strknit_woven,
							strContractva,
							strRetec_No,
							strOrms_Pord_No,
							strIMAN_Code,
							strCriterion_No,
							strTu_PoNo,
							strTu_Style,
							strPlant,
							strCustomer,
							strPo_Hit_No,
							strFcl_Lcl,
							strVCP,
							strProduct_No,
							strSales_Order_No,
							strItem_Color,
							strCtns_Type,
							strUnite,
							strSTF,
							strDestination,
							strProduct_Code,
							strMarsks_Numbers,
							strPcs_Per_Ctns,
							strNetWT_Ppcs,
							strGrsWT_Ppcs,
							strBlues_Po_No,
							strOther_Ref,
							dblCBM,
							dtmUp_Date,
							dblMRP_Price,
							strPbarQty,
							strStatus,
							strPossibleQty,
							strPossibleDate,
							strFactoryDate
							)
							VALUES
							(
							'$sc_no', 
							'$buyer',
							'$drop_no', 
							'$po_no', 
							'$StyleNo',
							'$DeptNo',
							'$season', 
							'$GOH',
							'$packType',
							'$Qty',
							'$CTNS' ,
							'$NET_wt',
							'$GRS_Wt',    
							'$Ctn_L',
							'$Ctn_W',     
							'$Ctn_H',      
							'$U_PRICE',    
							'$GSP_STATUS',
							'$DESC',      
							'$fabric',
							'$Country', 
							'$FACTORY',  
							'$SHIP_MODE', 
							'$EX_FTY',   
							'$FOB_DATE',    
							'$PO_Des',
							'$ITEM_No',    
							'$Knit_Woven',
							'$CONTRACT',    
							'$RETEK_NO',   
							'$ORMS_PORD_No',
							'$IMAN_Code',   
							'$Criterion_No',
							'$TU_PONO',
							'$TU_STY',      
							'$PLANT',   
							'$CUSTOMER',   
							'$PO_HIT_NO',
							'$FCL_LCL',     
							'$VCP',   
							'$PRODUCT_NO',  
							'$SALES_ORDER_NO',
							'$ITEM_COLOR',    
							'$CTNS_TYPE',    
							'$UNITE',     
							'$SCF_STATUS',
							'$Destination',   
							'$Product_Code',  
							'$Marsks_Numbers',
							'$PCS_Per_CTNS',
							'$NetWT_Ppcs',      
							'$GrsWT_Ppcs',   
							'$BLUES_PO_NO',     
							'$OTHER_REF',
							$CBM,	
							now(),
							$MRP_Price,
							$PbarQty,
							'0',
							'0',
							'',
							'$FactoryDate'
							)";
					$result=$db->RunQuery($SQL_add);
					if($result){
							echo "Successfully Saved";
						}
		}
		
		
		if($request == "editforcast"){
	$sc_no 		 	 =  $_GET['SCNO'];
	$buyer 		 	 =  $_GET['Buyer'];
	$drop_no 	 	 =  $_GET['Delivery'];
	$po_no 		 	 =  $_GET['PoNo'];	
	$StyleNo	 	 =  $_GET['StyleNo'];
	$DeptNo		 	 =  $_GET['DeptNo'];
	$season 	 	 =  $_GET['Season'];
	$GOH 		 	 =  $_GET['GOH'];
	$CTNS 		 	 =  $_GET['CTNS'];
	$packType	 	 = 	$_GET['PackType'];
	$Qty 		 	 =  $_GET['QTY'];
	$NET_wt		 	 =  $_GET['NetWeight'];
	$GRS_Wt      	 =  $_GET['GrossWeight'];
	$Ctn_L		 	 =  $_GET['CTNL'];
	$Ctn_W       	 =  $_GET['CTNW'];
	$Ctn_H       	 =  $_GET['CTNH'];
	$U_PRICE     	 =  $_GET['UnitPrice'];
	$GSP_STATUS  	 =  $_GET['GSPApproval'];
	$DESC         	 =  $_GET['Description'];
	$fabric		 	 =  $_GET['Fabric'];
	$Country 		 = 	$_GET['Country'];
	$FACTORY     	 =  $_GET['Factory'];
	$SHIP_MODE       =  $_GET['ShipMode'];
	
	$EX_FTY          =  $_GET['EXFTY'];
	$DateArrry= explode('/',$EX_FTY);
	$EX_FTY			 = $DateArrry[2].'-'.$DateArrry[1].'-'.$DateArrry[0];
	
	$FOB_DATE        =  $_GET[''];
	$PO_Des			 =  $_GET['PODesc'];
	$ITEM_No       	 =  $_GET['ItemNo'];
	$Knit_Woven      =  $_GET['KnitWoven'];
	$CONTRACT        =  $_GET['ContractNo'];
	$RETEK_NO        =  $_GET[''];
	$ORMS_PORD_No    =  $_GET['PordNo'];
	$IMAN_Code       =  $_GET['IMANCode'];
	$Criterion_No    =  $_GET['Criterion'];
	$TU_PONO		 =  $_GET['TuPoNo'];
	$TU_STY      	 =  $_GET['TuStyle'];
	$PLANT    	     =  $_GET[''];
	$CUSTOMER        =  $_GET[''];
	$PO_HIT_NO		 =  $_GET[''];
	$FCL_LCL      	 =  $_GET['FCLLCL'];
	$VCP    	     =  $_GET[''];
	$PRODUCT_NO      =  $_GET[''];
	$SALES_ORDER_NO	 =  $_GET[''];
	$ITEM_COLOR      =  $_GET['Color'];
	$CTNS_TYPE    	 =  $_GET[''];
	$UNITE       	 =  $_GET['UnitPCSSETS'];
	$SCF_STATUS		 =  $_GET[''];
	$Destination     =  $_GET['Destination'];
	$Product_Code    =  $_GET[''];
	$Marsks_Numbers  =  $_GET[''];
	$PCS_Per_CTNS	 =  $_GET['PCSPerCTNS'];
	$NetWT_Ppcs      =  $_GET['NETWTPPC'];
	$GrsWT_Ppcs    	 =  $_GET['GRSWTPPc'];
	$BLUES_PO_NO     =  $_GET[''];
	$OTHER_REF	     =  $_GET['Reference'];
	$CBM			 =  $_GET['CBM'];
	$MRP_Price       =  $_GET[''];
	$PbarQty      	 =  $_GET[''];
	$ShipmentID      =  $_GET['ShipmentID'];
	
	$FactoryDate   	 =  $_GET['FactoryDate'];
	$sailingDateArrry= explode('/',$FactoryDate);
	$FactoryDate	 = $sailingDateArrry[2].'-'.$sailingDateArrry[1].'-'.$sailingDateArrry[0];

					if($buyer == ""){
					$buyer = "n/a";
					}
					if($drop_no == ""){
					$drop_no = 0;
					}
					if($po_no == ""){
					$po_no = 0;
					}
					if($StyleNo == ""){
					$StyleNo = 0;
					}
					if($DeptNo == ""){
					$DeptNo = 0;
					}
					if($season == ""){
					$season = 0;
					}
					if($GOH == ""){
					$GOH = 0;
					}
					if($CTNS == ""){
					$CTNS = 0;
					}
					if($packType == ""){
					$packType = 0;
					}
					if($Qty == ""){
					$Qty = 0;
					}
					if($NET_wt == ""){
					$NET_wt = 0;
					}
					if($GRS_Wt == ""){
					$GRS_Wt = 0;
					}
					if($Ctn_L == ""){
					$Ctn_L = 0;
					}
					if($Ctn_W == ""){
					$Ctn_W = 0;
					}
					if($Ctn_H == ""){
					$Ctn_H = 0;
					}
					if($U_PRICE == ""){
					$U_PRICE = 0;
					}
					if($GSP_STATUS == ""){
					$GSP_STATUS = 0;
					}
					if($DESC == ""){
					$DESC = 0;
					}
					if($fabric == ""){
					$fabric = 0;
					}
					if($Country == ""){
					$Country = 0;
					}
					if($FACTORY == ""){
					$FACTORY = 0;
					}
					if($SHIP_MODE == ""){
					$SHIP_MODE = 0;
					}
					if($EX_FTY == ""){
					$EX_FTY = 0;
					}
					if($FOB_DATE == ""){
					$FOB_DATE = 0;
					}
					if($PO_Des == ""){
					$PO_Des = 0;
					}
					if($ITEM_No == ""){
					$ITEM_No = 0;
					}
					if($Knit_Woven == ""){
					$Knit_Woven = 0;
					}
					if($CONTRACT == ""){
					$CONTRACT = 0;
					}
					if($RETEK_NO == ""){
					$RETEK_NO = 0;
					}
					if($ORMS_PORD_No == ""){
					$ORMS_PORD_No = 0;
					}
					if($IMAN_Code == ""){
					$IMAN_Code = 0;
					}
					if($Criterion_No == ""){
					$Criterion_No = 0;
					}
					if($TU_PONO == ""){
					$TU_PONO = 0;
					}
					if($TU_STY == ""){
					$TU_STY = 0;
					}
					if($PLANT == ""){
					$PLANT = 0;
					}
					if($CUSTOMER == ""){
					$CUSTOMER = 0;
					}
					if($PO_HIT_NO == ""){
					$PO_HIT_NO = 0;
					}
					if($FCL_LCL == ""){
					$FCL_LCL = 0;
					}
					if($VCP == ""){
					$VCP = 0;
					}
					if($PRODUCT_NO == ""){
					$PRODUCT_NO = 0;
					}
					if($SALES_ORDER_NO == ""){
					$SALES_ORDER_NO = 0;
					}
					if($ITEM_COLOR == ""){
					$ITEM_COLOR = 0;
					}
					if($CTNS_TYPE == ""){
					$CTNS_TYPE = 0;
					}
					if($UNITE == ""){
					$UNITE = 0;
					}
					if($SCF_STATUS == ""){
					$SCF_STATUS = 0;
					}
					if($Destination == ""){
					$Destination = 0;
					}
					if($Product_Code == ""){
					$Product_Code = 0;
					}
					if($Marsks_Numbers == ""){
					$Marsks_Numbers = 0;
					}
					if($PCS_Per_CTNS == ""){
					$PCS_Per_CTNS = 0;
					}
					if($NetWT_Ppcs == ""){
					$NetWT_Ppcs = 0;
					}
					if($GrsWT_Ppcs == ""){
					$GrsWT_Ppcs = 0;
					}
					if($BLUES_PO_NO == ""){
					$BLUES_PO_NO = 0;
					}
					if($OTHER_REF == ""){
					$OTHER_REF = 0;
					}
					if($CBM == ""){
					$CBM = 0;
					}
					if($MRP_Price == ""){
					$MRP_Price = 0;
					}
					if($PbarQty == ""){
					$PbarQty = 0;
					}
					if($FactoryDate == ""){
					$FactoryDate = 0;
					}
		$SQL_edit="UPDATE shipmentforecast_detail SET
							strSC_No='$sc_no',
							strBuyer='$buyer',
							strDrop_No='$drop_no',
							strPoNo='$po_no',
							strStyleNo='$StyleNo',
							strDeptNo='$DeptNo',
							strSeason='$season',
							strGOH_No='$GOH',
							strPackType='$packType',
							strQty='$Qty',
							intNOF_Ctns='$CTNS',
							intNetWt='$NET_wt',
							intGrsWt='$GRS_Wt',
							intCtnsL='$Ctn_L',
							intCtnsW='$Ctn_W',
							intCtnsH='$Ctn_H',
							intUnitPrice='$U_PRICE',
							intGSP_status='$GSP_STATUS',
							strDesc='$DESC',
							strFabric='$fabric',
							strCountry='$Country',
							strFactory='$FACTORY',
							strShipMode='$SHIP_MODE',
							dtmEX_FTY_Date='$EX_FTY',
							dtmFOBdate='$FOB_DATE',
							strPo_des='$PO_Des',
							strItemNo='$ITEM_No',
							strknit_woven='$Knit_Woven',
							strContractva='$CONTRACT',
							strRetec_No='$RETEK_NO',
							strOrms_Pord_No='$ORMS_PORD_No',
							strIMAN_Code='$IMAN_Code',
							strCriterion_No='$Criterion_No',
							strTu_PoNo='$TU_PONO',
							strTu_Style='$TU_STY',
							strPlant='$PLANT',
							strCustomer='$CUSTOMER',
							strPo_Hit_No='$PO_HIT_NO',
							strFcl_Lcl='$FCL_LCL',
							strVCP='$VCP',
							strProduct_No='$PRODUCT_NO',
							strSales_Order_No='$SALES_ORDER_NO',
							strItem_Color='$ITEM_COLOR',
							strCtns_Type='$CTNS_TYPE',
							strUnite='$UNITE',
							strSTF='$SCF_STATUS',
							strDestination='$Destination',
							strProduct_Code='$Product_Code',
							strMarsks_Numbers='$Marsks_Numbers',
							strPcs_Per_Ctns='$PCS_Per_CTNS',
							strNetWT_Ppcs='$NetWT_Ppcs',
							strGrsWT_Ppcs='$GrsWT_Ppcs',
							strBlues_Po_No='$BLUES_PO_NO',
							strOther_Ref='$OTHER_REF',
							dblCBM='$CBM',
							dblMRP_Price='$MRP_Price',
							strPbarQty='$PbarQty',
							strStatus='0',
							strFactoryDate='$FactoryDate'
							WHERE intID='$ShipmentID'";
					$result=$db->RunQuery($SQL_edit);
					if($result){
							echo "Successfully Saved";
						}
		}
		
		
		if($request == "getdata"){
			$buyer = $_GET['Buyer'];
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
						$ResponseXML = "";
						$ResponseXML.= "<GridDetails>\n";
			
			$getdata="SELECT
			shipmentforecast_detail.strSC_No,
			shipmentforecast_detail.strBuyer,
			shipmentforecast_detail.strPoNo,
			shipmentforecast_detail.strStyleNo,
			shipmentforecast_detail.strQty,
			shipmentforecast_detail.intNetWt,
			shipmentforecast_detail.intGrsWt,
			shipmentforecast_detail.intNOF_Ctns,
			shipmentforecast_detail.intUnitPrice,
			shipmentforecast_detail.strDesc,
			shipmentforecast_detail.strFabric,
			shipmentforecast_detail.strCountry,
			shipmentforecast_detail.strItem_Color,
			shipmentforecast_detail.strFactory,
			shipmentforecast_detail.dblCBM,
			shipmentforecast_detail.intGSP_status,
			shipmentforecast_detail.dtmUp_Date,
			shipmentforecast_detail.strRetec_No,
			shipmentforecast_detail.strPackType,
			shipmentforecast_detail.strUnite,
			shipmentforecast_detail.strSeason,
			shipmentforecast_detail.intID,
			shipmentforecast_detail.strStatus,
			shipmentforecast_detail.strPossibility,
			shipmentforecast_detail.strPossibleQty,
			shipmentforecast_detail.strPossibleDate
			FROM
			shipmentforecast_detail
			WHERE strBuyer = '$buyer'
			ORDER BY
			shipmentforecast_detail.dtmUp_Date DESC";
			$result_getdata=$db->RunQuery($getdata);
			
			while($row=mysql_fetch_array($result_getdata))
	{
                        
                        $ResponseXML .= "<SCNo><![CDATA[" . $row["strSC_No"]  . "]]></SCNo>\n";
                        $ResponseXML .= "<PoNo><![CDATA[" . $row["strPoNo"]  . "]]></PoNo>\n";
                        $ResponseXML .= "<StyleNo><![CDATA[" . $row["strStyleNo"]  . "]]></StyleNo>\n";
                        $ResponseXML .= "<Desc><![CDATA[" .$row["strDesc"]  . "]]></Desc>\n";
                        $ResponseXML .= "<Fabric><![CDATA[" .$row["strFabric"]  . "]]></Fabric>\n";
                        $ResponseXML .= "<CBM><![CDATA[" .$row["dblCBM"]  . "]]></CBM>\n";
                        $ResponseXML .= "<Season><![CDATA[" .$row["strSeason"]  . "]]></Season>\n";
                        $ResponseXML .= "<UnitPrice><![CDATA[" .$row["intUnitPrice"]  . "]]></UnitPrice>\n";
                        $ResponseXML .= "<Factory><![CDATA[" .$row["strFactory"]  . "]]></Factory>\n";
                        $ResponseXML .= "<CtnMes><![CDATA[" .$row["intNOF_Ctns"]  . "]]></CtnMes>\n";
                        $ResponseXML .= "<Qty><![CDATA[" .$row["strQty"]  . "]]></Qty>\n";
                      	$ResponseXML .= "<Net><![CDATA[" .$row["intNetWt"]  . "]]></Net>\n";
						$ResponseXML .= "<Grs><![CDATA[" . $row["intGrsWt"]  . "]]></Grs>\n";
						$ResponseXML .= "<GSP><![CDATA[" . $row["intGSP_status"]  . "]]></GSP>\n";
						$ResponseXML .= "<UpLdDate><![CDATA[" . $row["dtmUp_Date"]  . "]]></UpLdDate>\n";
						$ResponseXML .= "<Color><![CDATA[" . $row["strItem_Color"]  . "]]></Color>\n";
						$ResponseXML .= "<RetecNo><![CDATA[" . $row["strRetec_No"]  . "]]></RetecNo>\n";
						$ResponseXML .= "<PackType><![CDATA[" . $row["strPackType"]  . "]]></PackType>\n";
						$ResponseXML .= "<Unite><![CDATA[" . $row["strUnite"]  . "]]></Unite>\n";
						$ResponseXML .= "<Season><![CDATA[" . $row["strSeason"]  . "]]></Season>\n";
						$ResponseXML .= "<shipmentID><![CDATA[" . $row["intID"]  . "]]></shipmentID>\n";
						$ResponseXML .= "<Status><![CDATA[" . $row["strStatus"]  . "]]></Status>\n";
						$ResponseXML .= "<Possibility><![CDATA[" . $row["strPossibility"]  . "]]></Possibility>\n";
						$ResponseXML .= "<PossibleQty><![CDATA[" . $row["strPossibleQty"]  . "]]></PossibleQty>\n";
						$PossibleDate =substr($row["strPossibleDate"],0,10);
						$PossibleDateArray=explode('-',$PossibleDate);
						$formatedPossibleDateDate=$PossibleDateArray[2]."/".$PossibleDateArray[1]."/".$PossibleDateArray[0];
						$ResponseXML .= "<PossibleDate><![CDATA[" . $formatedPossibleDateDate  . "]]></PossibleDate>\n";
			
			
	}
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;
	
}

if($request == "load_SC"){
	$getdata="SELECT
				specification.intSRNO
				FROM
				specification
				GROUP BY
				specification.intSRNO
				ORDER BY
				specification.intSRNO ASC";
			$result_getdata=$db->RunQuery($getdata);
			
			while($row=mysql_fetch_array($result_getdata)){
				$inv_arr.=$row['intSRNO']."|";
				 
			}
			echo $inv_arr;
		
}

if($request == "load_PO"){
	$SCNo = $_GET['SCNo'];
	$getdata="SELECT
				specification.intSRNO,
				bpodelschedule.strBuyerPONO
				FROM
				specification
				INNER JOIN bpodelschedule ON bpodelschedule.intStyleId = specification.intStyleId
				WHERE
				specification.intSRNO = '$SCNo'
				ORDER BY
				bpodelschedule.strBuyerPONO ASC";
			$result_getdata=$db->RunQuery($getdata);
			
			while($row=mysql_fetch_array($result_getdata)){
				$inv_arr.=$row['strBuyerPONO']."|";
				 
			}
			echo $inv_arr;
		
}

if($request == "loadData"){

	$SCNo = $_GET['SCNo'];
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$RequestXML = "";
	$RequestXML.= "<GridDetails>\n";
	$getdata="SELECT
bpodelschedule.intStyleId,
DATE_FORMAT(bpodelschedule.dtDateofDelivery, '%d/%m/%Y') AS dtDateofDelivery,
style_buyerponos.strBuyerPoName,
bpodelschedule.strBuyerPONO,
bpodelschedule.intQty,
bpodelschedule.strRemarks,
style_buyerponos.strCountryCode,
country.strCountry,
DATE_FORMAT(deliveryschedule.estimatedDate, '%d/%m/%Y') AS estimatedDate,
DATE_FORMAT(deliveryschedule.dtmHandOverDate, '%d/%m/%Y') AS handoverDate,
deliveryschedule.strShippingMode,
shipmentmode.strDescription,
deliveryschedule.intSerialNO,
eventtemplateheader.reaLeadTime,
country.intConID,
specification.intStyleId,
specification.intSRNO,
orders.strStyle
FROM
bpodelschedule
INNER JOIN style_buyerponos ON bpodelschedule.intStyleId = style_buyerponos.intStyleId AND bpodelschedule.strBuyerPONO = style_buyerponos.strBuyerPoName
INNER JOIN country ON style_buyerponos.strCountryCode = country.intConID
INNER JOIN deliveryschedule ON bpodelschedule.intStyleId = deliveryschedule.intStyleId AND deliveryschedule.intBPO = style_buyerponos.strBuyerPoName
INNER JOIN shipmentmode ON deliveryschedule.strShippingMode = shipmentmode.intShipmentModeId
LEFT JOIN eventtemplateheader ON deliveryschedule.intSerialNO = eventtemplateheader.intSerialNO
INNER JOIN specification ON bpodelschedule.intStyleId = specification.intStyleId
INNER JOIN orders ON specification.intStyleId = orders.intStyleId
WHERE
specification.intSRNO = '$SCNo'
GROUP BY
bpodelschedule.intStyleId,
bpodelschedule.dtDateofDelivery,
bpodelschedule.strBuyerPONO
order by style_buyerponos.strBuyerPoName";
			$result_getdata=$db->RunQuery($getdata);
			
			while($row=mysql_fetch_array($result_getdata)){
     			$RequestXML .= "<strStyle><![CDATA[" . $row["strStyle"]  . "]]></strStyle>\n";
				$RequestXML .= "<strBuyerPONO><![CDATA[" . $row["strBuyerPONO"]  . "]]></strBuyerPONO>\n";
				$RequestXML .= "<dtDateofDelivery><![CDATA[" . $row["dtDateofDelivery"]  . "]]></dtDateofDelivery>\n";
				$RequestXML .= "<intQty><![CDATA[" . $row["intQty"]  . "]]></intQty>\n";
				$RequestXML .= "<strCountry><![CDATA[" . $row["strCountry"]  . "]]></strCountry>\n";
				//$RequestXML .= "<dblUnitPrice><![CDATA[" . $row["dblUnitPrice"]  . "]]></dblUnitPrice>\n";
			}
		$RequestXML .= "</GridDetails>";
	echo $RequestXML;
}
		
if($request == "loadPOData"){

	$PONo = $_GET['PONo'];
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$RequestXML = "";
	$RequestXML.= "<GridDetails>\n";
	$getdata="SELECT
bpodelschedule.intStyleId,
DATE_FORMAT(bpodelschedule.dtDateofDelivery, '%d/%m/%Y') AS dtDateofDelivery,
style_buyerponos.strBuyerPoName,
bpodelschedule.strBuyerPONO,
bpodelschedule.intQty,
bpodelschedule.strRemarks,
style_buyerponos.strCountryCode,
country.strCountry,
DATE_FORMAT(deliveryschedule.estimatedDate, '%d/%m/%Y') AS estimatedDate,
DATE_FORMAT(deliveryschedule.dtmHandOverDate, '%d/%m/%Y') AS handoverDate,
deliveryschedule.strShippingMode,
shipmentmode.strDescription,
deliveryschedule.intSerialNO,
eventtemplateheader.reaLeadTime,
country.intConID,
orders.strStyle
FROM
bpodelschedule
INNER JOIN style_buyerponos ON bpodelschedule.intStyleId = style_buyerponos.intStyleId AND bpodelschedule.strBuyerPONO = style_buyerponos.strBuyerPoName
INNER JOIN country ON style_buyerponos.strCountryCode = country.intConID
INNER JOIN deliveryschedule ON bpodelschedule.intStyleId = deliveryschedule.intStyleId AND deliveryschedule.intBPO = style_buyerponos.strBuyerPoName
INNER JOIN shipmentmode ON deliveryschedule.strShippingMode = shipmentmode.intShipmentModeId
LEFT JOIN eventtemplateheader ON deliveryschedule.intSerialNO = eventtemplateheader.intSerialNO ,
orders
WHERE
bpodelschedule.strBuyerPONO = '$PONo'
GROUP BY
bpodelschedule.intStyleId,
bpodelschedule.dtDateofDelivery,
bpodelschedule.strBuyerPONO
order by style_buyerponos.strBuyerPoName";
			$result_getdata=$db->RunQuery($getdata);
			
			while($row=mysql_fetch_array($result_getdata)){
     			$RequestXML .= "<strStyle><![CDATA[" . $row["strStyle"]  . "]]></strStyle>\n";
				$RequestXML .= "<strBuyerPONO><![CDATA[" . $row["strBuyerPONO"]  . "]]></strBuyerPONO>\n";
				$RequestXML .= "<dtDateofDelivery><![CDATA[" . $row["dtDateofDelivery"]  . "]]></dtDateofDelivery>\n";
				$RequestXML .= "<intQty><![CDATA[" . $row["intQty"]  . "]]></intQty>\n";
				$RequestXML .= "<strCountry><![CDATA[" . $row["strCountry"]  . "]]></strCountry>\n";
				//$RequestXML .= "<dblUnitPrice><![CDATA[" . $row["dblUnitPrice"]  . "]]></dblUnitPrice>\n";
			}
		$RequestXML .= "</GridDetails>";
	echo $RequestXML;
}

if($request == "editdata"){
	$value = $_GET['value'];
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$RequestXML = "";
	$RequestXML.= "<GridDetails>\n";
	$getdata="SELECT
				shipmentforecast_detail.intSerialNo,
				shipmentforecast_detail.strSC_No,
				shipmentforecast_detail.strBuyer,
				shipmentforecast_detail.strDrop_No,
				shipmentforecast_detail.strPoNo,
				shipmentforecast_detail.strStyleNo,
				shipmentforecast_detail.strDeptNo,
				shipmentforecast_detail.strSeason,
				shipmentforecast_detail.strGOH_No,
				shipmentforecast_detail.intNOF_Ctns,
				shipmentforecast_detail.intCtnsL,
				shipmentforecast_detail.intCtnsW,
				shipmentforecast_detail.intCtnsH,
				shipmentforecast_detail.strPackType,
				shipmentforecast_detail.strQty,
				shipmentforecast_detail.intNetWt,
				shipmentforecast_detail.intGrsWt,
				shipmentforecast_detail.intUnitPrice,
				shipmentforecast_detail.intGSP_status,
				shipmentforecast_detail.strDesc,
				shipmentforecast_detail.strFabric,
				shipmentforecast_detail.strCountry,
				shipmentforecast_detail.strFactory,
				shipmentforecast_detail.strShipMode,
				shipmentforecast_detail.dtmEX_FTY_Date,
				shipmentforecast_detail.dtmFOBdate,
				shipmentforecast_detail.strPo_des,
				shipmentforecast_detail.strItemNo,
				shipmentforecast_detail.strknit_woven,
				shipmentforecast_detail.strContractva,
				shipmentforecast_detail.strRetec_No,
				shipmentforecast_detail.strOrms_Pord_No,
				shipmentforecast_detail.intPopUpChk,
				shipmentforecast_detail.strIMAN_Code,
				shipmentforecast_detail.strCriterion_No,
				shipmentforecast_detail.strTu_PoNo,
				shipmentforecast_detail.strTu_Style,
				shipmentforecast_detail.strPlant,
				shipmentforecast_detail.strCustomer,
				shipmentforecast_detail.strPo_Hit_No,
				shipmentforecast_detail.strFcl_Lcl,
				shipmentforecast_detail.strVCP,
				shipmentforecast_detail.strProduct_No,
				shipmentforecast_detail.strSales_Order_No,
				shipmentforecast_detail.strItem_Color,
				shipmentforecast_detail.strCtns_Type,
				shipmentforecast_detail.strUnite,
				shipmentforecast_detail.strSTF,
				shipmentforecast_detail.strDestination,
				shipmentforecast_detail.strProduct_Code,
				shipmentforecast_detail.strMarsks_Numbers,
				shipmentforecast_detail.strPcs_Per_Ctns,
				shipmentforecast_detail.strNetWT_Ppcs,
				shipmentforecast_detail.strGrsWT_Ppcs,
				shipmentforecast_detail.strBlues_Po_No,
				shipmentforecast_detail.strOther_Ref,
				shipmentforecast_detail.dblCBM,
				shipmentforecast_detail.dtmUp_Date,
				shipmentforecast_detail.dblMRP_Price,
				shipmentforecast_detail.strPbarQty,
				shipmentforecast_detail.strStatus,
				shipmentforecast_detail.intID,
				shipmentforecast_detail.strFactoryDate
				FROM
				shipmentforecast_detail
				WHERE
				shipmentforecast_detail.intID = '$value'";
			$result_getdata=$db->RunQuery($getdata);
			
			while($row=mysql_fetch_array($result_getdata)){
     			$RequestXML .= "<strSC_No><![CDATA[" . $row["strSC_No"]  . "]]></strSC_No>\n";
				$RequestXML .= "<strDrop_No><![CDATA[" . $row["strDrop_No"]  . "]]></strDrop_No>\n";
				$RequestXML .= "<strPoNo><![CDATA[" . $row["strPoNo"]  . "]]></strPoNo>\n";
				$RequestXML .= "<strStyleNo><![CDATA[" . $row["strStyleNo"]  . "]]></strStyleNo>\n";
				$RequestXML .= "<strDeptNo><![CDATA[" . $row["strDeptNo"]  . "]]></strDeptNo>\n";
				$RequestXML .= "<strSeason><![CDATA[" . $row["strSeason"]  . "]]></strSeason>\n";
				$RequestXML .= "<strGOH_No><![CDATA[" . $row["strGOH_No"]  . "]]></strGOH_No>\n";
				$RequestXML .= "<intNOF_Ctns><![CDATA[" . $row["intNOF_Ctns"]  . "]]></intNOF_Ctns>\n";
				$RequestXML .= "<intCtnsL><![CDATA[" . $row["intCtnsL"]  . "]]></intCtnsL>\n";
				$RequestXML .= "<intCtnsW><![CDATA[" . $row["intCtnsW"]  . "]]></intCtnsW>\n";
				$RequestXML .= "<intCtnsH><![CDATA[" . $row["intCtnsH"]  . "]]></intCtnsH>\n";
				$RequestXML .= "<strPackType><![CDATA[" . $row["strPackType"]  . "]]></strPackType>\n";
				$RequestXML .= "<strQty><![CDATA[" . $row["strQty"]  . "]]></strQty>\n";
				$RequestXML .= "<intNetWt><![CDATA[" . $row["intNetWt"]  . "]]></intNetWt>\n";
				$RequestXML .= "<intGrsWt><![CDATA[" . $row["intGrsWt"]  . "]]></intGrsWt>\n";
				$RequestXML .= "<intUnitPrice><![CDATA[" . $row["intUnitPrice"]  . "]]></intUnitPrice>\n";
				$RequestXML .= "<intGSP_status><![CDATA[" . $row["intGSP_status"]  . "]]></intGSP_status>\n";
				$RequestXML .= "<strDesc><![CDATA[" . $row["strDesc"]  . "]]></strDesc>\n";
				$RequestXML .= "<strFabric><![CDATA[" . $row["strFabric"]  . "]]></strFabric>\n";
				$RequestXML .= "<strCountry><![CDATA[" . $row["strCountry"]  . "]]></strCountry>\n";
				$RequestXML .= "<strFactory><![CDATA[" . $row["strFactory"]  . "]]></strFactory>\n";
				$RequestXML .= "<strShipMode><![CDATA[" . $row["strShipMode"]  . "]]></strShipMode>\n";
				
				$EXFTYDate		 = $row["dtmEX_FTY_Date"];
				$EXFTYDateArrry  = explode('-',$EXFTYDate);
				$EXFTYDate       = $EXFTYDateArrry[2].'/'.$EXFTYDateArrry[1].'/'.$EXFTYDateArrry[0];
				
				$RequestXML .= "<dtmEX_FTY_Date><![CDATA[" . $EXFTYDate  . "]]></dtmEX_FTY_Date>\n";
				$RequestXML .= "<dtmFOBdate><![CDATA[" . $row["dtmFOBdate"]  . "]]></dtmFOBdate>\n";
				$RequestXML .= "<strPo_des><![CDATA[" . $row["strPo_des"]  . "]]></strPo_des>\n";
				$RequestXML .= "<strItemNo><![CDATA[" . $row["strItemNo"]  . "]]></strItemNo>\n";
				$RequestXML .= "<strknit_woven><![CDATA[" . $row["strknit_woven"]  . "]]></strknit_woven>\n";
				$RequestXML .= "<strContractva><![CDATA[" . $row["strContractva"]  . "]]></strContractva>\n";
				$RequestXML .= "<strRetec_No><![CDATA[" . $row["strRetec_No"]  . "]]></strRetec_No>\n";
				$RequestXML .= "<strOrms_Pord_No><![CDATA[" . $row["strOrms_Pord_No"]  . "]]></strOrms_Pord_No>\n";
				$RequestXML .= "<intPopUpChk><![CDATA[" . $row["intPopUpChk"]  . "]]></intPopUpChk>\n";
				$RequestXML .= "<strIMAN_Code><![CDATA[" . $row["strIMAN_Code"]  . "]]></strIMAN_Code>\n";
				$RequestXML .= "<strCriterion_No><![CDATA[" . $row["strCriterion_No"]  . "]]></strCriterion_No>\n";
				$RequestXML .= "<strTu_PoNo><![CDATA[" . $row["strTu_PoNo"]  . "]]></strTu_PoNo>\n";
				$RequestXML .= "<strTu_Style><![CDATA[" . $row["strTu_Style"]  . "]]></strTu_Style>\n";
				$RequestXML .= "<strPlant><![CDATA[" . $row["strPlant"]  . "]]></strPlant>\n";
				$RequestXML .= "<strCustomer><![CDATA[" . $row["strCustomer"]  . "]]></strCustomer>\n";
				$RequestXML .= "<strPo_Hit_No><![CDATA[" . $row["strPo_Hit_No"]  . "]]></strPo_Hit_No>\n";
				$RequestXML .= "<strFcl_Lcl><![CDATA[" . $row["strFcl_Lcl"]  . "]]></strFcl_Lcl>\n";
				$RequestXML .= "<strVCP><![CDATA[" . $row["strVCP"]  . "]]></strVCP>\n";
				$RequestXML .= "<strProduct_No><![CDATA[" . $row["strProduct_No"]  . "]]></strProduct_No>\n";
				$RequestXML .= "<strSales_Order_No><![CDATA[" . $row["strSales_Order_No"]  . "]]></strSales_Order_No>\n";
				$RequestXML .= "<strItem_Color><![CDATA[" . $row["strItem_Color"]  . "]]></strItem_Color>\n";
				$RequestXML .= "<strCtns_Type><![CDATA[" . $row["strCtns_Type"]  . "]]></strCtns_Type>\n";
				$RequestXML .= "<strUnite><![CDATA[" . $row["strUnite"]  . "]]></strUnite>\n";
				$RequestXML .= "<strSTF><![CDATA[" . $row["strSTF"]  . "]]></strSTF>\n";
				$RequestXML .= "<strDestination><![CDATA[" . $row["strDestination"]  . "]]></strDestination>\n";
				$RequestXML .= "<strProduct_Code><![CDATA[" . $row["strProduct_Code"]  . "]]></strProduct_Code>\n";
				$RequestXML .= "<strMarsks_Numbers><![CDATA[" . $row["strMarsks_Numbers"]  . "]]></strMarsks_Numbers>\n";
				$RequestXML .= "<strPcs_Per_Ctns><![CDATA[" . $row["strPcs_Per_Ctns"]  . "]]></strPcs_Per_Ctns>\n";
				$RequestXML .= "<strNetWT_Ppcs><![CDATA[" . $row["strNetWT_Ppcs"]  . "]]></strNetWT_Ppcs>\n";
				$RequestXML .= "<strGrsWT_Ppcs><![CDATA[" . $row["strGrsWT_Ppcs"]  . "]]></strGrsWT_Ppcs>\n";
				$RequestXML .= "<strBlues_Po_No><![CDATA[" . $row["strBlues_Po_No"]  . "]]></strBlues_Po_No>\n";
				$RequestXML .= "<strOther_Ref><![CDATA[" . $row["strOther_Ref"]  . "]]></strOther_Ref>\n";
				$RequestXML .= "<dblCBM><![CDATA[" . $row["dblCBM"]  . "]]></dblCBM>\n";
				$RequestXML .= "<dtmUp_Date><![CDATA[" . $row["dtmUp_Date"]  . "]]></dtmUp_Date>\n";
				$RequestXML .= "<dblMRP_Price><![CDATA[" . $row["dblMRP_Price"]  . "]]></dblMRP_Price>\n";
				$RequestXML .= "<strPbarQty><![CDATA[" . $row["strPbarQty"]  . "]]></strPbarQty>\n";
				$RequestXML .= "<strStatus><![CDATA[" . $row["strStatus"]  . "]]></strStatus>\n";
				$RequestXML .= "<intID><![CDATA[" . $row["intID"]  . "]]></intID>\n";
				
				$FactoryDate       = $row["strFactoryDate"];
				$FactoryDateArrry  = explode('-',$FactoryDate);
				$FactoryDate       = $FactoryDateArrry[2].'/'.$FactoryDateArrry[1].'/'.$FactoryDateArrry[0];
				
				$RequestXML .= "<FactoryDate><![CDATA[" . $FactoryDate  . "]]></FactoryDate>\n";
				
			}
		$RequestXML .= "</GridDetails>";
	echo $RequestXML;
	}
	
	if($request == "save_approval_details"){
		$SCNo=$_GET['SCNO'];
		$Buyer=$_GET['Buyer'];
		$PONo=$_GET['BuyerPONo'];
		$IntID=$_GET['ShipmentID'];
		$PossibleQty=$_GET['PossibleQty'];
		$PossibleDate=$_GET['PossibleDate'];
		
		$invoicedateArray 	= explode('/',$PossibleDate);
		$FormatInvoiceDate = $invoicedateArray[2]."-".$invoicedateArray[1]."-".$invoicedateArray[0];
		
		$sql_update="UPDATE shipmentforecast_detail 
						set strPossibility='Y', 
						strPossibleQty='$PossibleQty', 
						strPossibleDate='$FormatInvoiceDate' 
						WHERE strSC_No='$SCNo' 
						AND strBuyer='$Buyer' 
						AND strPoNo='$PONo' 
						AND intID='$IntID'";
		$result=$db->RunQuery($sql_update);
		
		}
		
		if($request == "save_notapproval_details"){
		$SCNo=$_GET['SCNO'];
		$Buyer=$_GET['Buyer'];
		$PONo=$_GET['BuyerPONo'];
		$IntID=$_GET['ShipmentID'];
		$PossibleQty=$_GET['PossibleQty'];
		$PossibleDate=$_GET['PossibleDate'];
		
		$invoicedateArray 	= explode('/',$PossibleDate);
		$FormatInvoiceDate = $invoicedateArray[2]."-".$invoicedateArray[1]."-".$invoicedateArray[0];
		
		$sql_update="UPDATE shipmentforecast_detail 
						set strPossibility='N', 
						strPossibleQty='', 
						strPossibleDate='' 
						WHERE strSC_No='$SCNo' 
						AND strBuyer='$Buyer' 
						AND strPoNo='$PONo' 
						AND intID='$IntID'";
		$result=$db->RunQuery($sql_update);
		
		}
?>