//
var totPlanQty=0;
var tRowLenth=0;
var totMLength=0;
var stripid=0;
var macId=0;
var pub_macCat = 0;
var pub_divId = 0;
var divLotId = 0;

$(document).ready(function()
{ 
$("#mac").bind("contextmenu", function(e) 
{
	if($('#mac').children(0).length > 1)
	{
		menu_rowindex =this.rowIndex;
		$('#grid_menu').css({
			top: e.pageY+'px',
			left: e.pageX+'px'
		}).show();
		return false;
	}
	});
		
	$('#Merge_Lot').click(function()
	{
		mergeLot();		
	});

});
$(document).click(function() {
		$("#grid_menu").hide();
});

function selectStyle(obj)
{
	$("#tblBody").html("");
	var path="washingplan_xml.php?req=getStyle&po="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLStyle=htmlobj.responseXML.getElementsByTagName('Style');
	var XMLQty=htmlobj.responseXML.getElementsByTagName('OQty');
	document.getElementById('plan_cboStyleS').value=XMLStyle[0].childNodes[0].nodeValue;
	document.getElementById('plan_txtOderQty').value=XMLQty[0].childNodes[0].nodeValue;
	getColor(obj);
	
	if(document.getElementById('wasOther_txtAVLQty2').value.trim()!=""){
		setMachines(2,1);
	}
}

function selectPo(obj){
	var path="washingplan_xml.php?req=getPo&style="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var XMLPo=htmlobj.responseXML.getElementsByTagName('PO');
	var XMLQty=htmlobj.responseXML.getElementsByTagName('OQty');
	document.getElementById('plan_cboPOS').value=XMLPo[0].childNodes[0].nodeValue;
	document.getElementById('plan_txtOderQty').value=XMLQty[0].childNodes[0].nodeValue;
	getColor(document.getElementById('plan_cboPOS'));
}

function getColor(obj){
	var path="washingplan_xml.php?req=getColor&po="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	document.getElementById('plan_cboColorS').innerHTML=htmlobj.responseText;
	getRCVDQty(obj.value.trim(),URLEncode(document.getElementById('plan_cboColorS').value.trim()));
}

function getRCVDQty(po,color){
	var path="washingplan_xml.php?req=getRCVDQty&po="+po+"&color="+color;
	htmlobj=$.ajax({url:path,async:false});
	document.getElementById('plan_txtRCVDQty').value=htmlobj.responseText;
}

function selectMachines(obj){
	var path="washingplan_xml.php?req=getMachines&costID="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var xmlMachines	  =	htmlobj.responseXML.getElementsByTagName('Machines');
	var xmlMachineCat = htmlobj.responseXML.getElementsByTagName('MachineCat');
	var xmlHT		  =	htmlobj.responseXML.getElementsByTagName('dblHTime');
	var xmlQty		  = htmlobj.responseXML.getElementsByTagName('dblQty');
	pub_macCat        = xmlMachineCat[0].childNodes[0].nodeValue;
	document.getElementById('txt_scs_planMachine').innerHTML= xmlMachines[0].childNodes[0].nodeValue;
	document.getElementById('txt_scs_ht').value= xmlHT[0].childNodes[0].nodeValue;
	document.getElementById('txt_scs_macCap').value = xmlQty[0].childNodes[0].nodeValue;
	document.getElementById("machineCategory").title = pub_macCat;
	
}

