var ArrayColor="";
var ArraySize ="";
var ArrayQty ="";

//-----------------------------------------------
function loadRatios()
{
	
	var url = "editStyleRatio_Popup/editStyleRatio_Popup-db-get.php?RequestType=loadRatio";
	
	url=url+"&strStyleID="+URLEncode(document.getElementById("txtStyle").value);			
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
		var strStyleID=document.getElementById("txtStyle").value;
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
		
	var url = "editStyleRatio_Popup/editStyleRatio_Popup-db-set.php?RequestType=saveEditedStyleRatio";
	
	url=url+"&strStyleID="+URLEncode(document.getElementById("txtStyle").value);			
	url=url+"&buyerPO="+URLEncode(document.getElementById("cboBuyerPO").value);	
	url=url+"&ArrayColor="+URLEncode(ArrayColor);	
	url=url+"&ArraySize="+URLEncode(ArraySize);	
	url=url+"&ArrayQty="+URLEncode(ArrayQty);	
	var httpobj = $.ajax({url:url,async:false});
	alert(httpobj.responseText);
	loadRatios();
	loadCombo('SELECT distinct intOrderNo, intOrderNo FROM editedStyleRatio where intStyleId='+strStyleID+' order by intOrderNo DESC','cboRatioOrderNos');
	 
}
//-------------------------------------------------------
function loadOrderNos(){
	document.getElementById('divLoadOrderNos').style.visibility = "visible";
}
//------------------------------------------------------
function callClose(){
	document.getElementById('divLoadOrderNos').style.visibility = "hidden";
}
//------------------------------------------------
function loadRatioEditedReport(){
var styleID=URLEncode(document.getElementById("txtStyle").value);
var ratioOrderNos=document.getElementById("cboRatioOrderNos").value;
	if(ratioOrderNos==''){
	alert("Please select a Order No");
	return false;	
	}
	window.open("editStyleRatio_Popup/editStyleRatio_Popup_report.php?styleID="+styleID+"&ratioOrderNos="+ratioOrderNos); 
}
//-------------------------------------------------------
function loadStyleEditionPopup(styleID){
	if(styleID==''){
	alert("Select a Style." );
//	document.getElementById('cboStyleCategory').focus();
	return false;
	}
			var url  = "editStyleRatio_Popup/editStyleRatio_Popup.php?styleID="+styleID;
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