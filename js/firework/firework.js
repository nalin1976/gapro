////////////////////////////////////////////////////////////////
// Javascript made by Rasmus - http://www.peters1.dk //
////////////////////////////////////////////////////////////////

var FIRE_Path = "js/firework/"; // Path to the directory containing the firework-pictures
var FIRE_no = 10; // Numbers of Rockets in one firework
var FIRE_Pause = 5; // Pause between the fireworks in seconds
var FIRE_SameColor = false; // If true = The rockets have the same color in one firework

var FIRE_Time, FIRE_Bang, FIRE_Vindue_Width, FIRE_Vindue_Height;
var FIRE_PosLeft, FIRE_PosTop, FIRE_PosVenAfv, FIRE_PosTopAfv;
var i;
var FIRE_j = 0;

var FIRE_browser_IE_NS = (document.body.clientHeight) ? 1 : 0;
var FYR_browser_IE_SCM = (document.documentElement.clientHeight) ? 1 : 0;
var FIRE_browser_MOZ = (self.innerWidth) ? 1 : 0;

if (FIRE_browser_IE_NS)
{
	FIRE_Vindue_Width = document.body.clientWidth;
	FIRE_Vindue_Height = document.body.clientHeight;
}
else if (FYR_browser_IE_SCM)
{
	FIRE_Vindue_Width = document.documentElement.clientWidth;
	FIRE_Vindue_Height = document.documentElement.clientHeight;
}
else
{
	FIRE_Vindue_Width = self.innerWidth - 20;
	FIRE_Vindue_Height = self.innerHeight;
}

var FIRE_Top = 60;
var FIRE_Bot = FIRE_Vindue_Height ;
var FIRE_Mid = FIRE_Vindue_Width/2;

FIRE_PosLeft = new Array();
FIRE_PosTop = new Array();
FIRE_PosVenAfv = new Array();
FIRE_PosTopAfv = new Array();
FIRE_Time = new Array();
FIRE_TopBang = new Array();
FIRE_Billede = new Array();
FIRE_Farve = new Array("orange","blue","yellow","red","green");
FIRE_Pause = FIRE_Pause*1000;

for (i = 0; i < FIRE_no; ++ i) 
{  
	FIRE_TopBang[i] = FIRE_Top + Math.random()*200;
	FIRE_PosTop[i] = FIRE_Bot;
	FIRE_PosTopAfv[i] = 0;
	FIRE_PosLeft[i] = FIRE_Mid;
	if (i % 2 == 0) FIRE_PosVenAfv[i] = 4*Math.random(); 
	else FIRE_PosVenAfv[i] = Math.random()*(-4); 
	document.write("<\div id=\"FIRE_no"+ i +"\" style=\"position: absolute; font-size: 15px; z-index: "+ i +"; visibility: visible; top: "+FIRE_PosTop[i]+"px; left: "+FIRE_PosLeft[i]+"px;\"><a href=\"http://www.peters1.dk\" target=\"_blank\"><b>.</b></a><\/div>");
}


function FIRE_Op(FIRE_number)
{
	if (FIRE_PosTop[FIRE_number] > (FIRE_Top + FIRE_TopBang[FIRE_number])) 
	{
		FIRE_PosTop[FIRE_number] = FIRE_PosTop[FIRE_number] - FIRE_PosTopAfv[FIRE_number];
		FIRE_PosLeft[FIRE_number] = FIRE_PosLeft[FIRE_number] + FIRE_PosVenAfv[FIRE_number];
		FIRE_PosTopAfv[FIRE_number] = (FIRE_PosTop[FIRE_number]/40);
		document.getElementById("FIRE_no"+FIRE_number).style.top=FIRE_PosTop[FIRE_number]+"px";
		document.getElementById("FIRE_no"+FIRE_number).style.left=FIRE_PosLeft[FIRE_number]+"px";
		FIRE_Time[i] = setTimeout("FIRE_Op("+FIRE_number+")",10);
	}
	else
	{
		clearTimeout("FIRE_Time["+FIRE_number+"]");
		FIRE_ShowBang(FIRE_number);
	}
}

function FIRE_Start() 
{  

if (FIRE_SameColor)
{
if (FIRE_j == 4) FIRE_j = 0;
else FIRE_j = FIRE_j + 1;
}

for (i = 0; i < FIRE_no; i++) 
{ 
	if (!FIRE_SameColor)
	{
	FIRE_j = Math.round(Math.random() * 4); 
	}
	FIRE_Billede[i] = FIRE_Path+FIRE_Farve[FIRE_j]+".gif";
	document.getElementById("FIRE_no"+i).innerHTML = "<b>*</b>";
	document.getElementById("FIRE_no"+i).style.color=FIRE_Farve[FIRE_j];
	setTimeout("FIRE_Op("+i+")",(1500*Math.random()));
}
}

function FIRE_ShowBang(FIRE_number)
{
	if (FIRE_number == 0) document.getElementById("FIRE_no"+FIRE_number).innerHTML = "<a href=\"http://www.peters1.dk\" target=\"_blank\"><\img src=\""+FIRE_Billede[FIRE_number]+"\" border=\"0\" /></a>";
	else document.getElementById("FIRE_no"+FIRE_number).innerHTML = "<\img src=\""+FIRE_Billede[FIRE_number]+"\" border=\"0\" />";
	document.getElementById("FIRE_no"+FIRE_number).style.top=(FIRE_PosTop[FIRE_number] - 20)+"px";
	document.getElementById("FIRE_no"+FIRE_number).style.left=(FIRE_PosLeft[FIRE_number] - 40)+"px";
	setTimeout("FIRE_Reset("+FIRE_number+")",1000)
}

function FIRE_Reset(FIRE_number)
{
	FIRE_TopBang[FIRE_number] = FIRE_Top + Math.random()*100;
	FIRE_PosTop[FIRE_number] = FIRE_Bot;
	FIRE_PosTopAfv[FIRE_number] = 4;
	FIRE_PosLeft[FIRE_number] = FIRE_Mid;
	if (FIRE_number % 2 == 0) FIRE_PosVenAfv[FIRE_number] = 4*Math.random(); 
	else FIRE_PosVenAfv[FIRE_number] = Math.random()*(-4); 
	
	document.getElementById("FIRE_no"+FIRE_number).innerHTML = "";
	document.getElementById("FIRE_no"+FIRE_number).style.top=FIRE_PosTop[FIRE_number]+"px";
	document.getElementById("FIRE_no"+FIRE_number).style.left=FIRE_PosLeft[FIRE_number]+"px";

	if (FIRE_number == FIRE_no-1) setTimeout("FIRE_Start()",FIRE_Pause);
}

FIRE_Start();