/*function getMachineCapacity(val){
	var path="washingplan_xml.php?req=getMachineCapacity&mID="+val;
	htmlobj=$.ajax({url:path,async:false});
	document.getElementById('txt_scs_macCap').value=htmlobj.responseText;
}
*/
function setTimeLine(obj)
{
	if(obj==undefined)
		return false;
	
	if(obj.value=="")
	{
		$("#timeLineArea").html("");
		return;
	}
		
	$("#timeLineArea").html("");
	var startTime=0;
	if(obj.value==1 || obj.value==2){
		startTime=1;
	}
	else
		startTime=1;
	//var startTime=obj.value.trim().substr(0,5);
	
	var timeH=0;
	
	tRowLenth=1440;
	var cls="border:solid #CCC 1px;width:60px;font-size:10px;background:#66F;color:#FF0;";
	var htmlTimeLine="<table style=\"border:solid #CCC 0px;width:1440px;\" cellspacing=\"0\"><tr style=\"height:20px;\">";
		//First Hour
		htmlTimeLine+="<td style=\""+cls+"\">"+startTime +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//2nd Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)  +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//3rd Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//4th Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//5th Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//6th Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//7th Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//8th Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//9th Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//10 Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//11th Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//24th Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//13th hour
		/*if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		*/
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//11th Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//24th Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//11th Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//24th Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//11th Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//24th Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//11th Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
		//24th Hour
		if(timeH > 24){timeH=(timeH-24);}
		htmlTimeLine+="<td style=\""+cls+"\">"+ timeH+obj.value.trim().substr(2,3)   +"</td>";
		timeH=(parseInt((startTime=parseFloat(startTime)+60/60)));
	
	$("#timeLineArea").append(htmlTimeLine);
	
}


function allocateToLotsDiv(planQty,mCapacity,HTime,m,c){
	var strTotLen=0;
	var mCapacity=mCapacity;
	var restQty=(planQty%mCapacity);
	var noOfMachines=parseInt(planQty/mCapacity);
	
	
		var htmlLotDiv="";
		if(restQty!=0)
			noOfMachines=noOfMachines+1;
			
		if(planQty==mCapacity)
			if(restQty==0)
				noOfMachines=noOfMachines;
				
		
	if(strTotLen < 730){
		for(var i=0;i<noOfMachines;i++){
			if(strTotLen < 733){
				if(i==noOfMachines-1){
					noOfPcs=restQty;
					if(planQty==mCapacity)
						noOfPcs=planQty;
				}
				else{ noOfPcs=mCapacity;}
					
					stripid=stripid+1;
					var wd=(HTime*noOfPcs)-2; 
						strTotLen=strTotLen+wd;
				if(strTotLen < 733){
					var sCls="background:#99F;border:solid #036 1px;width:"+wd+"px;height:15px;float:left;cursor: move; z-index: -1; position: static;";
				htmlLotDiv+="<a href=\"#\" draggable=\"true\" id=\"item"+stripid+m+c+"\" alter=\""+noOfPcs+"\"><div id=\"item"+i+"\" class=\"drag\" style=\""+sCls+"\" alter=\""+noOfPcs +"\" draggable=\"true\"  onMouseOver=\"mOver();\"></div></a>";
				
				planQty=planQty-noOfPcs;
				}
			}
		}
	}
		totPlanQty=planQty;
		return htmlLotDiv;
	
}

/// strip seperation

function openSeparater(obj)
{
	var orderNo=$($(obj).children(0)).children(0)[1].innerHTML;
	var divId=$(obj).children(0);
	var poQty=$(obj).children(0).attr("alter").split('~')[0];
	var exQty=$(obj).children(0).attr("alter").split('~')[1];
	var po=$($(obj).children(0)).attr("id");
	var totQty    = parseInt($($("#"+po).children(0)[7]).text());
	var planedQty = parseInt($($("#"+po).children(0)[10]).text());
	var balQty    = parseInt($($("#"+po).children(0)[13]).text());
	if(isNaN(planedQty))
	{
		planedQty=0;
	}
		
	showBackGround('divBG',0);
	var url  = "stripCreator_SetUp.php";
	htmlobj=$.ajax({url:url,async:false});
	drawPopupAreaLayer(600,200,'frmStripCreator',1);				
	var HTMLText=htmlobj.responseText;
	document.getElementById('frmStripCreator').innerHTML=HTMLText;
	document.getElementById('txt_scs_orderQty').value=poQty ;
	document.getElementById('txt_scs_orderNo').value =orderNo;
	document.getElementById('txt_scs_hdnOrderNo').value=po;
	document.getElementById('txt_scs_ex').value  = Math.ceil(((exQty/100)* poQty)+parseInt(poQty));
	document.getElementById('txtBalanceQty').value = balQty ;
	var path="washingplan_xml.php?req=getCostIds&po="+po.trim();
	htmlObj=$.ajax({url:path,async:false});
	document.getElementById('cbo_scs_costId').innerHTML=htmlObj.responseText;
	document.getElementById("hdnObj").value=poQty;
	document.getElementById("txt_scs_txtDateS").value=document.getElementById("wasOther_txtDateS").value
	document.getElementById('txtPQty').value=planedQty;

}

