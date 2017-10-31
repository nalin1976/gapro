var xmlHttp;
var xmlHttp1=[];
var pub_intxmlHttp_count=0;

var pub_matNo = 0;
var pub_printWindowNo=0;
function createXMLHttpRequest() 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}
function createXMLHttpRequest1(index) 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp1[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp1[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp1[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}

function ShowItems()
{

	drawPopupBox(550,478,'frmMaterial',1);
	var HTMLText =  " <table width=\"500\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
					"  <tr>"+
					"	<td>&nbsp;</td>"+
					" 	</tr>"+
					"	<tr>"+
					"	<td><table width=\"100%\" border=\"0\">"+
					"	  <tr>"+
					"		<td width=\"22%\" height=\"233\">&nbsp;</td>"+
					"		<td width=\"55%\"><form>"+
					"		  <table width=\"75%\" border=\"0\">"+
					"			<tr>"+
					"			  <td height=\"16\" bgcolor=\"#498CC2\" class=\"TitleN2white\">Add Material</td>"+
					"			</tr>"+
					"			<tr >"+
					"			  <td height=\"7\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
					"				<tr>"+
					"				  <td width=\"12%\" height=\"25\">&nbsp;</td>"+
					"				  <td width=\"26%\" class=\"normalfnt\">Category</td>"+
					"				  <td width=\"50%\"><select name=\"cboMainCategory\" class=\"txtbox\" id=\"cboMainCategory\" style=\"width:255px\" onchange=\"loadSubCategory();\">"+
					"				  </select>"+
					"				  </td>"+
					"				  <td width=\"12%\">&nbsp;</td>"+
					"				</tr>"+
					"				<tr>"+
					"				  <td height=\"25\">&nbsp;</td>"+
					"				  <td class=\"normalfnt\">Material</td>"+
					"				  <td><select name=\"cboSubCategory\" class=\"txtbox\" id=\"cboSubCategory\" style=\"width:255px\" onchange=\"loadMaterial();\">"+
					"				  </select></td>"+
					"				  <td>&nbsp;</td>"+
					"				</tr>"+
					"				<tr>"+
					"				  <td height=\"25\">&nbsp;</td>"+
					"				  <td class=\"normalfnt\">Mat Detail Like</td>"+
					"				  <td><input name=\"txtDetailsLike\" type=\"text\"  class=\"txtbox\" id=\"txtDetailsLike\" size=\"40\" onkeyup=\"textChange(this.value);\" /></td>"+
					"				  <td>&nbsp;</td>"+
					"				</tr>"+
					"			  </table></td>"+
					"			</tr>"+
					"			<tr >"+
					"			  <td height=\"8\" bgcolor=\"#80AED5\" class=\"normaltxtmidb2L\">Select Items</td>"+
					"			</tr>"+
					"			<tr>"+
					"			  <td height=\"74\"><table width=\"100%\" height=\"141\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
					"				  <tr class=\"bcgl1\">"+
					"					<td width=\"100%\" height=\"141\"><table width=\"93%\" height=\"250\" border=\"0\" class=\"bcgl1\">"+
					"						<tr>"+
					"						  <td colspan=\"3\"><div id=\"divcons\" style=\"overflow:scroll; height:250px; width:500px;\">"+
					"							  <table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblMaterial\">"+
					"								<tr>"+
					"								  <td width=\"54\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Add</td>"+
					/*"								  <td width=\"0\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"  style=\"visibility:hidden\">Ratio</td>"+*/
					"								  <td width=\"410\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Detail</td>"+
					"								  </tr>"+
					"							  </table>"+
					"						  </div></td>"+
					"						</tr>"+
					"					</table></td>"+
					"				  </tr>"+
					"			  </table></td>"+
					"			</tr>"+
					"			<tr>"+
					"			  <td height=\"32\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
					"				<tr bgcolor=\"#D6E7F5\">"+
					"				  <td width=\"28%\">&nbsp;</td>"+
					"				  <td width=\"18%\"><img src=\"../../images/ok.png\" alt=\"ok\" width=\"86\" height=\"24\" onclick=\"addItemToMainTable();\" /></td>"+
					"				  <td width=\"6%\">&nbsp;</td>"+
					"				  <td width=\"20%\"><img src=\"../../images/close.png\" width=\"97\" height=\"24\" onclick=\"closePopupBox(1);\"/></td>"+
					"				  <td width=\"28%\">&nbsp;</td>"+
					"				</tr>"+
					"			  </table></td>"+
					"			</tr>"+
					"		  </table>"+
					"		</form></td>"+
					"		<td width=\"23%\">&nbsp;</td>"+
					"	  </tr>"+
					"	</table></td>"+
					" </tr>"+
					"  <tr>"+
					"	<td>&nbsp;</td>"+
					"  </tr>"+
					"</table>";

	var frame = document.createElement("div");
    frame.id = "materialSelectedWindow";
	document.getElementById('frmMaterial').innerHTML=HTMLText;
	loadItems();
}

///////////////////// FOR LOADGIN ITEMS //////////////////////////////
	function loadItems()
	{
			loadMainCategory();
	}

	function loadMainCategory()
	{
		createXMLHttpRequest1(0);
		xmlHttp1[0].onreadystatechange = loadMainCategoryRequest;
		xmlHttp1[0].open("GET", 'generalPo-xml.php?id=loadMainCategory', true);
		xmlHttp1[0].send(null); 
	}
	
	function loadMainCategoryRequest()
	{
	if(xmlHttp1[0].readyState == 4 && xmlHttp1[0].status == 200 ) 
		{
			var XMLintID = xmlHttp1[0].responseXML.getElementsByTagName("intID");
			var XMLstrDescription = xmlHttp1[0].responseXML.getElementsByTagName("strDescription");
			
			 for ( var loop = 0; loop < XMLintID.length; loop++)
			 {
				var opt = document.createElement("option");
				opt.text =XMLstrDescription[loop].childNodes[0].nodeValue ;
				opt.value = XMLintID[loop].childNodes[0].nodeValue;
				document.getElementById("cboMainCategory").options.add(opt);
			 }
			 loadSubCategory();
		}
	}
	
	function loadSubCategory()
	{	
		clearCombo('cboSubCategory');
		var mainCatId = document.getElementById("cboMainCategory").value;
		createXMLHttpRequest1(1);
		xmlHttp1[1].onreadystatechange = loadSubCategoryRequest;
		xmlHttp1[1].open("GET", 'generalPo-xml.php?id=loadSubCategory&mainCatId='+mainCatId, true);
		xmlHttp1[1].send(null); 
	}
	
	function loadSubCategoryRequest()
	{
		if(xmlHttp1[1].readyState == 4 && xmlHttp1[1].status == 200 ) 
		{
			var XMLid = xmlHttp1[1].responseXML.getElementsByTagName("intSubCatNo");
			var XMLname = xmlHttp1[1].responseXML.getElementsByTagName("StrCatName");
			
			 for ( var loop = 0; loop < XMLid.length; loop++)
			 {
				var opt = document.createElement("option");
				opt.value = XMLid[loop].childNodes[0].nodeValue;
				opt.text =XMLname[loop].childNodes[0].nodeValue ;
				document.getElementById("cboSubCategory").options.add(opt);
			 }
			 loadMaterial();
		}
	}
	
	function clearCombo(name)
	{
		var index = document.getElementById(name).options.length;
		while(document.getElementById(name).options.length > 0) 
		{
			index --;
			document.getElementById(name).options[index] = null;
		}
	}
	
	function loadMaterial()
	{
		var mainCatId = document.getElementById("cboMainCategory").value;
		var subCatId = document.getElementById("cboSubCategory").value;
		var txtDetailsLike = document.getElementById("txtDetailsLike").value;
		createXMLHttpRequest1(2);
		xmlHttp1[2].onreadystatechange = loadMaterialRequest;
		xmlHttp1[2].open("GET", 'generalPo-xml.php?id=loadMaterial&mainCatId='+mainCatId+'&subCatId='+subCatId+'&txtDetailsLike='+txtDetailsLike, true);
		xmlHttp1[2].send(null); 
		
	}
	
	function loadMaterialRequest()
	{
		if(xmlHttp1[2].readyState == 4 && xmlHttp1[2].status == 200 ) 
		{
			var XMLid = xmlHttp1[2].responseXML.getElementsByTagName("intItemSerial");
			var XMLname = xmlHttp1[2].responseXML.getElementsByTagName("strItemDescription");
			var XMLUnit = xmlHttp1[2].responseXML.getElementsByTagName("strUnit");
			//alert(XMLid.length);
			var tblMaterial = document.getElementById("tblMaterial");
			
			var selection = "";				
			selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"checkitem(this)\"/>";
			
			var tableText = "<tr>"+
									"		<td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Add</td>"+
									/*"		<td width=\"0%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" style=\"visibility:hidden\">Ratio</td>"+*/
									"		<td width=\"74%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Detail</td>"+
									"		<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Material Id</td>"+
									"		<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Unit</td>"+
									"		</tr>"+
									"		<tr>";
			
		 for ( var loop = 0; loop < XMLid.length; loop++)
		 {
			/*tableText +="<tr>"+
			"	<td class=\"normalfnt\" ><div align=\"center\">"+
			"	</div></td>"+
			"	<td class=\"normalfnt\" style=\"visibility:hidden\"><div align=\"center\">"+
			"   <img  src=\"../../images/ratio.png\" alt=\"login\"  class=\"noborderforlink\" onclick=\"ShowBulkPurchaseRatio(this);\" /></a>"+
			"	</div></td>"+
			"	<td class=\"normalfnt\">"+XMLname[loop].childNodes[0].nodeValue+"</td>"+
			"	<td class=\"normalfnt\">"+XMLid[loop].childNodes[0].nodeValue+"</td>"+
			"	<td class=\"normalfnt\">"+XMLUnit[loop].childNodes[0].nodeValue+"</td>"+
			"	</tr>";*/
			tableText +="<tr>"+
			"	<td class=\"normalfnt\" ><div align=\"center\">"+ selection + "</div></td>"+
			"	<td class=\"normalfnt\">"+XMLname[loop].childNodes[0].nodeValue+"</td>"+
			"	<td class=\"normalfnt\">"+XMLid[loop].childNodes[0].nodeValue+"</td>"+
			"	<td class=\"normalfnt\">"+XMLUnit[loop].childNodes[0].nodeValue+"</td>"+
			"	</tr>";
		}
		tblMaterial.innerHTML = tableText;
		}
	}
	function textChange(text)
	{
		loadMaterial();
	}
	
	function ShowBulkPurchaseRatio(objRatio)
	{
		pub_matNo = objRatio.parentNode.parentNode.parentNode.rowIndex;
		showBulkPurchaseRatioWindow();
	}
	function showBulkPurchaseRatioWindow()
	{
			drawPopupBox(550,550,'frmColorSize',2);
			var HTMLText = "<table width=\"500\" border=\"0\" align=\"center\">"+
			"		  <tr>"+
			"			<td>&nbsp;</td>"+
			"		  </tr>"+
			"		  <tr>"+
			"			<td><table width=\"100%\" border=\"0\">"+
			"			  <tr>"+
			"				<td width=\"8%\">&nbsp;</td>"+
			"				<td width=\"90%\"><table width=\"500\" border=\"0\" align=\"center\">"+
			"				  <tr>"+
			"					<td width=\"486\" height=\"24\" bgcolor=\"#498CC2\" class=\"TitleN2white\"><table width=\"100%\" border=\"0\">"+
			"						<tr>"+
			"						  <td width=\"94%\">Bulk Purchase Ratio</td>"+
			"						  <td width=\"6%\">&nbsp;</td>"+
			"						</tr>"+
			"					</table></td>"+
			"				  </tr>"+
			"				  <tr>"+
			"					<td height=\"135\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
			"						<tr>"+
			"						  <td height=\"20\" bgcolor=\"#80AED5\" class=\"normaltxtmidb2L\">Colors</td>"+
			"						  <td height=\"20\" bgcolor=\"#80AED5\" class=\"normaltxtmidb2L\">&nbsp;</td>"+
			"						  <td height=\"20\" bgcolor=\"#80AED5\" class=\"normaltxtmidb2L\">Selected Colors</td>"+
			"						</tr>		"+
			"						<tr>"+
			"						  <td width=\"46%\" height=\"141\" valign=\"top\"><select name=\"cbocolors\" size=\"10\" class=\"txtbox\" id=\"cbocolors\" style=\"width:225px\" ondblclick=\"MoveColorRight();\">"+
			//there is for colors
			"						  </select></td>"+
			"						  <td width=\"8%\"><table width=\"100%\" border=\"0\">"+
			"					<tr>" +
								"<td><div align=\"center\"><img src=\"../../images/bw.png\" alt=\"&gt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveColorRight();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"../../images/fw.png\" alt=\"&lt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveColorLeft();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"../../images/ff.png\" alt=\"&gt;&gt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveAllColorsLeft();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"../../images/fb.png\" alt=\"&lt;&lt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveAllColorsRight();\" /></div></td>" +
							  "</tr>" +
			"						  </table></td>"+
			"				<td width=\"46%\" valign=\"top\"><select name=\"cboselectedcolors\" size=\"10\" class=\"txtbox\" id=\"cboselectedcolors\" style=\"width:225px\" ondblclick=\"MoveColorLeft();\">"+

			"						  </select></td>"+
			"						</tr>"+
			"						<tr>"+
			"						  <td height=\"8\" colspan=\"3\" class=\"specialFnt1\"><table width=\"100%\" border=\"0\" class=\"bcgl2Lbl\">"+
			"							<tr>"+
			"							  <td width=\"118\" bgcolor=\"#80AED5\" class=\"normaltxtmidb2\">Add New Color</td>"+
			"							  <td width=\"80\" class=\"normalfnt\">Color Name</td>"+
			"							  <td width=\"147\"><input name=\"txtColor\" type=\"text\" class=\"txtbox\" id=\"txtColor\" size=\"20\" /></td>"+
			"							  <td width=\"129\" bgcolor=\"#D6E7F5\"><div align=\"center\"><img src=\"../images/addsmall.png\" alt=\"add\" width=\"95\" height=\"24\" /></div></td>"+
			"							  </tr>"+
			"						  </table></td>"+
			"						</tr>"+
			"						<tr>"+
			"						  <td height=\"15\" colspan=\"3\" class=\"specialFnt1\"></td>"+
			"						</tr>"+
			"						<tr>"+
			"						  <td height=\"11\" colspan=\"3\" class=\"normaltxtmidb2L\">&nbsp;</td>"+
			"						</tr>"+
			"					</table></td>"+
			"				  </tr>"+
			"				  <tr>"+
			"					<td height=\"136\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
			"					  <tr>"+
			"						<td height=\"20\" bgcolor=\"#80AED5\" class=\"normaltxtmidb2L\">Sizes</td>"+
			"						<td height=\"20\" bgcolor=\"#80AED5\" class=\"normaltxtmidb2L\">&nbsp;</td>"+
			"						<td height=\"20\" bgcolor=\"#80AED5\" class=\"normaltxtmidb2L\">Selected Sizes</td>"+
			"					  </tr>"+
			"					  <tr>"+
			"						<td width=\"46%\" height=\"141\" valign=\"top\"><select name=\"cbosizes\" size=\"10\" class=\"txtbox\" id=\"cbosizes\" style=\"width:225px\" ondblclick=\"MoveSizeRight();\">"+
//			there is for sizes
			"						</select></td>"+
			"						<td width=\"8%\"><table width=\"100%\" border=\"0\">"+
			"					<tr>" +
								"<td><div align=\"center\"><img src=\"../../images/bw.png\" alt=\"&gt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveSizeRight();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"../../images/fw.png\" alt=\"&lt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveSizeLeft();\" /></div></td>" +
							  "</tr>" + 
							  "<tr>" +
								"<td><div align=\"center\"></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"../../images/ff.png\" alt=\"&gt;&gt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveAllSizesLeft();\" /></div></td>" +
							  "</tr>" +
							  "<tr>" +
								"<td><div align=\"center\"><img src=\"../../images/fb.png\" alt=\"&lt;&lt;\" width=\"18\" height=\"19\" class=\"mouseover\" onClick=\"MoveAllSizesRight();\" /></div></td>" +
							  "</tr>" +
			"						</table></td>"+
			"						<td width=\"46%\" valign=\"top\"><select name=\"cboselectedsizes\" size=\"10\" class=\"txtbox\" id=\"cboselectedsizes\" style=\"width:225px\" ondblclick=\"MoveSizeLeft();\">"+

			"						</select></td>"+
			"					  </tr>"+
			"					  <tr>"+
			"						<td height=\"8\" colspan=\"3\" class=\"specialFnt1\"><table width=\"100%\" border=\"0\" class=\"bcgl2Lbl\">"+
			"							<tr>"+
			"							  <td width=\"118\" bgcolor=\"#80AED5\" class=\"normaltxtmidb2\">Add New Size</td>"+
			"							  <td width=\"80\" class=\"normalfnt\">Size Name</td>"+
			"							  <td width=\"147\"><input name=\"txtSize\" type=\"text\" class=\"txtbox\" id=\"txtSize\" size=\"20\" /></td>"+
			"							  <td width=\"129\" bgcolor=\"#D6E7F5\"><div align=\"center\"><img src=\"../images/addsmall.png\" alt=\"add\" width=\"95\" height=\"24\" /></div></td>"+
			"							</tr>"+
			"						</table></td>"+
			"					  </tr>"+
			"					  <tr>"+
			"						<td height=\"15\" colspan=\"3\" class=\"specialFnt1\"></td>"+
			"					  </tr>"+
			"					  <tr>"+
			"						<td height=\"11\" colspan=\"3\" class=\"normaltxtmidb2L\">&nbsp;</td>"+
			"					  </tr>"+
			"					</table></td>"+
			"				  </tr>"+
			"				  <tr>"+
			"					<td bgcolor=\"#D6E7F5\"><table width=\"100%\" border=\"0\">"+
			"						<tr>"+
			"						  <td width=\"25%\">&nbsp;</td>"+
			"				<td width=\"29%\"><img src=\"../../images/save.png\" alt=\"save\" width=\"84\" height=\"24\" onclick=\"addItemToMainTable();\"/></td>"+
			"				<td width=\"21%\"><img src=\"../../images/close.png\" alt=\"Close\" width=\"97\" height=\"24\" onclick=\"closePopupBox(2);\" /></td>"+
			"						  <td width=\"25%\">&nbsp;</td>"+
			"						</tr>"+
			"					</table></td>"+
			"				  </tr>"+
			"				</table></td>"+
			"				<td width=\"2%\">&nbsp;</td>"+
			"			  </tr>"+
			"			</table></td>"+
			"		  </tr>"+
			"		  <tr>"+
			"			<td>&nbsp;</td>"+
			"		  </tr>"+
			"		</table>";
			var frame = document.createElement("div");
			frame.id = "frmColorSize";
			document.getElementById('frmColorSize').innerHTML=HTMLText;
			loadColor();
			loadSize();
	}
	function loadColor()
	{
		createXMLHttpRequest1(0);
		xmlHttp1[0].onreadystatechange = loadColorRequest;
		xmlHttp1[0].open("GET", 'generalPo-xml.php?id=loadColor', true);
		xmlHttp1[0].send(null); 
	}
	function loadColorRequest()
	{
		if(xmlHttp1[0].readyState == 4 && xmlHttp1[0].status == 200 ) 
		{
			var lstColor1 = document.getElementById("cbocolors");
			var strResponse = xmlHttp1[0].responseText;
			lstColor1.innerHTML =  strResponse;
		}
	}
	function loadSize()
	{
		createXMLHttpRequest1(1);
		xmlHttp1[1].onreadystatechange = loadSizeRequest;
		xmlHttp1[1].open("GET", 'generalPo-xml.php?id=loadSize', true);
		xmlHttp1[1].send(null); 
	}
	function loadSizeRequest()
	{
		if(xmlHttp1[1].readyState == 4 && xmlHttp1[1].status == 200 ) 
		{
			var lstSize1 = document.getElementById("cbosizes");
			var strResponse = xmlHttp1[1].responseText;
			lstSize1.innerHTML =  strResponse;
		}
	}
	
	
function MoveColorRight()
{
	var colors = document.getElementById("cbocolors");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cboselectedcolors"),true))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = selectedColor;
		document.getElementById("cboselectedcolors").options.add(optColor);
		colors.options[colors.selectedIndex] = null;
	}
}

function MoveColorLeft()
{
	var colors = document.getElementById("cboselectedcolors");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cbocolors"),true))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = selectedColor;
		document.getElementById("cbocolors").options.add(optColor);
		colors.options[colors.selectedIndex] = null;
	}
}

