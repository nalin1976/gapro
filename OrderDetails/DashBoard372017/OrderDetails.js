
var deliveryIndex = 0;


function AutoSelect(obj,controler)
{

	document.getElementById(controler).value = obj.value;
}



function loadOrderNo(obj,controller){


 var type = "getBPo";
   var url="OrderDetailsDB.php";
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
	
	var sah 		= 0;
	var ttlfob		= 0;
	var ftyCM  	= 0;
	var ttlCM		= 0;
	var trnsInQty	= 0;
	var gpToFTY		= 0;
	var transInFTY	= 0;
	
	RemoveRow();
	
	
	 var type = "getScDetails";
   var url="OrderDetailsDB.php";
				url=url+"?RequestType="+type+"";
				    url += '&styleId='+styleId+"";
					 url += '&bpo='+URLEncode(bpo)+"";
					  url += '&buyer='+URLEncode(buyer)+"";
	  				   url += '&matCategory='+matCategory;
				
	var htmlobj=$.ajax({url:url,async:false});
	//var bpo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
	

			var XMLScNo 	= htmlobj.responseXML.getElementsByTagName("intSRNO");
			var XMLbuyer 		= htmlobj.responseXML.getElementsByTagName("buyer");
			var XMLStyleId  = htmlobj.responseXML.getElementsByTagName("intStyleId");
			var XMLintBPO   = htmlobj.responseXML.getElementsByTagName("intBPO");
			var XMLbpoQty   = htmlobj.responseXML.getElementsByTagName("bpoQty");
			var XMLodrColor   = htmlobj.responseXML.getElementsByTagName("odrColor");
			var XMLfty   = htmlobj.responseXML.getElementsByTagName("fty");
			var XMLxFacDate   = htmlobj.responseXML.getElementsByTagName("xFacDate");
			var XMLhandOverDate   = htmlobj.responseXML.getElementsByTagName("handOverDate");
			var XMLdateofDelivery   = htmlobj.responseXML.getElementsByTagName("dateofDelivery");
			var XMLstrCountry   = htmlobj.responseXML.getElementsByTagName("strCountry");
			
			var XMLreaFOB   = htmlobj.responseXML.getElementsByTagName("reaFOB");
			var XMLstyleName   = htmlobj.responseXML.getElementsByTagName("styleName");
			var XMLshpMode   = htmlobj.responseXML.getElementsByTagName("shpMode");
		    var XMLsmv   = htmlobj.responseXML.getElementsByTagName("smv");
			var XMLCM   = htmlobj.responseXML.getElementsByTagName("CM");
			
			//alert(XMLPoQty[1].childNodes[0].nodeValue);
			
			for ( var loop = 0; loop < XMLScNo.length; loop ++)
			{
			
				var scNo      = XMLScNo[loop].childNodes[0].nodeValue;
				var styleName      = XMLstyleName[loop].childNodes[0].nodeValue;
				var buyerName  = XMLbuyer[loop].childNodes[0].nodeValue;
				var bpo       = XMLintBPO[loop].childNodes[0].nodeValue;
				var styleId   = XMLStyleId[loop].childNodes[0].nodeValue;
				
				var bpoQty      = XMLbpoQty[loop].childNodes[0].nodeValue;
				var odrColor  = XMLodrColor[loop].childNodes[0].nodeValue;
				var fty       = XMLfty[loop].childNodes[0].nodeValue;
				var xFacDate   = XMLxFacDate[loop].childNodes[0].nodeValue;
				
				var handOverDate      = XMLhandOverDate[loop].childNodes[0].nodeValue;
				var dateofDelivery  = XMLdateofDelivery[loop].childNodes[0].nodeValue;
				var country       = XMLstrCountry[loop].childNodes[0].nodeValue;
				var fob   = XMLreaFOB[loop].childNodes[0].nodeValue;
				
				var shpMode   = XMLshpMode[loop].childNodes[0].nodeValue;
				var smv		  = XMLsmv[loop].childNodes[0].nodeValue;
				var cm		  = XMLCM[loop].childNodes[0].nodeValue;
				// gpToFTY   = parseFloat(XMLGpToFTY[loop].childNodes[0].nodeValue);
				 //transInFTY   = parseFloat(XMLTransInFTY[loop].childNodes[0].nodeValue);
				

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

				sah = smv*bpoQty;
				ttlfob = fob*bpoQty;
				ftyCM = cm*smv;
				ttlCM = ftyCM*bpoQty
					//	url_po = "../StyleReport/reports/rptpurchaseorder.php?strStyleNo="+styleId+"&strBPo="+bpo+"&intMeterial=&intCategory=&intDescription="+matId+"&intSupplier=&intBuyer=&dtmDateFrom=&dtmDateTo=&status=10&intCompany=&noFrom=&noTo=&txtMatItem=''";
						
				
				
				var cellScNo = row.insertCell(0);     
				cellScNo.className="normalfntMid";
				cellScNo.innerHTML = buyerName;
				
				var cellBPO = row.insertCell(1);     
				cellBPO.className="normalfntMid";
				cellBPO.innerHTML = scNo;
				
		
				var cellItem = row.insertCell(2);     
				cellItem.className="normalfntLeft";
				cellItem.id = styleId;
				cellItem.innerHTML = styleName;
				
				
				var cellQty = row.insertCell(3);     
				cellQty.className="normalfntRite";
				cellQty.id = bpo;
				cellQty.innerHTML = bpo
				
				
				var cellPoQty = row.insertCell(4);     
				cellPoQty.className="normalfntRite";
				cellPoQty.innerHTML = bpoQty;
				//cellPoQty.innerHTML = "<a href=\'"+url_po+"\' class=\'non-html pdf\' target=\'_blank\'>"+bpoQty+"</a>";
				
				
				var cellColor = row.insertCell(5);     
				cellColor.className="normalfntRite";
				cellColor.innerHTML = odrColor;
				
				
				var cellGrnQty = row.insertCell(6);     
				cellGrnQty.className="normalfntRite";
				cellGrnQty.innerHTML = fty;
				
				
				var cellGrnQty = row.insertCell(7);     
				cellGrnQty.className="normalfntRite";
				cellGrnQty.innerHTML = xFacDate;

			
				var cellGrnQty = row.insertCell(8);     
				cellGrnQty.className="normalfntRite";
				cellGrnQty.innerHTML = handOverDate;
				
				
				var cellGrnQty = row.insertCell(9);     
				cellGrnQty.className="normalfntRite";
				cellGrnQty.innerHTML = dateofDelivery;				
			
				
				var cellGrnQty = row.insertCell(10);     
				cellGrnQty.className="normalfntMid";
				cellGrnQty.innerHTML = country;


				var cellGrnQty = row.insertCell(11);     
				cellGrnQty.className="normalfntMid";
				cellGrnQty.innerHTML = shpMode;


				var cellGrnQty = row.insertCell(12);     
				cellGrnQty.className="normalfntRite";
				cellGrnQty.innerHTML = smv;



				var cellGrnQty = row.insertCell(13);     
				cellGrnQty.className="normalfntRite";
				cellGrnQty.innerHTML = sah.toFixed(2);


				var cellGrnQty = row.insertCell(14);     
				cellGrnQty.className="normalfntRite";
				cellGrnQty.innerHTML = fob;
				
				
				var cellGrnQty = row.insertCell(15);     
				cellGrnQty.className="normalfntRite";
				cellGrnQty.innerHTML = ttlfob.toFixed(2);


				var cellGrnQty = row.insertCell(16);     
				cellGrnQty.className="normalfntRite";
				cellGrnQty.innerHTML = ftyCM.toFixed(2);	
					
					
		
				var cellGrnQty = row.insertCell(17);     
				cellGrnQty.className="normalfntRite";
				cellGrnQty.innerHTML = ttlCM.toFixed(2);
				
				deliveryIndex++ ;
				
			}
			
}