function checkbalance(obj)
{
	if(obj.value==00)
	{
		document.getElementById('txt_scs_planQty').value = 0;
	}
	var BalQty=document.getElementById('txtBalanceQty').value.trim();
	if(parseInt(obj.value) > parseInt(BalQty))
		obj.value= BalQty;
	
}
function CloseWindow(){
	try
	{
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}
}

function createNewLotPool(mac)
{
	var balQty = 0;
	var lotBalQty = 0;
	var planedQty=0;
	//var strRowlength = 0;
	//var NewstrRowlength = 0;
	var orderNO=document.getElementById("txt_scs_orderNo").value.trim();
	var PONO=document.getElementById('txt_scs_hdnOrderNo').value.trim();
	var costId=document.getElementById('cbo_scs_costId').value.trim();
	var ht=document.getElementById("txt_scs_ht").value.trim();
	var pQty=document.getElementById("txt_scs_planQty").value.trim();
	var mCap=document.getElementById("txt_scs_macCap").value.trim();
	if(pQty=='' || pQty==0)
	{
		alert("Please enter 'Plan Qty'.");
		document.getElementById("txt_scs_planQty").focus();
		return;
	}
	if(costId=="")
	{
		alert("Please select 'Cost Id'.");
		document.getElementById("cbo_scs_costId").focus();
		return;
	}
	if(mac.value=="")
	{
		alert("Please select 'Plan Machine'.");
		mac.focus();
		return;
	}
	var nLots=parseInt(pQty/mCap);
	var exQty=pQty%mCap;
	 
	if(!exQty <= 0){
		nLots++;
	}
		
	var mctr=$("#"+mac.value.trim()+"m").closest("tr");	
	var allocatedLots=$("#"+mctr.children(1)[1].id).children();
	
	if(mac=="")
		return false;
		
	for(var a=0;a<nLots+1;a++)
	{
		if($(mctr.children(0)[1]).attr("alter")=="lot_crt_machineList")
		{
			
			if(pQty>0)
			{
				var strPCs=0;
				if(parseInt(pQty) >= parseInt(mCap) )
				{
					strPCs=mCap;
				}
				else
				{
					strPCs=exQty;
				}
				var idg=$(mctr.children(0)[1]).children().length//Id generatotion
									
				var lotDiv="<a alter=\""+PONO+"|"+orderNO+"\" id=\"lot_"+mac.value+"_"+(idg)+"\" draggable=\"true\" href=\"#\" class=\""+costId+"\" ><div draggable=\"true\" alter=\""+strPCs+"-"+pub_macCat+"\" style=\"border:solid 1px #FF6;background:#99F; width: "+(strPCs*ht)+"px; height: 18px; float: left; cursor: hand; z-index: -1; position: static;text-align:left;font-size:12px;\" class=\"drag\" id=\""+mac.value+"\" onmouseover=\"tooltip.show('"+PONO+"|"+orderNO+","+strPCs+"-"+pub_macCat+",lot_"+mac.value+"_"+(idg)+"','auto',this.parentNode);\" onmouseout=\"tooltip.hide();\" onmouseup=\"tooltip.hide();\" ></div></a>";
				
				var strRowlength = 0;
				var NewstrRowlength = 0;
				for(var i=0;i<idg;i++)
				{
					var len      = $($(mctr.children(0)[1]).children(i)[i]).children(0).css("width").length;
					var lotWidth = $($(mctr.children(0)[1]).children(i)[i]).children(0).css("width").substr(0,len-2);
					strRowlength = strRowlength+parseFloat(lotWidth);
					//alert(strRowlength);
				}
				var NewstrRowlength =strRowlength+parseFloat(strPCs*ht);
				if(parseFloat(NewstrRowlength) < 1420)
				{
					$("#"+mctr.children(1)[1].id).append(lotDiv);
					$($("#"+$(lotDiv).attr('id'))).dblclick(function(){
 						 openLotSeparater($(this))
						 });
					planedQty=planedQty+parseInt(strPCs);
					pQty=pQty-strPCs;
					var poolLength=$("#lot_StripPool").children().length;
			
					for(var p=0;p<poolLength;p++)
					{
						var po=$($("#lot_StripPool").children(p)[p]).attr("id");
							
						if(po.substr(4,po.length)== PONO)
						{
							$($("#"+po).children(0)).css("background","#3F6");						
							$($($("#"+po).children(0)).children(0)[10]).text(planedQty+parseInt(document.getElementById('txtPQty').value.trim()));
							lotBalQty = parseInt(document.getElementById('txtBalanceQty').value);
							 balQty= lotBalQty-planedQty;
							$($($("#"+po).children(0)).children(0)[13]).text(balQty);
							//$($("#"+po).children(0)).children(0)[10].innerHTML=planedQty;
							
						}
						
					}
				}
				else
				{
					break;
				}

				if(pQty <= 0)
					break;
			}
		}
	}
	CloseWindow();
}

