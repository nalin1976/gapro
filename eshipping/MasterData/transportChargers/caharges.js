var xmlHttp = [];

//<script ="../Bank/bank.js">

function createNewXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp[index] = new XMLHttpRequest();
    }
}


function ClearForm()
{

document.getElementById("txtExType").value = "";
document.getElementById("txtExDesc").value = "";
document.getElementById("txtExType").value = "";


}


function doInsert(req,serial)
{		
		var update=req;
		var floor=	document.getElementById("txtFloor").value;
		var  ceiling=	document.getElementById("txtCeiling").value;
		var amount=	document.getElementById("txtAmount").value;
		
		
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=function()
		{
			if(xmlHttp[0].readyState == 4)
				{
			
				alert(xmlHttp[0].responseText);
				setTimeout("location.reload(true);",100);	
				
							
				}
		
		}		
		
		
		xmlHttp[0].open("GET",'chargeseditdb.php?&SERIAL='+ serial + '&REQUEST=' + update +'&FLOOR=' + floor+ '&AMOUNT=' + amount + '&CEILING=' +ceiling ,true);
		xmlHttp[0].send(null);	
}


function saveData(serial)
{
	if(validateForm())
		
	{	
			validatebd(serial);
		
	}	
}


function validateForm()
	{
			
		if(document.getElementById("txtFloor").value =="" )
			{
			alert("Please enter the CBM floor. ");
			document.getElementById("txtFloor").focus();
			return false;
			}
			
		if(document.getElementById("txtCeiling").value =="" )
			{
			alert("Please enter the CBM ceiling.");
			document.getElementById("txtCeiling").focus();
			return false;
			}
			
		if(document.getElementById("txtAmount").value =="" )
			{
			alert("Please enter the Amount.");
			document.getElementById("txtAmount").focus();
			return false;
			}
			
		
				
		else
			{
		
	
			return true;
			}
	}

	
	
function validatebd(serial,no)
{		
	var floor=	document.getElementById("txtFloor").value;
	var  ceiling=	document.getElementById("txtCeiling").value;
	var amount=	document.getElementById("txtAmount").value;
	if (floor)
		{	
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=checkAvailability;
		xmlHttp[0].open("GET",'chargesmiddle.php?request=checkdb&SERIAL='+ serial + '&FLOOR=' +floor+ '&AMOUNT=' + amount + '&CEILING=' +ceiling ,true);
		xmlHttp[0].send(null);
		}
		
	

}


function checkAvailability()
{
	if(xmlHttp[0].readyState == 4) 
	{
        if(xmlHttp[0].status == 200) 
        	{	
				 var res= xmlHttp[0].responseText;
				 if (res=="cant")
				 	{
						alert("Sorry! Record already exist. ")				 	
				 	}
				    
								 	
				else if (res=="insert")
				 	{	
				 		var req="insert";
						doInsert(req);					 	
				 	} 
				 	
				else
				 	{
						var ans=confirm("Record already exist, do you want to Update?");
						if (ans)
						{
							var req="update";
							doInsert(req,res);
						}
						 	
				 	} 
				    	  
				 		
      	}
    }	
}



function deleteData(id)
{
 	{ 
 	if(document.getElementById("txtFloor").value!="")
 		{
			
		var deleted = confirm("Are you sure you want to delete this record?" );
 		
		if (deleted)		
			{
			var request="delete";
			
			createNewXMLHttpRequest(0);
			xmlHttp[0].onreadystatechange=function()
			{
			if(xmlHttp[0].readyState == 4)
				{
				setTimeout("location.reload(true);",100);			
				alert(xmlHttp[0].responseText);	
				}
			}		
				xmlHttp[0].open("GET",'chargeseditdb.php?REQUEST=' + request +  '&SERIAL=' + id , true);
				xmlHttp[0].send(null);	
		}	
			
		
	
		
	}				
}		
 
}

function editlist(serialno,type,desc,amount)
{		
	if(serialno)
	{	
	createNewXMLHttpRequest(0);
			xmlHttp[0].onreadystatechange=function()
			{
			if(xmlHttp[0].readyState == 4)
				{
				drawPopupArea(500,200,'expensewindow');	
				document.getElementById("expensewindow").innerHTML = xmlHttp[0].responseText;
				//alert(xmlHttp[0].responseText);
				document.getElementById("txtFloor").value=type;
				document.getElementById("txtCeiling").value=desc;		
				document.getElementById("txtAmount").value=amount;
					
				}
			}	
	}		
	else
	{
	
	createNewXMLHttpRequest(0);
			xmlHttp[0].onreadystatechange=function()
			{
			if(xmlHttp[0].readyState == 4)
				{
				drawPopupArea(500,200,'expensewindow')	
				document.getElementById("expensewindow").innerHTML = xmlHttp[0].responseText;
				}
			}	
	
	}			
			
				
				xmlHttp[0].open("GET",'popcharges.php?&ID='+ serialno + '&NO=' + amount , true);
						
				xmlHttp[0].send(null);	
	
				
}


/*
function updatetable(exid)
{	
		var tbl = document.getElementById('tblExType');
   		//alert (tbl.rows.length);
   		
   		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
  		var rw = tbl.rows[loop];
  			alert(rw);
		  	var cel=	rw.cells[1].lastChild.nodeValue;	
			alert (cel);		  	
		  	
		/*
      var conPC = rw.cells[6].lastChild.nodeValue;
		var totalQty = parseInt(orderQty,10) * parseFloat(conPC,10);
		var cc = rw.cells[8].lastChild.nodeValue;
		rw.cells[8].lastChild.nodeValue = RoundNumbers(totalQty,4);
		var unitPrice = parseFloat(rw.cells[10].lastChild.nodeValue);
		var price = parseInt(orderQty,10) * parseFloat(conPC,10) * unitPrice;
		rw.cells[13].lastChild.nodeValue = RoundNumbers(price,4);
		var value = parseFloat(conPC) * unitPrice;
		rw.cells[14].lastChild.nodeValue = RoundNumbers(value,4);
	
	}
   	
   
}
*/