function MoveAllColorsLeft()
{
	var colors = document.getElementById("cbocolors");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cboselectedcolors"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].text;
			document.getElementById("cboselectedcolors").options.add(optColor);
		}
	}
	RemoveCurrentColors();
}

function MoveAllColorsRight()
{
	var colors = document.getElementById("cboselectedcolors");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cbocolors"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].text;
			document.getElementById("cbocolors").options.add(optColor);
		}
	}
	RemoveSelectedColors();
}

function CheckitemAvailability(itemName, cmb, message)
{
	for(var i = 0; i < cmb.options.length ; i++) 
	{
		if ( cmb.options[i].text.toLowerCase() == itemName.toLowerCase())
		{
			if (message)
				alert("The item " + itemName + " is already exists in the list.");
			return true;			
		}
	}
	return false;
}

function RemoveSelectedColors()
{
	var index = document.getElementById("cboselectedcolors").options.length;
	while(document.getElementById("cboselectedcolors").options.length > 0) 
	{
		index --;
		document.getElementById("cboselectedcolors").options[index] = null;
	}
}

function RemoveSelectedSizes()
{
	var index = document.getElementById("cboselectedsizes").options.length;
	while(document.getElementById("cboselectedsizes").options.length > 0) 
	{
		index --;
		document.getElementById("cboselectedsizes").options[index] = null;
	}
}

