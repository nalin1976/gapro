// JavaScript Document

function submitPage()
{
	document.forms["frmbom"].submit();
}

function selectAll()
{
	var tbl = document.getElementById('tbliou');
	var chk = document.getElementById('chkAll').checked;
	if(chk)
	{
		for(var x=1;x<tbl.rows.length;x++)
		{
			tbl.rows[x].cells[0].childNodes[0].checked = true;
		}
	}
	else
	{
		for(var x=1;x<tbl.rows.length;x++)
		{
			tbl.rows[x].cells[0].childNodes[0].checked = false;
		}
	}
	
}

function checkClick(obj)
{
	if(!obj.checked)
	{
		document.getElementById('chkAll').checked = false;
	}
}