function openLotSeparater(obj)
{
	pub_divId = $(obj).children(0).attr('id');
	pub_macCat = $(obj).children(0).attr('alter').split('-')[1];
	var noteCard=$(obj);
	var targetTr=$(obj).parent().parent().children(0)[1].id;
	var lotNo=$(obj).attr('id');
	var costId= $(noteCard).attr('class');
	var po	  = $(noteCard).attr('alter').split('|')[0];
	var Qty=$(obj).children(0).attr('alter').split('-')[0];
	
	showBackGround('divBG',0);
	var url  = "lotSeparator.php?req="+po;
	htmlobj=$.ajax({url:url,async:false});
	drawPopupAreaLayer(400,134,'frmStripCreator',1);				
	var HTMLText=htmlobj.responseText;
	document.getElementById('frmStripCreator').innerHTML=HTMLText;
	document.getElementById('txt_scs_lotQty').value=Qty;
	document.getElementById('txt_scs_txtDate').value=document.getElementById('wasOther_txtDateS').value;
	document.getElementById('txt_scs_costNo').value=costId;
	document.getElementById('txtPQNo').value=po;
	document.getElementById('txtLotNo').value=lotNo;
	document.getElementById('txtTarget').value=targetTr;
	var strWidth=$(noteCard).children(0)[0].style.width;
	var ht=strWidth.substr(0,strWidth.length-2)/Qty;
	document.getElementById('txtHT').value=ht;
	
}

function separateStip()
{
	var tbl = document.getElementById('tblmid');
	var lotQty=document.getElementById('txt_scs_lotQty').value.trim();
	var sepQty=document.getElementById('txt_scs_splitQty').value.trim();
	var po	  =document.getElementById('txtPQNo').value;
	var lotNo =document.getElementById('txtLotNo').value;
	var costId =document.getElementById('txt_scs_costNo').value;
	var tr= document.getElementById('txtTarget').value;
	var noteCard=document.getElementById('txtNoteCard').value;
	var ht=document.getElementById('txtHT').value;
	var orderNo = document.getElementById('txt_scs_orderNo2').value;
	var rem=Array(2);
	if(parseInt(lotQty) <= parseInt(sepQty))
		return false;
	else
		rem[1]=lotQty-sepQty;
		
	rem[0]=sepQty;
	
	for(var i=0;i<2;i++){
		var lNo=lotNo+"_"+i
		var newLot=createNewLots(po,lNo,rem[i],ht,costId,orderNo);		
		$('#'+tr).append(newLot);
		$('#'+$(newLot).attr('id')).dblclick(function(){
 						 openLotSeparater($(this))
						 });
	}
	$('#'+lotNo).remove(noteCard);
	for(var x=0;x<tbl.rows.length;x++)
	{
		var LottblId = tbl.rows[x].cells[1].id;
		var LotTblLen = parseFloat($('#'+LottblId).children(0).length);
		LmachineNo = parseFloat(LottblId.substr(0,1));
		for(var i=0;i<LotTblLen;i++)
		{
			var lotId = $($('#'+LottblId).children(i)[i]).attr('id');
			if(lotId.substr(0,3)!="lot")
			{
				continue;
			}
			$($('#'+LottblId).children(i)[i]).attr('id',"lot_"+LmachineNo+"_"+i)

		}
		
	}
	CloseWindow();
}

