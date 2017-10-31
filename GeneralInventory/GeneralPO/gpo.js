/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function viewItemHistory(itemObject, event){
    
    var gItemCode = itemObject.id;
    
    SetDivPosition(event, gItemCode)
    
    var sHTML = '';
    
    var url = "generalPo-xml.php?id=ViewItemHis&itemCode="+gItemCode;
    xmlHttp = $.ajax({url:url,async:false});
    
    //alert(xmlHttp.responseText);
    
    var xmlPONo = xmlHttp.responseXML.getElementsByTagName('pono');
    var xmlSupplier = xmlHttp.responseXML.getElementsByTagName('supplier');
    var xmlUOM = xmlHttp.responseXML.getElementsByTagName('UOM');
    var xmlUnitPrice = xmlHttp.responseXML.getElementsByTagName('unitprice');
    var xmlPOQty = xmlHttp.responseXML.getElementsByTagName('poqty');
    var xmlDeliveryLocation = xmlHttp.responseXML.getElementsByTagName('dellocation');

    for(i=0; i<xmlPONo.length; i++){

            var _PONo = xmlPONo[i].childNodes[0].nodeValue;
            var _Supplier = xmlSupplier[i].childNodes[0].nodeValue;
            var _UOM = xmlUOM[i].childNodes[0].nodeValue;
            var _UnitPrice = xmlUnitPrice[i].childNodes[0].nodeValue;
            var _POQty = xmlPOQty[i].childNodes[0].nodeValue;
            var _DeliveryLocation = xmlDeliveryLocation[i].childNodes[0].nodeValue;

            sHTML +="<tr><td class='trformat'>"+_PONo+"</td><td class='trformat'>"+_Supplier+"</td><td class='trformat'>"+_UOM+"</td><td class='trformat normalfntR'>"+_UnitPrice+"&nbsp;</td><td class='trformat normalfntR'>"+_POQty+"&nbsp;</td><td class='trformat'>"+_DeliveryLocation+"</td></tr>";

    }
	
    document.getElementById('tbodyItemView').innerHTML = sHTML;
    
}

function SetDivPosition(event, prmObjId){
    
       
	
	document.getElementById("divPopUp").style.display = 'block';
	//document.getElementById("divPopUp").style.top = "280px";
	document.getElementById("divPopUp").style.top = event.clientY-350+"px";;
	//document.getElementById("divPopUp").style.left = "970px";	
	document.getElementById("divPopUp").style.left = event.clientX-50+"px";	
}

function HideDiv(){

	document.getElementById("divPopUp").style.display = 'none';	
}
