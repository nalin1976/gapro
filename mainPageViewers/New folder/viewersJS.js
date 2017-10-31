////////////JavaScript Document Created by lahiru rangana lahirurangana@gmail.com 2013-01-07////////////////////////////////
//////////// Permission for popup ///////////////////////
var allowTnAPopupBox = false;
var allowReorderLevelPopupBox = false;

if(document.getElementById("hdPermisionTnaPopup").value==1){
allowTnAPopupBox = true; // permision take from main page hidden field
}
if(document.getElementById("hdPermisionRolPopup").value==1){
allowReorderLevelPopupBox = true; // permision take from main page hidden field
}
//alert(allowTnAPopupBox);
//alert(allowReorderLevelPopupBox);

//////////// Viewer Positions //////////////
var positionArray = [[15,10,0],[355,10,0],[700,10,0]];///array formate - [X,Y,Flag]
	
if(allowTnAPopupBox) 
{
	var position = getFreePosition(positionArray);
	var eventViewerX = position[0];
	var eventViewerY = position[1];
}else{
	var eventViewerX = 0;
	var eventViewerY = 0;
}

if(allowReorderLevelPopupBox)
{	
	var position = getFreePosition(positionArray);
	var rolViewerX = position[0];
	var rolViewerY = position[1];
}else{
	var rolViewerX = 0;
	var rolViewerY = 0;
}
////////////////////////////////////////////
function setPositionPopupBox()  /// main page onload call this function
{
	if(allowTnAPopupBox){ /// display TNA popup
	document.getElementById("eventViewerMainDiv").style.display = "block";
	}
	if(allowReorderLevelPopupBox){ /// display ROL popup
	document.getElementById("costViewerMainDiv").style.display = "block";
	}
	
	setViewerPosition('eventViewerMainDiv',eventViewerX,eventViewerY);
	setViewerPosition('costViewerMainDiv',rolViewerX,rolViewerY);
	setTimeout("loadNoOfDelayedEvent();",200);	
}

jQuery(document).scroll(function(){ /// when scroll browser 
  
	 setViewerPosition("eventViewerMainDiv",eventViewerX,eventViewerY);////(viewerId,x,y)
	 setViewerPosition("costViewerMainDiv",rolViewerX,rolViewerY);////(viewerId,x,y)
	 ///setViewerPosition("Example",500,10);////(viewerId,x,y) 
});

function setViewerPosition(viewerId,x,y)
{
	var scrollY = getScrollY();
	var viewportWidth  = screen.width;
	var viewportHeight = document.documentElement.clientHeight;
	var viewerHeight = document.getElementById(viewerId).clientHeight;
	var viewerWidth = document.getElementById(viewerId).clientWidth;
	document.getElementById(viewerId).style.top =((scrollY-y)+viewportHeight)-viewerHeight +"px";	
	document.getElementById(viewerId).style.left = ((viewportWidth-viewerWidth)-x)-y +"px";
}

function getScrollX()
{
  var scrOfX = 0;
  if( typeof( window.pageYOffset ) == 'number' ) {
	scrOfX = window.pageXOffset;
  } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
    scrOfX = document.body.scrollLeft;
  } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
    scrOfX = document.documentElement.scrollLeft;
  }
  return scrOfX ;
}

function getScrollY()
{
  var scrOfY = 0;
  if( typeof( window.pageYOffset ) == 'number' ) {
    scrOfY = window.pageYOffset;
  } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
    scrOfY = document.body.scrollTop;
  } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
    scrOfY = document.documentElement.scrollTop;
  }
  return scrOfY ;
}

function getFreePosition(positionArray)
{
	var freePosition = [0,0];
	for(var i=0; i<positionArray.length; i++){
		
		if(positionArray[i][2]==0){ /// get freee position
		freePosition[0] = positionArray[i][0];
		freePosition[1] = positionArray[i][1];
		positionArray[i][2] = 1;/// update flag(for idintify useed position)
		return freePosition;		
		}
	}
return freePosition;//if no position		
}