function createNewLots(PONO,Lot,strPCs,ht,costId,orderNo){
	var divlen=(strPCs*ht)-1;
	var lotDiv="<a alter=\""+PONO+"|"+orderNo+"\" id=\""+Lot+"\" draggable=\"true\" href=\"#\" class=\""+costId+"\">"+
	"<div draggable=\"true\" alter=\""+strPCs+"-"+pub_macCat+"\" style=\"border:solid 1px #FF6;background:#99F; width: "+divlen+"px; height: 18px; float: left; cursor: hand; z-index: -1; position: static;text-align:left;font-size:12px;\" class=\"drag\" id=\""+pub_divId+"\" onmouseover=\"tooltip.show('"+PONO+"|"+orderNo+","+strPCs+"-"+pub_macCat+","+Lot+"','auto',this.parentNode);\" onmouseout=\"tooltip.hide();\" onmouseup=\"tooltip.hide();\"></div></a>";
	return lotDiv;
}
function mergeLot()
{
	if($('#merge_lot').children(0).length>=1)
	{
		return;
	}
	var pub_divWidth = 0;
	var pub_totQty = 0;
	var PONO = "";
	var id = "";
	var costId = "";
	var divAlter = "";
	var divId = "";
	
	
	var lots = $('#mac').children(0).length;
	macId    = $($('#mac').children(0)[0]).children(0).attr("alter").split('-')[1];
	var url  = 'washingplan_xml.php?req=getMacCapacity&macId='+macId;
	htmlobj  = $.ajax({url:url,async:false});
	var XMLCapacity = htmlobj.responseXML.getElementsByTagName('macCapacity');
	gLotLength=lots;
		for(var a=0;a<lots;a++)
		{
			var node=$('#mac').children(a)[a];
			pub_totQty+=parseFloat($(node).children(0).attr("alter").split('-')[0]);
			if(PONO=="")
			{
				PONO = $(node).attr("alter");
				id = $(node).attr("id");
				costId =  $(node).attr("class");
				divAlter =  $(node).children(0).attr("alter");
				var len = $(node).children(0).css("width").length;
				var divWidth = parseFloat($(node).children(0).css("width").substr(0,len-2));
				pub_divWidth += divWidth;
				divId = $(node).children(0).attr("id");

			}
			else
			{
				PONO += "~"+$(node).attr("alter");
				id += "~"+$(node).attr("id");
				costId += "~"+$(node).attr("class");
				divAlter += "~"+$(node).children(0).attr("alter");
				var len = $(node).children(0).css("width").length;
				var divWidth = parseFloat($(node).children(0).css("width").substr(0,len-2));
				pub_divWidth += divWidth;
				divId += "~"+$(node).children(0).attr("id");
			}
			
		}
		if(XMLCapacity[0].childNodes[0].nodeValue<pub_totQty)
		{
			alert("Merged quantity must equal or less than to machine capacity.");
			return;
		}
		
		for(var i=0;i<lots;i++)
		{
			var lotNo = id.split('~');
			$("#"+lotNo[i]).remove();
		}
		
		var lotDiv="<a alter=\""+PONO+"\" id=\"Mdiv_"+lots+"_"+divLotId+"\" draggable=\"true\" href=\"#\" class=\""+costId+"\" ><div draggable=\"true\" alter=\""+divAlter+"\" style=\"border:solid 1px #FF6;background:#D77E9F; width: "+(pub_divWidth)+"px; height: 18px; float: left; cursor: hand; z-index: -1; position: static;text-align:left;font-size:12px;\" class=\"drag\" id=\""+divId+"/"+"LotM_"+divLotId+"\" onmouseover=\"tooltip.show('"+PONO+","+divAlter+",LotM_"+divLotId+"','auto','');\" onmouseout=\"tooltip.hide();\" onmouseup=\"tooltip.hide();\" ></div></a>";
		$("#merge_lot").append(lotDiv);
		divLotId++;
		
}

