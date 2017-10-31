<?php 
	$backwardseperator ='../';
	include "../Connector.php";
	
	$styleid   = $_POST['cboOrderNo'];
	$custid	   = $_POST['cboBuyerFind'];
	$stylename = $_POST['cboStyleNoFind'];
	$filename  = $_POST['filepath'];
	$custname  = $_POST['lblcust'];
	
	if($styleid!="")
	{	
		mkdir("../styleDocument/".$styleid,0777);
		mkdir("../styleDocument/".$styleid."/Sketch",0777);
		
		$target  = "../styleDocument/".$styleid."/Sketch/";
		move_uploaded_file($_FILES['filepath']['tmp_name'],$target."".$_FILES['filepath']['name']);
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Style Definition - Gapro GSL</title>
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />

<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="StyleDefinitionJS.js"></script>
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="preorder.js" type="text/javascript"></script>
<script type="text/javascript">
function setActiveStyleSheet(link, title) {
  var i, a, main;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
      a.disabled = true;
      if(a.getAttribute("title") == title) a.disabled = false;
    }
  }
  if (oldLink) oldLink.style.fontWeight = 'normal';
  oldLink = link;
  link.style.fontWeight = 'bold';
  return false;
}

// This function gets called when the end-user clicks on some date.
function selected(cal, date) {
  cal.sel.value = date; // just update the date in the input field.
  if (cal.dateClicked && (cal.sel.id == "sel1" || cal.sel.id == "sel3"))
    // if we add this call we close the calendar on single-click.
    // just to exemplify both cases, we are using this only for the 1st
    // and the 3rd field, while 2nd and 4th will still require double-click.
    cal.callCloseHandler();
}

// And this gets called when the end-user clicks on the _selected_ date,
// or clicks on the "Close" button.  It just hides the calendar without
// destroying it.
function closeHandler(cal) {
  cal.hide();                        // hide the calendar
//  cal.destroy();
  _dynarch_popupCalendar = null;
}


function showCalendar(id, format, showsTime, showsOtherMonths) {
  var el = document.getElementById(id);
  if (_dynarch_popupCalendar != null) {
    // we already have some calendar created
    _dynarch_popupCalendar.hide();                 // so we hide it first.
  } else {
    // first-time call, create the calendar.
    var cal = new Calendar(1, null, selected, closeHandler);
    // uncomment the following line to hide the week numbers
    // cal.weekNumbers = false;
    if (typeof showsTime == "string") {
      cal.showsTime = true;
      cal.time24 = (showsTime == "24");
    }
    if (showsOtherMonths) {
      cal.showsOtherMonths = true;
    }
    _dynarch_popupCalendar = cal;                  // remember it in the global var
    cal.setRange(1900, 2070);        // min/max year allowed.
    cal.create();
  }
  _dynarch_popupCalendar.setDateFormat(format);    // set the specified date format
  _dynarch_popupCalendar.parseDate(el.value);      // try to parse the text in field
  _dynarch_popupCalendar.sel = el;                 // inform it what input field we use

  // the reference element that we pass to showAtElement is the button that
  // triggers the calendar.  In this example we align the calendar bottom-right
  // to the button.
  _dynarch_popupCalendar.showAtElement(el.nextSibling, "Br");        // show the calendar

  return false;
}

var MINUTE = 60 * 1000;
var HOUR = 60 * MINUTE;
var DAY = 24 * HOUR;
var WEEK = 7 * DAY;


function isDisabled(date) {
  var today = new Date();
  return (Math.abs(date.getTime() - today.getTime()) / DAY) > 10;
}

function flatSelected(cal, date) {
  var el = document.getElementById("preview");
  el.innerHTML = date;
}

function showFlatCalendar() {
  var parent = document.getElementById("display");

  // construct a calendar giving only the "selected" handler.
  var cal = new Calendar(0, null, flatSelected);

  // hide week numbers
  cal.weekNumbers = false;

  // We want some dates to be disabled; see function isDisabled above
  cal.setDisabledHandler(isDisabled);
  cal.setDateFormat("%A, %B %e");

 
  cal.create(parent);

  // ... we can show it here.
  cal.show();
}


</script>