function MoveSizeRight()
{
	var colors = document.getElementById("cbosizes");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cboselectedsizes"),true))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = selectedColor;
		document.getElementById("cboselectedsizes").options.add(optColor);
		colors.options[colors.selectedIndex] = null;
	}
}

function MoveSizeLeft()
{
	var colors = document.getElementById("cboselectedsizes");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cbosizes"),true))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = selectedColor;
		document.getElementById("cbosizes").options.add(optColor);
		colors.options[colors.selectedIndex] = null;
	}
}

function MoveAllSizesLeft()
{
	var colors = document.getElementById("cbosizes");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cboselectedsizes"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].text;
			document.getElementById("cboselectedsizes").options.add(optColor);
		}
	}
	RemoveCurrentSizes();
}

function MoveAllSizesRight()
{
	var colors = document.getElementById("cboselectedsizes");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cbosizes"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].text;
			document.getElementById("cbosizes").options.add(optColor);
		}
	}
	RemoveSelectedSizes();
}

function isValidColorSizeSelection()
{
	if (document.getElementById("cboselectedcolors").options.length == 0 && document.getElementById("cboselectedsizes").options.length == 0)
	{
		alert ("Please choose your color size ratio.");
		return false;
	}
	return true;
}

function RemoveCurrentColors()
{
	var index = document.getElementById("cbocolors").options.length;
	while(document.getElementById("cbocolors").options.length > 0) 
	{
		index --;
		document.getElementById("cbocolors").options[index] = null;
	}
}
function RemoveCurrentSizes()
{
	var index = document.getElementById("cbosizes").options.length;
	while(document.getElementById("cbosizes").options.length > 0) 
	{
		index --;
		document.getElementById("cbosizes").options[index] = null;
	}
}

