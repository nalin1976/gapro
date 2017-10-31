//js
function submitFrom(){
	document.getElementById('frmWip').submit();
}
function loadPos(obj)
{
	if(obj.value.trim()==""){ document.getElementById("wip_cboPoNo").innerHtml="";}
	var comID=document.getElementById(obj.id).value;
	var path  = "wip_xml.php?req=loadPo&comId="+comID;
	htmlobj=$.ajax({url:path,async:false});
	var XMLPoNo=htmlobj.responseXML.getElementsByTagName('poNo');
	var XMLPoDesc=htmlobj.responseXML.getElementsByTagName('poDesc');
	
	document.getElementById("wip_cboPoNo").innerHtml="";
	for(var i=0;i<XMLPoDesc.length;i++)
	{
		var opt = document.createElement("option");
			opt.value = XMLPoNo[i].childNodes[0].nodeValue;
			opt.text = XMLPoDesc[i].childNodes[0].nodeValue;	
			document.getElementById("wip_cboPoNo").options.add(opt);
	}
	

	loadGrid(obj);
}
function edDate(obj)
{
	if(document.getElementById(obj.id).checked==false){
		document.getElementById("wip_toDate").disabled=true;
		document.getElementById("wip_fromDate").disabled=true;
		document.getElementById("wip_toDate").value="";
		document.getElementById("wip_fromDate").value="";
	}
	else{
		document.getElementById("wip_toDate").disabled=false;
		document.getElementById("wip_fromDate").disabled=false;
	}
}

function loadGrid(obj)
{
	ClearForm();
	var comID=document.getElementById(obj.id).value;
	var path  = "wip_xml.php?req=loadGrid&comId="+comID;
	htmlobj=$.ajax({url:path,async:false});
	var XMLComCode=htmlobj.responseXML.getElementsByTagName('strComCode');
	var XMLcName=htmlobj.responseXML.getElementsByTagName('cName');
	var XMLName=htmlobj.responseXML.getElementsByTagName('strName');
	var XMLDivision=htmlobj.responseXML.getElementsByTagName('strDivision');
	var XMLOrderNo=htmlobj.responseXML.getElementsByTagName('strOrderNo');
	var XMLStyleId=htmlobj.responseXML.getElementsByTagName('intStyleId');
	var XMLQty=htmlobj.responseXML.getElementsByTagName('intQty');
	var XMLCutQty=htmlobj.responseXML.getElementsByTagName('intCutQty');
	var XMLColor=htmlobj.responseXML.getElementsByTagName('strColor');
	//XMLCutQty[i].childNodes[0].nodeValue
	for(var i=0;i<XMLComCode.length;i++)
	{
	var tbl=document.getElementById('tblWIPGrid').tBodies[0];
	var rowCount=tbl.rows.length;
    var row = tbl.insertRow(rowCount);
	row.className="bcgcolor-tblrowWhite";
			row.style.cursor="pointer";
			//row.setAttribute();
            var htm = "<td width=\"8\" class=\"normalfnt\" >"+XMLComCode[i].childNodes[0].nodeValue+"</td>";
              htm+="<td width=\"49\" height=\"20\" class=\"normalfnt\" valign=\"bottom\">"+XMLDivision[i].childNodes[0].nodeValue+"</td>";
              htm+="<td width=\"100\" height=\"20\" class=\"normalfnt\" valign=\"bottom\">"+XMLcName[i].childNodes[0].nodeValue+"</td>";
              htm+="<td width=\"55\" class=\"normalfnt\" valign=\"bottom\">"+XMLStyleId[i].childNodes[0].nodeValue+"</td>";
              htm+="<td width=\"99\" class=\"normalfnt\" valign=\"bottom\">"+XMLOrderNo[i].childNodes[0].nodeValue+"</td>";
              htm+="<td width=\"85\" class=\"normalfnt\" valign=\"bottom\">"+XMLColor[i].childNodes[0].nodeValue+"</td>";
              htm+="<td width=\"86\" class=\"normalfnt\" valign=\"bottom\">"+XMLQty[i].childNodes[0].nodeValue+"</td>";
			  htm+="<td width=\"100\" class=\"normalfnt\" valign=\"bottom\"></td>";
              htm+="<td width=\"107\" class=\"normalfnt\" valign=\"bottom\"></td>";
              htm+="<td width=\"157\" class=\"normalfnt\" valign=\"bottom\">";
              	htm+="<table cellpadding=\"0\" cellspacing=\"1\" border=\"0\" bgcolor=\"#F3E8FF\" rules=\"all\" style=\"border:#FFF\">";
             		htm+="<tr bgcolor=\"#498CC2\">";
              			htm+="<td class=\"normalfnt\"></td>";
              			htm+="<td class=\"normalfnt\"></td>";
              			htm+="<td class=\"normalfnt\"></td>";
              		htm+="</tr>";
              	htm+="</table>"
              htm+="</td>";
              htm+="<td width=\"89\" class=\"normalfnt\" valign=\"bottom\"></td>";
              htm+="<td width=\"87\" class=\"normalfnt\" valign=\"bottom\"></td>";
              htm+="<td width=\"108\" class=\"normalfnt\" valign=\"bottom\"></td>";
              htm+="<td width=\"103\" class=\"normalfnt\" valign=\"bottom\"></td>";
              htm+="<td width=\"80\" class=\"normalfnt\" valign=\"bottom\"></td>";
              htm+="<td width=\"97\" class=\"normalfnt\" valign=\"bottom\"></td>";
              htm+="<td width=\"124\" class=\"normalfnt\" valign=\"bottom\"></td>";
              htm+="<td width=\"110\" class=\"normalfnt\" valign=\"bottom\"></td>";
              htm+="<td width=\"83\" class=\"normalfnt\" valign=\"bottom\"></td>";
              htm+="<td width=\"115\" class=\"normalfnt\" valign=\"bottom\"></td>";
              htm+="<td width=\"94\" class=\"normalfnt\" valign=\"bottom\"></td>";
              htm+="<td width=\"108\" class=\"normalfnt\" valign=\"bottom\"></td>";
              htm+="<td width=\"113\" class=\"normalfnt\" valign=\"bottom\"></td>";
              htm+="<td width=\"94\" class=\"normalfnt\" valign=\"bottom\"></td>";
              htm+="<td width=\"361\" class=\"normalfnt\" valign=\"bottom\"><textarea style=\"height:20px;width:auto\" class=\"txtbox\"></textarea></td>";
			row.innerHTML=htm;
	}
}

function calBalance()
{
	
}

function ClearForm()
{
	//document.getElementById('frmWashIssues').reset();
	var tbl=document.getElementById('tblWIPGrid').tBodies[0];
	var rCount = tbl.rows.length;
	for(var loop=0;loop<rCount;loop++)
	{
			tbl.deleteRow(loop);
			rCount--;
			loop--;
	}
}