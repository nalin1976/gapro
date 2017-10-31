
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
	
	var chkFilterStatus = document.getElementById('chkCdnFilter').checked;
	//alert(chkFilterStatus);
	if(chkFilterStatus==true){
				gatCdnDeta();
		}else{
				gatGenDeta();
			}
}

function gatGenDeta(){
	
	var styleId = document.getElementById('cboSR').value;	
	var cdnDateFrom        = document.getElementById('cdnDateFrom').value;	
	var buyer      = document.getElementById('cboBuyer').value;	
	var cdnDateTo = document.getElementById('cdnDateTo').value;
	
	var toDate = document.getElementById('dateTo').value;	
	var fromDate = document.getElementById('dateFrom').value;		
	var tbl = document.getElementById('tblBomDetails');
	
	var url_rmcPc = "";
	
	
	
	var sah 		= 0;
	var ttlfob		= 0;
	var ftyCM  	= 0;
	var ttlCM		= 0;
	var ttlRMC	= 0;
	var frontEndCost		= 0;
	var projectedNp	= 0;
	var odrToShip	= 0;
	var shpSAH	= 0;
	var rmcShp	= 0;
	var shtOrOverShpVal	= 0;	
	var frontEnd	= 0;	
	var np	= 0;	
	var ttlNp	= 0;
	var ttlfrontEnd	= 0;	
	var ttlshOvShpVal	= 0;
		
	RemoveRow();
	
	
	 var type = "getScDetails";
   var url="OrderDetailsDB.php";
				url=url+"?RequestType="+type+"";
				    url += '&styleId='+styleId+"";
					 url += '&cdnDateTo='+cdnDateTo+"";
					  url += '&buyer='+buyer+"";
					   url += '&toDate='+toDate+"";
					    url += '&fromDate='+fromDate+"";
	  				     url += '&cdnDateFrom='+cdnDateFrom;
							url += "&chkBuyerFilter="+(document.getElementById('chkBuyerFilter').checked ? 1:0);
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
			var XMLshippedQty  = htmlobj.responseXML.getElementsByTagName("shippedQty");
			var XMLrmcPc   = htmlobj.responseXML.getElementsByTagName("rmcPc");
			var XMLshpFob  = htmlobj.responseXML.getElementsByTagName("shpFob");
			var XMLcdnDate  = htmlobj.responseXML.getElementsByTagName("cdnDate");
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
				var smv		  = parseFloat(XMLsmv[loop].childNodes[0].nodeValue);
				var cm		  = XMLCM[loop].childNodes[0].nodeValue;
				var rmcPc		  = parseFloat(XMLrmcPc[loop].childNodes[0].nodeValue);	
				var shippedQty		  = parseFloat(XMLshippedQty[loop].childNodes[0].nodeValue);
				var shpFob		  = parseFloat(XMLshpFob[loop].childNodes[0].nodeValue);	
				var cdnDate		  = XMLcdnDate[loop].childNodes[0].nodeValue;
				// gpToFTY   = parseFloat(XMLGpToFTY[loop].childNodes[0].nodeValue);
				 //transInFTY   = parseFloat(XMLTransInFTY[loop].childNodes[0].nodeValue);
					//url_rmcPc = "../../oritpreorderReport.php?strStyleNo="+styleId;

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
					  
					  
					  if(shippedQty>0){
						  	shippedQty=shippedQty;
							odrToShip = (shippedQty-bpoQty)/bpoQty;
						  }else{
							shippedQty =" NaN ";
							odrToShip  =" - ";
							cdnDate=" NaN "
							}
						  

				sah 	= smv*bpoQty/60;
				ttlfob  = fob*bpoQty;
				ftyCM   = cm*smv;
				ttlCM   = ftyCM*bpoQty;
				ttlRMC  = rmcPc*bpoQty;
				frontEndCost= 0.018*sah*60;
				projectedNp = ttlfob-ttlRMC-ttlCM-frontEndCost;
				shpSAH  = shippedQty*smv/60;
				rmcShp = rmcPc*(shippedQty/fob);
				shtOrOverShpVal = shpFob-ttlfob;
				frontEnd = 0.018*shippedQty*smv;
				np		=  shpFob-rmcShp-shtOrOverShpVal-frontEnd;

				if(shippedQty>0){
						ttlNp+=	np;
						ttlfrontEnd+=frontEnd;
						ttlshOvShpVal+=shtOrOverShpVal;
					}
				
			
						
				
				
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
				cellGrnQty.innerHTML = smv.toFixed(2);



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
				
				
				var cellRmcPc = row.insertCell(18);     
				cellRmcPc.className="normalfntRite";
				cellRmcPc.innerHTML = rmcPc.toFixed(4);
				//cellGrnQty.innerHTML = "<a href=\'"+url_rmcPc+"\' class=\'non-html pdf\' target=\'_blank\'>"+rmcPc.toFixed(4)+"</a>";	
				
				
				var cellTtlRMC = row.insertCell(19);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = ttlRMC.toFixed(4);
				
				
				var cellTtlRMC = row.insertCell(20);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = ((rmcPc/fob)*100).toFixed(2)+"%";
				
				
				var cellTtlRMC = row.insertCell(21);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = frontEndCost.toFixed(4);
				
				
				var cellTtlRMC = row.insertCell(22);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = projectedNp.toFixed(4);
				
				
				var cellTtlRMC = row.insertCell(23);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = shippedQty;							
				
				
							
				var cellTtlRMC = row.insertCell(24);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = (parseFloat(odrToShip)*100).toFixed(2);	
				
				
				
				var cellTtlRMC = row.insertCell(25);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = shpFob;	
				
				
				var cellTtlRMC = row.insertCell(26);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = (parseFloat(shpSAH)).toFixed(4);
				
				
				var cellTtlRMC = row.insertCell(27);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = (parseFloat(rmcShp)).toFixed(4);				
									
							
				var cellTtlRMC = row.insertCell(28);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = (parseFloat(shtOrOverShpVal)).toFixed(4);	
				
				
				var cellTtlRMC = row.insertCell(29);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = (parseFloat(frontEnd)).toFixed(4);
				
				
				var cellTtlRMC = row.insertCell(30);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = (parseFloat(np)).toFixed(4);	
				
				var cellTtlRMC = row.insertCell(31);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = cdnDate;					
							
																
				deliveryIndex++ ;
				
			}
			
			document.getElementById('ttlNp').value=ttlNp.toFixed(4);
			document.getElementById('fntEnd').value=ttlfrontEnd.toFixed(4);
			document.getElementById('shOvShpVal').value=ttlshOvShpVal.toFixed(4);
}