function addItemToMainTable()
{
	//alert(123);
	var tblMain = document.getElementById("tblMain");
	var tblMaterial = document.getElementById("tblMaterial");

	var strMain = document.getElementById("cboMainCategory").options[document.getElementById("cboMainCategory").selectedIndex].text;

	var tempText="";
			for (var i = 2; i < tblMaterial.rows.length; i++ )
			{
				if(tblMaterial.rows[i].cells[0].childNodes[0].childNodes[0].checked == true)
				{
					if(! isItemAvailable(parseInt(tblMaterial.rows[i].cells[2].lastChild.nodeValue)))
						{
					var rowCount = tblMain.rows.length;
					tblMain.insertRow(rowCount);
					tblMain.rows[rowCount].innerHTML=  "<td class=\"normalfntMid\"><img src=\"../../images/del.png\" width=\"15\" height=\"15\" onclick=\"removeRow(this);\" /></td>"+
				  "<td class=\"normalfntMid\">"+strMain+"</td>"+
				  "<td class=\"normalfnt\">"+tblMaterial.rows[i].cells[1].lastChild.nodeValue+"</td>"+
				  "<td class=\"normalfntMidSML\">"+tblMaterial.rows[i].cells[3].lastChild.nodeValue+"</td>"+
				  "<td class=\"normalfntRite\"><input type=\"text\" name=\"txtQty\" style=\"text-align:right\" size=\"15\" class=\"txtbox\" id=\"txtQty\" style=\"width:80px\" onkeyup=\"calculateRowValue(this);\"  onblur=\"calculateT();\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"></td>"+
				 "<td class=\"normalfntRite\"><input type=\"text\" name=\"txtValue\" style=\"text-align:right\" size=\"15\" class=\"txtbox\" id=\"txtValue\" style=\"width:80px\"  onkeyup=\"calculateRowValue(this);\"  onblur=\"calculateT();\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"></td>"+
				  "<td class=\"normalfntRite\">0</td>"+
				  "<td class=\"normalfntMidSML\">"+tblMaterial.rows[i].cells[2].lastChild.nodeValue+"</td>"+
		"<td class=\"normaltxtmidb2\"><div align=\"center\"><input type=\"checkbox\" name=\"chkfixed\" id=\"chkfixed\" /></div></td>"+
		"<td class=\"normaltxtmidb2\">"+ " " +"</td>"+
		"<td class=\"normaltxtmidb2\">"+ " " +"</td>"+
		"<td class=\"normaltxtmidb2\">"+ " " +"</td>"+
		"<td class=\"normaltxtmidb2\">"+ " " +"</td>";
					}
				}
			}
	closePopupBox(2);
}

 function isItemAvailable(matDetailId)
 {

	 var tbl = document.getElementById('tblMain');

	 for (var a = 1; a < tbl.rows.length ; a++)
	 {
		 
		 var gridItemId 		= parseInt(tbl.rows[a].cells[7].childNodes[0].nodeValue);
		//alert(gridItemId +' '+ matDetailId);
		 if (gridItemId== matDetailId)
		{	
			alert("Item is allready added to line "+a);
			return true; 
		}
		 
	 }
	  return false;
 }
 
