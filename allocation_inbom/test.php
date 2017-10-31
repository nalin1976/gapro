<script>
var browserType;

if (document.layers) {browserType = "nn4"}
if (document.all) {browserType = "ie"}
if (window.navigator.userAgent.toLowerCase().match("gecko")) {
 browserType= "gecko"
}

function hide2() {
  if (browserType == "gecko" )
     document.poppedLayer =
         eval('document.getElementById("realtooltip2")');
  else if (browserType == "ie")
     document.poppedLayer =
        eval('document.getElementById("realtooltip2")');
  else
     document.poppedLayer =
        eval('document.layers["realtooltip2"]');
  document.poppedLayer.style.display = "none";
}

function show2() {
  if (browserType == "gecko" )
     document.poppedLayer =
         eval('document.getElementById("realtooltip2")');
  else if (browserType == "ie")
     document.poppedLayer =
        eval('document.getElementById("realtooltip2")');
  else
     document.poppedLayer =
         eval('document.layers["realtooltip2"]');
  document.poppedLayer.style.display = "inline";
}

</script>


<form>
<input type=button onClick="hide2()" value="hide">
<input type=button onClick="show2()" value="show">
<a href="#" onclick="show2()">Show</a>
<a href="#" onclick="hide2();">Hide</a>
</form>
<div id="realtooltip2" style="display: inline">
<big>Real's HowTo</big>
<layer></layer></div>
