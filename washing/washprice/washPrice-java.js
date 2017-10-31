var xmlHttp;
var xmlHttp1=[];
var pub_intxmlHttp_count=0;
var key="n";

var pub_matNo = 0;
var pub_printWindowNo=0;
function createXMLHttpRequest() 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}
function createXMLHttpRequest1(index) 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp1[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp1[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp1[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}



function clearTable()
{
	var tblTable    = 	document.getElementById("tblWashPriceGrid");
	

document.washPrice.reset();
	document.getElementById("cboStyleName").options[0].value="";
	document.getElementById("cboStyleName").options[0].text="";
	document.getElementById("cboColor").options[0].value="";
	document.getElementById("cboColor").options[0].text="";

	var binCount	=	tblTable.rows.length;
	for(var loop=1;loop<binCount;loop++)
	{
			tblTable.deleteRow(loop);
			binCount--;
			loop--;
	}
	

	loadGridBodyOnload();
}



function loadHeaderInfo(){
	var mode=0;
		if(document.washPrice.InOrOut[0].checked==true){mode="0"}
		if(document.washPrice.InOrOut[1].checked==true){mode="1"}
		
		if(mode==0){
			var cboPoNo = document.getElementById("cboPoNo").value;
			createXMLHttpRequest1(0);
			xmlHttp1[0].onreadystatechange = loadHeaderInfoRequest;
			var url  = "washPrice-xml.php?id=loadHeaderInfo";
				url += "&cboPoNo="+cboPoNo;
			xmlHttp1[0].open("GET",url,true);
			xmlHttp1[0].send(null);
		}
		else{
			loadOutSideWashPriceData();
		}
}

function loadHeaderInfoRequest(){ 	
 if(xmlHttp1[0].readyState == 4 && xmlHttp1[0].status == 200 ) 
 {
//alert(xmlHttp1[0].responseText);

  			var tblDryPro = document.getElementById("tblDryPro");
			var XMLintStyleId = xmlHttp1[0].responseXML.getElementsByTagName("intStyleId");
			var XMLstylename = xmlHttp1[0].responseXML.getElementsByTagName("stylename");
			var XMLstyleno   = xmlHttp1[0].responseXML.getElementsByTagName("styleno");
			var XMLfabric    = xmlHttp1[0].responseXML.getElementsByTagName("fabric");
			var XMLcompany   = xmlHttp1[0].responseXML.getElementsByTagName("company");
			var XMLColor   = xmlHttp1[0].responseXML.getElementsByTagName("color");
			var XMLcompanyId   = xmlHttp1[0].responseXML.getElementsByTagName("companyId");
			var XMLGarment	= xmlHttp1[0].responseXML.getElementsByTagName("garment");
            var XMLIncome	= xmlHttp1[0].responseXML.getElementsByTagName("Income");
//alert(XMLintStyleId.length);
if(XMLintStyleId.length >0){
           /* document.getElementById("cboStyleName").options[0].value = XMLintStyleId[0].childNodes[0].nodeValue;
	      	document.getElementById("cboStyleName").options[0].text = XMLstylename[0].childNodes[0].nodeValue;*/
			ClearOptions('cboStyleName');
			var styleID = XMLintStyleId[0].childNodes[0].nodeValue;
			var styleName = XMLstylename[0].childNodes[0].nodeValue;
			var newOption = $('<option>');
			newOption.attr('value',styleID).text(styleName);
 			$('#cboStyleName').append(newOption);
			document.getElementById("txtStyleNo").value=XMLstyleno[0].childNodes[0].nodeValue;
			/*document.getElementById("cboColor").options[0].value = XMLcolor[0].childNodes[0].nodeValue;
	      	document.getElementById("cboColor").options[0].text = XMLcolor[0].childNodes[0].nodeValue;*/
			ClearOptions('cboColor');
		/*	var color =  XMLcolor[0].childNodes[0].nodeValue;
			var newOption = $('<option>');
			newOption.attr().text(color);
 			$('#cboColor').append(newOption);*/
			
			var opt = document.createElement("option");
			opt.value 	= XMLColor[0].childNodes[0].nodeValue;	
			opt.text 	= XMLColor[0].childNodes[0].nodeValue;	
			document.getElementById("cboColor").options.add(opt);
			
			document.getElementById("txtFabricDes").value=XMLfabric[0].childNodes[0].nodeValue;
			document.getElementById("txtFactory").value=XMLcompany[0].childNodes[0].nodeValue;
			//document.getElementById("txtFactory").value=XMLcompany[0].childNodes[0].nodeValue;
			document.getElementById("proFinshRecComId").value=XMLcompanyId[0].childNodes[0].nodeValue;
			if(XMLIncome.length>0){
				document.getElementById("txtWashIncome").value=XMLIncome[0].childNodes[0].nodeValue;
			}
			
			else{
				document.getElementById("txtWashIncome").value=0;
			}
			document.getElementById('cboGmtType').value=XMLGarment[0].childNodes[0].nodeValue;
   }else{
	document.washPrice.reset();
	document.getElementById("cboStyleName").options[0].value="";
	document.getElementById("cboStyleName").options[0].text="";
	document.getElementById("cboColor").options[0].value="";
	document.getElementById("cboColor").options[0].text="";
	alert("No records");
   }
 }
}

function loadDryProcess(){

		createXMLHttpRequest1(0);
		xmlHttp1[0].onreadystatechange = loadDryProcessRequest;
		var url  = "washPrice-xml.php?id=loadDryProcess";
		
		xmlHttp1[0].open("GET",url,true);
		xmlHttp1[0].send(null);
}

function loadDryProcessRequest(){ 	
 if(xmlHttp1[0].readyState == 4 && xmlHttp1[0].status == 200 ) 
 {
//alert(xmlHttp1[0].responseText);
  			var tblDryPro = document.getElementById("tblDryPro");
			var XMLintSerialNo     = xmlHttp1[0].responseXML.getElementsByTagName("intSerialNo");
			var XMLstrDescription  = xmlHttp1[0].responseXML.getElementsByTagName("strDescription");

	      	var cls="";
			var cnt=0;
			for(var n = 0; n < XMLintSerialNo.length; n++) 
			{
				(cnt%2==0)?cls="grid_raw":cls="grid_raw2";
				var itemserial =XMLintSerialNo[n].childNodes[0].nodeValue
				var rowCount = tblDryPro.rows.length;
				var row = tblDryPro.insertRow(rowCount);
					row.className="bcgcolor-tblrowWhite";
				
				
				tblDryPro.rows[rowCount].innerHTML= 
                "<td class=\""+cls+"\"><input type=\"checkbox\" onclick=\"focusTextBox("+rowCount+");\"/></td>"+
		        "<td class=\""+cls+"\" id=\""+itemserial+"\"  style=\"text-align:left;\">"+XMLstrDescription[n].childNodes[0].nodeValue+"</td>"+
				"<td class=\""+cls+"\"><input type=\"text\" style=\"text-align:right;\" onkeypress=\"return CheckforValidDecimal(this.value,3,event)\" size=\"10\" maxlength=\"10\" onchange=\"checkLastDecimal(this);\" onkeyup=\"checkfirstDecimal(this);\"/></td>";
				cnt++;
			}
				loadGridBodyOnload();
 }
}

function focusTextBox(rowCount){
	var tblDryPro = document.getElementById("tblDryPro");
	tblDryPro.rows[rowCount].cells[2].childNodes[0].focus();
}

function loadGridBodyOnload(){
	inHouseDet(0);
	outSideDet(1);	
}
function inHouseDet(cat){
	var url  = "washPrice-xml.php?id=loadGrid&cat=0";
		htmlobj=$.ajax({url:url,async:false});
		var tblWashPriceGrid = document.getElementById("tblWashPriceGrid");
			var XMLpono       = htmlobj.responseXML.getElementsByTagName("pono");
			var XMLintStyleId = htmlobj.responseXML.getElementsByTagName("intStyleId");
			var XMLstyleno    = htmlobj.responseXML.getElementsByTagName("styleno");
			var XMLstylename  = htmlobj.responseXML.getElementsByTagName("stylename");
			var XMLwashincome = htmlobj.responseXML.getElementsByTagName("washincome");
			var XMLcostprice  = htmlobj.responseXML.getElementsByTagName("costprice");
			var XMLgarment    = htmlobj.responseXML.getElementsByTagName("garment");
			var XMLintGarmentId = htmlobj.responseXML.getElementsByTagName("intGarmentId");
			var XMLwashtype   = htmlobj.responseXML.getElementsByTagName("washtype");
			var XMLintWasTypeId = htmlobj.responseXML.getElementsByTagName("intWasTypeId");
			var XMLcolor      = htmlobj.responseXML.getElementsByTagName("color");
			var XMLstrFabDes  = htmlobj.responseXML.getElementsByTagName("strFabDes");
			var XMLstrName      = htmlobj.responseXML.getElementsByTagName("strName");
			var XMLCompanyID     = htmlobj.responseXML.getElementsByTagName("companyID");

	       	var InOrOut = "In";
		for(var n = 0; n < XMLpono.length; n++) 
			{
				var rowCount = tblWashPriceGrid.rows.length;
				var row = tblWashPriceGrid.insertRow(rowCount);
					row.className="bcgcolor-tblrowWhite";
    
				   var cls="";
				   var cnt=0;
				   (cnt%2==0)?cls="grid_raw":cls="grid_raw2";
					var intStyleId   = XMLintStyleId[n].childNodes[0].nodeValue;
					var intGarmentId = XMLintGarmentId[n].childNodes[0].nodeValue;
					var intWashtypeId = XMLintWasTypeId[n].childNodes[0].nodeValue;
					var strFabDes =  XMLstrFabDes[n].childNodes[0].nodeValue;
					var strName =  XMLstrName[n].childNodes[0].nodeValue;
					var companyID = XMLCompanyID[n].childNodes[0].nodeValue;
					
					tblWashPriceGrid.rows[rowCount].innerHTML= 
				   "<td class=\""+cls+"\"><img src=\"../../images/edit.png\" width=\"15\" height=\"15\" onclick=\"fillHeaderToUpdate("+rowCount+");\" /></td>"+
					"<td class=\""+cls+"\">"+InOrOut+"</td>"+
			"<td class=\""+cls+"\" id=\""+intStyleId+"\"  style=\"text-align:left;\">"+XMLstyleno[n].childNodes[0].nodeValue+"</td>"+
					"<td class=\""+cls+"\"  style=\"text-align:left;\">"+XMLpono[n].childNodes[0].nodeValue+"</td>"+
					"<td class=\""+cls+"\"  style=\"text-align:left;\">"+XMLstylename[n].childNodes[0].nodeValue+"</td>"+
					"<td class=\""+cls+"\" id=\""+strFabDes+"\"  style=\"text-align:right;\">"+XMLwashincome[n].childNodes[0].nodeValue+"</td>"+
					"<td class=\""+cls+"\" id=\""+strName+"\"  style=\"text-align:right;\">"+XMLcostprice[n].childNodes[0].nodeValue+"</td>"+
					"<td class=\""+cls+"\" id=\""+intGarmentId+"\"  style=\"text-align:left;\">"+XMLgarment[n].childNodes[0].nodeValue+"</td>"+
					"<td class=\""+cls+"\" id=\""+intWashtypeId+"\"  style=\"text-align:left;\">"+XMLwashtype[n].childNodes[0].nodeValue+"</td>"+
					"<td class=\""+cls+"\" id=\""+companyID+"\" style=\"text-align:left;\">"+XMLcolor[n].childNodes[0].nodeValue+"</td>";
					cnt++;
				}
		var tblDryPro = document.getElementById("tblDryPro");
					var rowCount = tblDryPro.rows.length;
					for(var i=1;i<rowCount;i++){
					tblDryPro.rows[i].cells[0].childNodes[0].checked=false;	
					tblDryPro.rows[i].cells[2].childNodes[0].value="";	
					}
}
function outSideDet(cat){
	var url  = "washPrice-xml.php?id=loadGrid&cat=1";
		htmlobj=$.ajax({url:url,async:false});
		var tblWashPriceGrid = document.getElementById("tblWashPriceGrid");
			var XMLpono       = htmlobj.responseXML.getElementsByTagName("pono");
			var XMLPoId 	= htmlobj.responseXML.getElementsByTagName("poId");
			var XMLstyleno    = htmlobj.responseXML.getElementsByTagName("strStyleNo");
			var XMLstylename  = htmlobj.responseXML.getElementsByTagName("strStyleDes");
			var XMLwashincome = htmlobj.responseXML.getElementsByTagName("Income");
			var XMLcostprice  = htmlobj.responseXML.getElementsByTagName("Cost");
			var XMLgarment    = htmlobj.responseXML.getElementsByTagName("Garment");
			var XMLintGarmentId = htmlobj.responseXML.getElementsByTagName("GarmentId");
			var XMLwashtype   = htmlobj.responseXML.getElementsByTagName("WasType");
			var XMLintWasTypeId = htmlobj.responseXML.getElementsByTagName("WashTypeId");
			var XMLColor      = htmlobj.responseXML.getElementsByTagName("Color");
			var XMLstrFabDes  = htmlobj.responseXML.getElementsByTagName("FabDes");
			var XMLstrName      = htmlobj.responseXML.getElementsByTagName("ComName");
			//var XMLCompanyID     = htmlobj.responseXML.getElementsByTagName("companyID");

	       	var InOrOut = "Out";
		for(var n = 0; n < XMLpono.length; n++) 
			{
				var rowCount = tblWashPriceGrid.rows.length;
				var row = tblWashPriceGrid.insertRow(rowCount);
					row.className="bcgcolor-tblrowWhite";
    
				   var cls="";
				   var cnt=0;
				   (cnt%2==0)?cls="grid_raw":cls="grid_raw2";
					var intStyleId   = XMLstyleno[n].childNodes[0].nodeValue;
					var intGarmentId = XMLintGarmentId[n].childNodes[0].nodeValue;
					var intWashtypeId = XMLintWasTypeId[n].childNodes[0].nodeValue;
					var strFabDes =  XMLstrFabDes[n].childNodes[0].nodeValue;
					var strName =  XMLstrName[n].childNodes[0].nodeValue;
					var PoId 	= XMLPoId[n].childNodes[0].nodeValue;
					
					tblWashPriceGrid.rows[rowCount].innerHTML= 
				   "<td class=\""+cls+"\"><img src=\"../../images/edit.png\" width=\"15\" height=\"15\" onclick=\"fillHeaderToUpdate("+rowCount+");\" /></td>"+
					"<td class=\""+cls+"\">"+InOrOut+"</td>"+
			"<td class=\""+cls+"\" id=\""+PoId+"\"  style=\"text-align:left;\">"+XMLpono[n].childNodes[0].nodeValue+"</td>"+
					"<td class=\""+cls+"\"  style=\"text-align:left;\">"+XMLstyleno[n].childNodes[0].nodeValue+"</td>"+
					"<td class=\""+cls+"\"  style=\"text-align:left;\">"+XMLstylename[n].childNodes[0].nodeValue+"</td>"+
					"<td class=\""+cls+"\" id=\""+strFabDes+"\"  style=\"text-align:right;\">"+XMLwashincome[n].childNodes[0].nodeValue+"</td>"+
					"<td class=\""+cls+"\" id=\""+XMLstrName[n].childNodes[0].nodeValue+"\"  style=\"text-align:right;\">"+XMLcostprice[n].childNodes[0].nodeValue+"</td>"+
					"<td class=\""+cls+"\" id=\""+intGarmentId+"\"  style=\"text-align:left;\">"+XMLgarment[n].childNodes[0].nodeValue+"</td>"+
					"<td class=\""+cls+"\" id=\""+intWashtypeId+"\"  style=\"text-align:left;\">"+XMLwashtype[n].childNodes[0].nodeValue+"</td>"+
					"<td class=\""+cls+"\" id=\"\" style=\"text-align:left;\">"+XMLColor[n].childNodes[0].nodeValue+"</td>";
					cnt++;
				}
		var tblDryPro = document.getElementById("tblDryPro");
					var rowCount = tblDryPro.rows.length;
					for(var i=1;i<rowCount;i++){
					tblDryPro.rows[i].cells[0].childNodes[0].checked=false;	
					tblDryPro.rows[i].cells[2].childNodes[0].value="";	
					}
}


function fillHeaderToUpdate(a){
var tblWashPriceGrid = document.getElementById("tblWashPriceGrid");	
	var i=0;
	if(tblWashPriceGrid.rows[a].cells[1].innerHTML=="In"){
		i=0;
	}
	else{
		i=1;
	}
		document.washPrice.radioCat[i].checked=true;
key="y";	

	var sql="select distinct wopo.intId,wopo.intPoNo from  was_oustside_issuedtowash woi inner join was_outsidepo wopo on wopo.intId=woi.intPoNo and woi.intPoNo not in(select woi.intPoNo from  was_oustside_issuedtowash woi) order by wopo.intPOno;";
	var control="cboPoNo";
	loadCombo(sql,control);
var upPoNo = tblWashPriceGrid.rows[a].cells[2].childNodes[0].nodeValue;
document.getElementById("cboPoNo").options[0].text = upPoNo;

var upintStyleId = tblWashPriceGrid.rows[a].cells[2].id;
document.getElementById("cboPoNo").options[0].value = upintStyleId;

var upStyleNo = tblWashPriceGrid.rows[a].cells[3].childNodes[0].nodeValue;
document.getElementById("txtStyleNo").value = upStyleNo;

var upDescription = tblWashPriceGrid.rows[a].cells[4].childNodes[0].nodeValue;
//document.getElementById("cboStyleName").options[0].text = upDescription;
//document.getElementById("cboStyleName").options[0].value = upintStyleId;
ClearOptions('cboStyleName');
var newOption = $('<option>');
newOption.attr('value',upintStyleId).text(upDescription);
 $('#cboStyleName').append(newOption);
 
var upWashIncome = tblWashPriceGrid.rows[a].cells[5].childNodes[0].nodeValue;
document.getElementById("txtWashIncome").value = upWashIncome;

var upWashCost = tblWashPriceGrid.rows[a].cells[6].childNodes[0].nodeValue;
document.getElementById("txtWashCost").value = upWashCost;

var upGarment = tblWashPriceGrid.rows[a].cells[7].childNodes[0].nodeValue;
//document.getElementById("cboGmtType").options[0].text = upGarment;
var upGarmentid = tblWashPriceGrid.rows[a].cells[7].id;
document.getElementById("cboGmtType").value = upGarmentid;

var upWashType = tblWashPriceGrid.rows[a].cells[8].childNodes[0].nodeValue;
//document.getElementById("cboWashType").options[0].text = upWashType;
var upWashTypeId = tblWashPriceGrid.rows[a].cells[8].id;

document.getElementById("cboWashType").value = upWashTypeId;


var upColor = tblWashPriceGrid.rows[a].cells[9].childNodes[0].nodeValue;
/*document.getElementById("cboColor").options[0].text = upColor;
document.getElementById("cboColor").options[0].value = upColor;*/
ClearOptions('cboColor');
/*var newOption = $('<option>');
newOption.attr().text(upColor);
 $('#cboColor').append(newOption);*/
 var opt = document.createElement("option");
		opt.value 	= upColor;	
		opt.text 	= upColor;	
		document.getElementById("cboColor").options.add(opt);
 
var upstrFabDes = tblWashPriceGrid.rows[a].cells[5].id;
document.getElementById("txtFabricDes").value = upstrFabDes;

var upstrName = tblWashPriceGrid.rows[a].cells[6].id;
document.getElementById("txtFactory").value = upstrName;

document.getElementById("proFinshRecComId").value = tblWashPriceGrid.rows[a].cells[9].id;

var cboPoNo = document.getElementById("cboPoNo").value;
		createXMLHttpRequest1(0);
		xmlHttp1[0].onreadystatechange = loadDetailsRequest;
		var url  = "washPrice-xml.php?id=loadDetails";
		    url += "&cboPoNo="+cboPoNo;

		xmlHttp1[0].open("GET",url,true);
		xmlHttp1[0].send(null);
}

function loadDetailsRequest(){
if(xmlHttp1[0].readyState == 4 && xmlHttp1[0].status == 200 ) 
 {
	var tblDryPro = document.getElementById("tblDryPro");
	var binCount	=	tblDryPro.rows.length;
	for(var loop=1;loop<binCount;loop++)
	{
			tblDryPro.deleteRow(loop);
			binCount--;
			loop--;
	}
//alert(xmlHttp1[0].responseText);
  		
			var XMLintSerialNo     = xmlHttp1[0].responseXML.getElementsByTagName("intSerialNo");
			var XMLstrDescription  = xmlHttp1[0].responseXML.getElementsByTagName("strDescription");
			var XMLintDryProssId   = xmlHttp1[0].responseXML.getElementsByTagName("intDryProssId");
			var XMLdblWashPrice    = xmlHttp1[0].responseXML.getElementsByTagName("dblWashPrice");

	      	var cnt=0;
			var cls="";
			for(var n = 0; n < XMLintSerialNo.length; n++) 
			{
				(cnt%2==0)?cls="grid_raw":cls="grid_raw2";
				var itemserial =XMLintSerialNo[n].childNodes[0].nodeValue
				var rowCount = tblDryPro.rows.length;
				var row = tblDryPro.insertRow(rowCount);
					row.className="bcgcolor-tblrowWhite";

			tblDryPro.rows[rowCount].innerHTML= 
	"<td class=\""+cls+"\"><input type=\"checkbox\" checked=\"checked\"  onclick=\"focusTextBox("+rowCount+");\"/></td>"+	             
		    "<td class=\""+cls+"\" id=\""+itemserial+"\" style=\"text-align:left;\">"+XMLstrDescription[n].childNodes[0].nodeValue+"</td>"+
			"<td class=\""+cls+"\"><input type=\"text\" style=\"text-align:right;\" onkeypress=\"return CheckforValidDecimal(this.value,3,event)\" size=\"10\" maxlength=\"10\" value=\""+XMLdblWashPrice[n].childNodes[0].nodeValue+"\" onchange=\"checkLastDecimal(this);\" onkeyup=\"checkfirstDecimal(this);\"/></td>";
			cnt++;
			}
			//----------------------------------------------------------------------------------------------------------
			var XMLintSerialNo2     = xmlHttp1[0].responseXML.getElementsByTagName("intSerialNo2");
			var XMLstrDescription2  = xmlHttp1[0].responseXML.getElementsByTagName("strDescription2");
			var XMLintDryProssId2   = xmlHttp1[0].responseXML.getElementsByTagName("intDryProssId2");
			var XMLdblWashPrice2    = xmlHttp1[0].responseXML.getElementsByTagName("dblWashPrice2");

	    
			for(var nn = 0; nn < XMLintSerialNo2.length; nn++) 
			{  (cnt%2==0)?cls="grid_raw":cls="grid_raw2";
				var itemserial =XMLintSerialNo2[nn].childNodes[0].nodeValue
				var rowCount = tblDryPro.rows.length;
				var row = tblDryPro.insertRow(rowCount);
					row.className="bcgcolor-tblrowWhite";

			tblDryPro.rows[rowCount].innerHTML= 
			"<td class=\""+cls+"\"><input type=\"checkbox\"  onclick=\"focusTextBox("+rowCount+");\"/></td>"+	             
		    "<td class=\""+cls+"\" id=\""+itemserial+"\" style=\"text-align:left;\">"+XMLstrDescription2[nn].childNodes[0].nodeValue+"</td>"+
			"<td class=\""+cls+"\" ><input type=\"text\"  onkeypress=\"return CheckforValidDecimal(this.value,3,event)\" size=\"10\" maxlength=\"10\" style=\"text-align:right;\" onchange=\"checkLastDecimal(this);\" onkeyup=\"checkfirstDecimal(this);\"/></td>";
			cnt++;
			}
 }
}

function saveWashPriceHeader(){
	var cboPoNo = document.getElementById("cboPoNo").value;
	var cboColor = document.getElementById("cboColor").value;
	var cboStyleName = document.getElementById("cboStyleName").value;
	var txtStyleNo = document.getElementById("txtStyleNo").value;
	var txtWashIncome = document.getElementById("txtWashIncome").value;
	var txtFabricDes = document.getElementById("txtFabricDes").value;
	var txtWashCost = document.getElementById("txtWashCost").value;
	var cboWashType = document.getElementById("cboWashType").value;
	var txtFactory = document.getElementById("proFinshRecComId").value;
	var cboGmtType = document.getElementById("cboGmtType").value;
	var proFinishRecCompanyID = document.getElementById("proFinshRecComId").value;
	
    if(cboPoNo == ""){
	alert("Please select \"PO No\".");
	document.getElementById("cboPoNo").focus();
	return false;
	}
	
    if(cboColor == ""){
	alert("Please select \"Color\".");
	document.getElementById("cboPoNo").focus();
	return false;
	}
	
	
	if(txtStyleNo == ""){
	alert("Please select \"Style No\".");
	document.getElementById("cboColor").focus();
	return false;
	}
	
	if(txtWashIncome == ""){
	alert("Please select \"Wash Income\".");
	document.getElementById("txtWashIncome").focus();
	return false;
	}
	
	if(txtWashCost == ""){
	alert("Please select \"Wash Cost\".");
	document.getElementById("txtWashCost").focus();
	return false;
	}
	
	if(cboWashType == ""){
	alert("Please select \"Wash Type\".");
	document.getElementById("cboWashType").focus();
	return false;
	}
	
    if(cboGmtType == ""){
	alert("Please select \"Garment Type\".");
	document.getElementById("cboGmtType").focus();
	return false;
	}
	var mode=0;
		if(document.washPrice.InOrOut[0].checked==true){mode="0"}
		if(document.washPrice.InOrOut[1].checked==true){mode="1"}
	if(key == "n"){
		
		createXMLHttpRequest1(0);
		xmlHttp1[0].onreadystatechange = saveWashPriceHeaderRequest;
		var url  = "washPrice-db.php?id=saveWashPriceHeader";
		    url += "&cboPoNo="+URLEncode(cboPoNo);
			url += "&cboColor="+URLEncode(cboColor);
			url += "&cboStyleName="+URLEncode(cboStyleName);
			url += "&cboGmtType="+URLEncode(cboGmtType);
			url += "&cboWashType="+URLEncode(cboWashType);
			url += "&txtStyleNo="+URLEncode(txtStyleNo);
			url += "&txtWashIncome="+URLEncode(txtWashIncome);
			url += "&txtFabricDes="+URLEncode(txtFabricDes);
			url += "&txtWashCost="+URLEncode(txtWashCost);
			url += "&txtFactory="+URLEncode(txtFactory);
			url += "&proFinishRecCompanyID="+proFinishRecCompanyID;
			url += "&cat="+mode;
		xmlHttp1[0].open("GET",url,true);
		xmlHttp1[0].send(null);
	}else{
		//alert("B");
		var mode=0;
		if(document.washPrice.InOrOut[0].checked==true){mode="0"}
		if(document.washPrice.InOrOut[1].checked==true){mode="1"}
		
	var cboPoNo = document.getElementById("cboPoNo").value;
	var path = "washPrice-db.php?id=deleteForUpdate&cboPoNo="+cboPoNo;
	htmlobj=$.ajax({url:path,async:false});
	//alert(htmlobj.responseText);
		createXMLHttpRequest1(0);
		xmlHttp1[0].onreadystatechange = updateWashPriceHeaderRequest;
		var url  = "washPrice-db.php?id=updateWashPriceHeader";
		    url += "&cboPoNo="+URLEncode(cboPoNo);
			url += "&cboColor="+URLEncode(cboColor);
			url += "&cboStyleName="+URLEncode(cboStyleName);
			url += "&cboGmtType="+URLEncode(cboGmtType);
			url += "&cboWashType="+URLEncode(cboWashType);
			url += "&txtStyleNo="+URLEncode(txtStyleNo);
			url += "&txtWashIncome="+URLEncode(txtWashIncome);
			url += "&txtFabricDes="+URLEncode(txtFabricDes);
			url += "&txtWashCost="+URLEncode(txtWashCost);
			url += "&txtFactory="+URLEncode(txtFactory);
			url += "&proFinishRecCompanyID="+proFinishRecCompanyID;
			url += "&cat="+mode;
		xmlHttp1[0].open("GET",url,true);
		xmlHttp1[0].send(null);
	}
}

function refreshPage(){
	
	document.getElementById('cboStyleName').innerHTML="";
	document.getElementById('cboColor').innerHTML="";
	key="n";
	clearDryProcessData();
	loadOrderNolist();//do not get style id's which are not in the wash_price tbl
	document.washPrice.reset();
}

function saveWashPriceHeaderRequest(){

		if(xmlHttp1[0].readyState == 4 && xmlHttp1[0].status == 200 ) 
		{
			var response = xmlHttp1[0].responseText;
		//alert(response);
			if(response!="Saving-Error")
			{
				
				saveWashPriceDetails();

				
			}
			else
			{
				alert("Error : \nInvoice Costing header not saved");
				return;
			}
		}
}

function updateWashPriceHeaderRequest(){

		if(xmlHttp1[0].readyState == 4 && xmlHttp1[0].status == 200 ) 
		{
			var response = xmlHttp1[0].responseText;
		//alert(response);
			if(response!="Saving-Error")
			{
				
				updateWashPriceDetails();

				
			}
			else
			{
				alert("Error : \nInvoice Costing header not saved");
				return;
			}
		}
}

function deleteWashPriceDetails(){

}


function saveWashPriceDetails()
{
	
	var tblWash = document.getElementById("tblDryPro");	
	pub_intxmlHttp_count = tblWash.rows.length-1;

	for(var loop=1;loop<tblWash.rows.length;loop++)
	{
	if(tblWash.rows[loop].cells[0].lastChild.checked == true){
	var chkBox = 'yes';	
	}else{
	var chkBox = 'no';	
	}
	var cboPoNo      = document.getElementById("cboPoNo").value;	
	var descrip      = tblWash.rows[loop].cells[1].id;
	var washPrice    = tblWash.rows[loop].cells[2].lastChild.value;


	createXMLHttpRequest1(loop);
	xmlHttp1[loop].onreadystatechange = saveWashPriceDetailsRequest;
	var url  = "washPrice-db.php?id=saveWashPriceDetails";
	    url += "&cboPoNo="+cboPoNo;
		url += "&chkBox="+chkBox;
		url += "&descrip="+descrip;
		url += "&washPrice="+washPrice;
		
	xmlHttp1[loop].index = loop;
	xmlHttp1[loop].open("GET",url,true);
	xmlHttp1[loop].send(null);

	}
}

function updateWashPriceDetails()
{
	
	var tblWash = document.getElementById("tblDryPro");	
	pub_intxmlHttp_count = tblWash.rows.length-1;

	for(var loop=1;loop<tblWash.rows.length;loop++)
	{
	if(tblWash.rows[loop].cells[0].lastChild.checked == true){
	var chkBox = 'yes';	
	}else{
	var chkBox = 'no';	
	}
	var cboPoNo      = document.getElementById("cboPoNo").value;	
	var descrip      = tblWash.rows[loop].cells[1].id;
	var washPrice    = tblWash.rows[loop].cells[2].lastChild.value;


	createXMLHttpRequest1(loop);
	xmlHttp1[loop].onreadystatechange = updateWashPriceDetailsRequest;
	var url  = "washPrice-db.php?id=updateWashPriceDetails";
	    url += "&cboPoNo="+cboPoNo;
		url += "&chkBox="+chkBox;
		url += "&descrip="+descrip;
		url += "&washPrice="+washPrice;
		
	xmlHttp1[loop].index = loop;
	xmlHttp1[loop].open("GET",url,true);
	xmlHttp1[loop].send(null);

	}
}

function saveWashPriceDetailsRequest()
{
		if(xmlHttp1[this.index].readyState == 4 && xmlHttp1[this.index].status == 200 ) 
		{
			var cboPoNo =xmlHttp1[this.index].responseText;
			//alert(cboPoNo);
			if(cboPoNo==1)
			{
				pub_intxmlHttp_count=pub_intxmlHttp_count-1;
				if (pub_intxmlHttp_count ==0)
				{
				var	cboPoNo1= document.getElementById("cboPoNo").options[document.getElementById("cboPoNo").selectedIndex].text;
					alert("Style No  \"" + cboPoNo1 + "\" Saved successfully.");
					document.getElementById("cboPoNo").value="";
					
					var tblDryPro = document.getElementById("tblDryPro");
					var rowCount = tblDryPro.rows.length;
					for(var i=1;i<rowCount;i++){
					tblDryPro.rows[i].cells[0].lastChild.checked=false;	
					tblDryPro.rows[i].cells[2].lastChild.value="";	
					}

			 document.getElementById("cboGmtType").options[0].text = "";
			 document.getElementById("cboWashType").options[0].value = "";
			 

             ClearForm();		
				}
			}
			else{
				//alert( "wash price details saving error...");
			}
		}
}

function updateWashPriceDetailsRequest()
{
		if(xmlHttp1[this.index].readyState == 4 && xmlHttp1[this.index].status == 200 ) 
		{
			var cboPoNo =xmlHttp1[this.index].responseText;
			//alert(cboPoNo);
			if(cboPoNo==1)
			{
				pub_intxmlHttp_count=pub_intxmlHttp_count-1;
				if (pub_intxmlHttp_count ==0)
				{
				var	cboPoNo1= document.getElementById("cboPoNo").options[document.getElementById("cboPoNo").selectedIndex].text;
					alert("Style No  \"" + cboPoNo1 + "\" Saved successfully !");
					document.getElementById("cboPoNo").value="";
					
					var tblDryPro = document.getElementById("tblDryPro");
					var rowCount = tblDryPro.rows.length;
					for(var i=1;i<rowCount;i++){
					tblDryPro.rows[i].cells[0].lastChild.checked=false;	
					tblDryPro.rows[i].cells[2].lastChild.value="";	
					}

			 document.getElementById("cboGmtType").options[0].text = "";
			 document.getElementById("cboWashType").options[0].value = "";

             ClearForm();	
			 
				}
			}
			else{
				//alert( "wash price details saving error...");
			}
		}
}

function ClearForm()
{
var mode=0;
if(document.washPrice.InOrOut[0].checked==true){mode="0"}
if(document.washPrice.InOrOut[1].checked==true){mode="1"}
createXMLHttpRequest();
xmlHttp.onreadystatechange = ClearFormRequest;
var url  = "washPrice-xml.php?id=pono&Mode="+mode;

xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}
	

	
function ClearFormRequest(){	
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{
			document.getElementById("cboPoNo").innerHTML  = xmlHttp.responseText;				
			clearTable();
		}
	}				
}
	
  function enter(e)
  {
   /*evt = e || window.event;
   if(evt && evt.keyCode == 13)
   {*/

    searchGrid();
/*
    return false; 
   }
   else
    return true; 
	}*/

	}
function searchGrid()
{
 var poNoLike = document.getElementById("poNoLike").value.trim();	
 createXMLHttpRequest1(0);
 xmlHttp1[0].onreadystatechange = searchGridRequest;
 var url  = "washPrice-xml.php?id=searchGrid";
     url += "&poNoLike="+poNoLike;

 xmlHttp1[0].open("GET",url,true);
 xmlHttp1[0].send(null);
}

function searchGridRequest(){ 

 if(xmlHttp1[0].readyState == 4 && xmlHttp1[0].status == 200 ) 
 {
//alert(xmlHttp1[0].responseText);
	var tblTable    = 	document.getElementById("tblWashPriceGrid");
	var binCount1	=	tblTable.rows.length;
	for(var loop=1;loop<binCount1;loop++)
	{
			tblTable.deleteRow(loop);
			binCount1--;
			loop--;
	}
	
  			var tblWashPriceGrid = document.getElementById("tblWashPriceGrid");
			var XMLpono       = xmlHttp1[0].responseXML.getElementsByTagName("pono");
			var XMLintStyleId = xmlHttp1[0].responseXML.getElementsByTagName("intStyleId");
			var XMLstyleno    = xmlHttp1[0].responseXML.getElementsByTagName("styleno");
			var XMLstylename  = xmlHttp1[0].responseXML.getElementsByTagName("stylename");
			var XMLwashincome = xmlHttp1[0].responseXML.getElementsByTagName("washincome");
			var XMLcostprice  = xmlHttp1[0].responseXML.getElementsByTagName("costprice");
			var XMLgarment    = xmlHttp1[0].responseXML.getElementsByTagName("garment");
			var XMLintGarmentId = xmlHttp1[0].responseXML.getElementsByTagName("intGarmentId");
			var XMLwashtype   = xmlHttp1[0].responseXML.getElementsByTagName("washtype");
			var XMLintWasTypeId = xmlHttp1[0].responseXML.getElementsByTagName("intWasTypeId");
			var XMLcolor      = xmlHttp1[0].responseXML.getElementsByTagName("color");
			var XMLstrFabDes  = xmlHttp1[0].responseXML.getElementsByTagName("strFabDes");
			var XMLstrName      = xmlHttp1[0].responseXML.getElementsByTagName("strName");
			var XMLintCat		= xmlHttp1[0].responseXML.getElementsByTagName("intCat"); 

	       var InOrOut = "";
		   var i=0;
		   var cls='';
			for(var n = 0; n < XMLpono.length; n++) 
			{
				(i%2==0)?cls="grid_raw":cls="grid_raw2";
				var rowCount = tblWashPriceGrid.rows.length;
				var row = tblWashPriceGrid.insertRow(rowCount);
					row.className="bcgcolor-tblrowWhite";
       //alert(XMLintCat[n].childNodes[0].nodeValue);
	   if(XMLintCat[n].childNodes[0].nodeValue==0){
		 InOrOut = "In";   
	   }else{
		 InOrOut = "Out";   
	   }
        var intStyleId   = XMLintStyleId[n].childNodes[0].nodeValue;
		var intGarmentId = XMLintGarmentId[n].childNodes[0].nodeValue;
		var intWashtypeId = XMLintWasTypeId[n].childNodes[0].nodeValue;
		var strFabDes =  XMLstrFabDes[n].childNodes[0].nodeValue;
		var strName =  XMLstrName[n].childNodes[0].nodeValue;
		
		tblWashPriceGrid.rows[rowCount].innerHTML= 
       "<td class=\""+cls+"\"><img src=\"../../images/edit.png\" width=\"15\" height=\"15\" onclick=\"fillHeaderToUpdate("+rowCount+");\" /></td>"+
        "<td class=\""+cls+"\">"+InOrOut+"</td>"+
"<td class=\""+cls+"\" id=\""+intStyleId+"\" style=\" text-align:left;\">"+XMLpono[n].childNodes[0].nodeValue+"</td>"+
		"<td class=\""+cls+"\" style=\"text-align:left;\">"+XMLstyleno[n].childNodes[0].nodeValue+"</td>"+
		"<td class=\""+cls+"\" style=\"text-align:left;\">"+XMLstylename[n].childNodes[0].nodeValue+"</td>"+
		"<td class=\""+cls+"\" id=\""+strFabDes+"\" style=\"text-align:right;\">"+XMLwashincome[n].childNodes[0].nodeValue+"</td>"+
		"<td class=\""+cls+"\" id=\""+strName+"\" style=\"text-align:right;\">"+XMLcostprice[n].childNodes[0].nodeValue+"</td>"+
		"<td class=\""+cls+"\" id=\""+intGarmentId+"\" style=\"text-align:left;\">"+XMLgarment[n].childNodes[0].nodeValue+"</td>"+
		"<td class=\""+cls+"\" id=\""+intWashtypeId+"\" style=\"text-align:left;\">"+XMLwashtype[n].childNodes[0].nodeValue+"</td>"+
		"<td class=\""+cls+"\" style=\"text-align:left;\">"+XMLcolor[n].childNodes[0].nodeValue+"</td>";

			}

		   }else{
			   var tblWashPriceGrid =document.getElementById("tblWashPriceGrid");
			   	var rowCount = tblWashPriceGrid.rows.length;
				var row = tblWashPriceGrid.insertRow(rowCount);
					row.className="bcgcolor-tblrowWhite";
		//tblWashPriceGrid.rows[rowCount].innerHTML= "<td colspan=\"6\" align=\"center\"><font size=\"2\" color=\"red\"/>No Records</td>";	;
		
	}i++
 }


function printPoAvailable(){
 	window.open("printPoAvailable.php","washPrice");	
}

function clearDryProcessData()
{
	var tblRwCnt = $('#tblDryPro tr').length;
	var tbl = document.getElementById("tblDryPro");
	for ( var loop = 1 ;loop < tblRwCnt ; loop ++ )
	{
		var chk = $('#tblDryPro tr:eq('+loop+') td:eq(0)').children(0).attr("checked",false);
		$('#tblDryPro tr:eq('+loop+') td:eq(2)').children(0).val('');
	}
}

function loadOrderNolist()
{
	var url = 'washPrice-xml.php?id=loadOrderNolist';	
				
		htmlobj=$.ajax({url:url,async:false});
		 $("#cboPoNo").html(htmlobj.responseXML.getElementsByTagName("orderNo")[0].childNodes[0].nodeValue);
}

function ClearOptions(id)
{
	var selectObj = document.getElementById(id);
	var selectParentNode = selectObj.parentNode;
	var newSelectObj = selectObj.cloneNode(false); // Make a shallow copy
	selectParentNode.replaceChild(newSelectObj, selectObj);
	return newSelectObj;
}

function checkfirstDecimal(obj){
	var d=obj.value.trim().charAt(0);	
	if(d=='.')
		obj.value=0;	
}

function checkLastDecimal(obj){
	var len=obj.value.trim().length;
	if(obj.value.trim().charAt(len-1)=='.')
			obj.value=obj.value.trim().substr(0,len-1);
}

function checkDecimals(obj){
	var d=obj.value.trim();	
	if(d.indexOf('.') > -1){
		//var c=d.charAt(d.indexOf('.'));
		obj.value=d.replace(/\./g,' ');
		obj.value=obj.value.trim();
	}
}