function calculateRowValue(objText)
{
	var dblQty = dblQty = objText.parentNode.parentNode.cells[4].lastChild.value;
	var dblUnitPrice =  objText.parentNode.parentNode.cells[5].lastChild.value;
	var dblTotal =  dblQty * dblUnitPrice;
	objText.parentNode.parentNode.cells[6].lastChild.nodeValue =dblTotal;
}	

function removeRow(objDel)
{
	var tblMain = objDel.parentNode.parentNode.parentNode;
	var rowNo = objDel.parentNode.parentNode.rowIndex
	tblMain.deleteRow(rowNo);
}
function setCurrency(objSup)
{
	createXMLHttpRequest1(5);
	xmlHttp1[5].onreadystatechange = setCurrencyRequest;
	xmlHttp1[5].open("GET", 'generalPo-xml.php?id=setCurrency&supId='+objSup.value, true);
	xmlHttp1[5].send(null); 
}


function setCurrencyRequest()
{
	if(xmlHttp1[5].readyState == 4 && xmlHttp1[5].status == 200) 
	{
		var currencyId = xmlHttp1[5].responseText;
		if(currencyId=="" || currencyId=='0' )
			document.getElementById("cboCurrency").selectedIndex = -1;
		else
			document.getElementById("cboCurrency").value=currencyId;
	}	
}

function dateDisable(objChk)
{
		if(!objChk.checked)
		{
			document.getElementById("deliverydateDD").disabled= true;
			document.getElementById("deliverydateDD").value="";
		}
		else
		{
			document.getElementById("deliverydateDD").disabled=false;
			document.getElementById("deliverydateDD").value ="" ;
		}
}

function calculateT()
{
	var tblMain  = document.getElementById("tblMain");
	var dblT = 0;
	for(var i=1;i<tblMain.rows.length;i++)
	{
		if(tblMain.rows[i].cells[4].lastChild.value=="")
			tblMain.rows[i].cells[4].lastChild.value=0;
			
		if(tblMain.rows[i].cells[5].lastChild.value=="")
			tblMain.rows[i].cells[5].lastChild.value=0;
		
		dblT = dblT +( parseFloat(tblMain.rows[i].cells[4].lastChild.value) * parseFloat(tblMain.rows[i].cells[5].lastChild.value));
	}
	//txtPoAmount
	document.getElementById("txtPoAmount").value = dblT;
}


function CheckforValidDecimal(sCell,decimalPoints,evt)
{
	value = sCell.value;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	
	var allowableCharacters = new Array(9,45,36,35);
	for (var loop = 0 ; loop < allowableCharacters.length ; loop ++ )
	{
		if (charCode == allowableCharacters[loop] )
		{
			return true;
		}
	}
	
	
	for (x in AllowableCharators)
	  {
		  if (AllowableCharators[x] == charCode)
		  return true;		
	  }
	
	if (charCode==46 && value.indexOf(".") >-1)
		return false;
	else if (charCode==46)
		return true;
	
	if (value.indexOf(".") > -1 && value.substring(value.indexOf("."),value.length).length > decimalPoints)
		return false;
	
	 if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
}

function validateBulkPo()
{	
	//	validate po no
	var strSupplier	= document.getElementById("cboSupplier").options[document.getElementById('cboSupplier').selectedIndex].text;
	if(strSupplier=="Select One")
	{
		alert("supplier not selected");
		return false;
	}
	
	var strCurrency	= document.getElementById("cboCurrency").value;
	if(strCurrency=="")
	{
		alert("Currency is empty.");
		return false;
	}
	
	//validate suplier advice no
	var deliverydateDD	= document.getElementById("deliverydateDD").value;
	if(deliverydateDD=="")
	{
		alert("Delivery Date is empty");
		document.getElementById("deliverydateDD").focus();
		return false;
	}
	if (validDate()==false) 
	{
		alert("Deliver Date is invalid.");
		return false;
	}
	var Deliverto	= document.getElementById("cboDeliverto").options[document.getElementById('cboDeliverto').selectedIndex].text;
	if(Deliverto=="")
	{
		alert("Deliver to Company is empty.");
		return false;
	}
	
	var InvoiceTo	= document.getElementById("cboInvoiceTo").options[document.getElementById('cboInvoiceTo').selectedIndex].text;
	if(InvoiceTo=="")
	{
		alert("Invoice to Company is empty.");
		return false;
	}
	
	
	var cboPayMode	= document.getElementById("cboPayMode").options[document.getElementById('cboPayMode').selectedIndex].text;
	if(cboPayMode=="Select One")
	{
		alert("PayMode not selected");
		return false;
	}
	var cboPayTerms	= document.getElementById("cboPayTerms").options[document.getElementById('cboPayTerms').selectedIndex].text;
	if(cboPayTerms=="Select One")
	{
		alert("PayTerms not selected");
		return false;
	}
	
	/*var cboShipment	= document.getElementById("cboShipment").options[document.getElementById('cboShipment').selectedIndex].text;
	if(cboShipment=="Select One")
	{
		alert("Shipment not selected");
		return false;
	}
*/
	return true;
}

function save()
{
	if(validateBulkPo()==false)
		return ;
	saveBulkGrnHeader();
}
function saveBulkGrnHeader()
{
		var text1 =  document.getElementById("txtBulkPoNo").value;
		
		if( text1 == ""){
			var intGenPONo			= "";
			var intYear				= "";
		}
		else{
			var intGenPONo			= (text1).split("/")[1];
			var intYear				= (text1).split("/")[0];
		}
		
		var intSupplierID		= document.getElementById("cboSupplier").value;
		var strRemarks			= "";
		var dtmDate				= document.getElementById("podate").value;
		var dtmDeliveryDate		= (document.getElementById("deliverydateDD").value).split("/")[2]+"-"+(document.getElementById("deliverydateDD").value).split("/")[1]+"-"+(	document.getElementById("deliverydateDD").value).split("/")[0];
		
		var strCurrency			= document.getElementById("cboCurrency").value;
		var dblTotalValue		= document.getElementById("txtPoAmount").value;
		
		var intInvoiceComp		= document.getElementById("cboInvoiceTo").value;
		var intDeliverTo		= document.getElementById("cboDeliverto").value;

		var strPayTerm			= document.getElementById("cboPayTerms").value;
		var intPayMode			= document.getElementById("cboPayMode").value;
/*		var intShipmentModeId   = document.getElementById("cboShipment").value;
*/		var strInstructions		= document.getElementById("txtIntroduction").value;
		
		/*var strPINO				= document.getElementById("txtBulkPoNo").value;*/
	
// stop here ......
	
	createXMLHttpRequest1(0);
	xmlHttp1[0].onreadystatechange = saveBulkPoHeaderRequest;
	var url  = "generalPo-db.php?id=saveBulkPoHeader";
		url += "&intGenPONo="+intGenPONo;
		url += "&intYear="+intYear;
		url += "&intSupplierID="+intSupplierID;
		url += "&strRemarks="+strRemarks;
		url += "&dtmDate="+dtmDate;
		url += "&dtmDeliveryDate="+dtmDeliveryDate;
		url += "&strCurrency="+strCurrency;
		url += "&dblTotalValue="+dblTotalValue;
		
		url += "&intInvoiceComp="+intInvoiceComp;
		url += "&intDeliverTo="+intDeliverTo;
		url += "&strPayTerm="+strPayTerm;
		url += "&intPayMode="+intPayMode;
		
		/*url += "&intShipmentModeId="+intShipmentModeId;*/
		url += "&strInstructions="+strInstructions;
		/*url += "&strPINO="+strPINO;*/
		
	xmlHttp1[0].open("GET",url,true);
	xmlHttp1[0].send(null);

}
function saveBulkPoHeaderRequest()
{
		if(xmlHttp1[0].readyState == 4 && xmlHttp1[0].status == 200 ) 
		{
			var bulkPoNo = trim(xmlHttp1[0].responseText);
			
			document.getElementById("txtBulkPoNo").value = bulkPoNo;
			if(bulkPoNo!="Saving-Error")
			{
				//alert(bulkPoNo);
				saveBulkGrnDetails(bulkPoNo);

				
			}
			else
			{
				alert("Error : \nGeneral Purchase order header not saved");
				return;
			}
		}
}

