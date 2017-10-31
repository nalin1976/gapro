
var deliveryIndex = 0;


function AutoSelect(obj,controler)
{

	document.getElementById(controler).value = obj.value;
}



function loadOrderNo(obj,controller){


 var type = "getBPo";
   var url="pcdTrackingDB.php";
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
	var pcdDateFrom      = document.getElementById('pcdDateFrom').value;	
	var PcdDateTo      = document.getElementById('PcdDateTo').value;
	var buyer      = document.getElementById('buyer').value;	
	var pcd			   = '0000-00-00'
	
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
	var grnDate	= 0;
	var gpToFTY		= 0;
	var leadTime	= 0;
	var intStatus	= 0;
	
	RemoveRow();
	
	
	 var type = "getScDetails";
   var url="pcdTrackingDB.php";
				url=url+"?RequestType="+type+"";
				    url += '&styleId='+styleId+"";
					 url += '&bpo='+URLEncode(bpo)+"";
					  url += '&PcdDateTo='+PcdDateTo+"";
					  url += '&pcdDateFrom='+pcdDateFrom+"";
 						url += '&buyer='+buyer+"";
						url += "&chkBuyerFilter="+(document.getElementById('chkBuyerFilter').checked ? 1:0);
				
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
			var XMLgrnDate   = htmlobj.responseXML.getElementsByTagName("grnDate");
			var XMLembType   = htmlobj.responseXML.getElementsByTagName("embType");
			var XMLbuyerName   = htmlobj.responseXML.getElementsByTagName("buyerName");
			
			var XMLPcd   = htmlobj.responseXML.getElementsByTagName("pcd");
			var XMLEstimatedDate   = htmlobj.responseXML.getElementsByTagName("estimatedDate");
			//alert(XMLPoQty[1].childNodes[0].nodeValue);
			
			for ( var loop = 0; loop < XMLScNo.length; loop ++)
			{
			
				var intStatus	= 0;
				var status = ""
				
					
				
				var scNo      = XMLScNo[loop].childNodes[0].nodeValue;
				var bpo_name  = XMLBpo[loop].childNodes[0].nodeValue;
				var bpo       = URLEncode(XMLBpo[loop].childNodes[0].nodeValue);
				var matItem   = XMLMatItem[loop].childNodes[0].nodeValue;
				
				 bomQty    = parseFloat(XMLBomQty[loop].childNodes[0].nodeValue);
				 poQty     = parseFloat(XMLPoQty[loop].childNodes[0].nodeValue);
				 grnQty    = parseFloat(XMLGrnQty[loop].childNodes[0].nodeValue);
				 gpQty     = parseFloat(XMLGpQty[loop].childNodes[0].nodeValue);
				 embType   = XMLembType[loop].childNodes[0].nodeValue;
				 grnDate   = XMLgrnDate[loop].childNodes[0].nodeValue;
				
				var styleId    = XMLStyleId[loop].childNodes[0].nodeValue;
				var matId     = XMLMatId[loop].childNodes[0].nodeValue;
				pcd     = XMLPcd[loop].childNodes[0].nodeValue;
				var exFacDate     = XMLEstimatedDate[loop].childNodes[0].nodeValue;
				var buyerName     = XMLbuyerName[loop].childNodes[0].nodeValue;

				
				var tmpembType = embType.split(',');
				leadTime	= 4;
				/*for ( var i = 0; i < tmpembType.length; i++)
					{
					//	alert("A="+poQty[i]);

						if(tmpembType[i]=='Non Emb' || tmpembType[i]==''){
								leadTime = 7;
							}else if(tmpembType.length==1){
								leadTime = 10;
								}else{
									leadTime = 14;
									}
					}*/
			
//alert("len = "+tmpembType.length+" ladTime = "+leadTime);
				var lastRow = tbl.rows.length;					
				var row = tbl.insertRow(lastRow);
				row.id = deliveryIndex;

					  if (loop % 2 == 0){
						row.className = "bcgcolor-tblrow";
					  }
				  else{
						row.className = "bcgcolor-tblrowWhite";
				      }


var d = new Date(pcd);
d.setDate(d.getDate() - leadTime);
var inDate=d.toLocaleString();
var res = inDate.split(',');

var matInDate = new Date(res[0]);
var matInDateFormated=(matInDate.getDate() + '/' + (matInDate.getMonth()+1) + '/' +  matInDate.getFullYear());


	//document.getElementById('txtMatInDate').value=matInDateFormated;	
	document.getElementById('txtEmbType').value=embType;	

var date = new Date(pcd);
var pcdDateFormated=(date.getDate() + '/' + (date.getMonth()+1) + '/' +  date.getFullYear());



if(pcd==""){
		pcdDateFormated='NaN'
	}
	
if(grnDate!=""){
		var grn_Date = new Date(grnDate);
		var grnFormated=(grn_Date.getDate() + '/' + (grn_Date.getMonth()+1) + '/' +  grn_Date.getFullYear());
	}
	else{
			var grnFormated='NaN'
		}


var d = new Date();
	var toDayFormated=(d.getDate() + '/' + (d.getMonth()+1) + '/' +  d.getFullYear());


	
/*if(pcd!="" && grnDate!=""){	
	if (process(grnFormated)> process(matInDateFormated)) {
		alert('grn is greater than matInDateFormated'+grnFormated);
	}	*/			

				
				var cellScNo = row.insertCell(0);     
				cellScNo.className="normalfntMid";
				cellScNo.innerHTML = scNo;
				
				var cellBPO = row.insertCell(1);     
				cellBPO.className="normalfntMid";
				cellBPO.innerHTML = bpo_name;
				
				
				var cellItem = row.insertCell(2);     
				cellItem.className="normalfntLeft";
				cellItem.innerHTML = buyerName;
				
				
				
				var cellItem = row.insertCell(3);     
				cellItem.className="normalfntLeft";
				cellItem.id = matId;
				cellItem.innerHTML = matItem;
				
				
				var cellQty = row.insertCell(4);     
				cellQty.className="normalfntRite";
				cellQty.id = bomQty;
				cellQty.innerHTML = bomQty
				
				

				var cellPoQty = row.insertCell(5);     
				cellPoQty.className="normalfntRite";
				//cellPoQty.innerHTML = poQty.toFixed(2);
			/*if(isNaN(poQty)){
						alert("a");
					}*/

				
				if (bomQty>poQty || isNaN(poQty)==true){
					//alert(poQty);
					cellPoQty.innerHTML = "<font color=\'#FF3366\'>"+poQty.toFixed(0)+"</font>";
					intStatus=1;
				}else{
						cellPoQty.innerHTML = poQty.toFixed(0);
					 }
					
					
				//cellPoQty.innerHTML = "<a href=\'"+url_po+"\' class=\'non-html pdf\' target=\'_blank\'>"+bpoQty+"</a>";
				//sc19314
				
				
				
				var cellColor = row.insertCell(6);     
				cellColor.className="normalfntRite";
				//cellColor.innerHTML = grnQty.toFixed(2);
				
				if(grnDate!=""){	
						if (poQty*98/100>grnQty) {
								cellColor.innerHTML = "<font color=\'#FF3366\'>"+grnQty.toFixed(0)+"</font>";
								
								intStatus=1;
								
								if (process(toDayFormated)< process(matInDateFormated)) {
										intStatus=2;
									}
						}else{
						     	cellColor.innerHTML = grnQty.toFixed(0);
							 }
							
					}else{
							cellColor.innerHTML = "-";
						 }	
				
				/*
				if(pcd!="" && grnDate==""){	
						if (process(toDayFormated)> process(matInDateFormated)) {
							//alert("|AA = "+loop+"toDayFormated = "+toDayFormated+" matInDateFormated = "+matInDateFormated);
								cellColor.innerHTML = "<font color=\'#FF3366\'>"+grnQty.toFixed(2)+"</font>";
								intStatus=1;
						}else{
						     	cellColor.innerHTML = grnQty.toFixed(2);
							 }
							
					}else{
							cellColor.innerHTML ="-";
						 }	*/
						 
						 
				//alert("|AA = "+loop+"toDayFormated = "+toDayFormated+" matInDateFormated = "+matInDateFormated+ " grn Date = "+grnDate);
				
				var cellGrnQty = row.insertCell(7);     
				cellGrnQty.className="normalfntRite";
				//cellGrnQty.innerHTML = grnFormated;
				
					if(pcd!="" && grnDate!=""){	
								if (process(grnFormated)> process(matInDateFormated)) {
										cellGrnQty.innerHTML = "<font color=\'#FF3366\'>"+grnFormated+"</font>";
										intStatus=1;
								}else{
										cellGrnQty.innerHTML = grnFormated;
									 }
							
					}else if(grnDate==""){
											
											if (process(toDayFormated)> process(matInDateFormated)) {
													intStatus=1;
													cellGrnQty.innerHTML ="-";}else{
													intStatus=2;
													cellGrnQty.innerHTML ="-";}
													
													
										 }
					else{
							cellGrnQty.innerHTML ="-";
						 }	

				
				/*if(pcd!="" && grnDate==""){	
						if (process(toDayFormated)> process(matInDateFormated)) {
								cellGrnQty.innerHTML = "<font color=\'#FF3366\'>"+grnFormated+"</font>";
								intStatus=1;
						}else{
						     	cellGrnQty.innerHTML = grnFormated;
							 }
							
					}else{
							cellGrnQty.innerHTML ="-";
						 }	
				*/
				var cellGrnQty = row.insertCell(8);     
				cellGrnQty.className="normalfntRite";
				cellGrnQty.innerHTML = matInDateFormated;
				
				
				var cellGrnQty = row.insertCell(9);     
				cellGrnQty.className="normalfntRite";
				cellGrnQty.innerHTML = pcdDateFormated;
				
				
				
				if(intStatus==1){
						 status = "Fail"
					}else if(intStatus==2){
							 status = "Pending"
						 }else{
							 	status = "Pass"
							  }
				var cellGrnQty = row.insertCell(10);     
				cellGrnQty.className="normalfntMid";
				cellGrnQty.innerHTML = status;

			
			
  var type = "saveTempData";
   var url2="pcdTrackingDB.php";
				url2=url2+"?RequestType="+type+"";
				url2 += '&scNo='+scNo+"";
				url2 += '&bpo_name='+URLEncode(bpo_name)+"";
				url2 += '&buyerName='+buyerName+"";
				url2 += '&matId='+matId+"";
 				url2 += '&bomQty='+bomQty+"";
				url2 += '&poQty='+poQty+"";
				url2 += '&grnQty='+grnQty+"";
				url2 += '&grnFormated='+grnFormated+"";
				url2 += '&matInDateFormated='+matInDateFormated+"";
				url2 += '&pcdDateFormated='+pcdDateFormated+"";
				url2 += '&status='+status+"";
	var htmlobj2=$.ajax({url:url2,async:false});
	
	
	
	
				
				deliveryIndex++ ;
				
			}
			
			

//alert('Today is: ' + d.toLocaleString());

	
}


