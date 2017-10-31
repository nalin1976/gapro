var xmlHttp1 				= [];
var pub_validateCount 		= 0;
var pub_taxValidateCount 	= 0;
var valLoop					= 0;
var pub_mainRw				= 0;
function createXMLHttpRequest1(index){
    if (window.ActiveXObject) 
    {
        xmlHttp1[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp1[index] = new XMLHttpRequest();
    }
}

function changeToStyleTextBox()
{
	var obj = this;
	var  currentTxt = obj.innerHTML;
	if ( obj.childNodes[0] instanceof HTMLInputElement)
	{
		return;
	}
	obj.innerHTML = "<input type=\"text\" onkeydown=\"isEnterKey1(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" class=\"txtbox\" value =\""+ currentTxt + "\" onblur=\"changeToTableCell1(this);\" style=\"width:250px\" maxlength=\"200\">";
	obj.childNodes[0].focus();
}
function isEnterKey1(evt)
  {
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 if(charCode == 13)
		 document.getElementById('txtNoLines').focus();
  }
  
function changeToTableCell1(obj)
{
	obj.parentNode.innerHTML = obj.value;
}

function RemoveItem(obj){
	if(confirm('Are you sure you want to remove this item?'))
	{
		obj.parentNode.parentNode;

		var td = obj.parentNode;
		var tro = td.parentNode;				
		tro.parentNode.removeChild(tro);			
		DeleteRow(obj);
	}
}

function DeleteRow(obj){
	var deliveryNo 	= document.getElementById("txtDeliveryNo").value;
	var rw			= obj.parentNode.parentNode;
	var recType 	= document.getElementById('txtDeliveryNo').parentNode.value;
	var detailID 	= rw.cells[2].id;		
	
	createXMLHttpRequest1(1);
	xmlHttp1[1].open("GET",'cusdecdb.php?RequestType=DeleteDetailRow&deliveryNo=' +deliveryNo+ '&detailID=' +detailID+ '&recType=' +recType,true);
	xmlHttp1[1].send(null);
}

function AddToDescription(obj)
{
	var no	= 1;
	var tblDescription 	= document.getElementById('tblDescription');
	var tblItemPopUp 	= document.getElementById('tblItemPopUp');
	
	var description 	= obj.cells[0].childNodes[0].nodeValue;
	var matDetailID 	= obj.cells[0].id;
	var commodityCode 	= obj.cells[1].childNodes[0].nodeValue;
	var units 			= obj.cells[2].childNodes[0].nodeValue;

	var qty				= 0;
	var price			= 0;
	var gross			= 0;
	var net				= 0;
	var noOfPkgs		= 0;
	var procCode1		= 0;
	var procCode2		= 0;
		
	var booCheck = false;
	var maxRow = 0;
			for (var mainLoop =1 ;mainLoop < tblDescription.rows.length; mainLoop++ ){
				var mainMatDetaiID 	= tblDescription.rows[mainLoop].cells[2].id;											
				var rowNo 			= parseFloat(tblDescription.rows[mainLoop].cells[1].childNodes[0].nodeValue);					
				maxRow = Math.max(maxRow, rowNo); 
				
				if (mainMatDetaiID==matDetailID)
				{
							booCheck = true;
							alert("Item : "+description+"\nAlready added.")
				}	
			}
			if (booCheck == false){
			var lastRow 		= tblDescription.rows.length;	
			var row 			= tblDescription.insertRow(lastRow);
			
			row.className ="bcgcolor-tblrow";	
			
			var cellDelete = row.insertCell(0); 
			cellDelete.className ="normalfnt";	
			cellDelete.innerHTML = "<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";			
			
			var cellNo = row.insertCell(1);
			cellNo.className ="normalfnt";
			cellNo.innerHTML =maxRow+1;
			
			var cellDescription = row.insertCell(2);
			cellDescription.className ="normalfntSML";
			cellDescription.id =matDetailID;
			cellDescription.innerHTML =description;
			cellDescription.onclick = changeToStyleTextBox;
			
					
			var cellStyleID = row.insertCell(3);
			cellStyleID.className ="normalfntMid";						
			cellStyleID.innerHTML =units+"<a href=\"#\" title=\"Click here for Unit Conversion..\"><img src=\"../../images/transfer.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"UnitConversionPopup(this);\" border=\"0\"/></a>";
					
			var cellqty = row.insertCell(4);
			cellqty.className ="normalfntRite";
			cellqty.innerHTML ="<input type=\"text\" name=\"txtQty\" id=\"txtQty\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" value=\""+qty+"\" onkeyup=\"GetUmoQty2(this);\" /></td>";
			
					
			var celPrice = row.insertCell(5);
			celPrice.className ="normalfntRite";
			//celPrice.onclick = changeToStyleTextBox;
			celPrice.innerHTML ="<input type=\"text\" name=\"txtQty\" id=\"txtQty\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" value=\""+price+"\" onkeyup=\"GetSumFobValue(this)\"/></td>";
			
					
			var cellSize = row.insertCell(6);
			cellSize.className ="normalfntRite";
			cellSize.innerHTML ="<input type=\"text\" name=\"txtQty\" id=\"txtQty\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" value=\""+gross+"\"/></td>";
			
			var cellUnits = row.insertCell(7);
			cellUnits.className ="normalfntRite";
			cellUnits.innerHTML ="<input type=\"text\" name=\"txtQty\" id=\"txtQty\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" value=\""+net+"\" onkeyup=\"GetUmoQty1(this);\"/></td>";
		
			var cellStockQty = row.insertCell(8);
			cellStockQty.className ="normalfntRite";
			cellStockQty.innerHTML ="<input type=\"text\" name=\"txtQty\" id=\"txtQty\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" value=\""+noOfPkgs+"\"/></td>";
			
			var cellGrnQty = row.insertCell(9);
			cellGrnQty.className ="normalfntRite";				
			cellGrnQty.innerHTML = "<input type=\"text\" name=\"txtQty\" id=\"txtQty\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" value=\""+procCode1+"\" maxlength=\"4\"/></td>";
			
			var cellTxt = row.insertCell(10);				
			cellTxt.className ="normalfntRite";				
			cellTxt.innerHTML =	"<input type=\"text\" name=\"txtQty\" id=\"txtQty\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" value=\""+procCode2+"\" maxlength=\"3\"/></td>";
			
			var cellTxt = row.insertCell(11);				
			cellTxt.className ="normalfntRite";	
			cellTxt.innerHTML =	"<input type=\"text\" name=\"txtUmoQty1\" id=\"txtUmoQty1\" class=\"txtbox\" size=\"10\" style=\"text-align:right\"   maxlength=\"20\"/></td>";
			
			var cellTxt = row.insertCell(12);				
			cellTxt.className ="normalfntRite";	
			cellTxt.innerHTML =	"<input type=\"text\" name=\"txtUmoQty2\" id=\"txtUmoQty2\" class=\"txtbox\" size=\"10\" style=\"text-align:right\"   maxlength=\"20\"/></td>";
			
			var cellTxt = row.insertCell(13);				
			cellTxt.className ="normalfntSML";	
			cellTxt.innerHTML =	"<input type=\"text\" name=\"txtUmoQty2\" id=\"txtUmoQty2\" class=\"txtbox\" size=\"10\" style=\"text-align:right\"   maxlength=\"20\"/></td>";
			
			var cellTxt = row.insertCell(14);				
			cellTxt.className ="normalfntRite";	
			cellTxt.innerHTML =	"0";
			
			var cellTxt = row.insertCell(15);				
			cellTxt.className ="normalfntRite";	
			cellTxt.innerHTML =	commodityCode;
			
			var celltax = row.insertCell(16); 
			celltax.className ="normalfntMid";	
			celltax.innerHTML = "<img src=\"../../images/aad.png\" alt=\"del\"  id=\"butTax\" onclick=\"OpenItemTaxPopUp(this);\" class=\"mouseover\"/>";
			
			no++;
			}
}

function SaveDetailValidation()
{
	var tbl	= document.getElementById('tblDescription');
	if(tbl.rows.length<=1){alert("Sorry..\nNo details appear to save in the page.");return}
	
	//START - CALCULATE FOB VALUE
	var price 			= 0;
	var calValue		= 0;
	
	var tblDescription 	= document.getElementById('tblDescription');
	var insurence		= parseFloat(document.getElementById('txtInsurance').value);
	var frieght			= parseFloat(document.getElementById('txtFreight').value);
	var other			= parseFloat(document.getElementById('txtOther').value);
	var exRate			= parseFloat(document.getElementById('txtExRate').value);
	var fob				= parseFloat(document.getElementById('txtFOB').value);
	
	for(loop=1;loop<tblDescription.rows.length;loop++)
	{
		price 		= parseFloat(tblDescription.rows[loop].cells[5].childNodes[0].value);
		price		= (isNaN(price) ? 0:price);
			if(price==0 || price==""){alert("Unit price can't be Empty or '0' in line no : " + loop);return;}
		calValue 	= (insurence + frieght + other)/fob;
		calValue 	= (calValue*price);
		calValue 	= (calValue+price)
		calValue 	= (calValue*exRate)
		calValue 	= (isNaN(calValue) ? 0:calValue);
		tblDescription.rows[loop].cells[14].childNodes[0].nodeValue= calValue.toFixed(2);
	}
	//END - CALCULATE FOB VALUE	
	//showBackGroundBalck();
	CalculateTax();
}

function SaveDetails()
{
	pub_validateCount 	= 0;
	var tbl				= document.getElementById('tblDescription');
	var deliveryNo		= document.getElementById('txtDeliveryNo').value;
	var totalValue     = document.getElementById('txtInvoAmount').value;
		for(var loop=1;loop<tbl.rows.length;loop++)
		{
			var description		= tbl.rows[loop].cells[2].childNodes[0].nodeValue;
			
			var styleID			= tbl.rows[loop].cells[13].childNodes[0].value;
			var matDetailID		= tbl.rows[loop].cells[2].id;
			var itemNo			= tbl.rows[loop].cells[1].childNodes[0].nodeValue;
			var commodityCode	= tbl.rows[loop].cells[15].childNodes[0].nodeValue;
			var qty				= tbl.rows[loop].cells[4].childNodes[0].value;
			var noOfPkgs		= tbl.rows[loop].cells[8].childNodes[0].value;
			var itemPrice		= tbl.rows[loop].cells[5].childNodes[0].value;
			var grossMass		= tbl.rows[loop].cells[6].childNodes[0].value;
			var netMass			= tbl.rows[loop].cells[7].childNodes[0].value;
			var procCode1		= tbl.rows[loop].cells[9].childNodes[0].value;
			var procCode2		= tbl.rows[loop].cells[10].childNodes[0].value;
			var umoQty1			= tbl.rows[loop].cells[11].childNodes[0].value;
			var umoQty2			= tbl.rows[loop].cells[12].childNodes[0].value;
			var umoQty3			= tbl.rows[loop].cells[13].childNodes[0].value;
			var itemValue		= tbl.rows[loop].cells[14].childNodes[0].nodeValue;
			var strUnit			= tbl.rows[loop].cells[3].childNodes[0].nodeValue;
			var remarks			= tbl.rows[loop].cells[1].childNodes[0].nodeValue;
			var recordType  	= tbl.rows[loop].cells[1].childNodes[0].nodeValue;
			pub_validateCount ++;
		createXMLHttpRequest1(loop);	
		//xmlHttp1[loop].onreadystatechange=LoadStockDetailsRequest;
		xmlHttp1[loop].open("GET",'cusdecdb.php?RequestType=SaveDeliveryDetails&deliveryNo=' +deliveryNo+ '&description=' +URLEncode(description)+ '&styleID=' +URLEncode(styleID)+ '&matDetailID=' +matDetailID+ '&itemNo=' +itemNo+ '&commodityCode=' +commodityCode+ '&qty=' +qty+ '&noOfPkgs=' +noOfPkgs+ '&itemPrice=' +itemPrice+ '&grossMass=' +grossMass+ '&netMass=' +netMass+ '&procCode1=' +procCode1+'&procCode2=' +procCode2+ '&itemValue=' +itemValue+ '&strUnit=' +strUnit+ '&totalValue=' +totalValue+ '&umoQty1=' +umoQty1+ '&umoQty2=' +umoQty2+ '&umoQty3=' +umoQty3 ,true);
		xmlHttp1[loop].send(null);
		}
		SaveCusdecDetailsValidate();
}
function SaveCusdecDetailsValidate()
{	
	var deliveryNo	= document.getElementById('txtDeliveryNo').value;
	createXMLHttpRequest1(1);
	xmlHttp1[1].index = deliveryNo;
	xmlHttp1[1].onreadystatechange = SaveCusdecDetailsValidateRequest;
	xmlHttp1[1].open("GET",'cusdecxml.php?RequestType=SaveCusdecDetailsValidate&deliveryNo=' +deliveryNo+ '&validateCount=' +pub_validateCount ,true);
	xmlHttp1[1].send(null);
}
	function SaveCusdecDetailsValidateRequest()
	{
		if(xmlHttp1[1].readyState == 4) 
		{
			if(xmlHttp1[1].status == 200)
			{				
				var XMLCountDetails= xmlHttp1[1].responseXML.getElementsByTagName("recCountDetails")[0].childNodes[0].nodeValue;
				
					if(XMLCountDetails=="TRUE")
					{
						alert ("Detail in Delivery No : "+xmlHttp1[1].index+" saved successfully.");				
						hideBackGroundBalck();
					}
					else 
					{						
						valLoop ++
						if(valLoop>=10)
						{
							alert("Sorry!\nError occured while saving the data. Please Save it again.");
							hideBackGroundBalck();
							valLoop = 0;
							return;
						}
						else
						{
							SaveCusdecDetailsValidate();
						}
					}			
			}
		}
	}

function LoadCusdecDetails()
{
	if(confirm('This action will lose your unsaved details\nDo you want to Reload this data?'))
	{
	var deliveryNo	= document.getElementById("txtDeliveryNo").value;
	RemoveAllRows('tblDescription');
	createXMLHttpRequest1(4);	
	xmlHttp1[4].onreadystatechange = LoadCusdecDetailsRequest;
	xmlHttp1[4].open("GET",'cusdecxml.php?RequestType=LoadCusdecDetails&deliveryNo=' +deliveryNo ,true);
	xmlHttp1[4].send(null);
	}
}
	
	function LoadCusdecDetailsRequest()
	{
		if(xmlHttp1[4].readyState==4 && xmlHttp1[4].status==200)
		{
			var tblDescription 	= document.getElementById('tblDescription');
			var fob = 0;
			var XMLStyleNo 			= xmlHttp1[4].responseXML.getElementsByTagName('StyleNo');
			var XMLItemCode 		= xmlHttp1[4].responseXML.getElementsByTagName('ItemCode');
			var XMLIntItemNo 		= xmlHttp1[4].responseXML.getElementsByTagName('IntItemNo');
			var XMLCommodityCode 	= xmlHttp1[4].responseXML.getElementsByTagName('CommodityCode');
			var XMLdblQty 			= xmlHttp1[4].responseXML.getElementsByTagName('dblQty');
			var XMLNoOfPackages 	= xmlHttp1[4].responseXML.getElementsByTagName('NoOfPackages');
			var XMLItemPrice 		= xmlHttp1[4].responseXML.getElementsByTagName('ItemPrice');
			var XMLGrossMass 		= xmlHttp1[4].responseXML.getElementsByTagName('GrossMass');
			var XMLNetMass 			= xmlHttp1[4].responseXML.getElementsByTagName('NetMass');
			var XMLProcCode1 		= xmlHttp1[4].responseXML.getElementsByTagName('ProcCode1');
			var XMLProcCode2 		= xmlHttp1[4].responseXML.getElementsByTagName('ProcCode2');
			var XMLItmValue 		= xmlHttp1[4].responseXML.getElementsByTagName('ItmValue');
			var XMLUnit 			= xmlHttp1[4].responseXML.getElementsByTagName('Unit');
			var XMLItemName 		= xmlHttp1[4].responseXML.getElementsByTagName('ItemName');
			var XMLUmoQty1 			= xmlHttp1[4].responseXML.getElementsByTagName('UmoQty1');
			var XMLUmoQty2 			= xmlHttp1[4].responseXML.getElementsByTagName('UmoQty2');
			var XMLUmoQty3 			= xmlHttp1[4].responseXML.getElementsByTagName('UmoQty3');
			
			for(var loop=0;loop<XMLStyleNo.length;loop++)
			{
			var lastRow 		= tblDescription.rows.length;	
			var row 			= tblDescription.insertRow(lastRow);
			
			row.className ="bcgcolor-tblrow";	
			
			var cellDelete = row.insertCell(0); 
			cellDelete.className ="normalfnt";	
			cellDelete.innerHTML = "<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";			
			
			var cellNo = row.insertCell(1);
			cellNo.className ="normalfnt";
			cellNo.innerHTML =XMLIntItemNo[loop].childNodes[0].nodeValue;
			
			var cellDescription = row.insertCell(2);
			cellDescription.className ="normalfntSML";
			cellDescription.id =XMLItemCode[loop].childNodes[0].nodeValue;
			cellDescription.innerHTML =XMLItemName[loop].childNodes[0].nodeValue;
			cellDescription.onclick = changeToStyleTextBox;
			
					
			var cellStyleID = row.insertCell(3);
			cellStyleID.className ="normalfntMid";						
			cellStyleID.innerHTML =XMLUnit[loop].childNodes[0].nodeValue+"<a href=\"#\" title=\"Click here for Unit Conversion..\"><img src=\"../../images/transfer.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"UnitConversionPopup(this);\" border=\"0\"/></a>";
					
			var cellqty = row.insertCell(4);
			cellqty.className ="normalfntRite";			
			cellqty.innerHTML ="<input type=\"text\" name=\"txtQty\" id=\"txtQty\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" value=\""+XMLdblQty[loop].childNodes[0].nodeValue+"\" onkeyup=\"GetUmoQty2(this);\"/></td>";
			
					
			var celPrice = row.insertCell(5);
			celPrice.className ="normalfntRite";
			//celPrice.onclick = changeToStyleTextBox;			
			celPrice.innerHTML ="<input type=\"text\" name=\"txtQty\" id=\"txtQty\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" value=\""+XMLItemPrice[loop].childNodes[0].nodeValue+"\" onkeyup=\"GetSumFobValue(this);\"/></td>";
			
					
			var cellSize = row.insertCell(6);
			cellSize.className ="normalfntRite";			
			cellSize.innerHTML ="<input type=\"text\" name=\"txtQty\" id=\"txtQty\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" value=\""+XMLGrossMass[loop].childNodes[0].nodeValue+"\"/></td>";
			
			var cellUnits = row.insertCell(7);
			cellUnits.className ="normalfntRite";			
			cellUnits.innerHTML ="<input type=\"text\" name=\"txtQty\" id=\"txtQty\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" value=\""+XMLNetMass[loop].childNodes[0].nodeValue+"\" onkeyup=\"GetUmoQty1(this);\"/></td>";
		
			var cellStockQty = row.insertCell(8);
			cellStockQty.className ="normalfntRite";			
			cellStockQty.innerHTML ="<input type=\"text\" name=\"txtQty\" id=\"txtQty\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" value=\""+XMLNoOfPackages[loop].childNodes[0].nodeValue+"\"/></td>";
			
			var cellGrnQty = row.insertCell(9);
			cellGrnQty.className ="normalfntRite";				
			cellGrnQty.innerHTML = "<input type=\"text\" name=\"txtQty\" id=\"txtQty\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" value=\""+XMLProcCode1[loop].childNodes[0].nodeValue+"\" maxlength=\"4\"/></td>";
			
			var cellTxt = row.insertCell(10);				
			cellTxt.className ="normalfntRite";			
			cellTxt.innerHTML =	"<input type=\"text\" name=\"txtQty\" id=\"txtQty\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" value=\""+XMLProcCode2[loop].childNodes[0].nodeValue+"\" maxlength=\"3\"/></td>";
			
			var cellTxt = row.insertCell(11);				
			cellTxt.className ="normalfntRite";	
			cellTxt.innerHTML =	"<input type=\"text\" name=\"txtQty\" id=\"txtQty\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" value=\""+XMLUmoQty1[loop].childNodes[0].nodeValue+"\" maxlength=\"20\"/></td>";
			
			var cellTxt = row.insertCell(12);				
			cellTxt.className ="normalfntRite";	
			cellTxt.innerHTML =	"<input type=\"text\" name=\"txtQty\" id=\"txtQty\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" value=\""+XMLUmoQty2[loop].childNodes[0].nodeValue+"\" maxlength=\"20\"/></td>";
			
			var cellTxt = row.insertCell(13);				
			cellTxt.className ="normalfntSML";	
			cellTxt.innerHTML =	"<input type=\"text\" name=\"txtQty\" id=\"txtQty\" class=\"txtbox\" size=\"10\" style=\"text-align:right\" value=\""+XMLUmoQty3[loop].childNodes[0].nodeValue+"\" maxlength=\"20\"/></td>";
			
			var cellTxt = row.insertCell(14);				
			cellTxt.className ="normalfntRite";	
			cellTxt.innerHTML =	XMLItmValue[loop].childNodes[0].nodeValue;
			
			var cellTxt = row.insertCell(15);				
			cellTxt.className ="normalfntRite";	
			cellTxt.innerHTML =	XMLCommodityCode[loop].childNodes[0].nodeValue;
			
			var celltax = row.insertCell(16); 
			celltax.className ="normalfntMid";	
			celltax.innerHTML = "<img src=\"../../images/aad.png\" alt=\"del\"  id=\"butTax\" onclick=\"OpenItemTaxPopUp(this)\" class=\"mouseover\"/>";
			
			fob += parseFloat(XMLItemPrice[loop].childNodes[0].nodeValue);
			}
			document.getElementById('txtFOB').value = fob;
			document.getElementById('txtInvoAmount').value = fob;
			CulculateCusdecDetailsValueWhenLoading();
		}
	}
	
function GetSumFobValue(obj)
{
	var totlaFob = 0 ;
	var tblDescription 	= document.getElementById('tblDescription');
	for(loop=1;loop<tblDescription.rows.length;loop++)
	{
		 totlaFob += parseFloat(tblDescription.rows[loop].cells[5].childNodes[0].value);
	}
	
	document.getElementById('txtFOB').value = totlaFob;
	document.getElementById('txtInvoAmount').value = totlaFob;
	CulculateCusdecDetailsValue(obj);
}
function CulculateCusdecDetailsValue(obj)
{
	var rw 			= obj.parentNode.parentNode;
	var calValue	= 0;
	var fob			= parseFloat(document.getElementById('txtFOB').value);
	
	if(fob==""){
		//alert("FOB value cannot be Empty or '0'");
		fob	= 0;
		return false;
		}	
		
	var insurence	= parseFloat(document.getElementById('txtInsurance').value);
	var frieght		= parseFloat(document.getElementById('txtFreight').value);
	var other		= parseFloat(document.getElementById('txtOther').value);
	var exRate		= parseFloat(document.getElementById('txtExRate').value);
	var price 		= parseFloat(rw.cells[5].childNodes[0].value);	
	
	 	calValue 	= (insurence + frieght + other)/fob;
		calValue 	= (calValue*price);
		calValue 	= (calValue+price)
		calValue 	= (calValue*exRate)
		calValue 	= (isNaN(calValue) ? 0:calValue);
		rw.cells[14].childNodes[0].nodeValue	= calValue.toFixed(2);
}
function CulculateCusdecDetailsValueWhenLoading()
{
	var price 			= 0;
	var calValue		= 0;
	
	var tblDescription 	= document.getElementById('tblDescription');
	var insurence		= parseFloat(document.getElementById('txtInsurance').value);
	var frieght			= parseFloat(document.getElementById('txtFreight').value);
	var other			= parseFloat(document.getElementById('txtOther').value);
	var exRate			= parseFloat(document.getElementById('txtExRate').value);
	var fob				= parseFloat(document.getElementById('txtFOB').value);
	
	for(loop=1;loop<tblDescription.rows.length;loop++)
	{
		price 		= parseFloat(tblDescription.rows[loop].cells[5].childNodes[0].value);
		calValue 	= (insurence + frieght + other)/fob;
		calValue 	= (calValue*price);
		calValue 	= (calValue+price)
		calValue 	= (calValue*exRate)
		calValue 	= (isNaN(calValue) ? 0:calValue);
		tblDescription.rows[loop].cells[14].childNodes[0].nodeValue= calValue.toFixed(2);
	}
}
function CalculateTax()
{	
	pub_taxValidateCount	= 0;
	var deliveryNo			= document.getElementById("txtDeliveryNo").value;
	var tblDescription 		= document.getElementById('tblDescription');
	var recType 			= document.getElementById('txtDeliveryNo').parentNode.value;
	var fcl					= (document.getElementById('chkFcl').checked == true ? 1:0);
	var noOfContainer		= document.getElementById('txtFcl').value;
	var noRows				= tblDescription.rows.length;
	for(loop=1;loop<tblDescription.rows.length;loop++)
	{
		var value 	= tblDescription.rows[loop].cells[14].childNodes[0].nodeValue;
		var hsCode 	= tblDescription.rows[loop].cells[15].childNodes[0].nodeValue;
		var netMass = tblDescription.rows[loop].cells[7].childNodes[0].value;
		var itemID 	= tblDescription.rows[loop].cells[2].id;
		var umoQty2	= tblDescription.rows[loop].cells[12].childNodes[0].value;
		var umoQty3	= tblDescription.rows[loop].cells[13].childNodes[0].value;
		
		
		createXMLHttpRequest1(loop);
		xmlHttp1[loop].open("GET",'cusdecdb.php?RequestType=CalculateTax&deliveryNo=' +deliveryNo+ '&value=' +value+ '&hsCode=' +hsCode+ '&itemID=' +itemID+ '&recType=' +recType+ '&netMass=' +netMass+ '&fcl=' +fcl+ '&noOfContainer=' +noOfContainer+ '&umoQty2=' +umoQty2+ '&umoQty3=' +umoQty3+ '&noRows=' +noRows ,true);
		xmlHttp1[loop].send(null);
		pub_taxValidateCount ++;
	}
	SaveCalculateTaxValidate();
}
function SaveCalculateTaxValidate()
{	
	var deliveryNo	= document.getElementById('txtDeliveryNo').value;
	var recType 				= document.getElementById('txtDeliveryNo').parentNode.value;
	createXMLHttpRequest1(2);
	xmlHttp1[2].index = deliveryNo;
	xmlHttp1[2].onreadystatechange = SaveCalculateTaxValidateRequest;
	xmlHttp1[2].open("GET",'cusdecxml.php?RequestType=SaveCalculateTaxValidate&deliveryNo=' +deliveryNo+ '&taxValidateCount=' +pub_taxValidateCount+ '&recType=' +recType ,true);
	xmlHttp1[2].send(null);
}
	function SaveCalculateTaxValidateRequest()
	{
		if(xmlHttp1[2].readyState == 4) 
		{
			if(xmlHttp1[2].status == 200)
			{				
				var XMLTaxCountDetails= xmlHttp1[2].responseXML.getElementsByTagName("recTaxCount")[0].childNodes[0].nodeValue;
				
					if(XMLTaxCountDetails=="TRUE")
					{
						SaveDetails();				
						
					}
					else 
					{
						SaveCalculateTaxValidate();											
					}			
			}
		}
	}
function GetUmoQty1(obj)
{
	var rw = obj.parentNode.parentNode;
	
	rw.cells[11].childNodes[0].value = obj.value;
}
function GetUmoQty2(obj)
{
	var rw = obj.parentNode.parentNode;
	
	rw.cells[12].childNodes[0].value = obj.value;
}

//Start - item popup 
function FilterItemDescription()
{
	var popUpItemlike	= document.getElementById('txtPopUpItemlike').value;
	var popUpHslike	= document.getElementById('txtPopUpHslike').value;
	
	xmlHttp1[4].onreadystatechange = FilterItemDescriptionRequest;
	xmlHttp1[4].open("GET",'cusdecxml.php?RequestType=FilterItemDescription&popUpItemlike=' +URLEncode(popUpItemlike)+ '&popUpHslike=' +popUpHslike ,true);
	xmlHttp1[4].send(null);
}
	function FilterItemDescriptionRequest()
	{
		if(xmlHttp1[4].readyState == 4 && xmlHttp1[4].status == 200)
		{
			var tblItemPopUp		= document.getElementById('tblItemPopUp');
			var XMLItemCode 		= xmlHttp1[4].responseXML.getElementsByTagName('ItemCode');
			var XMLDescription 		= xmlHttp1[4].responseXML.getElementsByTagName('Description');
			var XMLCommodityCode 	= xmlHttp1[4].responseXML.getElementsByTagName('CommodityCode');
			var XMLUnit 			= xmlHttp1[4].responseXML.getElementsByTagName('Unit');
			RemoveAllRows('tblItemPopUp');
			document.getElementById('tblItemPopUp').innerHTML="";
			var strText="<table width=\"100%\" border=\"0\" id=\"tblItemPopUp\" cellpadding=\"0\" cellspacing=\"1\" class=\"bcgl1\">"+
			"<tr>"+
			"<td width=\"65%\" height=\"22\" bgcolor=\"#3E81B7\" class=\"normaltxtmidb2\">Item Description </td>"+
			"<td width=\"21%\" bgcolor=\"#3E81B7\" class=\"normaltxtmidb2\">Commodity Code</td>"+
			"<td width=\"14%\" bgcolor=\"#3E81B7\" class=\"normaltxtmidb2\">Unit</td>"+
			"</tr>";
			for(var loop=0;loop<XMLItemCode.length;loop++)
			{
				if(loop % 2 == 0)
					className	= "bcgcolor-tblrowWhite";
				else
					className	= "bcgcolor-tblrow";
				
		 strText +="<tr ondblclick=\"AddToDescription(this);\" class=\""+className+"\" onmouseover=\"this.style.background ='#D6E7F5';\" onmouseout=\"this.style.background='';\">"+
		"<td class=\"normalfnt\" id=\""+XMLItemCode[loop].childNodes[0].nodeValue+"\">"+XMLDescription[loop].childNodes[0].nodeValue+"</td>"+
		"<td class=\"normalfnt\">"+XMLCommodityCode[loop].childNodes[0].nodeValue+"</td>"+
		"<td class=\"normalfnt\">"+XMLUnit[loop].childNodes[0].nodeValue+"</td>"+
		"</tr>";
			}
			strText +="</table>";
			 document.getElementById('divItemPopUp').innerHTML=strText;
		}
	}
//End - item popup

function OpenItemTaxPopUp(obj)
{	
	pub_mainRw = obj.parentNode.parentNode.rowIndex;
	var rw = obj.parentNode.parentNode;
	var matdetailID	= rw.cells[2].id;
	var itenDec		= rw.cells[2].childNodes[0].nodeValue;
	var unitPrice	= rw.cells[5].childNodes[0].value;
	var deliveryNo	= document.getElementById('txtDeliveryNo').value;
	var recType 	= document.getElementById('txtDeliveryNo').parentNode.value;
	
	createXMLHttpRequest1(5);	
	xmlHttp1[5].onreadystatechange=OpenItemTaxPopUpRequest;
	xmlHttp1[5].open("GET",'taxpopup.php?deliveryNo='+deliveryNo+ '&matdetailID=' +matdetailID+ '&recType=' +recType+ '&itenDec=' +itenDec+ '&unitPrice=' +unitPrice ,true);
	xmlHttp1[5].send(null);
}

	function OpenItemTaxPopUpRequest(){
		if (xmlHttp1[5].readyState==4){
			if (xmlHttp1[5].status==200){
				drawPopupArea(580,315,'frmTaxPopUp');				
				var HTMLText=xmlHttp1[5].responseText;
				document.getElementById('frmTaxPopUp').innerHTML=HTMLText;						
			}
		}
	}
function UnitConversionPopup(obj)
{
	pub_mainRw = obj.parentNode.parentNode.parentNode.rowIndex;
	drawPopupArea(354,130,'unitConversionPopUp');
	document.getElementById("unitConversionPopUp").innerHTML =document.getElementById('unitConversion').innerHTML;
	document.getElementById('unitConversion').innerHTML="";	
	document.getElementById('txtFromUnitQty').value = 1;
}
function closePOP()
{
	document.getElementById('unitConversion').innerHTML = document.getElementById("unitConversionPopUp").innerHTML;
	closeWindow();
}

function ConvertCurrency(obj)
{
	var popupFromUnit 	= document.getElementById('cboPopupFromUnit').value;
	var popupToUnit		= document.getElementById('cboPopupToUnit').value;
	var fromUnitQty		= document.getElementById('txtFromUnitQty').value;	

	if(popupFromUnit=="YDS" && popupToUnit=="MTS")
	{		
		var ydsToMts 	= (fromUnitQty * 0.9144)
		document.getElementById('txtToUnitQty').value = ydsToMts.toFixed(2);
	}
	if(popupFromUnit=="MTS" && popupToUnit=="YDS")
	{		
		var ydsToMts 	= (fromUnitQty * 1.09361)
		document.getElementById('txtToUnitQty').value = ydsToMts.toFixed(2);
	}
}
function AddCovertedQty()
{
	var tblDescription 	= document.getElementById('tblDescription');
	tblDescription.rows[pub_mainRw].cells[3].childNodes[0].nodeValue = document.getElementById('cboPopupToUnit').value;
	tblDescription.rows[pub_mainRw].cells[4].childNodes[0].value = document.getElementById('txtToUnitQty').value;
	closePOP();
}

function SaveTaxPoPupDetails(obj)
{
	var tblDescription 	= document.getElementById('tblDescription');
	var deliveryNo		= document.getElementById('txtDeliveryNo').value;
	var recType 		= document.getElementById('txtDeliveryNo').parentNode.value;
	var matdetaiID		= tblDescription.rows[pub_mainRw].cells[2].id ; 
	
	var rw 				= obj.parentNode.parentNode;	
	var taxPosition		= rw.cells[2].childNodes[0].nodeValue;
	var taxType			= rw.cells[3].childNodes[0].nodeValue;
	var taxBase			= rw.cells[4].childNodes[0].value;
	var taxRate			= rw.cells[5].childNodes[0].nodeValue;
	var taxAmount		= rw.cells[6].childNodes[0].value;
	var taxMP			= (rw.cells[7].childNodes[0].checked==true ? 1:0);	
	
	createXMLHttpRequest1(6);		
	xmlHttp1[6].open("GET",'cusdecdb.php?RequestType=SaveTaxPoPupDetails&deliveryNo=' +deliveryNo+ '&recType=' +recType+ '&matdetaiID=' +matdetaiID+ '&taxPosition=' +taxPosition+ '&taxType=' +taxType+ '&taxBase=' +taxBase+ '&taxRate=' +taxRate+ '&taxAmount=' +taxAmount+ '&taxMP=' +taxMP ,true);			
	xmlHttp1[6].send(null);
	alert("Tax :"+taxType+" Updated.");
}

function AddNewTaxRow()
{
			var tblTaxPopUp	= document.getElementById('tblTaxPopUp');
			var maxRow = 0;
			for (var loop =1 ;loop < tblTaxPopUp.rows.length; loop++ ){											
				var rowNo 			= parseFloat(tblTaxPopUp.rows[loop].cells[2].childNodes[0].nodeValue);					
				maxRow = Math.max(maxRow, rowNo); 	
			
			}
			var lastRow 		= tblTaxPopUp.rows.length;	
			var row 			= tblTaxPopUp.insertRow(lastRow);
			
			row.onclick	= rowclickColorChangeIou;
			row.className ="bcgcolor-tblrow";
			
			var cell0 = row.insertCell(0); 
			cell0.className ="normalfntMid";	
			cell0.innerHTML = "<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"RemoveTaxPopUpItem(this);\"/>";			
			
			var cell0 = row.insertCell(1); 
			cell0.className ="normalfntMid";	
			cell0.innerHTML = "<img src=\"../../images/disk.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"SaveTaxPoPupDetails(this);\"/>";
			
			var cell1 = row.insertCell(2);
			cell1.className ="normalfntMid";
			cell1.innerHTML =maxRow+1;
			
			var cell2 = row.insertCell(3);
			cell2.className ="normalfnt";
			cell2.innerHTML ="Not Set";
			cell2.onclick	= changePopUpTaxToStyleTextBox;
			
					
			var cell3 = row.insertCell(4);
			cell3.className ="normalfnt";						
			cell3.innerHTML ="<input type=\"text\" name=\"txtPopupTaxAmount2\" id=\"txtPopupTaxAmount2\" class=\"txtbox\" size=\"17\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" />";
					
			var cell4 = row.insertCell(5);
			cell4.className ="normalfntMid";			
			cell4.innerHTML ="0%";
			cell4.onclick	= changePopUpTaxToStyleTextBox;
			
					
			var cell5 = row.insertCell(6);
			cell5.className ="normalfnt";		
			cell5.innerHTML ="<input type=\"text\" name=\"txtPopupTaxAmount\" id=\"txtPopupTaxAmount\" class=\"txtbox\" size=\"17\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" />";
			
					
			var cell6 = row.insertCell(7);
			cell6.className ="normalfnt";			
			cell6.innerHTML ="<input type=\"checkbox\" name=\"txtMP\" id=\"txtMP\" class=\"txtbox\" size=\"2\" style=\"text-align:center\" onclick=\"SaveMp(this);\"/>";
}

function RemoveTaxPopUpItem(obj){
	if(confirm('Are you sure you want to remove this item?'))
	{
		obj.parentNode.parentNode;

		var td = obj.parentNode;
		var tro = td.parentNode;				
		tro.parentNode.removeChild(tro);			
		DeleteTaxPopUpItem(obj);
	}
}

function DeleteTaxPopUpItem(obj){
	var tblDescription 	= document.getElementById('tblDescription');
	var rw 				= obj.parentNode.parentNode; 
	var deliveryNo		= document.getElementById('txtDeliveryNo').value;
	var recType 		= document.getElementById('txtDeliveryNo').parentNode.value;
	var taxType			= rw.cells[3].childNodes[0].nodeValue;
	var matdetaiID		= tblDescription.rows[pub_mainRw].cells[2].id ; 		
	
	createXMLHttpRequest1(1);
	xmlHttp1[1].open("GET",'cusdecdb.php?RequestType=DeleteTaxPopUpItem&deliveryNo=' +deliveryNo+ '&matdetaiID=' +matdetaiID+ '&recType=' +recType+ '&taxType=' +taxType ,true);
	xmlHttp1[1].send(null);
}
function changePopUpTaxToStyleTextBox(te)
{
var obj ="";
	if ( this instanceof HTMLTableCellElement)
	{
		obj = this;
	}	
	else
	{
		obj = te;
	}
	
	var  currentTxt = obj.innerHTML;
	if ( obj.childNodes[0] instanceof HTMLInputElement)
	{
		return;
	}
	obj.innerHTML = "<input type=\"text\" onkeydown=\"isEnterKey2(event);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" class=\"txtbox\" value =\""+ currentTxt + "\" onblur=\"changeToTableCell2(this);\" size=\"8\" maxlength=\"100\">";
	obj.childNodes[0].focus();
}
function isEnterKey2(evt)
  {
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 if(charCode == 13)
		 document.getElementById('txtNoLines').focus();
  }
  
function changeToTableCell2(obj)
{
	obj.parentNode.innerHTML = obj.value;
}

function SaveMp(obj)
{
	var tblDescription 	= document.getElementById('tblDescription');
	var deliveryNo		= document.getElementById('txtDeliveryNo').value;
	var recType 		= document.getElementById('txtDeliveryNo').parentNode.value;
	var matdetaiID		= tblDescription.rows[pub_mainRw].cells[2].id ; 
	
	var rw 				= obj.parentNode.parentNode;
	var taxType			= rw.cells[3].childNodes[0].nodeValue;
	var taxMP			= (rw.cells[7].childNodes[0].checked==true ? 1:0);	
	
	createXMLHttpRequest1(7);		
	xmlHttp1[7].open("GET",'cusdecdb.php?RequestType=SaveMp&deliveryNo=' +deliveryNo+ '&recType=' +recType+ '&matdetaiID=' +matdetaiID+ '&taxType=' +taxType+ '&taxMP=' +taxMP ,true);			
	xmlHttp1[7].send(null);
}