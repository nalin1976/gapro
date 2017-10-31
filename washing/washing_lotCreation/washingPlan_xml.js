//js
var divLotId   = 0;
var MergedivId = 0;
var dragStatus = 0;
var divColor   = 0;
var tooltipLotId = 0;

$(document).ready(function() 
{
	var url					= 'washingplanload_xml.php?req=loadPONO';
	var pub_xml_http_obj	= $.ajax({url:url,async:false});
	var pub_po_arr			= pub_xml_http_obj.responseText.split("|");
	
	$( "#txtSearchPONo" ).autocomplete({
			source: pub_po_arr
		});	
	
	var url					= 'washingplanload_xml.php?req=loadColor';
	var pub_http_obj		= $.ajax({url:url,async:false});
	var pub_color_arr		= pub_http_obj.responseText.split("|");
	
	$( "#txtSearchColor" ).autocomplete({
			source: pub_color_arr
		});	

});
	
function loadPlans(obj){
	if(obj.value.trim()=='')
	{
		clearAllLot();
		return false;
	}
	else
	{
		clearAllLot();
		loadPoPool(obj.value.trim());
		loadLots(obj.value.trim());
		
		
	}
}
 
function loadPoPool(val){
	$('#lot_StripPool').text();
	var path="washingplanload_xml.php?req=loadPoPool&planNo="+val;
	htmlobj=$.ajax({url:path,async:false});
	document.getElementById("machineLoading_txtTimeIn").value=htmlobj.responseXML.getElementsByTagName("Shift")[0].childNodes[0].nodeValue;
	document.getElementById("machineLoading_txtTimeIn").onchange();
	document.getElementById("wasOther_txtDateS").value=htmlobj.responseXML.getElementsByTagName("Date")[0].childNodes[0].nodeValue;
	document.getElementById("txtPlanNo").value = val;
	var po       = htmlobj.responseXML.getElementsByTagName("PO");
	var ONo		 = htmlobj.responseXML.getElementsByTagName("ONo"); 
	var planQty  = htmlobj.responseXML.getElementsByTagName("planQty");
	var orderQty = htmlobj.responseXML.getElementsByTagName("OQty");
	var ExPercentage	= htmlobj.responseXML.getElementsByTagName("ExPercentage");
	var PlanedQty	=	htmlobj.responseXML.getElementsByTagName("PlanedQty");
	
	for(i=0;i<po.length;i++){
		var styleId= po[i].childNodes[0].nodeValue;
		var Qty    = orderQty[i].childNodes[0].nodeValue;
		var EXRate = ExPercentage[i].childNodes[0].nodeValue;
		var oNo    = ONo[i].childNodes[0].nodeValue;
		var PQty   = PlanedQty[i].childNodes[0].nodeValue;
		var nCard  = createNoteCard(styleId,Qty,EXRate,oNo,PQty);
		
		$('#lot_StripPool').append(nCard);
		
	}
}

function loadLots(val)
{
	var boolCheck = false;
	var path="washingplanload_xml.php?req=loadLotPool&planNo="+val;
	htmlobj=$.ajax({url:path,async:false});
	
	var po     	   = htmlobj.responseXML.getElementsByTagName("PO");
	var Machine	   = htmlobj.responseXML.getElementsByTagName("Machine"); 
	var COSTID 	   = htmlobj.responseXML.getElementsByTagName("COSTID");
	var LotNo	   = htmlobj.responseXML.getElementsByTagName("LotNo");
	var LotQty 	   = htmlobj.responseXML.getElementsByTagName("LotQty");
	var lotWidth   = htmlobj.responseXML.getElementsByTagName("lotWidth");
	var planStatus = htmlobj.responseXML.getElementsByTagName("PlanStatus");
	
	
	var tbl= document.getElementById('tblmid');
	var tblLength =tbl.rows.length
	for(var a=0;a<tblLength;a++)
	{	
		var macId=tbl.rows[a].cells[1].id;
		for(i=0;i<po.length;i++)
		{
			var Mac    = Machine[i].childNodes[0].nodeValue.split('~')[0]+"mac";
	
			if(macId==Mac)
			{
				
				var styleId = po[i].childNodes[0].nodeValue;
				var checkMerge = styleId.split('~').length;
				var COSTNo  = COSTID[i].childNodes[0].nodeValue;
				var Lot     = LotNo[i].childNodes[0].nodeValue;
				var LQty    = LotQty[i].childNodes[0].nodeValue;
				var LW      = lotWidth[i].childNodes[0].nodeValue;
				var Mac     = Machine[i].childNodes[0].nodeValue;
				var status	= planStatus[i].childNodes[0].nodeValue;
				if(status==1)
					boolCheck = true;
				
				var lot     = createLots(styleId,Lot,LQty,LW,COSTNo,Mac,checkMerge,status);
		
				$('#'+macId).append(lot);
				$('#'+$(lot).attr('id')).dblclick(function()
				{
					if(!boolCheck)
					{
						if(this.id.split('_')[0]!="Mdiv")
						{
							openLotSeparater($(this))
						}
					}
						
				});
				
			}
		}
		if(boolCheck)
			document.getElementById('btnSave').style.display="none";
		else
			document.getElementById('btnSave').style.display="inline";
	}
}