function loadSummary(){

	var styleId = document.getElementById('cboStNo').value;	
	var bpo        = document.getElementById('cboBpo').value;	
	var pcdDateFrom      = document.getElementById('pcdDateFrom').value;	
	var PcdDateTo      = document.getElementById('PcdDateTo').value;
	var buyer      = document.getElementById('buyer').value;	
	var pcd			   = '0000-00-00'
	
	var tbl = document.getElementById('tblBomDetails');
	
	var bomQty 		= 0;
	var poQty		= 0;
	var grnQty  	= 0;
	var gpQty		= 0;
	var grnDate	= 0;
	var gpToFTY		= 0;
	var leadTime	= 0;
	var intStatus	= 0;
	
	RemoveRow();
	
	
	 var type = "getSummaryScDetails";
   var url="pcdTrackingDB.php";
				url=url+"?RequestType="+type+"";
				    url += '&styleId='+styleId+"";
					 url += '&bpo='+URLEncode(bpo)+"";
					  url += '&PcdDateTo='+PcdDateTo+"";
					  url += '&pcdDateFrom='+pcdDateFrom+"";
 						url += '&buyer='+buyer+"";
						url += "&chkBuyerFilter="+(document.getElementById('chkBuyerFilter').checked ? 1:0);
				
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
			var XMLgrnDate   = htmlobj.responseXML.getElementsByTagName("grnDate");
			var XMLembType   = htmlobj.responseXML.getElementsByTagName("embType");
			var XMLbuyerName   = htmlobj.responseXML.getElementsByTagName("buyerName");
			
			var XMLPcd   = htmlobj.responseXML.getElementsByTagName("pcd");
			var XMLEstimatedDate   = htmlobj.responseXML.getElementsByTagName("estimatedDate");
			//alert(XMLPoQty[1].childNodes[0].nodeValue);
			
			for ( var loop = 0; loop < XMLScNo.length; loop ++)
			{
			
				var intStatus	= 0;
				var status = ""
				
					
				
				var scNo      = XMLScNo[loop].childNodes[0].nodeValue;
				var bpo_name  = XMLBpo[loop].childNodes[0].nodeValue;
				var bpo       = URLEncode(XMLBpo[loop].childNodes[0].nodeValue);
				var matItem   = XMLMatItem[loop].childNodes[0].nodeValue;
				
				 bomQty    = parseFloat(XMLBomQty[loop].childNodes[0].nodeValue);
				 poQty     = parseFloat(XMLPoQty[loop].childNodes[0].nodeValue);
				 grnQty    = parseFloat(XMLGrnQty[loop].childNodes[0].nodeValue);
				 gpQty     = parseFloat(XMLGpQty[loop].childNodes[0].nodeValue);
				 embType   = XMLembType[loop].childNodes[0].nodeValue;
				 grnDate   = XMLgrnDate[loop].childNodes[0].nodeValue;
				
				var styleId    = XMLStyleId[loop].childNodes[0].nodeValue;
				var matId     = XMLMatId[loop].childNodes[0].nodeValue;
				pcd     = XMLPcd[loop].childNodes[0].nodeValue;
				var exFacDate     = XMLEstimatedDate[loop].childNodes[0].nodeValue;
				var buyerName     = XMLbuyerName[loop].childNodes[0].nodeValue;

				
				var tmpembType = embType.split(',');
				leadTime	= 4;
	
				var lastRow = tbl.rows.length;					
				var row = tbl.insertRow(lastRow);
				row.id = deliveryIndex;

					  if (loop % 2 == 0){
						row.className = "bcgcolor-tblrow";
					  }
				  else{
						row.className = "bcgcolor-tblrowWhite";
				      }


var d = new Date(pcd);
d.setDate(d.getDate() - leadTime);
var inDate=d.toLocaleString();
var res = inDate.split(',');

var matInDate = new Date(res[0]);
var matInDateFormated=(matInDate.getDate() + '/' + (matInDate.getMonth()+1) + '/' +  matInDate.getFullYear());


	//document.getElementById('txtMatInDate').value=matInDateFormated;	
	document.getElementById('txtEmbType').value=embType;	

var date = new Date(pcd);
var pcdDateFormated=(date.getDate() + '/' + (date.getMonth()+1) + '/' +  date.getFullYear());



if(pcd==""){
		pcdDateFormated='NaN'
	}
	
if(grnDate!=""){
		var grn_Date = new Date(grnDate);
		var grnFormated=(grn_Date.getDate() + '/' + (grn_Date.getMonth()+1) + '/' +  grn_Date.getFullYear());
	}
	else{
			var grnFormated='NaN'
		}


var d = new Date();
	var toDayFormated=(d.getDate() + '/' + (d.getMonth()+1) + '/' +  d.getFullYear());


				
				var cellScNo = row.insertCell(0);     
				cellScNo.className="normalfntMid";
				cellScNo.innerHTML = scNo;
				
				var cellBPO = row.insertCell(1);     
				cellBPO.className="normalfntMid";
				cellBPO.innerHTML = bpo_name;
				
				
				var cellItem = row.insertCell(2);     
				cellItem.className="normalfntLeft";
				cellItem.innerHTML = buyerName;
				
				
				
				var cellItem = row.insertCell(3);     
				cellItem.className="normalfntLeft";
				cellItem.id = matId;
				cellItem.innerHTML = matItem;
				
				
				var cellQty = row.insertCell(4);     
				cellQty.className="normalfntRite";
				cellQty.id = bomQty;
				cellQty.innerHTML = bomQty
				
				

				var cellPoQty = row.insertCell(5);     
				cellPoQty.className="normalfntRite";
				cellPoQty.innerHTML = poQty.toFixed(2);

				var cellColor = row.insertCell(6);     
				cellColor.className="normalfntRite";
				cellColor.innerHTML = grnQty.toFixed(2);
				
				
				var cellGrnQty = row.insertCell(7);     
				cellGrnQty.className="normalfntRite";
				cellGrnQty.innerHTML = grnFormated;
	

				var cellGrnQty = row.insertCell(8);     
				cellGrnQty.className="normalfntRite";
				cellGrnQty.innerHTML = matInDateFormated;
				
				
				var cellGrnQty = row.insertCell(9);     
				cellGrnQty.className="normalfntRite";
				cellGrnQty.innerHTML = pcdDateFormated;
				
				
				
				if(intStatus==1){
						 status = "Fail"
					}else if(intStatus==2){
							 status = "Pending"
						 }else{
							 	status = "Pass"
							  }
				var cellGrnQty = row.insertCell(10);     
				cellGrnQty.className="normalfntMid";
				cellGrnQty.innerHTML = status;

			
				
				deliveryIndex++ ;
				
			}
			



}

function process(date){
   var parts = date.split("/");

   return new Date(parts[2], parts[1] - 1, parts[0]);
}