
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
			
			
			//alert(XMLPoQty[1].childNodes[0].nodeValue);
			
			for ( var loop = 0; loop < XMLScNo.length; loop ++)
			{
			
				var scNo      = XMLScNo[loop].childNodes[0].nodeValue;
				var bpo       = URLEncode(XMLBpo[loop].childNodes[0].nodeValue);
				var matItem   = XMLMatItem[loop].childNodes[0].nodeValue;
				var bomQty    = parseFloat(XMLBomQty[loop].childNodes[0].nodeValue);
				var poQty     = parseFloat(XMLPoQty[loop].childNodes[0].nodeValue);
				var grnQty    = parseFloat(XMLGrnQty[loop].childNodes[0].nodeValue);
				var styleId    = XMLStyleId[loop].childNodes[0].nodeValue;
				var matId     = XMLMatId[loop].childNodes[0].nodeValue;
				
				var lastRow = tbl.rows.length;					
				var row = tbl.insertRow(lastRow);
				row.id = deliveryIndex;

					  if (loop % 2 == 0){
						row.className = "bcgcolor-tblrow";
					  }
				  else{
						row.className = "bcgcolor-tblrowWhite";
				      }
					  
http://localhost/gapro/StyleReport/reports/rptgrn.php?strStyleNo=796&strBPo=&intMeterial=1&intCategory=437&intDescription=24071&intSupplier=&intBuyer=&dtmDateFrom=&dtmDateTo=&status=1&intCompany=&noFrom=&noTo=&txtMatItem=
						url_po = "../StyleReport/reports/rptpurchaseorder.php?strStyleNo="+styleId+"&strBPo="+bpo+"&intMeterial=&intCategory=&intDescription="+matId+"&intSupplier=&intBuyer=&dtmDateFrom=&dtmDateTo=&status=10&intCompany=&noFrom=&noTo=&txtMatItem=''";
						
						url_grn ="../StyleReport/reports/rptgrn.php?strStyleNo="+styleId+"&strBPo="+bpo+"&intMeterial=&intCategory=&intDescription="+matId+"&intSupplier=&intBuyer=&dtmDateFrom=&dtmDateTo=&status=1&intCompany=&noFrom=&noTo=&txtMatItem=''";	
				
				var cellScNo = row.insertCell(0);     
				cellScNo.className="normalfntMid";
				cellScNo.innerHTML = scNo;
				
				var cellBPO = row.insertCell(1);     
				cellBPO.className="normalfntMid";
				cellBPO.innerHTML = bpo;
				
		
				var cellItem = row.insertCell(2);     
				cellItem.className="normalfntLeft";
				cellItem.id = matId;
				cellItem.innerHTML = matItem;
				
				
				var cellQty = row.insertCell(3);     
				cellQty.className="normalfntRite";
				cellQty.id = bomQty;
				cellQty.innerHTML = bomQty.toFixed(2);
				
				
				var cellPoQty = row.insertCell(4);     
				cellPoQty.className="normalfntRite";
				//cellPoQty.innerHTML = poQty.toFixed(2);
				cellPoQty.innerHTML = "<a href=\'"+url_po+"\' class=\'non-html pdf\' target=\'_blank\'>"+poQty.toFixed(2)+"</a>";
				
				var cellGrnQty = row.insertCell(5);     
				cellGrnQty.className="normalfntRite";
				//cellGrnQty.innerHTML = grnQty.toFixed(2);
				cellGrnQty.innerHTML = "<a href=\'"+url_grn+"\' class=\'non-html pdf\' target=\'_blank\'>"+grnQty.toFixed(2)+"</a>";
				
				
				deliveryIndex++ ;
				
			}
			
}
