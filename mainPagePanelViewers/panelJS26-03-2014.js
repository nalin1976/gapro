// JavaScript Document Created by lahiru rangana lahirurangana@gmail.com 2013-07-24
// NOTE - 	Please use ajax techknowlagy for loading data to panel.
//			If you dont use ajax techknowlegy for loading data to panel,Main page will be slow for loading.
// This panel was deverloped for the gapro system.

function viewPanel(panelName)
{
	//document.getElementById("mainPanelDiv").style.display = "block"; // view main panel
	hideAllPanel(); // If you added new panel,Please add panel into this function also.
	
	if(panelName=="Production"){
		document.getElementById("subPanel1").style.display = "block";			
	}else if(panelName=="TNA"){
		document.getElementById("subPanel2").style.display = "block";	
	}else if(panelName=="MRN"){
		document.getElementById("subPanel0").style.display = "block";	
	}else if(panelName=="PLAN"){
		document.getElementById("subPanel3").style.display = "block";	//2014-03-11====================================================
	}else{
		document.getElementById("subPane09").style.display = "block";
	}
	downMainPanel();		
}
function hideAllPanel()
{
	document.getElementById("subPanel0").style.display = "none";
	document.getElementById("subPanel1").style.display = "none";
	document.getElementById("subPanel2").style.display = "none";
	document.getElementById("subPanel3").style.display = "none";//2014-03-11====================================================
	/// Add new panel ///	
}

function setupPanelData()
{
	if(document.getElementById("subPanel1").style.display == "block"){		
		setSewingProductionPanel();///this fac ava in sewingProductionJS.js file			
	}else if(document.getElementById("subPanel2").style.display == "block"){
		eventSchedulePanel();
	}else if(document.getElementById("subPanel0").style.display == "block"){
		setPanelMRN();
	}else if(document.getElementById("subPanel3").style.display == "block"){//==========2014-03-11================================
		//setPanelPLAN();
	}else{
			}
}
function downMainPanel()
{/*
	$('#mainPanelDiv').slideDown('slow', function() {
		hidePanelMenu();
		setupPanelData();
		setMainPanelPosition();
	});*/
	setPanelPosition("mainPanelDiv",0);
	$('#mainPanelDiv').animate({height:"toggle", opacity:1},"slow", function() {
		setTimeout("hidePanelMenu();",50);
		setTimeout("setMainPanelPosition();",80);
		setTimeout("setupPanelData();",100);		
	});
}

function closePanel()
{
	/*$('#mainPanelDiv').slideUp('slow', function() {
		viewPanelMenu();
	});*/
	$('#mainPanelDiv').animate({height:"toggle", opacity:0.4},"slow", function() {
		viewPanelMenu();
	});
}

jQuery(document).scroll(function(){
  setPanelPosition("panelMenuDiv",-3);
  setMainPanelPosition();
	
});

$(document).ready(function () {
	viewPanelMenu();			
});


function setPanelPosition(viewerId,y)
{
	var scrollY = getScrollY();
	document.getElementById(viewerId).style.top = (scrollY+y) +"px";	
}

function setMainPanelPosition()
{
	if(document.getElementById("mainPanelDiv").style.display == "block"){
		setPanelPosition("mainPanelDiv",0);
	}	
}

//////// Panel Menu Begin ////////
function viewPanelMenu()
{	
	//var scrollY = getScrollY();
	//setTimeout("downPanelMenu(-35,"+(-3)+")",150);	
	downPanelMenu(-35,-3);
}
function downPanelMenu(i,m)
{
	document.getElementById("panelMenuDiv").style.display = "block";
	document.getElementById("panelMenuDiv").style.top = i + "px";
	var i=parseInt(i)+1;
	if(m>=i){
	var x = setTimeout("downPanelMenu("+i+","+m+");",10);
	}else{
	clearTimeout(x);
	return false;
	}
}
function hidePanelMenu()
{	
var menuTopPosition = parseInt(document.getElementById("panelMenuDiv").style.top);//alert(menuTopPosition);
	setTimeout("upPanelMenu("+menuTopPosition+",-35)",2);	
}
function upPanelMenu(i,m)
{	
	document.getElementById("panelMenuDiv").style.top = i + "px";
	var i=parseInt(i)-1;
	if(m<=i){
	var x = setTimeout("upPanelMenu("+i+","+m+");",10);
	}else{
	clearTimeout(x);
	document.getElementById("panelMenuDiv").style.display = "none";
	return false;
	}
}
//////// Panel Menu End ////////