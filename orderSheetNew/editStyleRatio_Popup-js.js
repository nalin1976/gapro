var ArrayColor="";
var ArraySize ="";
var ArrayQty ="";

//-----------------------------------------------
function loadRatios()
{
	
	var url = "editStyleRatio_Popup-db-get.php?RequestType=loadRatio";
	
	url=url+"&strStyleID="+URLEncode(document.getElementById("cboOrderNo").value);			
	url=url+"&buyerPO="+URLEncode(document.getElementById("cboBuyerPO").value);			
	var httpobj = $.ajax({url:url,async:false});
	
document.getElementById("divStyleRatio").innerHTML=httpobj.responseText;
}
//-------------------------------------------
function compQty(rw,col)
{
var tbl = document.getElementById('tblStyleRatio');


var balExQty =parseFloat(tbl.rows[rw].cells[col].id);
if(tbl.rows[rw].cells[col].childNodes[0].value==''){
tbl.rows[rw].cells[col].childNodes[0].value=0;	
}
var newExQty=parseFloat(tbl.rows[rw].cells[col].childNodes[0].value);

if(newExQty > balExQty){
alert("Cannot exceed the balance ratio Qty");
tbl.rows[rw].cells[col].childNodes[0].value=balExQty;
}

var colSize=tbl.getElementsByTagName('tr')[0].getElementsByTagName('th').length;

		for ( var loop = 1 ;loop < tbl.rows.length-1 ; loop ++ )
		{
			var totRow=0;
			for ( var loop2 = 1 ;loop2 < colSize-1 ; loop2 ++ )
			{
			totRow +=parseFloat(tbl.rows[loop].cells[loop2].childNodes[0].value);
			}
			tbl.rows[loop].cells[colSize-1].innerHTML=totRow
		}

		var totQty=0;
		for ( var loop2 = 1 ;loop2 < colSize-1 ; loop2 ++ )
		{
			var totcol=0;
		for ( var loop = 1 ;loop < tbl.rows.length-1 ; loop ++ )
			{
			totcol +=parseFloat(tbl.rows[loop].cells[loop2].childNodes[0].value);
			totQty +=parseFloat(tbl.rows[loop].cells[loop2].childNodes[0].value);
			}
			tbl.rows[tbl.rows.length-1].cells[loop2].innerHTML=totcol
		}
			tbl.rows[tbl.rows.length-1].cells[colSize-1].innerHTML=totQty
}
//------------------------------------------save-----------------------------------------------------------------
function saveEditedStyleRatio()
{
		var strStyleID=document.getElementById("cboOrderNo").value;
		ArrayColor="";
		ArraySize ="";
		ArrayQty ="";
		var tbl = document.getElementById('tblStyleRatio');
		noOfRows=tbl.rows.length-1;
		var colSize=tbl.getElementsByTagName('tr')[0].getElementsByTagName('th').length;
		
		for ( var loop = 1 ;loop < tbl.rows.length-1 ; loop ++ )
		{
			for ( var loop2 = 1 ;loop2 < colSize-1 ; loop2 ++ )
			{
				var color = tbl.rows[loop].cells[0].innerHTML.trim();
				var size = tbl.rows[0].cells[loop2].innerHTML.trim();
				var qty = tbl.rows[loop].cells[loop2].childNodes[0].value;
	

				if (color.length > 0)
				{
						ArrayColor+= color + ",";
						ArraySize += size + ",";
						ArrayQty += qty + ",";
				 }
			}
		}

		if(tbl.rows[tbl.rows.length-1].cells[colSize-1].innerHTML.trim()==0){
		alert("No quantities to save");
		return false;	
		}
		
	var url = "editStyleRatio_Popup-db-set.php?RequestType=saveEditedStyleRatio";
	
	url=url+"&strStyleID="+URLEncode(document.getElementById("cboOrderNo").value);			
	url=url+"&buyerPO="+URLEncode(document.getElementById("cboBuyerPO").value);	
	url=url+"&ArrayColor="+URLEncode(ArrayColor);	
	url=url+"&ArraySize="+URLEncode(ArraySize);	
	url=url+"&ArrayQty="+URLEncode(ArrayQty);	
	var httpobj = $.ajax({url:url,async:false});
	alert(httpobj.responseText);
	loadRatios();
loadCombo('SELECT distinct intOrderNo, intOrderNo FROM editedStyleRatio where intStyleId='+strStyleID+' and editedStyleRatio.intStatus='+1+' order by intOrderNo DESC','cboRatioOrderNos');
	 
}
//-------------------------------------------------------
function loadOrderNos(){
	document.getElementById('divLoadOrderNos').style.visibility = "visible";
	var strStyleID=document.getElementById("cboOrderNo").value;
	loadCombo('SELECT distinct intOrderNo, intOrderNo FROM editedStyleRatio where intStyleId='+strStyleID+' and editedStyleRatio.intStatus='+1+' order by intOrderNo DESC','cboRatioOrderNos');
}
//------------------------------------------------------
function callClose(){
	document.getElementById('divLoadOrderNos').style.visibility = "hidden";
}
//------------------------------------------------
function loadRatioEditedReport(){
var styleID=URLEncode(document.getElementById("cboOrderNo").value);
var ratioOrderNos=document.getElementById("cboRatioOrderNos").value;
var txtWastageForAll=document.getElementById("txtWastageForAll").value;

document.getElementById('divLoadOrderNos').style.visibility = "hidden";
	if(ratioOrderNos==''){
	alert("Please select a Order No");
	return false;	
	}
	window.open("editStyleRatio_Popup_report.php?styleID="+styleID+"&ratioOrderNos="+ratioOrderNos+"&txtWastageForAll="+txtWastageForAll); 
}
//-------------------------------------------------------
function loadStyleEditionPopup(styleID){
	if(styleID==''){
	alert("Select a Style." );
//	document.getElementById('cboStyleCategory').focus();
	return false;
	}
			var url  = "editStyleRatio_Popup.php?styleID="+styleID;
			htmlobj=$.ajax({url:url,async:false});
			drawPopupAreaLayer(523,440,'frmeditStyleRatio',1);				
			var HTMLText=htmlobj.responseText;
			document.getElementById('frmeditStyleRatio').innerHTML=HTMLText;	
}
//--------------------------------------------------------------------
function CloseWindowStyleRatioPopup(){
	try {
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;		
	}catch(err){        
	}
}
//------------------------------------------