function createNoteCard(styleId,Qty,EXRate,oNo,PQty){
	var color='BCC6E0';
	if(PQty>0){
		color='3F6';
	}
var notecard = "<a alter=\""+styleId+"\" id=\"item"+styleId+"\" draggable=\"true\" href=\"#\" ondblclick=\"openSeparater('#'+this.id);\">";
	notecard += "<div  draggable=\"true\" alter=\""+Qty+"~"+EXRate+"\" ";
	notecard += "style=\"background:#"+color+"; border: 1px solid #639; width: 100px; height: 90px; float: none; cursor: arm; z-index: 10; position: static;text-align:left;font-size:10px;float:left;font-size:10px;\"";
	notecard += "class=\"drag\" id=\""+styleId+"\">";
	notecard += "<label id=\"lblPO\">PO No:-</label>";
	notecard += "<label id=\"lblPONo\">" +oNo+"</label><br />";
	notecard += "<label style=\"display:inline;\" id=\"lblOQty\">Order Qty:-</label>";
	notecard += "<label style=\"display:inline;\" id=\"lblPoQty\">" +Qty+"</label><br />";
	notecard += "<label style=\"display:inline;\" id=\"lblTot\">Total Qty:-</label>";
	notecard += "<label style=\"display:inline;\" id=\"lblTotQty\">"+ Math.ceil((parseInt(Qty)+parseInt(Qty*(EXRate*0.01))))+"</label><br />";
	notecard += "<label style=\"display:inline;\" id=\"lblPlaned\">Planed Qty:-</label>";
	notecard += "<label style=\"display:inline;\" id=\"lblPlanedQty\">"+PQty+"</label><br />";
	notecard += "<label style=\"display:inline;\" id=\"lblBalance\">Balance Qty:-</label>";
	notecard += "<label style=\"display:inline;\" id=\"lblBalanceQty\">" +Math.ceil(parseInt(parseInt(Qty)+parseInt(Qty*(EXRate*0.01)))-parseInt(PQty))+ "</label>";			
	notecard += "</div>";
	notecard += "</a>";
	return notecard;
}

function createLots(styleId,Lot,LQty,LW,COSTNo,Machine,checkMerge,planStatus)
{
	if(checkMerge>1)
	{
		 MergedivId ="/"+Lot;
		 AtagId = "Mdiv_"+checkMerge+"_"+divLotId;
		 tooltipLotId = Machine+MergedivId;
		 if(planStatus==1)
		 {
			 divColor   = "#648E4B";
			 dragStatus = "false";
		 }
		 else
			 divColor   = "#D77E9F";
		
	}
	else
	{
		MergedivId="";
		AtagId = Lot;
		tooltipLotId = AtagId;
		 if(planStatus==1)
		 {
			 divColor   = "#648E4B";
			 dragStatus = "false";
		 }
		 else
			 divColor   = "#99F";
	}
	
	
	var lotDiv="<a alter=\""+styleId+"\" id=\""+AtagId+"\" ondragstart=\"return "+dragStatus+";\" draggable=\""+dragStatus+"\" href=\"#\" class=\""+COSTNo+"\">"+
	"<div alter=\""+LQty+"\" draggable=\""+dragStatus+"\" style=\"border:solid 1px #FF6;background:"+divColor+"; width:"+LW+"px; height: 18px; float: left; cursor: hand; z-index: -1; position: static;text-align:left;font-size:12px;\" class=\"drag\" id=\""+Machine+MergedivId+"\" onmouseover=\"tooltip.show('"+styleId+","+LQty+","+tooltipLotId+"','auto','');\" onmouseout=\"tooltip.hide();\" onmouseup=\"tooltip.hide();\"></div></a>";
	divLotId++;
	return lotDiv;
}
function clearAll()
{
	document.getElementById('frmlotCreation').reset();
	$("#timeLineArea").html("");
	loadCombo("select concat(intPlanYear,'/',intPlanNo) as PLANID,concat(intPlanYear,'/',intPlanNo) as PLANID from was_planheader order by PLANID DESC","cboSearch");
	clearAllLot();
	searchPO();
	
}
function clearAllLot()
{
	
	var node = $('#lot_StripPool').children(0);
	var tbl  = document.getElementById('tblmid');
	if(node.length!=0)
	{
		for(var x=0;x<tbl.rows.length;x++)
		{
			var LottblId = tbl.rows[x].cells[1].id;
			var LotTblLen = $('#'+LottblId).children(0).length;
			for(var z=0;z<LotTblLen;z++)
			{
				var lotId = $('#'+LottblId).children(0).attr('id');
				$("#"+lotId).remove();
			}
			
		}
	}
	$("#lot_StripPool").html("");
}


