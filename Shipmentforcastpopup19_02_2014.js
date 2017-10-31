function Decathlonadd(value, x)
{

	var HTMLText ="<div id=\"login-box\" class=\"login-popup\"><table width=\"800\" height=\"390\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
	" <tr>"+
	"	<td width=\"850\" bgcolor=\"#498CC2\" class=\"TitleN2white\" >DECATHLON</td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" border=\"0\">"+
	"	  <tr>"+
	"		<td class=\"normalfnt\">"+
	" <table width=\"100%\" height=\"25\" border=\"0\" class=\"bcgl1\">"+

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">SC No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"changeSCCombo(event);\" id=\"txtSCNo\" name=\"txtSCNo\" class=\"txtbox\" style=\"width:173px;\" onclick=\"abc_SCNo();\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Delivery</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDelivery\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Buyer Po No</td>"+
	"			<td width=\"15%\"><select id=\"txtBuyerPoNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" onchange=\"changePO();\"/></select></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Style No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtStyleNO\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Dept No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDeptNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GOH Y / N</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGOH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTNS</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">QTY</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtQty\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Net Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNetWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Gross Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGrossWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">CTN (L)</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (W)</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNW\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (H)</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit Price</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPrice\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GSP Status</td>"+
	"			<td width=\"15%\"><input type=\"checkbox\" id=\"GSPApproval\" name=\"GSP_Approval\" value=\"GSP_Approval\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Description of Items</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Fabric</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFabric\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Country</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCountry\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Factory</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFactory\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Ship mode</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtShipMode\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">EX FTY</td>"+
	"			<td width=\"15%\"><input name=\"txtEXFTY\" type=\"text\" class=\"txtbox\" id=\"txtEXFTY\" style=\"width:130px; text-align:center;\" onclick=\"getdate(this.id)\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Pord No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPordNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">IMAN Code</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtIMANCode\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Criterion</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCriterion\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">FCL / LCL</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFCLLCL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit PCS / SETS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPCSSETS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Destination</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDestination\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CBM</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCBM\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"
	
	if(x == "1"){
	HTMLText +="		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Factory Date</td>"+
	"			<td width=\"25%\" colspan=\"2\"><input name=\"txtFactoryDate\" type=\"text\" class=\"txtbox\" id=\"txtFactoryDate\" style=\"width:173px; text-align:center;\" onclick=\"getdate(this.id)\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	}
	HTMLText +="	</table></td>"+
	"  </tr>"+
	
	"    <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"  <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"	</table></td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"#D6E7F5\" align=\"center\" class=\"tableFooter\">"+


	"	  <tr>";
	//"		<td width=\"5%\" class=\"txtbox backcolorYellow\" ></td>"+
	if(x == "1"){
	if(value == "1"){
	HTMLText += "		<td align=\"right\"><img src=\"images/addsmall.png\" width=\"97\"  border=\"0\" onClick=\"addDecathlon();\" /></td>";
	}else{
	HTMLText += "		<td align=\"right\" ><img src=\"images/editbut.jpg\" width=\"97\" height=\"23\" border=\"0\" onClick=\"editDecathlon();\" /></td>";
	}
	}
	//"		<td width=\"15%\" class=\"normalfnt\">Completed Orders</td>"+
	HTMLText += "		<td align=\"right\"><img src=\"images/close.png\" width=\"97\"  border=\"0\" onClick=\"closeWindow();\" /></td>"+
	/*"		<td width=\"37%\">&nbsp;</td>"+*/
	"	  </tr>"+
	"	</table></td>"+
	" </tr>"+
	"</table></div>";
	document.getElementById('myResults').innerHTML=HTMLText;
		if(value != 1){
			getDecathlondata(value);
			}
	var loginBox = "#login-box";

		//Fade in the Popup and add close button
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;

	loadSearchPODetails();
	addItems();
		
		
}


function MANDSadd(value, x)
{

	var HTMLText ="<div id=\"login-box\" class=\"login-popup\"><table width=\"800\" height=\"390\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
	" <tr>"+
	"	<td width=\"850\" bgcolor=\"#498CC2\" class=\"TitleN2white\" >M AND S</td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" border=\"0\">"+
	"	  <tr>"+
	"		<td class=\"normalfnt\">"+
	" <table width=\"100%\" height=\"25\" border=\"0\" class=\"bcgl1\">"+

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">SC No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"changeSCCombo(event);\" id=\"txtSCNo\" name=\"txtSCNo\" class=\"txtbox\" style=\"width:173px;\" onclick=\"abc_SCNo();\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Delivery</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDelivery\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Buyer Po No</td>"+
	"			<td width=\"15%\"><select id=\"txtBuyerPoNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" onchange=\"changePO();\"/></select></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Style No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtStyleNO\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Dept No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDeptNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GOH Y / N</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGOH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTNS</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">QTY</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtQty\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Net Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNetWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Gross Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGrossWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">CTN (L)</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (W)</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNW\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (H)</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit Price</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPrice\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GSP Status</td>"+
	"			<td width=\"15%\"><input type=\"checkbox\" id=\"GSPApproval\" name=\"GSP_Approval\" value=\"GSP_Approval\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Description of Items</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Fabric</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFabric\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Country</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCountry\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Factory</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFactory\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Ship mode</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtShipMode\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">EX FTY</td>"+
	"			<td width=\"15%\"><input name=\"txtEXFTY\" type=\"text\" class=\"txtbox\" id=\"txtEXFTY\" style=\"width:130px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Pord No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPordNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PO Description</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPODescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Knit / Woven</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtKnitWoven\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">FCL / LCL</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFCLLCL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit PCS / SETS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPCSSETS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Destination</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDestination\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CBM</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCBM\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PCS Per CTNS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPCSPerCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">NET WT P/PC</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNETWTPPC\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GRS WT P/Pc</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGRSWTPPc\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Other Reference</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtReference\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Pack Type</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPackType\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	if(x == "1"){
	HTMLText +="		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Factory Date</td>"+
	"			<td width=\"25%\" colspan=\"2\"><input name=\"txtFactoryDate\" type=\"text\" class=\"txtbox\" id=\"txtFactoryDate\" style=\"width:173px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	}
	HTMLText +="	</table></td>"+
	"  </tr>"+
	
	"    <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"  <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"	</table></td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"#D6E7F5\" align=\"center\" class=\"tableFooter\">"+


	"	  <tr>";
	//"		<td width=\"5%\" class=\"txtbox backcolorYellow\" ></td>"+
		if(x == "1"){
	if(value == "1"){
	HTMLText += "		<td align=\"right\"><img src=\"images/addsmall.png\" width=\"97\"  border=\"0\" onClick=\"addMandS();\" /></td>";
	}else{
	HTMLText += "		<td align=\"right\" ><img src=\"images/editbut.jpg\" width=\"97\" height=\"23\" border=\"0\" onClick=\"editMANDS();\" /></td>";
	}
	}/*"		<td width=\"37%\">&nbsp;</td>"+*/
	HTMLText += "		<td align=\"right\"><img src=\"images/close.png\" width=\"97\"  border=\"0\" onClick=\"closeWindow();\" /></td>"+
	"	  </tr>"+
	"	</table></td>"+
	" </tr>"+
	"</table></div>";
		document.getElementById('myResults').innerHTML=HTMLText;
			if(value != 1){
			getMANDSdata(value);
			}
	var loginBox = "#login-box";

		//Fade in the Popup and add close button
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;

	loadSearchPODetails();
	addItems();

}

function Tescoadd(value, x)
{

	var HTMLText ="<div id=\"login-box\" class=\"login-popup\"><table width=\"800\" height=\"390\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
	" <tr>"+
	"	<td width=\"850\" bgcolor=\"#498CC2\" class=\"TitleN2white\" >TESCO</td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" border=\"0\">"+
	"	  <tr>"+
	"		<td class=\"normalfnt\">"+
	" <table width=\"100%\" height=\"25\" border=\"0\" class=\"bcgl1\">"+

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">SC No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"changeSCCombo(event);\" id=\"txtSCNo\" name=\"txtSCNo\" class=\"txtbox\" style=\"width:173px;\" onclick=\"abc_SCNo();\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Delivery</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDelivery\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Buyer Po No</td>"+
	"			<td width=\"15%\"><select id=\"txtBuyerPoNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" onchange=\"changePO();\"/></select></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Style No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtStyleNO\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Dept No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDeptNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GOH Y / N</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGOH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTNS</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">QTY</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtQty\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Net Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNetWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Gross Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGrossWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">CTN (L)</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (W)</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNW\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (H)</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit Price</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPrice\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GSP Status</td>"+
	"			<td width=\"15%\"><input type=\"checkbox\" id=\"GSPApproval\" name=\"GSP_Approval\" value=\"GSP_Approval\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Description of Items</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Fabric</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFabric\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Country</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCountry\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Factory</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFactory\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Ship mode</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtShipMode\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">EX FTY</td>"+
	"			<td width=\"15%\"><input name=\"txtEXFTY\" type=\"text\" class=\"txtbox\" id=\"txtEXFTY\" style=\"width:130px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Pord No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPordNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PO Description</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPODescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Knit / Woven</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtKnitWoven\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">FCL / LCL</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFCLLCL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit PCS / SETS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPCSSETS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Destination</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDestination\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CBM</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCBM\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PCS Per CTNS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPCSPerCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">NET WT P/PC</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNETWTPPC\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GRS WT P/Pc</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGRSWTPPc\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Other Reference</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtReference\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Pack Type</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPackType\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Season</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtSeason\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"
	if(x == "1"){
	HTMLText +="		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Factory Date</td>"+
	"			<td width=\"25%\" colspan=\"2\"><input name=\"txtFactoryDate\" type=\"text\" class=\"txtbox\" id=\"txtFactoryDate\" style=\"width:173px; text-align:center;\" onclick=\"getdate(this.id)\"/></td></tr>"
	}
	HTMLText +="	<tr><td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Retek No</td>"+
	"			<td width=\"18%\"><input name=\"txtRetekNo\" type=\"text\" class=\"txtbox\" id=\"txtRetekNo\" style=\"width:173px;\" /></td></tr></table></td>"+
	"  </tr>"+
	
	"    <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"  <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"	</table></td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"#D6E7F5\" align=\"center\" class=\"tableFooter\">"+


	"	  <tr>";
	//"		<td width=\"5%\" class=\"txtbox backcolorYellow\" ></td>"+
		if(x == "1"){
	if(value == "1"){
	HTMLText += "		<td align=\"right\"><img src=\"images/addsmall.png\" width=\"97\"  border=\"0\" onClick=\"addTesco();\" /></td>";
	}else{
	HTMLText += "		<td align=\"right\" ><img src=\"images/editbut.jpg\" width=\"97\" height=\"23\" border=\"0\" onClick=\"editTesco();\" /></td>";
	}
	}
	//"		<td width=\"15%\" class=\"normalfnt\">Completed Orders</td>"+
	HTMLText += "		<td align=\"right\"><img src=\"images/close.png\" width=\"97\"  border=\"0\" onClick=\"closeWindow();\" /></td>"+
	/*"		<td width=\"37%\">&nbsp;</td>"+*/
	"	  </tr>"+
	"	</table></td>"+
	" </tr>"+
	"</table></div>";
	document.getElementById('myResults').innerHTML=HTMLText;
		if(value != 1){
			getTescodata(value);
			}
	var loginBox = "#login-box";

		//Fade in the Popup and add close button
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;

	loadSearchPODetails();
	addItems();

}

function Nextadd(value, x)
{

	var HTMLText ="<div id=\"login-box\" class=\"login-popup\"><table width=\"800\" height=\"390\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
	" <tr>"+
	"	<td width=\"850\" bgcolor=\"#498CC2\" class=\"TitleN2white\" >NEXT</td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" border=\"0\">"+
	"	  <tr>"+
	"		<td class=\"normalfnt\">"+
	" <table width=\"100%\" height=\"25\" border=\"0\" class=\"bcgl1\">"+

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">SC No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"changeSCCombo(event);\" id=\"txtSCNo\" name=\"txtSCNo\" class=\"txtbox\" style=\"width:173px;\" onclick=\"abc_SCNo();\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Delivery</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDelivery\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Buyer Po No</td>"+
	"			<td width=\"15%\"><select id=\"txtBuyerPoNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" onchange=\"changePO();\"/></select></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Style No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtStyleNO\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Dept No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDeptNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GOH Y / N</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGOH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTNS</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">QTY</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtQty\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Net Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNetWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Gross Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGrossWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">CTN (L)</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (W)</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNW\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (H)</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit Price</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPrice\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GSP Status</td>"+
	"			<td width=\"15%\"><input type=\"checkbox\" id=\"GSPApproval\" name=\"GSP_Approval\" value=\"GSP_Approval\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Description of Items</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Fabric</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFabric\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Country</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCountry\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Factory</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFactory\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Ship mode</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtShipMode\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">EX FTY</td>"+
	"			<td width=\"15%\"><input name=\"txtEXFTY\" type=\"text\" class=\"txtbox\" id=\"txtEXFTY\" style=\"width:130px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Pord No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPordNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PO Description</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPODescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Knit / Woven</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtKnitWoven\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">FCL / LCL</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFCLLCL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit PCS / SETS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPCSSETS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Destination</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDestination\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CBM</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCBM\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PCS Per CTNS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPCSPerCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">NET WT P/PC</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNETWTPPC\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GRS WT P/Pc</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGRSWTPPc\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">NSL D/NO</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNSLDNO\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Item No</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtItemNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Contract No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtContractNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"
	if(x == "1"){
	HTMLText +="		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Factory Date</td>"+
	"			<td width=\"25%\" colspan=\"2\"><input name=\"txtFactoryDate\" type=\"text\" class=\"txtbox\" id=\"txtFactoryDate\" style=\"width:173px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	}
	HTMLText +="	</table></td>"+
	"  </tr>"+
	
	"    <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"  <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"	</table></td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"#D6E7F5\" align=\"center\" class=\"tableFooter\">"+


	"	  <tr>";
	//"		<td width=\"5%\" class=\"txtbox backcolorYellow\" ></td>"+
		if(x == "1"){
	if(value == "1"){
	HTMLText += "		<td align=\"right\"><img src=\"images/addsmall.png\" width=\"97\"  border=\"0\" onClick=\"addNext();\" /></td>";
	}else{
	HTMLText += "		<td align=\"right\" ><img src=\"images/editbut.jpg\" width=\"97\" height=\"23\" border=\"0\" onClick=\"editNext();\" /></td>";
	}
	}
	//"		<td width=\"15%\" class=\"normalfnt\">Completed Orders</td>"+
	HTMLText += "		<td align=\"right\"><img src=\"images/close.png\" width=\"97\"  border=\"0\" onClick=\"closeWindow();\" /></td>"+
	/*"		<td width=\"37%\">&nbsp;</td>"+*/
	"	  </tr>"+
	"	</table></td>"+
	" </tr>"+
	"</table></div>";
	document.getElementById('myResults').innerHTML=HTMLText;
		if(value != 1){
			getNextdata(value);
			}
	var loginBox = "#login-box";

		//Fade in the Popup and add close button
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;

	loadSearchPODetails();
	addItems();

}

function Sainsburyadd(value, x)
{

	var HTMLText ="<div id=\"login-box\" class=\"login-popup\"><table width=\"800\" height=\"390\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
	" <tr>"+
	"	<td width=\"850\" bgcolor=\"#498CC2\" class=\"TitleN2white\" >SAINSBURY</td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" border=\"0\">"+
	"	  <tr>"+
	"		<td class=\"normalfnt\">"+
	" <table width=\"100%\" height=\"25\" border=\"0\" class=\"bcgl1\">"+

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">SC No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"changeSCCombo(event);\" id=\"txtSCNo\" name=\"txtSCNo\" class=\"txtbox\" style=\"width:173px;\" onclick=\"abc_SCNo();\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Delivery</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDelivery\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Buyer Po No</td>"+
	"			<td width=\"15%\"><select id=\"txtBuyerPoNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" onchange=\"changePO();\"/></select></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Style No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtStyleNO\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Dept No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDeptNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GOH Y / N</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGOH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTNS</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">QTY</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtQty\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Net Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNetWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Gross Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGrossWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">CTN (L)</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (W)</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNW\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (H)</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit Price</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPrice\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GSP Status</td>"+
	"			<td width=\"15%\"><input type=\"checkbox\" id=\"GSPApproval\" name=\"GSP_Approval\" value=\"GSP_Approval\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Description of Items</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Fabric</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFabric\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Country</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCountry\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Factory</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFactory\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Ship mode</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtShipMode\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">EX FTY</td>"+
	"			<td width=\"15%\"><input name=\"txtEXFTY\" type=\"text\" class=\"txtbox\" id=\"txtEXFTY\" style=\"width:130px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Pord No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPordNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PO Description</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPODescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Knit / Woven</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtKnitWoven\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">FCL / LCL</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFCLLCL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit PCS / SETS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPCSSETS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Destination</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDestination\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CBM</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCBM\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PCS Per CTNS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPCSPerCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">NET WT P/PC</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNETWTPPC\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GRS WT P/Pc</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGRSWTPPc\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Color</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtColor\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Tu Po No</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtTuPoNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Tu Style</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtTuStyle\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PackType</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPackType\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	if(x == "1"){
	HTMLText +="		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Factory Date</td>"+
	"			<td width=\"25%\" colspan=\"2\"><input name=\"txtFactoryDate\" type=\"text\" class=\"txtbox\" id=\"txtFactoryDate\" style=\"width:173px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	}
	HTMLText +="	</table></td>"+
	"  </tr>"+
	
	"    <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"  <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"	</table></td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"#D6E7F5\" align=\"center\" class=\"tableFooter\">"+


	"	  <tr>";
	//"		<td width=\"5%\" class=\"txtbox backcolorYellow\" ></td>"+
		if(x == "1"){
	if(value == "1"){
	HTMLText += "		<td align=\"right\"><img src=\"images/addsmall.png\" width=\"97\"  border=\"0\" onClick=\"addSainsbury();\" /></td>";
	}else{
	HTMLText += "		<td align=\"right\" ><img src=\"images/editbut.jpg\" width=\"97\" height=\"23\" border=\"0\" onClick=\"editSainsbury();\" /></td>";
	}
	}
	//"		<td width=\"15%\" class=\"normalfnt\">Completed Orders</td>"+
	HTMLText += "		<td align=\"right\"><img src=\"images/close.png\" width=\"97\"  border=\"0\" onClick=\"closeWindow();\" /></td>"+
	/*"		<td width=\"37%\">&nbsp;</td>"+*/
	"	  </tr>"+
	"	</table></td>"+
	" </tr>"+
	"</table></div>";
	document.getElementById('myResults').innerHTML=HTMLText;
		if(value != 1){
			getSainsburydata(value);
			}
	var loginBox = "#login-box";

		//Fade in the Popup and add close button
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;

	loadSearchPODetails();
	addItems();

}

function FasionLabadd(value, x)
{

	var HTMLText ="<div id=\"login-box\" class=\"login-popup\"><table width=\"800\" height=\"390\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
	" <tr>"+
	"	<td width=\"850\" bgcolor=\"#498CC2\" class=\"TitleN2white\" >FASION LAB</td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" border=\"0\">"+
	"	  <tr>"+
	"		<td class=\"normalfnt\">"+
	" <table width=\"100%\" height=\"25\" border=\"0\" class=\"bcgl1\">"+

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">SC No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"changeSCCombo(event);\" id=\"txtSCNo\" name=\"txtSCNo\" class=\"txtbox\" style=\"width:173px;\" onclick=\"abc_SCNo();\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Delivery</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDelivery\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Buyer Po No</td>"+
	"			<td width=\"15%\"><select id=\"txtBuyerPoNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" onchange=\"changePO();\"/></select></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Style No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtStyleNO\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Dept No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDeptNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GOH Y / N</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGOH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTNS</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">QTY</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtQty\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Net Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNetWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Gross Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGrossWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">CTN (L)</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (W)</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNW\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (H)</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit Price</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPrice\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GSP Status</td>"+
	"			<td width=\"15%\"><input type=\"checkbox\" id=\"GSPApproval\" name=\"GSP_Approval\" value=\"GSP_Approval\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Description of Items</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Fabric</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFabric\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Country</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCountry\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Factory</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFactory\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Ship mode</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtShipMode\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">EX FTY</td>"+
	"			<td width=\"15%\"><input name=\"txtEXFTY\" type=\"text\" class=\"txtbox\" id=\"txtEXFTY\" style=\"width:130px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Pord No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPordNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PO Description</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPODescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Knit / Woven</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtKnitWoven\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">FCL / LCL</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFCLLCL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit PCS / SETS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPCSSETS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Destination</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDestination\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CBM</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCBM\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PCS Per CTNS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPCSPerCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">NET WT P/PC</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNETWTPPC\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GRS WT P/Pc</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGRSWTPPc\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Color</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtColor\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Tu Po No</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtTuPoNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Tu Style</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtTuStyle\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PackType</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPackType\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	if(x == "1"){
	HTMLText +="		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Factory Date</td>"+
	"			<td width=\"25%\" colspan=\"2\"><input name=\"txtFactoryDate\" type=\"text\" class=\"txtbox\" id=\"txtFactoryDate\" style=\"width:173px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	}
	HTMLText +="	</table></td>"+
	"  </tr>"+
	
	"    <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"  <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"	</table></td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"#D6E7F5\" align=\"center\" class=\"tableFooter\">"+


	"	  <tr>";
	//"		<td width=\"5%\" class=\"txtbox backcolorYellow\" ></td>"+
		if(x == "1"){
	if(value == "1"){
	HTMLText += "		<td align=\"right\"><img src=\"images/addsmall.png\" width=\"97\"  border=\"0\" onClick=\"addFasionLab();\" /></td>";
	}else{
	HTMLText += "		<td align=\"right\" ><img src=\"images/editbut.jpg\" width=\"97\" height=\"23\" border=\"0\" onClick=\"editFasionLab();\" /></td>";
	}
	}
	//"		<td width=\"15%\" class=\"normalfnt\">Completed Orders</td>"+
	HTMLText += "		<td align=\"right\"><img src=\"images/close.png\" width=\"97\"  border=\"0\" onClick=\"closeWindow();\" /></td>"+
	/*"		<td width=\"37%\">&nbsp;</td>"+*/
	"	  </tr>"+
	"	</table></td>"+
	" </tr>"+
	"</table></div>";
	document.getElementById('myResults').innerHTML=HTMLText;
		if(value != 1){
			getFasionLabdata(value);
			}
	var loginBox = "#login-box";

		//Fade in the Popup and add close button
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;

	loadSearchPODetails();
	addItems();
	
	
}

function OriginaMarinesadd(value, x)
{

	var HTMLText ="<div id=\"login-box\" class=\"login-popup\"><table width=\"800\" height=\"390\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
	" <tr>"+
	"	<td width=\"850\" bgcolor=\"#498CC2\" class=\"TitleN2white\" >ORIGINAL MARINES</td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" border=\"0\">"+
	"	  <tr>"+
	"		<td class=\"normalfnt\">"+
	" <table width=\"100%\" height=\"25\" border=\"0\" class=\"bcgl1\">"+

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">SC No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"changeSCCombo(event);\" id=\"txtSCNo\" name=\"txtSCNo\" class=\"txtbox\" style=\"width:173px;\" onclick=\"abc_SCNo();\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Delivery</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDelivery\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Buyer Po No</td>"+
	"			<td width=\"15%\"><select id=\"txtBuyerPoNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" onchange=\"changePO();\"/></select></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Style No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtStyleNO\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Dept No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDeptNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GOH Y / N</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGOH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTNS</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">QTY</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtQty\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Net Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNetWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Gross Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGrossWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">CTN (L)</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (W)</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNW\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (H)</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit Price</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPrice\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GSP Status</td>"+
	"			<td width=\"15%\"><input type=\"checkbox\" id=\"GSPApproval\" name=\"GSP_Approval\" value=\"GSP_Approval\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Description of Items</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Fabric</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFabric\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Country</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCountry\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Factory</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFactory\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Ship mode</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtShipMode\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">EX FTY</td>"+
	"			<td width=\"15%\"><input name=\"txtEXFTY\" type=\"text\" class=\"txtbox\" id=\"txtEXFTY\" style=\"width:130px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Pord No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPordNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PO Description</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPODescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Knit / Woven</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtKnitWoven\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">FCL / LCL</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFCLLCL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit PCS / SETS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPCSSETS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Destination</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDestination\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CBM</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCBM\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PCS Per CTNS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPCSPerCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">NET WT P/PC</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNETWTPPC\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GRS WT P/Pc</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGRSWTPPc\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Color</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtColor\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Tu Po No</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtTuPoNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Tu Style</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtTuStyle\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PackType</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPackType\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	if(x == "1"){
	HTMLText +="		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Factory Date</td>"+
	"			<td width=\"25%\" colspan=\"2\"><input name=\"txtFactoryDate\" type=\"text\" class=\"txtbox\" id=\"txtFactoryDate\" style=\"width:173px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	}
	HTMLText +="	</table></td>"+
	"  </tr>"+
	
	"    <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"  <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"	</table></td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"#D6E7F5\" align=\"center\" class=\"tableFooter\">"+


	"	  <tr>";
	//"		<td width=\"5%\" class=\"txtbox backcolorYellow\" ></td>"+
		if(x == "1"){
	if(value == "1"){
	HTMLText += "		<td align=\"right\"><img src=\"images/addsmall.png\" width=\"97\"  border=\"0\" onClick=\"addOriginaMarines();\" /></td>";
	}else{
	HTMLText += "		<td align=\"right\" ><img src=\"images/editbut.jpg\" width=\"97\" height=\"23\" border=\"0\" onClick=\"editOriginaMarines();\" /></td>";
	}
	}
	//"		<td width=\"15%\" class=\"normalfnt\">Completed Orders</td>"+
	HTMLText += "		<td align=\"right\"><img src=\"images/close.png\" width=\"97\"  border=\"0\" onClick=\"closeWindow();\" /></td>"+
	/*"		<td width=\"37%\">&nbsp;</td>"+*/
	"	  </tr>"+
	"	</table></td>"+
	" </tr>"+
	"</table></div>";
	document.getElementById('myResults').innerHTML=HTMLText;
	if(value != 1){
			getOriginaMarinesdata(value);
			}
	var loginBox = "#login-box";

		//Fade in the Popup and add close button
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;
	
	loadSearchPODetails();
	addItems();
	
}

function Bluesadd(value, x)
{

	var HTMLText ="<div id=\"login-box\" class=\"login-popup\"><table width=\"800\" height=\"390\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
	" <tr>"+
	"	<td width=\"850\" bgcolor=\"#498CC2\" class=\"TitleN2white\" >BLUES</td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" border=\"0\">"+
	"	  <tr>"+
	"		<td class=\"normalfnt\">"+
	" <table width=\"100%\" height=\"25\" border=\"0\" class=\"bcgl1\">"+

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">SC No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"changeSCCombo(event);\" id=\"txtSCNo\" name=\"txtSCNo\" class=\"txtbox\" style=\"width:173px;\" onclick=\"abc_SCNo();\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Delivery</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDelivery\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Buyer Po No</td>"+
	"			<td width=\"15%\"><select id=\"txtBuyerPoNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" onchange=\"changePO();\"/></select></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Style No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtStyleNO\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Dept No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDeptNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GOH Y / N</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGOH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTNS</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">QTY</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtQty\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Net Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNetWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Gross Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGrossWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">CTN (L)</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (W)</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNW\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (H)</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit Price</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPrice\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GSP Status</td>"+
	"			<td width=\"15%\"><input type=\"checkbox\" id=\"GSPApproval\" name=\"GSP_Approval\" value=\"GSP_Approval\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Description of Items</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Fabric</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFabric\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Country</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCountry\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Factory</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFactory\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Ship mode</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtShipMode\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">EX FTY</td>"+
	"			<td width=\"15%\"><input name=\"txtEXFTY\" type=\"text\" class=\"txtbox\" id=\"txtEXFTY\" style=\"width:130px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Pord No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPordNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PO Description</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPODescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Knit / Woven</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtKnitWoven\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">FCL / LCL</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFCLLCL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit PCS / SETS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPCSSETS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Destination</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDestination\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CBM</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCBM\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PCS Per CTNS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPCSPerCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">NET WT P/PC</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNETWTPPC\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GRS WT P/Pc</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGRSWTPPc\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Color</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtColor\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Tu Po No</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtTuPoNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Tu Style</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtTuStyle\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PackType</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPackType\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	if(x == "1"){
	HTMLText +="		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Factory Date</td>"+
	"			<td width=\"25%\" colspan=\"2\"><input name=\"txtFactoryDate\" type=\"text\" class=\"txtbox\" id=\"txtFactoryDate\" style=\"width:173px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	}
	HTMLText +="	</table></td>"+
	"  </tr>"+
	
	"    <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"  <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"	</table></td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"#D6E7F5\" align=\"center\" class=\"tableFooter\">"+


	"	  <tr>";
	//"		<td width=\"5%\" class=\"txtbox backcolorYellow\" ></td>"+
		if(x == "1"){
	if(value == "1"){
	HTMLText += "		<td align=\"right\"><img src=\"images/addsmall.png\" width=\"97\"  border=\"0\" onClick=\"addBlues();\" /></td>";
	}else{
	HTMLText += "		<td align=\"right\" ><img src=\"images/editbut.jpg\" width=\"97\" height=\"23\" border=\"0\" onClick=\"editBlues();\" /></td>";
	}
	}
	//"		<td width=\"15%\" class=\"normalfnt\">Completed Orders</td>"+
	HTMLText += "		<td align=\"right\"><img src=\"images/close.png\" width=\"97\"  border=\"0\" onClick=\"closeWindow();\" /></td>"+
	/*"		<td width=\"37%\">&nbsp;</td>"+*/
	"	  </tr>"+
	"	</table></td>"+
	" </tr>"+
	"</table></div>";
	document.getElementById('myResults').innerHTML=HTMLText;
	if(value != 1){
			getBluesdata(value);
			}
	var loginBox = "#login-box";

		//Fade in the Popup and add close button
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;
	
	loadSearchPODetails();
	addItems();
	
	
}

function Feildingadd(value, x)
{

	var HTMLText ="<div id=\"login-box\" class=\"login-popup\"><table width=\"800\" height=\"390\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
	" <tr>"+
	"	<td width=\"850\" bgcolor=\"#498CC2\" class=\"TitleN2white\" >FEILDING</td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" border=\"0\">"+
	"	  <tr>"+
	"		<td class=\"normalfnt\">"+
	" <table width=\"100%\" height=\"25\" border=\"0\" class=\"bcgl1\">"+

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">SC No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"changeSCCombo(event);\" id=\"txtSCNo\" name=\"txtSCNo\" class=\"txtbox\" style=\"width:173px;\" onclick=\"abc_SCNo();\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Delivery</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDelivery\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Buyer Po No</td>"+
	"			<td width=\"15%\"><select id=\"txtBuyerPoNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" onchange=\"changePO();\"/></select></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Style No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtStyleNO\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Dept No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDeptNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GOH Y / N</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGOH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTNS</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">QTY</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtQty\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Net Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNetWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Gross Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGrossWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">CTN (L)</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (W)</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNW\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (H)</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit Price</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPrice\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GSP Status</td>"+
	"			<td width=\"15%\"><input type=\"checkbox\" id=\"GSPApproval\" name=\"GSP_Approval\" value=\"GSP_Approval\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Description of Items</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Fabric</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFabric\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Country</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCountry\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Factory</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFactory\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Ship mode</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtShipMode\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">EX FTY</td>"+
	"			<td width=\"15%\"><input name=\"txtEXFTY\" type=\"text\" class=\"txtbox\" id=\"txtEXFTY\" style=\"width:130px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Pord No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPordNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PO Description</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPODescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Knit / Woven</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtKnitWoven\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">FCL / LCL</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFCLLCL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit PCS / SETS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPCSSETS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Destination</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDestination\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CBM</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCBM\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PCS Per CTNS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPCSPerCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">NET WT P/PC</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNETWTPPC\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GRS WT P/Pc</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGRSWTPPc\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Color</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtColor\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Tu Po No</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtTuPoNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Tu Style</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtTuStyle\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PackType</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPackType\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	if(x == "1"){
	HTMLText +="		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Factory Date</td>"+
	"			<td width=\"25%\" colspan=\"2\"><input name=\"txtFactoryDate\" type=\"text\" class=\"txtbox\" id=\"txtFactoryDate\" style=\"width:173px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	}
	HTMLText +="	</table></td>"+
	"  </tr>"+
	
	"    <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"  <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"	</table></td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"#D6E7F5\" align=\"center\" class=\"tableFooter\">"+


	"	  <tr>";
	//"		<td width=\"5%\" class=\"txtbox backcolorYellow\" ></td>"+
		if(x == "1"){
	if(value == "1"){
	HTMLText += "		<td align=\"right\"><img src=\"images/addsmall.png\" width=\"97\"  border=\"0\" onClick=\"addFeilding();\" /></td>";
	}else{
	HTMLText += "		<td align=\"right\" ><img src=\"images/editbut.jpg\" width=\"97\" height=\"23\" border=\"0\" onClick=\"editFeilding();\" /></td>";
	}
	}
	//"		<td width=\"15%\" class=\"normalfnt\">Completed Orders</td>"+
	HTMLText += "		<td align=\"right\"><img src=\"images/close.png\" width=\"97\"  border=\"0\" onClick=\"closeWindow();\" /></td>"+
	/*"		<td width=\"37%\">&nbsp;</td>"+*/
	"	  </tr>"+
	"	</table></td>"+
	" </tr>"+
	"</table></div>";
	document.getElementById('myResults').innerHTML=HTMLText;
	if(value != 1){
			getFeildingdata(value);
			}
	var loginBox = "#login-box";

		//Fade in the Popup and add close button
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;
	
	loadSearchPODetails();
	addItems();
	
}

function Nikeadd(value, x)
{

	var HTMLText ="<div id=\"login-box\" class=\"login-popup\"><table width=\"800\" height=\"390\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
	" <tr>"+
	"	<td width=\"850\" bgcolor=\"#498CC2\" class=\"TitleN2white\" >Nike</td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" border=\"0\">"+
	"	  <tr>"+
	"		<td class=\"normalfnt\">"+
	" <table width=\"100%\" height=\"25\" border=\"0\" class=\"bcgl1\">"+

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">SC No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"changeSCCombo(event);\" id=\"txtSCNo\" name=\"txtSCNo\" class=\"txtbox\" style=\"width:173px;\" onclick=\"abc_SCNo();\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Delivery</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDelivery\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Buyer Po No</td>"+
	"			<td width=\"15%\"><select id=\"txtBuyerPoNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" onchange=\"changePO();\"/></select></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Style No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtStyleNO\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Dept No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDeptNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GOH Y / N</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGOH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTNS</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">QTY</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtQty\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Net Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNetWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Gross Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGrossWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">CTN (L)</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (W)</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNW\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (H)</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit Price</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPrice\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GSP Status</td>"+
	"			<td width=\"15%\"><input type=\"checkbox\" id=\"GSPApproval\" name=\"GSP_Approval\" value=\"GSP_Approval\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Description of Items</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Fabric</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFabric\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Country</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCountry\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Factory</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFactory\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Ship mode</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtShipMode\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">EX FTY</td>"+
	"			<td width=\"15%\"><input name=\"txtEXFTY\" type=\"text\" class=\"txtbox\" id=\"txtEXFTY\" style=\"width:130px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Pord No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPordNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PO Description</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPODescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Knit / Woven</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtKnitWoven\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">FCL / LCL</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFCLLCL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit PCS / SETS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPCSSETS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Destination</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDestination\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CBM</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCBM\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PCS Per CTNS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPCSPerCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">NET WT P/PC</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNETWTPPC\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GRS WT P/Pc</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGRSWTPPc\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">NSL D/NO</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNSLDNO\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Item No</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtItemNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Contract No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtContractNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"
	if(x == "1"){
	HTMLText +="		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Factory Date</td>"+
	"			<td width=\"25%\" colspan=\"2\"><input name=\"txtFactoryDate\" type=\"text\" class=\"txtbox\" id=\"txtFactoryDate\" style=\"width:173px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	}
	HTMLText +="	</table></td>"+
	"  </tr>"+
	
	"    <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"  <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"	</table></td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"#D6E7F5\" align=\"center\" class=\"tableFooter\">"+


	"	  <tr>";
	//"		<td width=\"5%\" class=\"txtbox backcolorYellow\" ></td>"+
		if(x == "1"){
	if(value == "1"){
	HTMLText += "		<td align=\"right\"><img src=\"images/addsmall.png\" width=\"97\"  border=\"0\" onClick=\"addNike();\" /></td>";
	}else{
	HTMLText += "		<td align=\"right\" ><img src=\"images/editbut.jpg\" width=\"97\" height=\"23\" border=\"0\" onClick=\"editNike();\" /></td>";
	}
	}
	//"		<td width=\"15%\" class=\"normalfnt\">Completed Orders</td>"+
	HTMLText += "		<td align=\"right\"><img src=\"images/close.png\" width=\"97\"  border=\"0\" onClick=\"closeWindow();\" /></td>"+
	/*"		<td width=\"37%\">&nbsp;</td>"+*/
	"	  </tr>"+
	"	</table></td>"+
	" </tr>"+
	"</table></div>";
	document.getElementById('myResults').innerHTML=HTMLText;
	if(value != 1){
			getNikedata(value);
			}
	var loginBox = "#login-box";

		//Fade in the Popup and add close button
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;
	
	loadSearchPODetails();
	addItems();
	
}

function Levisadd(value, x)
{

	var HTMLText ="<div id=\"login-box\" class=\"login-popup\"><table width=\"800\" height=\"390\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
	" <tr>"+
	"	<td width=\"850\" bgcolor=\"#498CC2\" class=\"TitleN2white\" >LEVIS</td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" border=\"0\">"+
	"	  <tr>"+
	"		<td class=\"normalfnt\">"+
	" <table width=\"100%\" height=\"25\" border=\"0\" class=\"bcgl1\">"+

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">SC No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"changeSCCombo(event);\" id=\"txtSCNo\" name=\"txtSCNo\" class=\"txtbox\" style=\"width:173px;\" onclick=\"abc_SCNo();\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Delivery</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDelivery\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Buyer Po No</td>"+
	"			<td width=\"15%\"><select id=\"txtBuyerPoNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" onchange=\"changePO();\"/></select></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Style No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtStyleNO\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Dept No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDeptNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GOH Y / N</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGOH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTNS</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">QTY</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtQty\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Net Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNetWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Gross Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGrossWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">CTN (L)</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (W)</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNW\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (H)</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit Price</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPrice\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GSP Status</td>"+
	"			<td width=\"15%\"><input type=\"checkbox\" id=\"GSPApproval\" name=\"GSP_Approval\" value=\"GSP_Approval\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Description of Items</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Fabric</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFabric\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Country</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCountry\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Factory</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFactory\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Ship mode</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtShipMode\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">EX FTY</td>"+
	"			<td width=\"15%\"><input name=\"txtEXFTY\" type=\"text\" class=\"txtbox\" id=\"txtEXFTY\" style=\"width:130px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Pord No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPordNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PO Description</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPODescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Knit / Woven</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtKnitWoven\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">FCL / LCL</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFCLLCL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit PCS / SETS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPCSSETS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Destination</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDestination\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CBM</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCBM\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PCS Per CTNS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPCSPerCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	if(x == "1"){
	HTMLText +="		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Factory Date</td>"+
	"			<td width=\"25%\" colspan=\"2\"><input name=\"txtFactoryDate\" type=\"text\" class=\"txtbox\" id=\"txtFactoryDate\" style=\"width:173px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	}
	HTMLText +="	</table></td>"+
	"  </tr>"+
	
	"    <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"  <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"	</table></td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"#D6E7F5\" align=\"center\" class=\"tableFooter\">"+


	"	  <tr>";
	//"		<td width=\"5%\" class=\"txtbox backcolorYellow\" ></td>"+
		if(x == "1"){
	if(value == "1"){
	HTMLText += "		<td align=\"right\"><img src=\"images/addsmall.png\" width=\"97\"  border=\"0\" onClick=\"addLevis();\" /></td>";
	}else{
	HTMLText += "		<td align=\"right\" ><img src=\"images/editbut.jpg\" width=\"97\" height=\"23\" border=\"0\" onClick=\"editLevis();\" /></td>";
	}
	}
	//"		<td width=\"15%\" class=\"normalfnt\">Completed Orders</td>"+
	HTMLText += "		<td align=\"right\"><img src=\"images/close.png\" width=\"97\"  border=\"0\" onClick=\"closeWindow();\" /></td>"+
	/*"		<td width=\"37%\">&nbsp;</td>"+*/
	"	  </tr>"+
	"	</table></td>"+
	" </tr>"+
	"</table></div>";
	document.getElementById('myResults').innerHTML=HTMLText;
	if(value != 1){
			getLevisdata(value);
			}
	var loginBox = "#login-box";

		//Fade in the Popup and add close button
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;
	
	loadSearchPODetails();
	addItems();
	
}

function Asdaadd(value, x)
{

	var HTMLText ="<div id=\"login-box\" class=\"login-popup\"><table width=\"800\" height=\"390\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
	" <tr>"+
	"	<td width=\"850\" bgcolor=\"#498CC2\" class=\"TitleN2white\" >ASDA</td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" border=\"0\">"+
	"	  <tr>"+
	"		<td class=\"normalfnt\">"+
	" <table width=\"100%\" height=\"25\" border=\"0\" class=\"bcgl1\">"+

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">SC No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"changeSCCombo(event);\" id=\"txtSCNo\" name=\"txtSCNo\" class=\"txtbox\" style=\"width:173px;\" onclick=\"abc_SCNo();\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Delivery</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDelivery\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Buyer Po No</td>"+
	"			<td width=\"15%\"><select id=\"txtBuyerPoNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" onchange=\"changePO();\"/></select></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Style No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtStyleNO\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Dept No</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDeptNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GOH Y / N</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGOH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTNS</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">QTY</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtQty\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Net Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtNetWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Gross Weight</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtGrossWeight\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">CTN (L)</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (W)</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNW\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CTN (H)</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCTNH\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit Price</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPrice\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">GSP Status</td>"+
	"			<td width=\"15%\"><input type=\"checkbox\" id=\"GSPApproval\" name=\"GSP_Approval\" value=\"GSP_Approval\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Description of Items</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Fabric</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFabric\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Country</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCountry\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Factory</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFactory\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Ship mode</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtShipMode\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">EX FTY</td>"+
	"			<td width=\"15%\"><input name=\"txtEXFTY\" type=\"text\" class=\"txtbox\" id=\"txtEXFTY\" style=\"width:130px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Pord No</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPordNo\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PO Description</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPODescription\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Knit / Woven</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtKnitWoven\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">FCL / LCL</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtFCLLCL\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Unit PCS / SETS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtUnitPCSSETS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">Destination</td>"+
	"			<td width=\"15%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtDestination\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\">CBM</td>"+
	"			<td width=\"18%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtCBM\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td></tr>"+ 

	"		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">PCS Per CTNS</td>"+
	"			<td width=\"25%\"><input type=\"text\" onkeypress=\"EnableEnterSubmitLoadItems(event);\" id=\"txtPCSPerCTNS\" name=\"txtMatitemDes\" class=\"txtbox\" style=\"width:173px;\" /></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"15%\"></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	if(x == "1"){
	HTMLText +="		  <tr>"+
	"			<td width=\"5%\" height=\"21\" nowrap=\"nowrap\">Factory Date</td>"+
	"			<td width=\"25%\" colspan=\"2\"><input name=\"txtFactoryDate\" type=\"text\" class=\"txtbox\" id=\"txtFactoryDate\" style=\"width:173px; text-align:center;\" onclick=\"getdate(this.id)\"/></td>"+
	"			<td width=\"9%\" height=\"21\" nowrap=\"nowrap\"></td>"+
	"			<td width=\"18%\"></td></tr>"
	}
	HTMLText +="	</table></td>"+
	"  </tr>"+
	
	"    <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"  <tr>"+
	"	<td></td>"+
	"		</tr>"+
	"	</table></td>"+
	"  </tr>"+
	"  <tr>"+
	"	<td><table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"#D6E7F5\" align=\"center\" class=\"tableFooter\">"+


	"	  <tr>";
	//"		<td width=\"5%\" class=\"txtbox backcolorYellow\" ></td>"+
		if(x == "1"){
	if(value == "1"){
	HTMLText += "		<td align=\"right\"><img src=\"images/addsmall.png\" width=\"97\"  border=\"0\" onClick=\"addAsda();\" /></td>";
	}else{
	HTMLText += "		<td align=\"right\" ><img src=\"images/editbut.jpg\" width=\"97\" height=\"23\" border=\"0\" onClick=\"editAsda();\" /></td>";
	}
	}
	//"		<td width=\"15%\" class=\"normalfnt\">Completed Orders</td>"+
	HTMLText += "		<td align=\"right\"><img src=\"images/close.png\" width=\"97\"  border=\"0\" onClick=\"closeWindow();\" /></td>"+
	/*"		<td width=\"37%\">&nbsp;</td>"+*/
	"	  </tr>"+
	"	</table></td>"+
	" </tr>"+
	"</table></div>";
	document.getElementById('myResults').innerHTML=HTMLText;
	if(value != 1){
			getAsdadata(value);
			}
	var loginBox = "#login-box";

		//Fade in the Popup and add close button
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;
	
	loadSearchPODetails();
	addItems();
	
	
}
