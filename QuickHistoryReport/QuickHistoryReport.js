
var deliveryIndex = 0;


function AutoSelect(obj,controler)
{

	document.getElementById(controler).value = obj.value;
}



function loadOrderNo(obj,controller){


 var type = "getBPo";
   var url="QuickHistoryReportDB.php";
				url=url+"?RequestType="+type+"";
				    url += '&stytleOrSc='+URLEncode(obj.value)+"";
					  url += '&type='+controller;
				
	var htmlobj=$.ajax({url:url,async:false});
	var bpo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
	document.getElementById("cboBpo").innerHTML =  bpo;
}

 function RemoveRow () {
            var table = document.getElementById ("tblBomDetails");
           for(var i = document.getElementById("tblBomDetails").rows.length; i >1;i--)
				{
				document.getElementById("tblBomDetails").deleteRow(i -1);
				}
            }

function gatDeta(){
	var styleId = document.getElementById('cboStNo').value;	
	var bpo        = document.getElementById('cboBpo').value;	
	var buyer      = document.getElementById('cboBuyer').value;	
	var matCategory = document.getElementById('matCategory').value;	
	var tbl = document.getElementById('tblBomDetails');
	var url_po = "";
	var url_grn = "";
	var url_transInFty="";
	var url_gp_pra="";
	var url_transIn="";
	var url_gp_Fty="";
	
	var bomQty 		= 0;
	var poQty		= 0;
	var grnQty  	= 0;
	var gpQty		= 0;
	var trnsInQty	= 0;
	var gpToFTY		= 0;
	var transInFTY	= 0;
	
	RemoveRow();
	
	
	 var type = "getScDetails";
   var url="QuickHistoryReportDB.php";
				url=url+"?RequestType="+type+"";
				    url += '&styleId='+styleId+"";
					 url += '&bpo='+URLEncode(bpo)+"";
					  url += '&buyer='+URLEncode(buyer)+"";
	  				   url += '&matCategory='+matCategory;
				
	var htmlobj=$.ajax({url:url,async:false});
	//var bpo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
	
	
			var XMLScNo 	= htmlobj.responseXML.getElementsByTagName("intSRNO");
			var XMLBpo 		= htmlobj.responseXML.getElementsByTagName("strBuyerPONO");
			var XMLMatItem  = htmlobj.responseXML.getElementsByTagName("strMatDetailID");
			var XMLBomQty   = htmlobj.responseXML.getElementsByTagName("matQty");
			var XMLPoQty   = htmlobj.responseXML.getElementsByTagName("poQty");
			var XMLGrnQty   = htmlobj.responseXML.getElementsByTagName("grnQty");
			var XMLStyleId   = htmlobj.responseXML.getElementsByTagName("styleId");
			var XMLMatId   = htmlobj.responseXML.getElementsByTagName("matId");
			var XMLGpQty   = htmlobj.responseXML.getElementsByTagName("gpQty");
			var XMLTrnsInQty   = htmlobj.responseXML.getElementsByTagName("trnsInQty");
			var XMLGpToFTY   = htmlobj.responseXML.getElementsByTagName("gpToFTY");
			
			var XMLTransInFTY   = htmlobj.responseXML.getElementsByTagName("transInFTY");
			var XMLPcd   = htmlobj.responseXML.getElementsByTagName("pcd");
			var XMLEstimatedDate   = htmlobj.responseXML.getElementsByTagName("estimatedDate");
			
			
			//alert(XMLPoQty[1].childNodes[0].nodeValue);
			
			for ( var loop = 0; loop < XMLScNo.length; loop ++)
			{
			
				var scNo      = XMLScNo[loop].childNodes[0].nodeValue;
				var bpo_name  = XMLBpo[loop].childNodes[0].nodeValue;
				var bpo       = URLEncode(XMLBpo[loop].childNodes[0].nodeValue);
				var matItem   = XMLMatItem[loop].childNodes[0].nodeValue;
				 bomQty    = parseFloat(XMLBomQty[loop].childNodes[0].nodeValue);
				 poQty     = parseFloat(XMLPoQty[loop].childNodes[0].nodeValue);
				 grnQty    = parseFloat(XMLGrnQty[loop].childNodes[0].nodeValue);
				 gpQty     = parseFloat(XMLGpQty[loop].childNodes[0].nodeValue);
				 trnsInQty = parseFloat(XMLTrnsInQty[loop].childNodes[0].nodeValue);
				 gpToFTY   = parseFloat(XMLGpToFTY[loop].childNodes[0].nodeValue);
				 transInFTY   = parseFloat(XMLTransInFTY[loop].childNodes[0].nodeValue);
				
				var styleId    = XMLStyleId[loop].childNodes[0].nodeValue;
				var matId     = XMLMatId[loop].childNodes[0].nodeValue;
				var pcd     = XMLPcd[loop].childNodes[0].nodeValue;
				var exFacDate     = XMLEstimatedDate[loop].childNodes[0].nodeValue;
			
				if(bomQty >= 0){
					bomQty    = bomQty.toFixed(0);
				}else{
					bomQty    = '-';
					}	

				if(poQty >= 0){
					poQty    = poQty.toFixed(0);
				}else{
					poQty    = '-';
					}	
					
				if(grnQty >= 0){
					grnQty    = grnQty.toFixed(0);
				}else{
					grnQty   = '-';
					}	
					
				if(gpQty >= 0){
					gpQty    = gpQty.toFixed(0);
				}else{
					gpQty    = '-';
					}	
					
				if(trnsInQty >= 0){
					trnsInQty    = trnsInQty.toFixed(0);
				}else{
					trnsInQty    = '-';
					}	
					
				if(gpToFTY >= 0){
					gpToFTY    = gpToFTY.toFixed(0);
				}else{
					gpToFTY    = '-';
					}	
					
					
				if(transInFTY >= 0){
					transInFTY    = transInFTY.toFixed(0);
				}else{
					transInFTY    = '-';
					}		

			//	alert(trnsInQty);
				var lastRow = tbl.rows.length;					
				var row = tbl.insertRow(lastRow);
				row.id = deliveryIndex;

					  if (loop % 2 == 0){
						row.className = "bcgcolor-tblrow";
					  }
				  else{
						row.className = "bcgcolor-tblrowWhite";
				      }



						url_po = "../StyleReport/reports/rptpurchaseorder.php?strStyleNo="+styleId+"&strBPo="+bpo+"&intMeterial=&intCategory=&intDescription="+matId+"&intSupplier=&intBuyer=&dtmDateFrom=&dtmDateTo=&status=10&intCompany=&noFrom=&noTo=&txtMatItem=''";
						
						url_grn ="../StyleReport/reports/rptgrn.php?strStyleNo="+styleId+"&strBPo="+bpo+"&intMeterial=&intCategory=&intDescription="+matId+"&intSupplier=&intBuyer=&dtmDateFrom=&dtmDateTo=&status=1&intCompany=&noFrom=&noTo=&txtMatItem=''";	
						
						url_gp_pra ="rptgatepass.php?strStyleNo="+styleId+"&strBPo="+bpo+"&intMeterial=&intCategory=&intDescription="+matId+"&intSupplier=&intBuyer=&dtmDateFrom=&dtmDateTo=&status=1&intCompany=&noFrom=&noTo=&txtMatItem=''";	
						
						url_transIn ="rptgatepasstransferin.php?strStyleNo="+styleId+"&strBPo="+bpo+"&intMeterial=&intCategory=&intDescription="+matId+"&intSupplier=&intBuyer=&dtmDateFrom=&dtmDateTo=&status=1&intCompany=&noFrom=&noTo=&txtMatItem=''";	
						
						url_transInFty ="rptgatepasstransferinfty.php?strStyleNo="+styleId+"&strBPo="+bpo+"&intMeterial=&intCategory=&intDescription="+matId+"&intSupplier=&intBuyer=&dtmDateFrom=&dtmDateTo=&status=1&intCompany=&noFrom=&noTo=&txtMatItem=''";	
				
				
						url_gp_Fty ="rptgatepassFty.php?strStyleNo="+styleId+"&strBPo="+bpo+"&intMeterial=&intCategory=&intDescription="+matId+"&intSupplier=&intBuyer=&dtmDateFrom=&dtmDateTo=&status=1&intCompany=&noFrom=&noTo=&txtMatItem=''";	
				
				
				var cellScNo = row.insertCell(0);     
				cellScNo.className="normalfntMid";
				cellScNo.innerHTML = scNo;
				
				var cellBPO = row.insertCell(1);     
				cellBPO.className="normalfntMid";
				cellBPO.innerHTML = bpo_name;
				
		
				var cellItem = row.insertCell(2);     
				cellItem.className="normalfntLeft";
				cellItem.id = matId;
				cellItem.innerHTML = matItem;
				
				
				var cellQty = row.insertCell(3);     
				cellQty.className="normalfntRite";
				cellQty.id = bomQty;
				cellQty.innerHTML = bomQty
				
				
				var cellPoQty = row.insertCell(4);     
				cellPoQty.className="normalfntRite";
				//cellPoQty.innerHTML = poQty.toFixed(2);
				cellPoQty.innerHTML = "<a href=\'"+url_po+"\' class=\'non-html pdf\' target=\'_blank\'>"+poQty+"</a>";
				
				
				var cellGrnQty = row.insertCell(5);     
				cellGrnQty.className="normalfntRite";
				//cellGrnQty.innerHTML = grnQty.toFixed(2);
				cellGrnQty.innerHTML = "<a href=\'"+url_grn+"\' class=\'non-html pdf\' target=\'_blank\'>"+grnQty+"</a>";
				
				
				var cellGrnQty = row.insertCell(6);     
				cellGrnQty.className="normalfntRite";
				//cellGrnQty.innerHTML = grnQty.toFixed(2);
				cellGrnQty.innerHTML = "<a href=\'"+url_gp_pra+"\' class=\'non-html pdf\' target=\'_blank\'>"+gpQty+"</a>";
				
				
				var cellGrnQty = row.insertCell(7);     
				cellGrnQty.className="normalfntRite";
				//cellGrnQty.innerHTML = grnQty.toFixed(2);
				cellGrnQty.innerHTML = "<a href=\'"+url_transIn+"\' class=\'non-html pdf\' target=\'_blank\'>"+trnsInQty+"</a>";
				
				
				var cellGrnQty = row.insertCell(8);     
				cellGrnQty.className="normalfntRite";
				//cellGrnQty.innerHTML = grnQty.toFixed(2);
				cellGrnQty.innerHTML = "<a href=\'"+url_gp_Fty+"\' class=\'non-html pdf\' target=\'_blank\'>"+gpToFTY+"</a>";
				
				
				var cellGrnQty = row.insertCell(9);     
				cellGrnQty.className="normalfntRite";
				//cellGrnQty.innerHTML = grnQty.toFixed(2);
				cellGrnQty.innerHTML = "<a href=\'"+url_transInFty+"\' class=\'non-html pdf\' target=\'_blank\'>"+transInFTY+"</a>";
				
				
				var cellGrnQty = row.insertCell(10);     
				cellGrnQty.className="normalfntRite";
				cellGrnQty.innerHTML = pcd;
				
				
				var cellGrnQty = row.insertCell(11);     
				cellGrnQty.className="normalfntRite";
				cellGrnQty.innerHTML = exFacDate;
				
				
				
				deliveryIndex++ ;
				
			}
			
}