function saveBulkGrnDetails(pono)
{
	
	var tblGrn = document.getElementById("tblMain");	
	pub_intxmlHttp_count = tblGrn.rows.length-1;
	
	for(var loop=1;loop<tblGrn.rows.length;loop++)
	{
		
	var	intGenPONo			= pono.split("/")[1];
	var intYear				= pono.split("/")[0];
	var	intMatDetailID		= tblGrn.rows[loop].cells[7].lastChild.nodeValue;
	var strDescription		= tblGrn.rows[loop].cells[2].lastChild.nodeValue;
	var strUnit				= tblGrn.rows[loop].cells[3].lastChild.nodeValue;
	var dblUnitPrice		= tblGrn.rows[loop].cells[5].lastChild.value;
	var dblQty				= tblGrn.rows[loop].cells[4].lastChild.value;
	var dblPending			= tblGrn.rows[loop].cells[4].lastChild.value;
	var dblDlPrice			= tblGrn.rows[loop].cells[4].lastChild.value * tblGrn.rows[loop].cells[5].lastChild.value;
	var strDeliveryDates	= document.getElementById("deliverydateDD").value;
	var intDeliverTo 		= document.getElementById("cboDeliverto").value;
	
	
	createXMLHttpRequest1(loop);
	xmlHttp1[loop].onreadystatechange = saveBulkPoDetailsRequest;
	var url  = "generalPo-db.php?id=saveBulkPoDetails";
		url += "&intGenPONo="+intGenPONo;
		url += "&intYear="+intYear;
		url += "&intMatDetailID="+intMatDetailID;
		url += "&strDescription="+strDescription;
		url += "&strUnit="+strUnit;
		url += "&dblUnitPrice="+dblUnitPrice;
		url += "&dblQty="+dblQty;
		url += "&dblPending="+dblPending;
		url += "&dblDlPrice="+dblDlPrice;
		url += "&strDeliveryDates="+strDeliveryDates;
		url += "&intDeliverTo="+intDeliverTo;
		url += "&count="+loop;
		
	xmlHttp1[loop].index = loop;
	xmlHttp1[loop].open("GET",url,true);
	xmlHttp1[loop].send(null);

	}
}

function saveBulkPoDetailsRequest()
{
		if(xmlHttp1[this.index].readyState == 4 && xmlHttp1[this.index].status == 200 ) 
		{
			var intNo =xmlHttp1[this.index].responseText;
			var poNo = intNo.split("-")[1];
			intNo = intNo.split("-")[0];
			//alert(intNo);
			if(intNo==1)
			{
				pub_intxmlHttp_count=pub_intxmlHttp_count-1;
				if (pub_intxmlHttp_count ==0)
				{
					alert("General Purchase Order " + poNo + " Saved successfully !");
					//alert("General PO Details Successfully Saved");
					document.getElementById("butConform").style.visibility="visible";
				}
			}
			else{
				alert( "General PO details saving error...");
			}
		}
}

function loadBulkPoForm(intGenPONo,intYear,intStatus)
{
	if ((intGenPONo!=0)||(intYear!=0))
	{		
		if(intStatus==1)
		{
			document.getElementById("butSave").style.visibility="hidden";
			document.getElementById("butConform").style.visibility="hidden";
		}
		else if(intStatus==10)
		{
			//document.getElementById("butSave").style.visibility="hidden";
			document.getElementById("butConform").style.visibility="hidden";
			document.getElementById("butCancel").style.visibility="hidden";
		}
		else if(intStatus==0)
		{
			document.getElementById("butCancel").style.visibility="hidden";
		}
		
		//  ==============================   BULK PO HEADER PART  ============================
		//document.getElementById("txtBulkPoNo").value = intGenPONo;
		
		createXMLHttpRequest1(0);
		xmlHttp1[0].onreadystatechange = bulkPoHeaderRequest;
		var url  = "generalPo-xml.php?id=loadBulkPoHeader";
			url += "&intGenPONo="+intGenPONo;
			url += "&intYear="+intYear;
			url += "&intStatus="+intStatus;
		xmlHttp1[0].open("GET",url,true);
		xmlHttp1[0].send(null);
		
		//====================================  BULK PO DETAIL PART ==============================================
		createXMLHttpRequest1(1);
		xmlHttp1[1].onreadystatechange = bulkPoDetailRequest;
		var url  = "generalPo-xml.php?id=loadBulkPoDetails";
			url += "&intGenPONo="+intGenPONo;
			url += "&intYear="+intYear;
			url += "&intStatus="+intStatus;
		xmlHttp1[1].intGenPONo = intGenPONo;
		xmlHttp1[1].intYear = intYear;
		xmlHttp1[1].open("GET",url,true);
		xmlHttp1[1].send(null);
	}	
	else
	{
		document.getElementById("butConform").style.visibility="hidden";
		document.getElementById("butCancel").style.visibility="hidden";
		//document.getElementById("butReport").style.visibility="hidden";
		document.getElementById("butMail").style.visibility="hidden";
	}
}

