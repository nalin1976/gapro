////////////JavaScript Document Created by lahiru rangana lahirurangana@gmail.com 2013-01-07////////////////////////////////
jQuery(document).scroll(function(){
  
	 setViewerPosition("eventViewerMainDiv",10,10);////(viewerId,x,y)
});

$(document).ready(function () {
	
 	 setViewerPosition("eventViewerMainDiv",10,10);			 
	 setTimeout("loadNoOfDelayedEvent();",200);
	 setTimeout("completeEventsBefore20130320();",400);
	 
});


function setViewerPosition(viewerId,x,y)
{
	//alert("mkk")
	var scrollX = getScrollX();
	var scrollY = getScrollY();
	document.getElementById(viewerId).style.top =(scrollY+y) +"px";	
	var viewportWidth  = screen.width;
	var viewportHeight = document.documentElement.clientHeight;
	var viewerHeight = document.getElementById(viewerId).clientHeight;
	var viewerWidth = document.getElementById(viewerId).clientWidth;
	document.getElementById(viewerId).style.top =((scrollY-y)+viewportHeight)-viewerHeight +"px";	
	document.getElementById(viewerId).style.left = ((viewportWidth-viewerWidth)-15)-y +"px";
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