function searchPO()
{
	showPleaseWait();
	var poNo     = document.getElementById('txtSearchPONo').value;
	var poStatus = document.getElementById('cboSearchPo').value;
	var color 	 = document.getElementById('txtSearchColor').value;

	var url  = "washingplanload_xml.php?req=loadSearchPO&poNo="+poNo+"&poStatus="+poStatus+"&color="+color;
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLstyleId   = htmlobj.responseXML.getElementsByTagName("styleId");
	var XMLQty	   	 = htmlobj.responseXML.getElementsByTagName("Qty"); 
	var XMLTotQty 	 = htmlobj.responseXML.getElementsByTagName("TotQty");
	var XMLOrderNo	 = htmlobj.responseXML.getElementsByTagName("OrderNo");
	var XMLplanedQty = htmlobj.responseXML.getElementsByTagName("planedQty");
	var XMLEXRate	 = htmlobj.responseXML.getElementsByTagName("EXRate");
	if(XMLstyleId.length==0 && poStatus!=2)
	{	
		alert("Invalid PO No.");
		document.getElementById("txtSearchPONo").focus();
		hidePleaseWait();
		return;
	}
	else if(XMLstyleId.length==0 && poStatus==2)
	{
		alert("Invalid Color.");
		document.getElementById("txtSearchColor").focus();
		hidePleaseWait();
		return;
	}
	$("#lot_crt_poList").html("");
	for(var i=0;i<XMLstyleId.length;i++)
	{
		styleId 	= XMLstyleId[i].childNodes[0].nodeValue;
		Qty 		= XMLQty[i].childNodes[0].nodeValue;
		TotQty	 	= XMLTotQty[i].childNodes[0].nodeValue;
		OrderNo 	= XMLOrderNo[i].childNodes[0].nodeValue;
		planedQty 	= XMLplanedQty[i].childNodes[0].nodeValue;
		EXRate		= XMLEXRate[i].childNodes[0].nodeValue;
		
		var NewPOList = createPOList(styleId,Qty,TotQty,OrderNo,planedQty,EXRate);
		$('#lot_crt_poList').append(NewPOList);
	}
	hidePleaseWait();
}
function createPOList(styleId,Qty,TotQty,OrderNo,planedQty,EXRate)
{
	var color = 0;
	var balQty = 0;
	
	if(planedQty=="")
	{
		color  = "#EDABE8";
		balQty =  TotQty;
	}
	else
	{
		color = "#3F6";
		balQty =  parseFloat(TotQty)-parseFloat(planedQty);
	}
		
	var notecard = "<a alter=\""+styleId+"\" id=\"item"+styleId+"\" draggable=\"true\" href=\"#\">";
	notecard += "<div  draggable=\"true\" alter=\""+Qty+"~"+EXRate+"\" ";
	notecard += "style=\"background:"+color+";border: 1px solid #639; width: 160px; height: 25px; float: none; cursor: arm; z-index: -1; position: static;text-align:left;font-size:10px;\"";
	notecard += "class=\"drag\" id=\""+styleId+"\">";
	notecard += "<label id=\"lblPO\">PO No:-</label>";
	notecard += "<label id=\"lblPONo\">" +OrderNo+"</label><br />";
	notecard += "<label style=\"display:none;\" id=\"lblOQty\">Order Qty:-</label>";
	notecard += "<label style=\"display:none;\" id=\"lblPoQty\">" +Qty+"</label><br />";
	notecard += "<label style=\"display:none;\" id=\"lblTot\">Total Qty:-</label>";
	notecard += "<label style=\"display:none;\" id=\"lblTotQty\">"+TotQty+"</label><br />";
	notecard += "<label style=\"display:none;\" id=\"lblPlaned\">Planed Qty:-</label>";
	notecard += "<label style=\"display:none;\" id=\"lblPlanedQty\">0</label><br />";
	notecard += "<label style=\"display:none;\" id=\"lblBalance\">Balance Qty:-</label>";
	notecard += "<label style=\"display:none;\" id=\"lblBalanceQty\">" +balQty+ "</label>";			
	notecard += "</div>";
	notecard += "</a>";
	return notecard;
}
function searchPOList(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if(charCode==13)
	{
		searchPO();	
		
	}
}
function searchBy(obj)
{
	if(obj.value==2)
	{
		$("#divPONOSearch").hide(500);
		$("#divColorSearch").show(1000);
		document.getElementById('txtSearchPONo').value="";
	}
	else
	{
		$("#divPONOSearch").show(1000);
		$("#divColorSearch").hide(500);
		document.getElementById('txtSearchColor').value="";
	}
}