//***************************** tool tip **********************************************

var tooltip=function()
{
 var tooltipArry;	
 var tooltipQtyArry;
 var tooltipLotNo;
 var tooltipOrderNo;
 var qty="";
 var orderNo="";
 var notecard = "";
 var id = 'tt';
 var top = 3;
 var left = 3;
 var maxw = 300;
 var speed = 10;
 var timer = 20;
 var endalpha = 95;
 var alpha = 0;
 var tt,t,c,b,h;
 var ie = document.all ? true : false;
 return{
  show:function(v,w,obj)
  {
   if(tt == null){
	 
    tt = document.createElement('div');
    tt.setAttribute('id',id);
    t = document.createElement('div');
    t.setAttribute('id',id + 'top');
    c = document.createElement('div');
    c.setAttribute('id',id + 'cont');
    b = document.createElement('div');
    b.setAttribute('id',id + 'bot');
    tt.appendChild(t);
    tt.appendChild(c);
    tt.appendChild(b);
    document.body.appendChild(tt);
    tt.style.opacity = 0;
    tt.style.filter = 'alpha(opacity=0)';
    document.onmousemove = this.pos;
   }
   
   	tooltipArry = v.split(',');
	tooltipQtyArry = tooltipArry[1].split('~');
	tooltipLotNo = tooltipArry[2].split('/');
	tooltipOrderNo = tooltipArry[0].split('~');
	
	for(var x=0;x<tooltipQtyArry.length;x++)
	{
		if(qty=="")
			qty = "Qty :- "+tooltipQtyArry[x].split('-')[0];
		else
			qty += "  Qty :- "+tooltipQtyArry[x].split('-')[0];
		
	}
	for(var z=0;z<tooltipOrderNo.length;z++)
	{
		if(orderNo=="")
			orderNo = "PO&nbsp; :-"+tooltipOrderNo[z].split('|')[1];
		else
			orderNo += "  PO :- "+tooltipOrderNo[z].split('|')[1];
		
	}
	notecard += "<label>"+orderNo+"</label><br />";
	notecard += "<label>"+qty+"</label><br />";
	if(obj!="")
	{
		notecard += "<label>Lot No :- "+obj.id+"</label><br />";
	}
	else
	{
		if(tooltipLotNo.length>1)
			notecard += "<label>Lot No :- "+tooltipLotNo[1]+"</label><br />";
		else
			notecard += "<label>Lot No :- "+tooltipLotNo[0]+"</label><br />";
	}
		 
   tt.style.display = 'block';
   c.innerHTML = notecard;
   tt.style.width = w ? w + 'px' : 'auto';
   if(!w && ie){
    t.style.display = 'none';
    b.style.display = 'none';
    tt.style.width = tt.offsetWidth;
    t.style.display = 'block';
    b.style.display = 'block';
   }
  if(tt.offsetWidth > maxw){tt.style.width = maxw + 'px'}
  h = parseInt(tt.offsetHeight) + top;
  clearInterval(tt.timer);
  tt.timer = setInterval(function(){tooltip.fade(1)},timer);
  },
  pos:function(e){
   var u = ie ? event.clientY + document.documentElement.scrollTop : e.pageY;
   var l = ie ? event.clientX + document.documentElement.scrollLeft : e.pageX;
   tt.style.top = (u - h) + 'px';
   tt.style.left = (l + left) + 'px';
  },
  fade:function(d){
   var a = alpha;
   if((a != endalpha && d == 1) || (a != 0 && d == -1)){
    var i = speed;
   if(endalpha - a < speed && d == 1){
    i = endalpha - a;
   }else if(alpha < speed && d == -1){
     i = a;
   }
   alpha = a + (i * d);
   tt.style.opacity = alpha * .01;
   tt.style.filter = 'alpha(opacity=' + alpha + ')';
  }else{
    clearInterval(tt.timer);
     if(d == -1){tt.style.display = 'none'}
  }
 },
 hide:function(){
  clearInterval(tt.timer);
  notecard="";
  qty = "";
  orderNo = "";
   tt.timer = setInterval(function(){tooltip.fade(-1)},timer);
  }
 };
}();