function bulkPoHeaderRequest()
{
		if(xmlHttp1[0].readyState == 4 && xmlHttp1[0].status == 200 ) 
		{
			//alert(xmlHttp1[0].responseText);
			var XMLstrBulkPONo = xmlHttp1[0].responseXML.getElementsByTagName("intGenPONo");
			var XMLintYear = xmlHttp1[0].responseXML.getElementsByTagName("intYear");
			var XMLintSupplierID = xmlHttp1[0].responseXML.getElementsByTagName("intSupplierID");
			var XMLdtmDate = xmlHttp1[0].responseXML.getElementsByTagName("dtmDate");
			var XMLdtmDeliveryDate = xmlHttp1[0].responseXML.getElementsByTagName("dtmDeliveryDate");
			var XMLstrCurrency = xmlHttp1[0].responseXML.getElementsByTagName("strCurrency");
			var XMLintStatus = xmlHttp1[0].responseXML.getElementsByTagName("intStatus");
			var XMLintCompId = xmlHttp1[0].responseXML.getElementsByTagName("intCompId");
			var XMLintDeliverTo = xmlHttp1[0].responseXML.getElementsByTagName("intDeliverTo");
			var XMLstrPayTerm = xmlHttp1[0].responseXML.getElementsByTagName("strPayTerm");
			var XMLintPayMode = xmlHttp1[0].responseXML.getElementsByTagName("intPayMode");
			/*var XMLintShipmentModeId = xmlHttp1[0].responseXML.getElementsByTagName("intShipmentModeId");*/
			var XMLstrInstructions = xmlHttp1[0].responseXML.getElementsByTagName("strInstructions");
			/*var XMLstrPINO = xmlHttp1[0].responseXML.getElementsByTagName("strPINO");*/
			var XMLintInvoiceComp = xmlHttp1[0].responseXML.getElementsByTagName("intInvoiceComp");
			
			document.getElementById("txtBulkPoNo").value= XMLintYear[0].childNodes[0].nodeValue+"/"+XMLstrBulkPONo[0].childNodes[0].nodeValue;
			var objDate = XMLdtmDate[0].childNodes[0].nodeValue.split(" ");
			document.getElementById("podate").value = objDate[0] ;
			document.getElementById("cboSupplier").value = XMLintSupplierID[0].childNodes[0].nodeValue;
			
			var d = XMLdtmDeliveryDate[0].childNodes[0].nodeValue;
				var d1 = "";
				d = d.split("-");
				d1= d[2].substring(0,2)+"/"+d[1]+"/"+d[0];
			document.getElementById("deliverydateDD").value = d1 ;
			
			document.getElementById("checkbox").checked = 1;
			document.getElementById("txtIntroduction").value = XMLstrInstructions[0].childNodes[0].nodeValue;
			document.getElementById("cboCurrency").value = XMLstrCurrency[0].childNodes[0].nodeValue;
			
			document.getElementById("cboInvoiceTo").value = XMLintInvoiceComp[0].childNodes[0].nodeValue;
			document.getElementById("cboDeliverto").value = XMLintDeliverTo[0].childNodes[0].nodeValue;
			document.getElementById("cboPayMode").value = XMLintPayMode[0].childNodes[0].nodeValue;
			document.getElementById("cboPayTerms").value = XMLstrPayTerm[0].childNodes[0].nodeValue;
/*			document.getElementById("cboShipment").value = XMLintShipmentModeId[0].childNodes[0].nodeValue;
*/			/*document.getElementById("txtPinNo").value = XMLstrPINO[0].childNodes[0].nodeValue;*/
			document.getElementById("cboCurrency").value = XMLstrCurrency[0].childNodes[0].nodeValue;
			document.getElementById("cboCurrency").value = XMLstrCurrency[0].childNodes[0].nodeValue;
			document.getElementById("txtPoAmount").value = "0";
		}
}

function bulkPoDetailRequest()
{
		if(xmlHttp1[1].readyState == 4 && xmlHttp1[1].status == 200 ) 
		{
			var tblMain = document.getElementById("tblMain");
			var XMLstrMainCategory = xmlHttp1[1].responseXML.getElementsByTagName("strMainCategory");
			var XMLitemDescription = xmlHttp1[1].responseXML.getElementsByTagName("itemDescription");
			var XMLstrUnit = xmlHttp1[1].responseXML.getElementsByTagName("strUnit");
			var XMLdblUnitPrice = xmlHttp1[1].responseXML.getElementsByTagName("dblUnitPrice");
			var XMLdblBalance = xmlHttp1[1].responseXML.getElementsByTagName("dblBalance");
			var XMLdblQty = xmlHttp1[1].responseXML.getElementsByTagName("dblQty");
			var XMLintMatDetailID = xmlHttp1[1].responseXML.getElementsByTagName("intMatDetailID");
			
			for(var n = 0; n < XMLstrMainCategory.length ; n++) 
			{
				var rowCount = tblMain.rows.length;
				tblMain.insertRow(rowCount);
				//tblMain.rows[rowCount].id = 
				tblMain.rows[rowCount].innerHTML=  "<td class=\"normalfntMid\"><img src=\"../../images/del.png\" width=\"15\" height=\"15\" onclick=\"removeRow(this);\" /></td>"+
		  		"<td class=\"normalfntMid\">"+XMLstrMainCategory[n].childNodes[0].nodeValue+"</td>"+
		  		"<td class=\"normalfnt\">"+XMLitemDescription[n].childNodes[0].nodeValue+"</td>"+
		/*		  "<td class=\"normalfntMidSML\">"+XMLstrColor[n].childNodes[0].nodeValue+"</td>"+
		  "<td class=\"normalfntMidSML\">"+XMLstrSize[n].childNodes[0].nodeValue+"</td>"+
		*/		"<td class=\"normalfntMidSML\">"+XMLstrUnit[n].childNodes[0].nodeValue+"</td>"+
		  		"<td class=\"normalfntRite\"><input type=\"text\" name=\"txtQty\" style=\"text-align:right\" size=\"15\" class=\"txtbox\" id=\"txtQty\" style=\"width:80px\" onkeyup=\"calculateRowValue(this);\"  onblur=\"calculateT();\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" value="+XMLdblQty[n].childNodes[0].nodeValue+"></td>"+
		 		"<td class=\"normalfntRite\"><input type=\"text\" name=\"txtValue\" style=\"text-align:right\" size=\"15\" class=\"txtbox\" id=\"txtValue\" style=\"width:80px\"  onkeyup=\"calculateRowValue(this);\"  onblur=\"calculateT();\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" value="+XMLdblUnitPrice[n].childNodes[0].nodeValue+"></td>"+
			  	"<td class=\"normalfntRite\">"+XMLdblQty[n].childNodes[0].nodeValue * XMLdblUnitPrice[n].childNodes[0].nodeValue+"</td>"+
		  		"<td class=\"normalfntMidSML\">"+XMLintMatDetailID[n].childNodes[0].nodeValue+"</td>";
			}
		}
		calculateT();
}

function newPage()
{
	var sURL = unescape(window.location.pathname);
    window.location.href = sURL;
}