function gatCdnDeta(){
	
	var styleId = document.getElementById('cboSR').value;	
	var cdnDateFrom        = document.getElementById('cdnDateFrom').value;	
	var buyer      = document.getElementById('cboBuyer').value;	
	var cdnDateTo = document.getElementById('cdnDateTo').value;
	
	var toDate = document.getElementById('dateTo').value;	
	var fromDate = document.getElementById('dateFrom').value;		
	var tbl = document.getElementById('tblBomDetails');
	
	var url_rmcPc = "";
	
	
	
	var sah 		= 0;
	var ttlfob		= 0;
	var ftyCM  	= 0;
	var ttlCM		= 0;
	var ttlRMC	= 0;
	var frontEndCost		= 0;
	var projectedNp	= 0;
	var odrToShip	= 0;
	var shpSAH	= 0;
	var rmcShp	= 0;
	var shtOrOverShpVal	= 0;	
	var frontEnd	= 0;	
	var np	= 0;	
	var ttlNp	= 0;
	var ttlfrontEnd	= 0;	
	var ttlshOvShpVal	= 0;
		
	RemoveRow();
	
	 var type = "getCDNScDetails";
   var url="OrderDetailsDB.php";
				url=url+"?RequestType="+type+"";
				    url += '&styleId='+styleId+"";
					 url += '&cdnDateTo='+cdnDateTo+"";
					  url += '&buyer='+buyer+"";
					   url += '&toDate='+toDate+"";
					    url += '&fromDate='+fromDate+"";
	  				     url += '&cdnDateFrom='+cdnDateFrom;
						 url += "&chkBuyerFilter="+(document.getElementById('chkBuyerFilter').checked ? 1:0);
				
	var htmlobj2=$.ajax({url:url,async:false});
	//var bpo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
	

			var XMLScNo 	= htmlobj2.responseXML.getElementsByTagName("intSRNO");
			var XMLbuyer 		= htmlobj2.responseXML.getElementsByTagName("buyer");
			var XMLStyleId  = htmlobj2.responseXML.getElementsByTagName("intStyleId");
			var XMLintBPO   = htmlobj2.responseXML.getElementsByTagName("intBPO");
			var XMLbpoQty   = htmlobj2.responseXML.getElementsByTagName("bpoQty");
			var XMLodrColor   = htmlobj2.responseXML.getElementsByTagName("odrColor");
			var XMLfty   = htmlobj2.responseXML.getElementsByTagName("fty");
			var XMLxFacDate   = htmlobj2.responseXML.getElementsByTagName("xFacDate");
			var XMLhandOverDate   = htmlobj2.responseXML.getElementsByTagName("handOverDate");
			var XMLdateofDelivery   = htmlobj2.responseXML.getElementsByTagName("dateofDelivery");
			var XMLstrCountry   = htmlobj2.responseXML.getElementsByTagName("strCountry");
			
			var XMLreaFOB   = htmlobj2.responseXML.getElementsByTagName("reaFOB");
			var XMLstyleName   = htmlobj2.responseXML.getElementsByTagName("styleName");
			var XMLshpMode   = htmlobj2.responseXML.getElementsByTagName("shpMode");
		    var XMLsmv   = htmlobj2.responseXML.getElementsByTagName("smv");
			var XMLCM   = htmlobj2.responseXML.getElementsByTagName("CM");
			var XMLshippedQty  = htmlobj2.responseXML.getElementsByTagName("shippedQty");
			var XMLrmcPc   = htmlobj2.responseXML.getElementsByTagName("rmcPc");
			var XMLshpFob  = htmlobj2.responseXML.getElementsByTagName("shpFob");
			var XMLcdnDate  = htmlobj2.responseXML.getElementsByTagName("cdnDate");
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
				var smv		  =  parseFloat(XMLsmv[loop].childNodes[0].nodeValue);
				var cm		  = XMLCM[loop].childNodes[0].nodeValue;
				var rmcPc		  = parseFloat(XMLrmcPc[loop].childNodes[0].nodeValue);	
				var shippedQty		  = parseFloat(XMLshippedQty[loop].childNodes[0].nodeValue);
				var shpFob		  = parseFloat(XMLshpFob[loop].childNodes[0].nodeValue);	
				var cdnDate		  = XMLcdnDate[loop].childNodes[0].nodeValue;
				// gpToFTY   = parseFloat(XMLGpToFTY[loop].childNodes[0].nodeValue);
				 //transInFTY   = parseFloat(XMLTransInFTY[loop].childNodes[0].nodeValue);
					//url_rmcPc = "../../oritpreorderReport.php?strStyleNo="+styleId;


				var lastRow = tbl.rows.length;					
				var row = tbl.insertRow(lastRow);
				row.id = deliveryIndex;

					  if (loop % 2 == 0){
						row.className = "bcgcolor-tblrow";
					  }
				  else{
						row.className = "bcgcolor-tblrowWhite";
				      }
					  
					  
					  if(shippedQty>0){
						  	shippedQty=shippedQty;
							odrToShip = (shippedQty-bpoQty)/bpoQty;
						  }else{
							shippedQty =" NaN ";
							odrToShip  =" - ";
							cdnDate=" NaN "
							}
						  

				sah 	= smv*bpoQty/60;
				ttlfob  = fob*bpoQty;
				ftyCM   = cm*smv;
				ttlCM   = ftyCM*bpoQty;
				ttlRMC  = rmcPc*bpoQty;
				frontEndCost= 0.018*sah*60;
				projectedNp = ttlfob-ttlRMC-ttlCM-frontEndCost;
				shpSAH  = shippedQty*smv/60;
				rmcShp = rmcPc*(shippedQty/fob);
				shtOrOverShpVal = shpFob-ttlfob;
				frontEnd = 0.018*shippedQty*smv;
				np		=  shpFob-rmcShp-shtOrOverShpVal-frontEnd;

				if(shippedQty>0){
						ttlNp+=	np;
						ttlfrontEnd+=frontEnd;
						ttlshOvShpVal+=shtOrOverShpVal;
					}
				
			
						
				
				
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
				cellGrnQty.innerHTML = smv.toFixed(2);



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
				
				
				var cellRmcPc = row.insertCell(18);     
				cellRmcPc.className="normalfntRite";
				cellRmcPc.innerHTML = rmcPc.toFixed(4);
				//cellGrnQty.innerHTML = "<a href=\'"+url_rmcPc+"\' class=\'non-html pdf\' target=\'_blank\'>"+rmcPc.toFixed(4)+"</a>";	
				
				
				var cellTtlRMC = row.insertCell(19);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = ttlRMC.toFixed(4);
				
				
				var cellTtlRMC = row.insertCell(20);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = ((rmcPc/fob)*100).toFixed(2)+"%";
				
				
				var cellTtlRMC = row.insertCell(21);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = frontEndCost.toFixed(4);
				
				
				var cellTtlRMC = row.insertCell(22);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = projectedNp.toFixed(4);
				
				
				var cellTtlRMC = row.insertCell(23);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = shippedQty;							
				
				
							
				var cellTtlRMC = row.insertCell(24);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = (parseFloat(odrToShip)*100).toFixed(2);	
				
				
				
				var cellTtlRMC = row.insertCell(25);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = shpFob;	
				
				
				var cellTtlRMC = row.insertCell(26);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = (parseFloat(shpSAH)).toFixed(4);
				
				
				var cellTtlRMC = row.insertCell(27);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = (parseFloat(rmcShp)).toFixed(4);				
									
							
				var cellTtlRMC = row.insertCell(28);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = (parseFloat(shtOrOverShpVal)).toFixed(4);	
				
				
				var cellTtlRMC = row.insertCell(29);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = (parseFloat(frontEnd)).toFixed(4);
				
				
				var cellTtlRMC = row.insertCell(30);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = (parseFloat(np)).toFixed(4);	
				
				var cellTtlRMC = row.insertCell(31);     
				cellTtlRMC.className="normalfntRite";
				cellTtlRMC.innerHTML = cdnDate;					
							
																
				deliveryIndex++ ;
				
			}
			
			document.getElementById('ttlNp').value=ttlNp.toFixed(4);
			document.getElementById('fntEnd').value=ttlfrontEnd.toFixed(4);
			document.getElementById('shOvShpVal').value=ttlshOvShpVal.toFixed(4);
}