function getStylewiseOrderNoNew()
{
	var stytleName = document.getElementById('cboStyles').value;

	var url="orderSheetXml.php";
					url=url+"?RequestType=getStylewiseOrderNoNew";
					url += '&stytleName='+URLEncode(stytleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboOrderNo').innerHTML =  OrderNo;			
}


function getScNo()
{
	var styleName = document.getElementById('cboStyles').value;
	var url="orderSheetXml.php";
					url=url+"?RequestType=getStyleWiseSCNum";
					url += '&styleName='+URLEncode(styleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("SCNO")[0].childNodes[0].nodeValue;
		document.getElementById('cboSR').innerHTML =  OrderNo;
	
}

function getStyleNo()
{
	var scNo = document.getElementById('cboSR').value;
	document.getElementById('cboOrderNo').value = scNo;
}

function getStyleandSC()
{
 document.getElementById('cboSR').value = document.getElementById('cboOrderNo').value;
}

function cancelOrderSheet(){
    var tdRatioOrderNos = document.getElementById("tdRatioOrderNos").lastChild.nodeValue;	
	var url = "editStyleRatio_Popup-db-set.php?RequestType=cancelOrderSheet";	
	    url = url+"&tdRatioOrderNos="+tdRatioOrderNos;	
					
	var htmlobj=$.ajax({url:url,async:false});
	if(htmlobj.responseText == 1){
	 alert("Canceled successfully");
	 location.reload(true);
	}
}