function conform()
{
		var text1 =  document.getElementById("txtBulkPoNo").value;
		if( text1 == ""){
			alert("can't find bulk po");
			return;
		}
		else{
			var intGenPONo			= (text1).split("/")[1];
			var intYear				= (text1).split("/")[0];
		}
		
	createXMLHttpRequest1(0);
	xmlHttp1[0].onreadystatechange = saveBulPoConfirm;
	var url  = "generalPo-db.php?id=confirmBulkPo";
		url += "&intGenPONo="+intGenPONo;
		url += "&intYear="+intYear;
		
	xmlHttp1[0].open("GET",url,true);
	xmlHttp1[0].send(null);
}
function saveBulPoConfirm()
{
		if( xmlHttp1[0].readyState == 4 && xmlHttp1[0].status == 200 ) 
		{
			var intConfirm = xmlHttp1[0].responseText;
			if(intConfirm)
			{
				alert("General Po is  Confirmed");
				document.getElementById("butSave").style.visibility="hidden";
				document.getElementById("butConform").style.visibility="hidden";
				document.getElementById("butCancel").style.visibility="hidden";
				document.getElementById("butReport").style.visibility="visible";
				document.getElementById("cmdAddNew").style.visibility="hidden";
				//newPage();
			}
			else
				alert("Error \nGeneral Po is not confirmed");
		}
}
function cancel()
{
		var text1 =  document.getElementById("txtBulkPoNo").value;
		if( text1 == ""){
			alert("Can't find General po");
			return;
		}
		else{
			var intGenPONo			= (text1).split("/")[1];
			var intYear				= (text1).split("/")[0];
		}
		
	createXMLHttpRequest1(0);
	xmlHttp1[0].onreadystatechange = saveBulPoCancel;
	var url  = "generalPo-db.php?id=cancelBulkPo";
		url += "&intGenPONo="+intGenPONo;
		url += "&intYear="+intYear;
		
	xmlHttp1[0].open("GET",url,true);
	xmlHttp1[0].send(null);
}

function saveBulPoCancel()
{
		if( xmlHttp1[0].readyState == 4 && xmlHttp1[0].status == 200 ) 
		{
			var intCancel = xmlHttp1[0].responseText;
			//if(intCancel)
			if(intCancel == 1)
			{
				alert("General Po is Canceled");
				//newPage();
			}
			else if(intCancel.length > 1)
			{
				//alert("Error \nGeneral Po is not canceld");
				var grnExistLst = intCancel;
				alert("Can not cancel, GRN(s) exist ! :" + grnExistLst);
			}
				
		}
}
function BulkPoReport()
{
		var path = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1]+'/'+document.location.pathname.split("/")[2];
	path += "/GeneralPO/generalPurchaeOrderReport.php?bulkPoNo="+document.getElementById("txtBulkPoNo").value.split("/")[1]+"&intYear="+document.getElementById("txtBulkPoNo").value.split("/")[0];
	//alert(path);
	//document.location.href = path;
	var win2=window.open(path,'win'+pub_printWindowNo++);
}

function trim(str) {
	return ltrim(rtrim(str, ' '), ' ' );
}

/* shivanka - additional scripts */

function delRow(objDel)
{
	var tblTable = 	document.getElementById("tblMain");
	
	var grnIndexNo		 =objDel.parentNode.parentNode.parentNode.id;
	//alert("grnIndexNo "+ grnIndexNo);
	tblTable.deleteRow(objDel.parentNode.parentNode.parentNode.rowIndex);
	
	tblTable		= 	document.getElementById("tblMain");
	var binCount	=	tblTable.rows.length;
	for(var loop=1;loop<binCount;loop++)
	{
		//alert("bin line  "+ tblTable.rows[loop].id + "==" +grnIndexNo);
		if(tblTable.rows[loop].id==grnIndexNo){
			tblTable.deleteRow(loop);
			binCount--;
			loop--;
		}
	}
}

function checkitem(objRatio)
	{
		pub_matNo = objRatio.parentNode.parentNode.parentNode.rowIndex;
		//showBulkPurchaseRatioWindow();
	}

function validDate()
{	
	var valDt = document.getElementById("deliverydateDD").value;
	var poDt = document.getElementById("podate").value;
	var poDtY = poDt.substr(0,4);
	var poDtM = poDt.substr(5,2);
	var poDtD = poDt.substr(8,2);
	var poDtYMD = new Date(poDtY + "/" + poDtM + "/" + poDtD );
	
	
	var valDtY = valDt.substr(6,4);
	var valDtM = valDt.substr(3,2);
	var valDtD = valDt.substr(0,2);
	var valDtYMD = new Date(valDtY + "/" + valDtM + "/" + valDtD );
	
	//alert(poDtYMD);
	//alert(valDtYMD);
	if (poDtYMD > valDtYMD)
	{
		//alert("Invalid Delivery Date !");
		return false;
	}
	return true;
}

function loadPO()
{
	if(document.getElementById('copyPOMain').style.visibility == "hidden")
	document.getElementById('copyPOMain').style.visibility = "visible";
	else
	document.getElementById('copyPOMain').style.visibility = "hidden";
	
	createXMLHttpRequest();
	document.getElementById('cboPONo').length=1;
    xmlHttp.onreadystatechange = handlLoadPO;
    xmlHttp.open("GET", 'generalPo-xml.php?id=GetPO', true);
    xmlHttp.send(null);  
	
}

function handlLoadPO()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			 var PO= xmlHttp.responseXML.getElementsByTagName("PO");
			 var POYear= xmlHttp.responseXML.getElementsByTagName("Year");
			 
			 for ( var loop = 0; loop < PO.length; loop ++)
			 {
			
				var opt = document.createElement("option");
				opt.text = POYear[loop].childNodes[0].nodeValue + "/" + PO[loop].childNodes[0].nodeValue;
				opt.value = POYear[loop].childNodes[0].nodeValue + "/" + PO[loop].childNodes[0].nodeValue;
				document.getElementById("cboPONo").options.add(opt);
			 }
			 
		}
	} 
}

function clearTable()
{
	var tblTable = 	document.getElementById("tblMain");
	tblTable		= 	document.getElementById("tblMain");
	var binCount	=	tblTable.rows.length;
	for(var loop=1;loop<binCount;loop++)
	{
			tblTable.deleteRow(loop);
			binCount--;
			loop--;
	}
}

function textClear()
{
	document.getElementById("txtBulkPoNo").value = "";
}

function copyPO()
{
	var PONo=document.getElementById('cboPONo').value;
	var cpPO = PONo.split("/")[1];
	var cpYear = PONo.split("/")[0];
	//alert(cpYear + "/" + cpPO );
	clearTable();
	loadBulkPoForm(cpPO,cpYear,10);
	setTimeout("textClear();",100);
	document.getElementById('copyPOMain').style.visibility = "hidden";
}

function callClose()
{
	document.getElementById('copyPOMain').style.visibility == "hidden";
}

function closeCopyPo()
{
	//setTimeout("callClose();",100);
	document.getElementById('copyPOMain').style.visibility == "hidden";
}
////////// end of line