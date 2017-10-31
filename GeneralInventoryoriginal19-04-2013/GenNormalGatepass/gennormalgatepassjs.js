var pub_No		= 0;
var pub_Year	= 0;
var prevPONo	= 0;
var prevmatID	= 0;

function fix_header(tableName,W,H)
{
	$("#"+tableName).fixedHeader({
	width: W,height: H
	});	
}

function ReloadPage()
{	
	document.frmNGList.submit();	
}

function resetAll()
{
	document.frmNormalGatePass.reset();
	$('#tblNGMain tr:gt(0)').remove();	
}

function ClearForm()
{
	document.frmNGList.reset();
	$('#tblIssueDetails tr:gt(0)').remove();
}

function loadGPONo()							 
{
	var url					='gennorrmalxml.php?Request=LoadGPONo';
	var pub_xml_http_obj	=$.ajax({url:url,async:false});
	var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
	
	$("#txtPoPupPRNo" ).autocomplete({
	source: pub_po_arr
	});
}

function OpenItemPopUp()
{
	showBackGround('divBG',0);
	var url  = "gennormalgatepasspop.php";
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(569,467,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	fix_header('tblPopItem',550,300);
	loadGPONo();
}

function ClosePRPopUp(LayerId)
{
	try
	{
		var box = document.getElementById(LayerId);
		box.parentNode.removeChild(box);
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}	
}

function loadSubCategory()
{	
	var cboMainId = document.getElementById("cboPopMainCat").value;	
	var url = 'gennorrmalxml.php?Request=loadSubCategory&cboMainId='+cboMainId;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById("cboPopSubCat").innerHTML = htmlobj.responseXML.getElementsByTagName('intSubCatNo')[0].childNodes[0].nodeValue;	
}

function LoadPopItems()
{	
	var url  = "gennorrmalxml.php?Request=URLLoadPopItems";
		url += "&MainCat="+document.getElementById('cboPopMainCat').value;
		url += "&SubCat="+document.getElementById('cboPopSubCat').value;
		url += "&ItemDesc="+(document.getElementById('txtDetail').value.trim());
		url += "&PRNo="+(document.getElementById('txtPoPupPRNo').value.trim());
	
	htmlobj=$.ajax({url:url,async:false});
	CreatePopUpItemGrid(htmlobj);
}

function CreatePopUpItemGrid(htmlobj)
{
	del_tbl_pop();
	var XMLItemId 	= htmlobj.responseXML.getElementsByTagName("ItemId");
	var XMLItemDesc = htmlobj.responseXML.getElementsByTagName("ItemDesc");
	var XMLUnit 	= htmlobj.responseXML.getElementsByTagName("Unit");
	var tbl 		= document.getElementById('tblPopItem');

	for(loop=0;loop<XMLItemId.length;loop++)
	{
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className = "bcgcolor-tblrowWhite";
		
		var cell = row.insertCell(0);
		cell.className ="normalfntMid";
		cell.setAttribute('height','20');
		cell.innerHTML = "<input name=\"checkbox\" type=\"checkbox\">";
		
		var cell = row.insertCell(1);
		cell.className ="normalfnt";
		cell.id = XMLItemId[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLItemDesc[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(2);
		cell.className ="normalfnt";
		cell.innerHTML = XMLUnit[loop].childNodes[0].nodeValue;
	}	
}

function del_tbl_pop()
{
	$('#tblPopItem tr:gt(0)').remove()		
}

function CheckAll(obj)
{
	var tblpop = document.getElementById("tblPopItem");
	if(obj.checked)
		var check = true;
	else
		var check = false;
		
	for(loop=1;loop<tblpop.rows.length;loop++)
	{
		tblpop.rows[loop].cells[0].childNodes[0].checked = check;		
	}
}

function addItemToMainTable()
{
	if(validateCheckPop())
	{
		var x=0;
		var txtPRNo = document.getElementById("txtPoPupPRNo").value;
		var tblpop 	= document.getElementById("tblPopItem");
		var tblMain	= document.getElementById('tblNGMain');
		
		
		for (var i = 1; i < tblpop.rows.length; i++ )
		{
			if(tblpop.rows[i].cells[0].childNodes[0].checked == true)
			{
				var url = 'gennorrmalxml.php?Request=loadDetailsMainTbl&txtPRNo='+txtPRNo+'&matId='+tblpop.rows[i].cells[1].id;
				var xml_http_obj	= $.ajax({url:url,async:false});
				var matId			= xml_http_obj.responseXML.getElementsByTagName('intItemSerial')[0].childNodes[0].nodeValue;
				var mitemDes   	    = xml_http_obj.responseXML.getElementsByTagName('strItemDescription')[0].childNodes[0].nodeValue;
				var strunit		    = xml_http_obj.responseXML.getElementsByTagName('strUnit')[0].childNodes[0].nodeValue;
				var qty			    = xml_http_obj.responseXML.getElementsByTagName('dblQty')[0].childNodes[0].nodeValue;

				var booCheck = false;
				for(var j=1;j < tblMain.rows.length; j++ )
				{
						if(tblMain.rows[j].cells[2].id==matId)
						{
							booCheck = true;								
						}						
				}
				if(!booCheck)
					createMainItemGrid(matId,mitemDes,strunit,qty,0,txtPRNo);
				else
					alert("Item no " + i + " already exist.");					
			}
		}
	}
	else
		return false;	
}

function createMainItemGrid(matId,mitemDes,strunit,qty,retunable,PRNo)
{
	var tblpop 			 = document.getElementById("tblPopItem");
	var tblMain 		 = document.getElementById("tblNGMain");		
		
	var lastRow 		 = tblMain.rows.length;
	var row 			 = tblMain.insertRow(lastRow);
	row.className		 = 'bcgcolor-tblrowWhite';
	var cellDelete       = row.insertCell(0); 
	cellDelete.className = "normalfntMid";	
	cellDelete.innerHTML = "<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"removeRow(this);\"/>";
	
	var rowCell 	  	 = row.insertCell(1);
	rowCell.className 	 = "normalfnt";
	rowCell.innerHTML 	 = PRNo;
	
	var rowCell 	  	 = row.insertCell(2);
	rowCell.className 	 = "normalfnt";
	rowCell.id			 = matId;
	rowCell.innerHTML 	  =mitemDes;
	
	var rowCell 	  	 = row.insertCell(3);
	rowCell.className 	 = "normalfntMid";
	rowCell.innerHTML 	 = "<input name=\"txtqty\" id=\"txtqty\" type=\"text\" style=\"width:70px;text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" value=\""+qty+"\" />";
	
	var rowCell 	  	 = row.insertCell(4);
	rowCell.className 	 = "normalfntMid";
	rowCell.innerHTML 	 = document.getElementById('unitbox').innerHTML;
			
	var rowCell 	  	 = row.insertCell(5);
	rowCell.className 	 = "normalfntMid";
	if(retunable==1)
		rowCell.innerHTML 	= "<input type=\"checkbox\" id=\"checkboxgrid\" name=\"checkboxgrid\" checked=\"checked\" /> ";
	else
		rowCell.innerHTML 	= "<input type=\"checkbox\" id=\"checkboxgrid\" name=\"checkboxgrid\" /> ";
		
	row.cells[4].childNodes[0].value=strunit;
}

function removeRow(objDel)
{
	if(confirm('Are you sure you want to remove this item?'))
	{
		var tblMain = objDel.parentNode.parentNode.parentNode;
		var rowNo = objDel.parentNode.parentNode.rowIndex
		tblMain.deleteRow(rowNo);
	}
}

function SaveNormalGatePass()
{
	if(!validateMain())
		return;
	
	var GPNo		= $('#txtGPNo').val();
	var GPto        = $('#txtGatePassTo').val();
	var attention   = $('#txtAttention').val();
	var through     = $('#txtThrough').val();
	var instby      = $('#txtInstructBy').val();
	var remark      = $('#txtRemarks').val();
	var style       = $('#txtStyleNo').val();
	var spintruct   = $('#txtInstructions').val();

	if(GPNo=="")
	{
		LoadNO();
		SaveHeader(GPto,attention,through,instby,remark,style,spintruct);
		SaveDetails(pub_No,pub_Year);
	}
	else
	{
		var noArray = GPNo.split("/");
		pub_No			= noArray[1];
		pub_Year		= noArray[0];	
		SaveHeader(GPto,attention,through,instby,remark,style,spintruct);
		SaveDetails(pub_No,pub_Year);		
	}
	alert(xml_http_obj.responseText);
}

function LoadNO()
{
	var url = 'gennorrmalxml.php?Request=getGPNo';
	var xml_http_obj= $.ajax({url:url,async:false});
	var xml_id		= xml_http_obj.responseXML.getElementsByTagName('ID')[0].childNodes[0].nodeValue;
	var xml_year	= xml_http_obj.responseXML.getElementsByTagName('year')[0].childNodes[0].nodeValue; 
	pub_No			= xml_id;
	pub_Year		= xml_year;	
	document.getElementById("txtGPNo").value = xml_year +  "/"  + xml_id ;
}

function SaveHeader(GPto,attention,through,instby,remark,style,spintruct)
{
	var url='gennorrmalxml.php?Request=save_header&GPto='+URLEncode(GPto)+'&pub_No='+pub_No+'&pub_Year='+pub_Year+'&attention='+URLEncode(attention)+'&through='+URLEncode(through)+'&instby='+URLEncode(instby)+'&remark='+URLEncode(remark)+'&style='+URLEncode(style)+'&spintruct='+URLEncode(spintruct);	
	xml_http_obj = $.ajax({url:url,async:false});	
}

function SaveDetails(pub_No,pub_Year)
{
	var row_source 	= $('#tblNGMain tr');
	for(var loopz=1;loopz<=row_source.length-1;loopz++)
	{
		var strPONo		= row_source[loopz].cells[1].innerHTML;
		var Itemserial	= row_source[loopz].cells[2].id;
		var dblQty		= row_source[loopz].cells[3].childNodes[0].value;
		var dblunit		= row_source[loopz].cells[4].childNodes[0].value;
		var retunable	= (row_source[loopz].cells[5].childNodes[0].checked==true ? 1:0);

		var url='gennorrmalxml.php?Request=save_detail&strPONo='+strPONo+'&Itemserial='+Itemserial+'&dblQty='+dblQty+'&dblunit='+dblunit+'&retunable='+retunable+'&pub_No='+pub_No+'&pub_Year='+pub_Year;
		var xml_http_obj	=$.ajax({url:url,async:false});					
	}		
}

function validateCheckPop()
{
	var row_source 	= $('#tblPopItem tr');
	var check=0;
	for(var loopz=1;loopz<=row_source.length-1;loopz++)
	{
		if(row_source[loopz].cells[0].childNodes[0].checked==true)
		{
			check=1;
			break;
		}			 
	}
	if(check==0)
	{
		alert("Please select an item.");
		return false;
	}
	else
	return true;
}

function validateMain()
{
	var row_source 	= $('#tblNGMain tr')
	var rowCheck=0;
	for(var loopz=1;loopz<=row_source.length-1;loopz++)
	{
		rowCheck=1;
		if(row_source[loopz].cells[3].childNodes[0].value=="")
		{
			alert("Please enter a quantity");
			row_source[loopz].cells[3].childNodes[0].focus();
			return false;
		}
	}
	if(rowCheck==0)
	{
		alert("Please add a items.");
		return false;		
	}
return true;
}

function loadDetails(year,no)
{
	if(no=='0')
		return;
	var url = 'gennorrmalxml.php?Request=LoadHeaderDetails&no=' +no+ '&year=' +year;
	htmlobj = $.ajax({url:url,async:false});
	
	var XMLGatePassNo 	= htmlobj.responseXML.getElementsByTagName("GatePassNo")[0].childNodes[0].nodeValue;
	var XMLRemarks 		= htmlobj.responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;				
	var XMLAttention	= htmlobj.responseXML.getElementsByTagName("Attention")[0].childNodes[0].nodeValue;			
	var XMLThrough 		= htmlobj.responseXML.getElementsByTagName("Through")[0].childNodes[0].nodeValue;
	var XMLToStores 	= htmlobj.responseXML.getElementsByTagName("ToStores")[0].childNodes[0].nodeValue;
	var XMLInstructedBy = htmlobj.responseXML.getElementsByTagName("InstructedBy")[0].childNodes[0].nodeValue;
	var XMLStyleID 		= htmlobj.responseXML.getElementsByTagName("StyleID")[0].childNodes[0].nodeValue;
	var XMLInstructions = htmlobj.responseXML.getElementsByTagName("Instructions")[0].childNodes[0].nodeValue;
	var XMLDate			= htmlobj.responseXML.getElementsByTagName("Date")[0].childNodes[0].nodeValue;
	
	LoadHeaderDetailsRequest(XMLGatePassNo,XMLRemarks,XMLAttention,XMLThrough,XMLToStores,XMLInstructedBy,XMLStyleID,XMLInstructions,XMLDate);
	
	var url = 'gennorrmalxml.php?Request=LoadGatePassDetails&no=' +no+ '&year=' +year;
	htmlobj =$.ajax({url:url,async:false}); 
				
	var XMLMatId 		= htmlobj.responseXML.getElementsByTagName('MatDetailID');
	var XMLUnit		    = htmlobj.responseXML.getElementsByTagName('Unit');
	var XMLQty			= htmlobj.responseXML.getElementsByTagName('Qty');
	var XMLRetunable	= htmlobj.responseXML.getElementsByTagName('Returnable');
	var XMLMitemDes		= htmlobj.responseXML.getElementsByTagName('Description');
	var XMLPRNo			= htmlobj.responseXML.getElementsByTagName('PRNo');
	
	for(var i=0;i<XMLMatId.length;i++)
	{
		
		var matId			= XMLMatId[i].childNodes[0].nodeValue;
		var strunit			= XMLUnit[i].childNodes[0].nodeValue;
		var qty		  	    = XMLQty[i].childNodes[0].nodeValue;
		var retunable       = XMLRetunable[i].childNodes[0].nodeValue;
		var mitemDes		= XMLMitemDes[i].childNodes[0].nodeValue;
		var PRNo			= XMLPRNo[i].childNodes[0].nodeValue;
		
		createMainItemGrid(matId,mitemDes,strunit,qty,retunable,PRNo);
	}	
}

function LoadHeaderDetailsRequest(XMLGatePassNo,XMLRemarks,XMLAttention,XMLThrough,XMLToStores,XMLInstructedBy,XMLStyleID,XMLInstructions,XMLDate)
{	
	document.getElementById("txtGPNo").value 	 	 = XMLGatePassNo;
	document.getElementById("txtRemarks").value		 = XMLRemarks;
	document.getElementById("txtAttention").value 	 = XMLAttention;			
	document.getElementById("txtThrough").value 	 = XMLThrough ;
	document.getElementById("txtGatePassTo").value 	 = XMLToStores ;				
	document.getElementById("txtInstructBy").value 	 = XMLInstructedBy ;
	document.getElementById("txtStyleNo").value 	 = XMLStyleID ;
	document.getElementById("txtInstructions").value = XMLInstructions ;
	document.getElementById("podate").value			 = XMLDate ;
}

function showReport1(No)
{		
	if(No == ""){
		alert("Sorry\nNo 'Normal GatePass No' appear to view.");
		return ;
	}
	newwindow=window.open('gennormalgatepassreport.php?No=' +No,'name');
		if (window.focus) {newwindow.focus()}	
}

function showReport()
{
	var No = document.getElementById('txtGPNo').value;
	
	if(No == ""){
		alert("Sorry\nNo 'General Normal GatePass No' to Save.");
		return ;
	}
	newwindow=window.open('gennormalgatepassreport.php?No=' +No,'name');
		if (window.focus) {newwindow.focus()}	
}