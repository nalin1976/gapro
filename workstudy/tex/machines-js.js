

function saveTex()
{ 
	 if(trim(document.getElementById('txtDescription').value)=="")
			{
				alert("Please enter \"Description\".");
				document.getElementById('txtDescription').focus();
				return ;				
			}
	
	 else if(!ValidateSave())
		{
			return;
		}
	 else
		{
		
		var url = "tex-db-set.php?type=save";
			
		url=url+"&cboSearch="+URLEncode(document.getElementById('cboSearch').value);			
		url=url+"&txtId="+URLEncode(document.getElementById('txtID').value);
		url=url+"&txtDescription="+URLEncode(document.getElementById('txtDescription').value);	
		
		var httpobj = $.ajax({url:url,async:false});
					  
		alert(httpobj.responseText);
		ClearForm();
		
		 }		
			
 } 
 

function deleteTex()
{
	    if(document.getElementById('cboSearch').value=="")		    
			alert("Please select \"Search\".");
		    
		else
		    {
				var Search =document.getElementById('cboSearch').options[document.getElementById('cboSearch').selectedIndex].text;
				var r=confirm("Are you sure you want to delete \'"+Search+"\'?");
			if(r==true)		
				DeleteData();
				ClearForm();
			}
}
 
function DeleteData()
{
	var url = "tex-db-set.php?type=delete&cboSearch="+document.getElementById("cboSearch").value;
	var httpobj = $.ajax({url:url,async:false});
	alert(httpobj.responseText);
	ClearForm();			
} 


function ClearForm()
{	
	document.getElementById('txtDescription').value = "";
	loadCombo('SELECT intID ,strDescription FROM ws_tex ORDER BY strDescription ASC ','cboSearch');
	document.getElementById('txtDescription').focus();
	
}
	
	 
function loadDetails(obj)
{	
	if(obj.value.trim()=="")
	   {
		return false;
	   } 
	   var url="tex-db-get.php?type=loadtex&intID="+obj.value;
	
	   var httpobj = $.ajax({url:url,async:false});
	   var xmlObj = httpobj.responseXML;
	 
	   var XMLID=xmlObj.getElementsByTagName('ID');
	   var XMLDescription=xmlObj.getElementsByTagName('Description');
	
	   document.getElementById('txtID').value=XMLID[0].childNodes[0].nodeValue;
	   document.getElementById('txtDescription').value=XMLDescription[0].childNodes[0].nodeValue;
		
}
	  

function ValidateSave()
 {	
	var cboSearch=document.getElementById('cboSearch').value;
	//var intId=document.getElementById('txtID').value;	
	var description=document.getElementById('txtDescription').value;	
	var x_find=checkInField('ws_tex','strDescription',description,'intID',cboSearch);
	
	if(x_find)
	    {  
			alert('Description "'+description+'" is already exist.');	
			document.getElementById('txtID').focus();
			return false;
	    }
       return true;	
 }