<style type="text/css">
	.style_border{height:auto; padding-bottom:5px; background:#FAD163; border:1px solid #cccccc;}
	.style_border2{height:auto; padding-bottom:5px; background:#FAD163; margin-top:1px; border:1px solid #cccccc;}
	.style_border3{height:85px; margin-top:1px; border:1px solid #cccccc; background:#FAD163;}
	#style_border5{height:45px; background:#FAD163; border:1px solid #cccccc;}
	.style_border4{height:45px; background:#FAD163; border:1px solid #cccccc;}
	.style_borderBlank{height:30px; background:#FAD163; margin-top:1px; border:1px solid #cccccc;}
</style>
<style type="text/css"><!--
      #container { position: relative; }
      #imageView { border: 1px solid #000; }
      #imageTemp { position: absolute; top: 1px; left: 1px; }
    --></style>
  <style type="text/css" charset="utf-8">/* See license.txt for terms of usage */

.firebugCanvas {

    position:fixed;

    top: 0;

    left: 0;

    display:none;

    border: 0 none;

    margin: 0;

    padding: 0;

    outline: 0;

    min-width: 0;

    max-width: none;

    min-height: 0;

    max-height: none;

    -moz-transform: rotate(0deg);

    -moz-transform-origin: 50% 50%;

}



.firebugCanvas:before, .firebugCanvas:after {

    content: "";

}



.firebugHighlight {

    z-index: 2147483646;

    position: fixed;

    background-color: #3875d7;

    opacity: 1;

    margin: 0;

    padding: 0;

    outline: 0;

    border: 0 none;

    min-width: 0;

    max-width: none;

    min-height: 0;

    max-height: none;

}



.firebugHighlight:before, .firebugHighlight:after {

    content: "";

}



.firebugLayoutBoxParent {

    z-index: 2147483646;

    position: fixed;

    background-color: transparent;

    border-top: 0 none;

    border-right: 1px dashed #E00 !important;

    border-bottom: 1px dashed #E00 !important;

    border-left: 0 none;

    margin: 0;

    padding: 0;

    outline: 0;

    min-width: 0;

    max-width: none;

    min-height: 0;

    max-height: none;

    -moz-transform: rotate(0deg);

    -moz-transform-origin: 50% 50%;

}



.firebugRuler {

    position: absolute;

    margin: 0;

    padding: 0;

    outline: 0;

    border: 0 none;

    opacity: 1;

    min-width: 0;

    max-width: none;

    min-height: 0;

    max-height: none;

    -moz-transform: rotate(0deg);

    -moz-transform-origin: 50% 50%;

}



.firebugRuler:before, .firebugRuler:after {

    content: "";

}



.firebugRulerH {

    top: -15px;

    left: 0;

    width: 100%;

    height: 14px;

    background: url("data:image/png,%89PNG%0D%0A%1A%0A%00%00%00%0DIHDR%00%00%13%88%00%00%00%0E%08%02%00%00%00L%25a%0A%00%00%00%04gAMA%00%00%D6%D8%D4OX2%00%00%00%19tEXtSoftware%00Adobe%20ImageReadyq%C9e%3C%00%00%04%F8IDATx%DA%EC%DD%D1n%E2%3A%00E%D1%80%F8%FF%EF%E2%AF2%95%D0D4%0E%C1%14%B0%8Fa-%E9%3E%CC%9C%87n%B9%81%A6W0%1C%A6i%9A%E7y%0As8%1CT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AATE9%FE%FCw%3E%9F%AF%2B%2F%BA%97%FDT%1D~K(%5C%9D%D5%EA%1B%5C%86%B5%A9%BDU%B5y%80%ED%AB*%03%FAV9%AB%E1%CEj%E7%82%EF%FB%18%BC%AEJ8%AB%FA'%D2%BEU9%D7U%ECc0%E1%A2r%5DynwVi%CFW%7F%BB%17%7Dy%EACU%CD%0E%F0%FA%3BX%FEbV%FEM%9B%2B%AD%BE%AA%E5%95v%AB%AA%E3E5%DCu%15rV9%07%B5%7F%B5w%FCm%BA%BE%AA%FBY%3D%14%F0%EE%C7%60%0EU%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5JU%88%D3%F5%1F%AE%DF%3B%1B%F2%3E%DAUCNa%F92%D02%AC%7Dm%F9%3A%D4%F2%8B6%AE*%BF%5C%C2Ym~9g5%D0Y%95%17%7C%C8c%B0%7C%18%26%9CU%CD%13i%F7%AA%90%B3Z%7D%95%B4%C7%60%E6E%B5%BC%05%B4%FBY%95U%9E%DB%FD%1C%FC%E0%9F%83%7F%BE%17%7DkjMU%E3%03%AC%7CWj%DF%83%9An%BCG%AE%F1%95%96yQ%0Dq%5Dy%00%3Et%B5'%FC6%5DS%95pV%95%01%81%FF'%07%00%00%00%00%00%00%00%00%00%F8x%C7%F0%BE%9COp%5D%C9%7C%AD%E7%E6%EBV%FB%1E%E0(%07%E5%AC%C6%3A%ABi%9C%8F%C6%0E9%AB%C0'%D2%8E%9F%F99%D0E%B5%99%14%F5%0D%CD%7F%24%C6%DEH%B8%E9rV%DFs%DB%D0%F7%00k%FE%1D%84%84%83J%B8%E3%BA%FB%EF%20%84%1C%D7%AD%B0%8E%D7U%C8Y%05%1E%D4t%EF%AD%95Q%BF8w%BF%E9%0A%BF%EB%03%00%00%00%00%00%00%00%00%00%B8vJ%8E%BB%F5%B1u%8Cx%80%E1o%5E%CA9%AB%CB%CB%8E%03%DF%1D%B7T%25%9C%D5(%EFJM8%AB%CC'%D2%B2*%A4s%E7c6%FB%3E%FA%A2%1E%80~%0E%3E%DA%10x%5D%95Uig%15u%15%ED%7C%14%B6%87%A1%3B%FCo8%A8%D8o%D3%ADO%01%EDx%83%1A~%1B%9FpP%A3%DC%C6'%9C%95gK%00%00%00%00%00%00%00%00%00%20%D9%C9%11%D0%C0%40%AF%3F%EE%EE%92%94%D6%16X%B5%BCMH%15%2F%BF%D4%A7%C87%F1%8E%F2%81%AE%AAvzr%DA2%ABV%17%7C%E63%83%E7I%DC%C6%0Bs%1B%EF6%1E%00%00%00%00%00%00%00%00%00%80cr%9CW%FF%7F%C6%01%0E%F1%CE%A5%84%B3%CA%BC%E0%CB%AA%84%CE%F9%BF)%EC%13%08WU%AE%AB%B1%AE%2BO%EC%8E%CBYe%FE%8CN%ABr%5Dy%60~%CFA%0D%F4%AE%D4%BE%C75%CA%EDVB%EA(%B7%F1%09g%E5%D9%12%00%00%00%00%00%00%00%00%00H%F6%EB%13S%E7y%5E%5E%FB%98%F0%22%D1%B2'%A7%F0%92%B1%BC%24z3%AC%7Dm%60%D5%92%B4%7CEUO%5E%F0%AA*%3BU%B9%AE%3E%A0j%94%07%A0%C7%A0%AB%FD%B5%3F%A0%F7%03T%3Dy%D7%F7%D6%D4%C0%AAU%D2%E6%DFt%3F%A8%CC%AA%F2%86%B9%D7%F5%1F%18%E6%01%F8%CC%D5%9E%F0%F3z%88%AA%90%EF%20%00%00%00%00%00%00%00%00%00%C0%A6%D3%EA%CFi%AFb%2C%7BB%0A%2B%C3%1A%D7%06V%D5%07%A8r%5D%3D%D9%A6%CAu%F5%25%CF%A2%99%97zNX%60%95%AB%5DUZ%D5%FBR%03%AB%1C%D4k%9F%3F%BB%5C%FF%81a%AE%AB'%7F%F3%EA%FE%F3z%94%AA%D8%DF%5B%01%00%00%00%00%00%00%00%00%00%8E%FB%F3%F2%B1%1B%8DWU%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*UiU%C7%BBe%E7%F3%B9%CB%AAJ%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5J%95*U%AAT%A9R%A5*%AAj%FD%C6%D4%5Eo%90%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5%86%AF%1B%9F%98%DA%EBm%BBV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%ADV%AB%D5j%B5Z%AD%D6%E4%F58%01%00%00%00%00%00%00%00%00%00%00%00%00%00%40%85%7F%02%0C%008%C2%D0H%16j%8FX%00%00%00%00IEND%AEB%60%82") repeat-x;

    border-top: 1px solid #BBBBBB;

    border-right: 1px dashed #BBBBBB;

    border-bottom: 1px solid #000000;

}



.firebugRulerV {

    top: 0;

    left: -15px;

    width: 14px;

    height: 100%;

    background: url("data:image/png,%89PNG%0D%0A%1A%0A%00%00%00%0DIHDR%00%00%00%0E%00%00%13%88%08%02%00%00%00%0E%F5%CB%10%00%00%00%04gAMA%00%00%D6%D8%D4OX2%00%00%00%19tEXtSoftware%00Adobe%20ImageReadyq%C9e%3C%00%00%06~IDATx%DA%EC%DD%D1v%A20%14%40Qt%F1%FF%FF%E4%97%D9%07%3BT%19%92%DC%40(%90%EEy%9A5%CB%B6%E8%F6%9Ac%A4%CC0%84%FF%DC%9E%CF%E7%E3%F1%88%DE4%F8%5D%C7%9F%2F%BA%DD%5E%7FI%7D%F18%DDn%BA%C5%FB%DF%97%BFk%F2%10%FF%FD%B4%F2M%A7%FB%FD%FD%B3%22%07p%8F%3F%AE%E3%F4S%8A%8F%40%EEq%9D%BE8D%F0%0EY%A1Uq%B7%EA%1F%81%88V%E8X%3F%B4%CEy%B7h%D1%A2E%EBohU%FC%D9%AF2fO%8BBeD%BE%F7X%0C%97%A4%D6b7%2Ck%A5%12%E3%9B%60v%B7r%C7%1AI%8C%BD%2B%23r%00c0%B2v%9B%AD%CA%26%0C%1Ek%05A%FD%93%D0%2B%A1u%8B%16-%95q%5Ce%DCSO%8E%E4M%23%8B%F7%C2%FE%40%BB%BD%8C%FC%8A%B5V%EBu%40%F9%3B%A72%FA%AE%8C%D4%01%CC%B5%DA%13%9CB%AB%E2I%18%24%B0n%A9%0CZ*Ce%9C%A22%8E%D8NJ%1E%EB%FF%8F%AE%CAP%19*%C3%BAEKe%AC%D1%AAX%8C*%DEH%8F%C5W%A1e%AD%D4%B7%5C%5B%19%C5%DB%0D%EF%9F%19%1D%7B%5E%86%BD%0C%95%A12%AC%5B*%83%96%CAP%19%F62T%86%CAP%19*%83%96%CA%B8Xe%BC%FE)T%19%A1%17xg%7F%DA%CBP%19*%C3%BA%A52T%86%CAP%19%F62T%86%CA%B0n%A9%0CZ%1DV%C6%3D%F3%FCH%DE%B4%B8~%7F%5CZc%F1%D6%1F%AF%84%F9%0F6%E6%EBVt9%0E~%BEr%AF%23%B0%97%A12T%86%CAP%19%B4T%86%CA%B8Re%D8%CBP%19*%C3%BA%A52huX%19%AE%CA%E5%BC%0C%7B%19*CeX%B7h%A9%0C%95%E1%BC%0C%7B%19*CeX%B7T%06%AD%CB%5E%95%2B%BF.%8F%C5%97%D5%E4%7B%EE%82%D6%FB%CF-%9C%FD%B9%CF%3By%7B%19%F62T%86%CA%B0n%D1R%19*%A3%D3%CA%B0%97%A12T%86uKe%D0%EA%B02*%3F1%99%5DB%2B%A4%B5%F8%3A%7C%BA%2B%8Co%7D%5C%EDe%A8%0C%95a%DDR%19%B4T%C66%82fA%B2%ED%DA%9FC%FC%17GZ%06%C9%E1%B3%E5%2C%1A%9FoiB%EB%96%CA%A0%D5qe4%7B%7D%FD%85%F7%5B%ED_%E0s%07%F0k%951%ECr%0D%B5C%D7-g%D1%A8%0C%EB%96%CA%A0%A52T%C6)*%C3%5E%86%CAP%19%D6-%95A%EB*%95q%F8%BB%E3%F9%AB%F6%E21%ACZ%B7%22%B7%9B%3F%02%85%CB%A2%5B%B7%BA%5E%B7%9C%97%E1%BC%0C%EB%16-%95%A12z%AC%0C%BFc%A22T%86uKe%D0%EA%B02V%DD%AD%8A%2B%8CWhe%5E%AF%CF%F5%3B%26%CE%CBh%5C%19%CE%CB%B0%F3%A4%095%A1%CAP%19*Ce%A8%0C%3BO*Ce%A8%0C%95%A12%3A%AD%8C%0A%82%7B%F0v%1F%2FD%A9%5B%9F%EE%EA%26%AF%03%CA%DF9%7B%19*Ce%A8%0C%95%A12T%86%CA%B8Ze%D8%CBP%19*Ce%A8%0C%95%D1ae%EC%F7%89I%E1%B4%D7M%D7P%8BjU%5C%BB%3E%F2%20%D8%CBP%19*Ce%A8%0C%95%A12T%C6%D5*%C3%5E%86%CAP%19*Ce%B4O%07%7B%F0W%7Bw%1C%7C%1A%8C%B3%3B%D1%EE%AA%5C%D6-%EBV%83%80%5E%D0%CA%10%5CU%2BD%E07YU%86%CAP%19*%E3%9A%95%91%D9%A0%C8%AD%5B%EDv%9E%82%FFKOee%E4%8FUe%A8%0C%95%A12T%C6%1F%A9%8C%C8%3D%5B%A5%15%FD%14%22r%E7B%9F%17l%F8%BF%ED%EAf%2B%7F%CF%ECe%D8%CBP%19*Ce%A8%0C%95%E1%93~%7B%19%F62T%86%CAP%19*Ce%A8%0C%E7%13%DA%CBP%19*Ce%A8%0CZf%8B%16-Z%B4h%D1R%19f%8B%16-Z%B4h%D1R%19%B4%CC%16-Z%B4h%D1R%19%B4%CC%16-Z%B4h%D1%A2%A52%CC%16-Z%B4h%D1%A2%A52h%99-Z%B4h%D1%A2%A52h%99-Z%B4h%D1%A2EKe%98-Z%B4h%D1%A2EKe%D02%5B%B4h%D1%A2EKe%D02%5B%B4h%D1%A2E%8B%96%CA0%5B%B4h%D1%A2E%8B%96%CA%A0e%B6h%D1%A2E%8B%96%CA%A0e%B6h%D1%A2E%8B%16-%95a%B6h%D1%A2E%8B%16-%95A%CBl%D1%A2E%8B%16-%95A%CBl%D1%A2E%8B%16-Z*%C3l%D1%A2E%8B%16-Z*%83%96%D9%A2E%8B%16-Z*%83%96%D9%A2E%8B%16-Z%B4T%86%D9%A2E%8B%16-Z%B4T%06-%B3E%8B%16-Z%B4T%06-%B3E%8B%16-Z%B4h%A9%0C%B3E%8B%16-Z%B4h%A9%0CZf%8B%16-Z%B4h%A9%0CZf%8B%16-Z%B4h%D1R%19f%8B%16-Z%B4h%D1R%19%B4%CC%16-Z%B4h%D1R%19%B4%CC%16-Z%B4h%D1%A2%A52%CC%16-Z%B4h%D1%A2%A52h%99-Z%B4h%D1%A2%A52h%99-Z%B4h%D1%A2EKe%98-Z%B4h%D1%A2EKe%D02%5B%B4h%D1%A2EKe%D02%5B%B4h%D1%A2E%8B%96%CA0%5B%B4h%D1%A2E%8B%96%CA%A0e%B6h%D1%A2E%8B%96%CA%A0e%B6h%D1%A2E%8B%16-%95a%B6h%D1%A2E%8B%16-%95A%CBl%D1%A2E%8B%16-%95A%CBl%D1%A2E%8B%16-Z*%C3l%D1%A2E%8B%16-Z*%83%96%D9%A2E%8B%16-Z*%83%96%D9%A2E%8B%16-Z%B4T%86%D9%A2E%8B%16-Z%B4T%06-%B3E%8B%16-Z%B4T%06-%B3E%8B%16-Z%B4h%A9%0C%B3E%8B%16-Z%B4h%A9%0CZf%8B%16-Z%B4h%A9%0CZf%8B%16-Z%B4h%D1R%19f%8B%16-Z%B4h%D1R%19%B4%CC%16-Z%B4h%D1R%19%B4%CC%16-Z%B4h%D1%A2%A52%CC%16-Z%B4h%D1%A2%A52h%99-Z%B4h%D1%A2%A52h%99-Z%B4h%D1%A2EKe%98-Z%B4h%D1%A2EKe%D02%5B%B4h%D1%A2EKe%D02%5B%B4h%D1%A2E%8B%96%CA0%5B%B4h%D1%A2E%8B%96%CA%A0e%B6h%D1%A2E%8B%96%CA%A0e%B6h%D1%A2E%8B%16-%95a%B6h%D1%A2E%8B%16-%95A%CBl%D1%A2E%8B%16-%95A%CBl%D1%A2E%8B%16-Z*%C3l%D1%A2E%8B%16-Z*%83%96%D9%A2E%8B%16-Z*%83%96%D9%A2E%8B%16-Z%B4T%86%D9%A2E%8B%16-Z%B4T%06-%B3E%8B%16-Z%B4%AE%A4%F5%25%C0%00%DE%BF%5C'%0F%DA%B8q%00%00%00%00IEND%AEB%60%82") repeat-y;

    border-left: 1px solid #BBBBBB;

    border-right: 1px solid #000000;

    border-bottom: 1px dashed #BBBBBB;

}



.overflowRulerX > .firebugRulerV {

    left: 0;

}



.overflowRulerY > .firebugRulerH {

    top: 0;

}



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

.firebugLayoutBox {

    margin: 0;

    padding: 0;

    border: 0 none;

    opacity: 1;

    outline: 0;

    width: auto;

    min-width: 0;

    max-width: none;

    min-height: 0;

    max-height: none;

    -moz-transform: rotate(0deg);

    -moz-transform-origin: 50% 50%;

}



.firebugLayoutBox:before, .firebugLayoutBox:after {

    content: "";

}



.firebugLayoutBoxOffset {

    z-index: 2147483646;

    position: fixed;

    opacity: 0.8;

}



.firebugLayoutBoxMargin {

    background-color: #EDFF64;

}



.firebugLayoutBoxBorder {

    background-color: #666666;

}



.firebugLayoutBoxPadding {

    background-color: SlateBlue;

}



.firebugLayoutBoxContent {

    background-color: SkyBlue;

}



.firebugLayoutLine {

    z-index: 2147483646;

    background-color: #000000;

    opacity: 0.4;

    margin: 0;

    padding: 0;

    outline: 0;

    border: 0 none;

    min-width: 0;

    max-width: none;

    min-height: 0;

    max-height: none;

    -moz-transform: rotate(0deg);

    -moz-transform-origin: 50% 50%;

}



.firebugLayoutLine:before, .firebugLayoutLine:after {

    content: "";

}



.firebugLayoutLineLeft, .firebugLayoutLineRight {

    position: fixed;

    width: 1px;

    height: 100%;

}



.firebugLayoutLineTop, .firebugLayoutLineBottom {

    position: fixed;

    width: 100%;

    height: 1px;

}


.curpencil {

   cursor:url(images/pencil.jpg);
   

}


.curline {

    margin-top: -1px;

    border-top: 1px solid #999999;

}

.currect {

    margin-top: -1px;

    border-top: 1px solid #999999;

}

.cureracer {

    margin-top: -1px;

    border-top: 1px solid #999999;

}


.firebugLayoutLineTop {

    margin-top: -1px;

    border-top: 1px solid #999999;

}



.firebugLayoutLineRight {

    border-right: 1px solid #999999;

}



.firebugLayoutLineBottom {

    border-bottom: 1px solid #999999;

}



.firebugLayoutLineLeft {

    margin-left: -1px;

    border-left: 1px solid #999999;

}



.fbProxyElement {

    position: absolute;

    background-color: transparent;

    z-index: 2147483646;

    margin: 0;

    padding: 0;

    outline: 0;

    border: 0 none;

}

#cat1{float:left;}
#cat2{float:left;}
#cat3{float:left;}

</style>

<style type="text/css">
        input.prompt {border:1 solid transparent; background-color:#99ccff;width:70;font-family:arial;font-size:12; color:black;}
        td.titlebar { background-color:#2b765F; color:#0000D2; font-weight:bold;font-family:arial; font-size:12;}
        table.promptbox {border:1 solid #ccccff; background-color:#FFFFE6; color:black;padding-left:2;padding-right:2;padding-bottom:2;font-family:arial; font-size:12;}
        input.promptbox {border:1 solid #0000FF; background-color:white;width:100%;font-family:arial;font-size:12; color:black; }
    </style>
    
    <script language='javascript'>
        
        var response = null
            function prompt2(dftvalue, prompttitle, message, sendto) {
                promptbox = document.createElement('div');
                promptbox.setAttribute ('id' , 'prompt')
                    document.getElementsByTagName('body')[0].appendChild(promptbox)
                    promptbox = eval("document.getElementById('prompt').style")
                    promptbox.position = 'absolute'
                      promptbox.top = 50
                    promptbox.left = 50
                    promptbox.width = 300
                    promptbox.border = 'outset 1 #bbbbbb'
                    document.getElementById('prompt').innerHTML = "<table cellspacing='0' cellpadding='0' border='0' width='100%'><tr valign='middle'><td width='22' height='22' style='text-indent:2;' class='titlebar'></td><td class='titlebar'>" + prompttitle + "</td></tr></table>"
                    document.getElementById('prompt').innerHTML = document.getElementById('prompt').innerHTML + "<table cellspacing='0' cellpadding='0' border='0' width='100%' class='promptbox'><tr><td>" + message + "</td></tr><tr><td><input type='text' value='" + dftvalue + "' id='promptbox' onblur='this.focus()' class='promptbox'></td></tr><tr><td align='right'><br><input type='button' class='prompt' value='OK' onMouseOver='this.style.border=\"1 outset #dddddd\"' onMouseOut='this.style.border=\"1 solid transparent\"' onClick='return document.getElementById(\"promptbox\").value; document.getElementsByTagName(\"body\")[0].removeChild(document.getElementById(\"prompt\"))'> <input type='button' class='prompt' value='Cancel' onMouseOver='this.style.border=\"1 outset transparent\"' onMouseOut='this.style.border=\"1 solid transparent\"' onClick='" + sendto + "(\"\"); document.getElementsByTagName(\"body\")[0].removeChild(document.getElementById(\"prompt\"))'></td></tr></table>"
                    document.getElementById("promptbox").focus();
                }

        function myfunction(value) {
            if(value.length<=0)
                return false;
				
			else
				return value;
            
        }
		
		

    </script>
    
    <script language='javascript'>
    
       

        function callPrompt(){
        
            
            
            prompt2('','Text Box','Enter your text :', 'myfunction');
        }

        
    </script>
</head>

<body>
<form id="frmsampledef" name="frmsampledef" enctype="multipart/form-data" method="post" action="orderInquiry.php">

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator.'Header.php'; ?> </td>
  </tr>
</table>

<div>
	<div align="center">
		<div class="trans_layoutLayout" style="padding-bottom:20px;">
			<div class="trans_text">Style Definition<span class="volu"></span></div>
			
			<!--////////////////////MAIN DIV\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->
			<div style="width:auto; height:auto">
			
			
				<!--////////////////////LEFT DIV\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->
				<div id="cat1" style="padding:1px; width:951px; height:932px; border:1px solid #cccccc;">
					<div class="style_border4" style="float:left; margin-left:1px; width:317px;">
                    	<label class="normalfnt" style="margin-left:2px;">
							<div align="left"><span class="normalfnt">Customer :</span></div>
						</label>
                    <div> 
					    <select name="cboBuyerFind" class="txtbox" id="cboBuyerFind" style="width:175px" onchange="LoadStyleCustomer();loadBuyerwiseOrderNo();addlable();">
                      <option value="" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT intBuyerID, strName FROM buyers where intStatus=1 order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		
		if($custid==$row["intBuyerID"])
		{
			echo "<option selected value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		}
	}
	
	?>
            </select>
						
			    </div> </div>
					<div class="style_border4" style="float:left; margin-left:1px; width:317px;">
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left"><span class="normalfnt">Style No</span> :</div>
						</label>
						<div> 
							<?php
								$sqlall = "SELECT * FROM orders WHERE intStyleId=$styleid AND intStatus=2";
					
								$resultall 	= $db->RunQuery($sqlall);
								$rowall 	= mysql_fetch_array($resultall)
							?>
							<select name="cboStyleNoFind" class="txtbox" id="cboStyleNoFind" style="width:150px" onchange="changeOrderNo(); ">
			<option value="" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT distinct strStyle FROM orders where intStatus='2' order by strStyle;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		if($stylename==$row["strStyle"])
		{
			echo "<option selected value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
		}
	}
	
	?>
            </select>
						</div></div>
                        
                        <div class="style_border4" style="float:left; margin-left:1px; width:305px;">
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left"><span class="normalfnt">Order No</span> :</div>
						</label>
						<div> 
							<?php
								$sql2 = "SELECT * FROM samplestyles WHERE samplestyles.intstyleid=$styleid";
					
								$result = $db->RunQuery($sql2);
								$row = mysql_fetch_array($result)
							?>
							<select name="cboOrderNo" class="txtbox" id="cboOrderNo" style="width:150px" onchange="loadSketch();">
			<option value="" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT  intStyleId,strOrderNo FROM orders where intStatus='2' order by strOrderNo";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{	
		if($styleid==$row["intStyleId"])
		{
			echo "<option selected value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		}
	}
	
	?>
            </select>
            
            </div>
						
					</div>
					<div  style=" background:#FBF8B3; margin-top:50px; height:880px; border:1px solid #cccccc; width:950px;">
						
							<?php
							if($styleid!="")
							{	
								$filePath='../styleDocument/'.$styleid.'/Sketch/'; 
					
								$dir = opendir($filePath); 
					
								while ($file = readdir($dir)) 
								{ 
									if (eregi("(.+\.jpg)|(.+\.JPG)|(.+\.jpeg)|(.+\.JPEG)|(.+\.gif)|(.+\.GIF)|(.+\.bmp)|(.+\.BMP)|(.+\.png)|(.+\.PNG)",$file)) 
									{ 
								?>
							<table align="center" style="margin-top:5px; margin-left:30px; border:1px solid #ffffff; background:#FAD163;">
								<tr>
                                <td><img src="images/textedit.jpg" onclick="showFonts();"name="text" width="26" height="25" id="text" style="border:1px solid #666666; -moz-border-radius:3px; padding:1px;" title="Text Area"/></td>
									<td><img onclick="hiddenFonts();" width="26" height="25" style="border:1px solid #666666; -moz-border-radius:3px; padding:1px;" src="images/pencil.jpg" title="Pencil" id="pencil"/></td>
									<td><img onclick="hiddenFonts();" width="26" height="25" style="border:1px solid #666666; -moz-border-radius:3px; padding:1px;" src="images/line.jpg" title="Draw Line" id="line"/></td>
									<td><img onclick="hiddenFonts();" width="26" height="25" style="border:1px solid #666666; -moz-border-radius:3px; padding:1px;" src="images/sqaure.jpg" title="Draw Sqaure" id="rect"/></td>
									<td><img onclick="hiddenFonts();" width="26" height="25" style="border:1px solid #666666; -moz-border-radius:3px; padding:1px;" src="images/eraser.jpg" title="Eraser" id="eracer"/></td>
									<td><img style="border:1px solid #666666; -moz-border-radius:3px; padding:1px;" src="images/picsave.jpg" title="Save Image" onclick="saveImg();"/></td>
								</tr>
                                <tr>
                               	  <td colspan="10">
                                    	<select id="cbofontsize" style="width:40px; text-align:left; height:20px; visibility:hidden">
                                    		<option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                            <option value="31">31</option>
                                            <option value="32">32</option>
                                            <option value="33">33</option>
                                            <option value="34">34</option>
                                            <option value="35">35</option>  
                                    	</select>
                                	<select id="cbofontname" style="width:80px; text-align:left; visibility:hidden;">
                                    		<option value="Arial" style="font-family:'Arial'">Arial</option>
                                            <option value="Arial Black" style="font-family:'Arial Black'">Arial Black</option>
                                            <option value="Bernard MT Condensed" style="font-family:'Bernard MT Condensed'">Bernard MT Condensed</option>
                                            <option value="Wide Latin" style="font-family:'Wide Latin'">Wide Latin</option>
                                            <option value="Blackadder ITC" style="font-family:'Blackadder ITC'">Blackadder ITC</option>
                                            <option value="Forte" style="font-family:'Forte'">Forte</option>
                                            <option value="Rockwell Extra Bold" style="font-family:'Rockwell Extra Bold'">Rockwell Extra Bold</option>
                                            <option value="Cooper Black" style="font-family:'Cooper Black'">Cooper Black</option>
                                            
                                   	  </select>
                                  	<img src="images/text_bold.jpg" class="mainImage" name="bold1" width="18" height="21" align="texttop" id="bold1" style="visibility:hidden; border:1px solid #666666; -moz-border-radius:3px; padding:1px;" title="Bold" />
                                  	<img src="images/text_italic.jpg" class="mainImage" name="italic1" width="18" align="texttop" height="21" id="italic1" style="visibility:hidden; border:1px solid #666666; -moz-border-radius:3px; padding:1px;" title="Italic"/>
                                  	<img src="images/text_underline.jpg" class="mainImage" name="underline1" align="texttop" width="18" height="21" id="underline1" style=" visibility:hidden; border:1px solid #666666; -moz-border-radius:3px; padding:1px;" title="Underline"/>
                                    </td>
                                    <td>
                                    
                                    </td>
                              </tr>
							</table>
										<div class="pd_hold">   
				              <label id="labfilename" style="visibility:hidden"><?php echo $file;?></label>     			
											<div id="container" >
									
												<canvas class="curpencil" id="imageView" width="950" height="785"></canvas>
												<!--<canvas id="imageTemp"></canvas>-->
                                            </div>
												<script type="text/javascript" src="example5.js"></script>
									
												<img class="mainImage" id="imgid" name="<?php echo $file; $currentfile=$file;?>" 
												src="<?php echo $filePath."".$file;?>" alt="" style="visibility:hidden"/>&nbsp;&nbsp;<br />
												
											</div>               
										</div>
					
								<?php 
									}
								}
							}
							?>
						</div>
				</div><!--////////////////////left div close tag\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->
				
				
				<!--////////////////////RIGHT DIV\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->
				<div id="cat2" style="padding:1px; margin-left:5px; width:235px; height:932px; border:1px solid #cccccc;">
					<div style="float:left; padding:1px; width:230px; height:700px; margin-left:1px; border:1px solid #ffffff;">
						<div class="style_border">
							<label class="normalfnt" style="margin-left:2px;">
								<div align="left">Upload Sketch :</div>
							</label>
						<div>
							<input type="file" id="filepath" name="filepath" align="middle" style="vertical-align:middle" width="30" />
							<input type="button" value="Upload" onclick="uploadfile();" />
							<input type="button" value="Delete" id="butDelete2" tabindex="6" onclick="deleteImage();"/>
						</div>
					</div>
                    
                    
                    <div class="style_border">
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left">Customer * :<input type="text" id="lblcust" name="lblcust" value="<?php echo $custname;?>"size="5" style="visibility:hidden"/></div>
						</label>
                        
						<div>
                        
							<select name="cboCustomer" class="txtbox" onchange="" style="width:154px; margin-top:5px; border:1px solid #cccccc; margin-left:50px;" id="cboCustomer">
                          <option value="" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT intBuyerID, strName FROM buyers where intStatus=1 order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		if($custid==$row["intBuyerID"])
		{
			echo "<option selected value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		}
	}
	
	?>
                        </select>
                        <img src="../images/add.png" alt="ok" width="16" height="16" align="top" onclick="OpenBuyerPopUp();"/>
						</div>
					</div>
					
                    <div class="style_border">
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left">Style No * :</div>
						</label>
						<div>
                        <?php $arr=explode('-',$stylename);?>
							<input name="txtStyleNo" type="text" class="txtbox" id="txtStyleNo" style="width:127px; margin-top:5px; border:1px solid #cccccc; margin-left:50px;" maxlength="26" value="<?php echo $arr[0]; ?>"/> <input name="txtRepeatNo" type="text" class="txtbox" id="txtRepeatNo" style="width:38px" maxlength="6" value="<?php echo $arr[1]; ?>" />
						</div>
					</div>
                    
					<div class="style_border">
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left">Order No * :</div>
						</label>
						<div>
							<input name="txtPoNo" type="text" class="txtbox" id="txtPoNo" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();"  maxlength="30" value="<?php
	
	$SQL6 = "SELECT  strOrderNo FROM orders where intStyleId = $styleid and intStatus=2";
	
	$result6 = $db->RunQuery($SQL6);
	
	$row6 = mysql_fetch_array($result6);
	echo $row6['strOrderNo'];
	
	
	?>"  style="text-align:right; width:172px; margin-top:5px; border:1px solid #cccccc; margin-left:50px;" />
						</div>
					</div>
                    
                   <div class="style_border2">
                   		<?php $fabsuppname=""; ?>
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left">Fabric Supplier :</div>
						</label>
						<div>
                        
							<select name="cboMill" class="txtbox" style="width:172px; margin-top:5px; border:1px solid #cccccc; margin-left:50px;"  id="cboMill" onchange="GetFabricRefNo(this.value);">
                          <option value="Null" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT strSupplierID, strTitle FROM suppliers where intApproved=1  order by strTitle;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		if($rowall['strSupplierID']==$row["strSupplierID"])
		{
			echo "<option selected value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
			$fabsuppname = $row["strTitle"];
		}
		else
		{
			echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
		}
	}
	
	?>
                        </select>
						</div>
					</div>	
                    
                   <div class="style_border">
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left">Description :<input type="text" id="lblsuppl" name="lblsuppl" value="<?php echo $fabsuppname;?>"size="5" style="visibility:hidden"/></div>
						</label>
						<div>
							<input type="text" id="txtDescription" name="txtDescription" 
							style="width:172px; margin-top:5px; border:1px solid #cccccc; margin-left:50px;" 
							value="<?php echo $rowall['strDescription']; ?>"/>
						</div>
					</div>
                   
                    
                    <div class="style_border">
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left">Designer :</div>
						</label>
						<div>
							<input type="text" id="txtDesigner" name="txtDesigner" 
							style="width:172px; margin-top:5px; border:1px solid #cccccc; margin-left:50px;" 
							value="<?php echo $rowall['strDesigner']; ?>"/>
						</div>
					</div>
					
					<div class="style_border2">
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left">Date :</div>
						</label>
						<div>
							<input type="text" id="txtdate" name="txtdate" 
							style="width:170px; margin-top:5px; border:1px solid #cccccc; margin-left:50px;" readonly="readonly" 
							value="<?php if($rowall["dtmDate"]!=""){ echo substr($rowall["dtmDate"], 0, -9);} else { echo date("Y-m-d"); } ?>" 
							onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input name="reseta" type="text"  class="txtbox" 
							style="visibility:hidden;width:10px" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" />
						</div>
					</div>
					
					
							
					<div class="style_border2">
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left">Size :</div>
						</label>
						<div>
							<input type="text" id="txtsize" name="txtsize" 
							style="width:170px; margin-top:5px; border:1px solid #cccccc; margin-left:50px;" 
							value="<?php echo $rowall['strSize']; ?>"/>
						</div>
					</div>
					
					
						
					<div class="style_border2">
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left">Quality :</div>
						</label>	
						<div>
							<input type="text" id="txtquality" name="txtquality" 
							style="width:170px; margin-top:5px; border:1px solid #cccccc; margin-left:50px;" 
							value="<?php echo $rowall['strQuality']; ?>"/>
						</div>
					</div>
                    
                    <div class="style_border2">
                   		<?php $fabsuppname=""; ?>
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left">Sample Type :</div>
						</label>
						<div>
                        
							<select name="cboType" class="txtbox" style="width:172px; margin-top:5px; border:1px solid #cccccc; margin-left:50px;"  id="cboType" onchange="">
                          <option value="Null" selected="selected">Select One</option>
                          <?php
	
	$SQL11 = "SELECT intSampleId, strDescription FROM sampletypes where intStatus=1  order by strDescription;";
	
	$result11 = $db->RunQuery($SQL11);
	
	while($row11 = mysql_fetch_array($result11))
	{
		if($rowall['strSampleId']==$row11["intSampleId"])
		{
			echo "<option selected value=\"". $row11["intSampleId"] ."\">" . $row11["strDescription"] ."</option>" ;
			$fabsuppname = $row11["strTitle"];
		}
		else
		{
			echo "<option value=\"". $row11["intSampleId"] ."\">" . $row11["strDescription"] ."</option>" ;
		}
	}
	
	?>
                        </select>
						</div>
					</div>	
					<div class="style_border2">
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left">Price :</div>
						</label>
						<div>
							<input type="text" id="txtprice" name="txtprice" 
							style="width:170px; margin-top:5px; border:1px solid #cccccc; margin-left:50px;" 
							value="<?php echo $rowall['dblPrice']; ?>"/>
						</div>
					</div>
					<div class="style_border2">
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left">Composition :</div>
						</label>
						<div>
							<input type="text" id="txtcomposition" name="txtcomposition" 
							style="width:170px; margin-top:5px; border:1px solid #cccccc; margin-left:50px;" 
							value="<?php echo $rowall['strComposition']; ?>"/>
						</div>
					</div>	
					
					<div class="style_border2">
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left">Lining :</div>
						</label>
						<div>
							<input type="text" id="txtlining" name="txtlining" 
							style="width:170px; margin-top:5px; border:1px solid #cccccc; margin-left:50px;" 
							value="<?php echo $rowall['strLining']; ?>"/>
						</div>
					</div>	
										
					<div class="style_border2">
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left">Button :</div>
						</label>
						<div>
							<input type="text" id="txtbutton" name="txtbutton" 
							style="width:170px; margin-top:5px; border:1px solid #cccccc; margin-left:50px;" 
							value="<?php echo $rowall['strButton']; ?>"/>
						</div>
					</div>
					
					<div class="style_border2">
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left">Zip :</div>
						</label>
						<div>
							<input type="text" id="txtzip" name="txtzip" 
							style="width:170px; margin-top:5px; border:1px solid #cccccc; margin-left:50px;" 
							value="<?php echo $rowall['strZip']; ?>"/>
						</div>
			  		</div>
						
					<div class="style_border3">
						<label class="normalfnt" style="margin-left:2px;">
							<div align="left">Additional Details :</div>
						</label>
						<div align="center">
							<textarea id="txtaradditional" name="txtaradditional" ><?php echo $rowall['strAddDetails']; ?></textarea>
						</div>
					</div>
				</div>
			</div><!--////////////////right div close tag\\\\\\\\\\\\\\\-->
				<div style="clear:left;"></div>
				<div align="left">
				  <table style="margin-top:15px;">
				    <tr>
				      <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                      <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                      <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                      <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                      <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                      <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
                      <td>&nbsp;</td>
				      <td><img src="../images/save.png" alt="Save" name="Save" id="butSave" tabindex="5" onclick="savedetails();"  class="mouseover"/><img class="mouseover" src="../images/new.png" alt="Delete" name="Delete" id="butDelete" tabindex="6" onclick="newStyle();"/><img class="mouseover" src="../images/report.png" alt="Report" id="butReport" tabindex="7" onclick="viewReport();" /><a href="../main.php"><img  class="mouseover" src="../images/close.png" alt="Close" name="Close" id="butClose" tabindex="8" border="0"/></a></td>
				      <td>&nbsp;</td>
			        </tr>
				    </table>
		  </div>
        </div><!--////////////////main div close tag\\\\\\\\\\\\\\\-->
			
		
		</div><!--////////////////headers div close tag\\\\\\\\\\\\\\\-->
	</div><!--////////////////headers div close tag\\\\\\\\\\\\\\\-->
</div><!--////////////////headers div close tag\\\\\\\\\\\\\\\-->
</form>
</body>
</html>

