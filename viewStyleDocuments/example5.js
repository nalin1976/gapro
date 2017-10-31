/* © 2009 ROBO Design
 * http://www.robodesign.ro
 */

// Keep everything in anonymous function, called on window load.
if(window.addEventListener) {
window.addEventListener('load', function () {
  var canvas, context, canvaso, contexto;

  // The active tool instance.
  var tool;
  var tool_default = 'pencil';
  var bold1=0;
  var italic1=0;
  var underline1=0;
  var fontB="";
  var fontI="";
  var fontU="";
  document.getElementById('bold1').style.background 		= '';
  document.getElementById('italic1').style.background 		= '';
  document.getElementById('underline1').style.background 	= '';

  function init () {
    // Find the canvas element.
    canvaso = document.getElementById('imageView');
    if (!canvaso) {
      alert('Error: I cannot find the canvas element!');
      return;
    }

    if (!canvaso.getContext) {
      alert('Error: no canvas.getContext!');
      return;
    }

    // Get the 2D canvas context.
    contexto = canvaso.getContext('2d');
	
	var img  = document.getElementById('imgid');
	contexto.drawImage(img,0,0,950,785);
	
    if (!contexto) {
      alert('Error: failed to getContext!');
      return;
    }

    // Add the temporary canvas.
    var container = canvaso.parentNode;
    canvas = document.createElement('canvas');
    if (!canvas) {
      alert('Error: I cannot create a new canvas element!');
      return;
    }

    canvas.id     = 'imageTemp';
    canvas.width  = canvaso.width;
    canvas.height = canvaso.height;
    container.appendChild(canvas);

    context = canvas.getContext('2d');

    // Get the tool select input.
    var tool_select  = document.getElementById('pencil');
	var tool_select1 = document.getElementById('line');
	var tool_select2 = document.getElementById('rect');
	var tool_select3 = document.getElementById('eracer');
	var tool_select4 = document.getElementById('text');
	var tool_select5 = document.getElementById('bold1');
	var tool_select6 = document.getElementById('italic1');
	var tool_select7 = document.getElementById('underline1');
	
    if (!tool_select) {
      alert('Error: failed to get the dtool element!');
      return;
    }
    tool_select.addEventListener('mousedown', ev_tool_change, false);
	tool_select1.addEventListener('mousedown', ev_tool_change, false);
	tool_select2.addEventListener('mousedown', ev_tool_change, false);
	tool_select3.addEventListener('mousedown', ev_tool_change, false);
	tool_select4.addEventListener('mousedown', ev_tool_change, false);
	tool_select5.addEventListener('mousedown', ev_tool_change, false);
	tool_select6.addEventListener('mousedown', ev_tool_change, false);
	tool_select7.addEventListener('mousedown', ev_tool_change, false);
    // Activate the default tool.
    if (tools[tool_default]) {
      tool = new tools[tool_default]();
      tool_select.value = tool_default;
    }

    // Attach the mousedown, mousemove and mouseup event listeners.
    canvas.addEventListener('mousedown', ev_canvas, false);
    canvas.addEventListener('mousemove', ev_canvas, false);
    canvas.addEventListener('mouseup',   ev_canvas, false);
  }

  // The general-purpose event handler. This function just determines the mouse 
  // position relative to the canvas element.
  function ev_canvas (ev) {
    if (ev.layerX || ev.layerX == 0) { // Firefox
      ev._x = ev.layerX;
      ev._y = ev.layerY;
    } else if (ev.offsetX || ev.offsetX == 0) { // Opera
      ev._x = ev.offsetX;
      ev._y = ev.offsetY;
    }

    // Call the event handler of the tool.
    var func = tool[ev.type];
    if (func) {
      func(ev);
    }
  }

  // The event handler for any changes made to the tool selector.
  function ev_tool_change (ev) {
    if (tools[this.id]) {
      tool = new tools[this.id]();
    }
  }

  // This function draws the #imageTemp canvas on top of #imageView, after which 
  // #imageTemp is cleared. This function is called each time when the user 
  // completes a drawing operation.
  function img_update () {
		contexto.drawImage(canvas, 0, 0);
		context.clearRect(0, 0, canvas.width, canvas.height);
  }

  // This object holds the implementation of each drawing tool.
  var tools = {};

  // The drawing pencil.
  tools.pencil = function () 
  {
	  fontB      = "";
	  fontI      = "";
	  fontU      = "";
	  bold1      = 0;
	  italic1    = 0;
	  underline1 = 0;
	  
	  document.getElementById('pencil').style.background = 'red';
	  document.getElementById('line').style.background   = '';
	  document.getElementById('rect').style.background   = '';
	  document.getElementById('eracer').style.background = '';
	  document.getElementById('text').style.background   = '';
	  
	  
	  context.lineWidth = 1;
	  context.strokeStyle = 'black';
	  //context.font = "20pt Arial";
	  //context.fillText("Sample String",600,600);
	 
    //alert("sdsd");
	var tool = this;
    this.started = false;

    // This is called when you start holding down the mouse button.
    // This starts the pencil drawing.
    this.mousedown = function (ev) {
        context.beginPath();
        context.moveTo(ev._x, ev._y);
        tool.started = true;
   };
	
	
	
  
    // This function is called every time you move the mouse. Obviously, it only 
    // draws if the tool.started state is set to true (when you are holding down 
    // the mouse button).
    this.mousemove = function (ev) 
	{
      if (tool.started) {
        context.lineTo(ev._x, ev._y);
        context.stroke();
      }
    };

    // This is called when you release the mouse button.
    this.mouseup = function (ev) {
      if (tool.started) {
        tool.mousemove(ev);
        tool.started = false;
        img_update();
      }
    };
  };
  
  
  tools.text = function () 
  {
	  
	  document.getElementById('pencil').style.background = '';
	  document.getElementById('line').style.background   = '';
	  document.getElementById('rect').style.background   = '';
	  document.getElementById('eracer').style.background = '';
	  document.getElementById('text').style.background   = 'red';
	  context.lineWidth   = 1;
	  
	//alert("sdsd");
	var tool = this;
    this.started = false;

    // This is called when you start holding down the mouse button.
    // This starts the pencil drawing.
    this.mousedown = function (ev) {
        context.beginPath();
		
		var txt = prompt("Enter your text :");
		//var txt = callPrompt();
		if(txt)
		{
        	var fontSize = document.getElementById('cbofontsize').value;
			var fontName = document.getElementById('cbofontname').value;
			
	  		context.strokeStyle = 'black';
	  		context.font        = fontB+" "+fontI+" "+fontSize+"pt "+fontName;
			
			
			context.fillText(txt,ev._x,ev._y);
			img_update();
		}
		
        };

  };
  
  tools.bold1 = function () 
  {
		if(bold1==0)
		{
			fontB = "bold";
			bold1 = 1;
			document.getElementById('bold1').style.background = 'red';
			document.getElementById('text').click();
		}
		else
		{
			bold1=0;
			fontB = "";
			document.getElementById('bold1').style.background = '';
			document.getElementById('text').click();
		}

  };
  
  tools.italic1 = function () 
  {
    	if(italic1==0)
		{
			fontI = "italic";
			italic1 = 1;
			document.getElementById('italic1').style.background = 'red';
			document.getElementById('text').click();
		}
		else
		{
			italic1=0;
			fontI = "";
			document.getElementById('italic1').style.background = '';
			document.getElementById('text').click();   
		}

  };
  
  
  tools.underline1 = function () 
  {
    	if(underline1==0)
		{
			fontU = "underline";
			underline1 = 1;
			document.getElementById('underline1').style.background = 'red';
			document.getElementById('text').click();
		}
		else
		{
			underline1=0;
			fontU = "";
			document.getElementById('underline1').style.background = '';
			document.getElementById('text').click();  
		}
		
    

  };
  
	tools.eracer = function () 
  {
	  document.getElementById('pencil').style.background = '';
	  document.getElementById('line').style.background   = '';
	  document.getElementById('rect').style.background   = '';
	  document.getElementById('eracer').style.background = 'red';
	  document.getElementById('text').style.background   = '';
	  
	  fontB      = "";
	  fontI      = "";
	  fontU      = "";
	  bold1      = 0;
	  italic1    = 0;
	  underline1 = 0;
	  
	  context.lineWidth = 10;
	  context.strokeStyle = 'white';
	  var tool = this;
    this.started = false;

    // This is called when you start holding down the mouse button.
    // This starts the pencil drawing.
    this.mousedown = function (ev) {
        context.beginPath();
        context.moveTo(ev._x, ev._y);
        tool.started = true;
   };
	
  
    // This function is called every time you move the mouse. Obviously, it only 
    // draws if the tool.started state is set to true (when you are holding down 
    // the mouse button).
    this.mousemove = function (ev) 
	{
      if (tool.started) {
        context.lineTo(ev._x, ev._y);
        context.stroke();
      }
    };

    // This is called when you release the mouse button.
    this.mouseup = function (ev) {
      if (tool.started) {
        tool.mousemove(ev);
        tool.started = false;
        img_update();
      }
    };
	
  };
  
  
  
  // The rectangle tool.
  tools.rect = function () {
	  
	  document.getElementById('pencil').style.background = '';
	  document.getElementById('line').style.background   = '';
	  document.getElementById('rect').style.background   = 'red';
	  document.getElementById('eracer').style.background = '';
	  document.getElementById('text').style.background   = '';
	  
	  fontB      = "";
	  fontI      = "";
	  fontU      = "";
	  bold1      = 0;
	  italic1    = 0;
	  underline1 = 0;
	  
	  context.lineWidth = 1;
	  context.strokeStyle = 'black';
    var tool = this;
    this.started = false;

    this.mousedown = function (ev) {
      tool.started = true;
      tool.x0 = ev._x;
      tool.y0 = ev._y;
    };

    this.mousemove = function (ev) {
      if (!tool.started) {
        return;
      }

      var x = Math.min(ev._x,  tool.x0),
          y = Math.min(ev._y,  tool.y0),
          w = Math.abs(ev._x - tool.x0),
          h = Math.abs(ev._y - tool.y0);

      context.clearRect(0, 0, canvas.width, canvas.height);

      if (!w || !h) {
        return;
      }

      context.strokeRect(x, y, w, h);
    };

    this.mouseup = function (ev) {
      if (tool.started) {
        tool.mousemove(ev);
        tool.started = false;
        img_update();
      }
    };
  };

  // The line tool.
  tools.line = function () {
	  
	  document.getElementById('pencil').style.background = '';
	  document.getElementById('line').style.background   = 'red';
	  document.getElementById('rect').style.background   = '';
	  document.getElementById('eracer').style.background = '';
	  document.getElementById('text').style.background   = '';
	  
	  fontB      = "";
	  fontI      = "";
	  fontU      = "";
	  bold1      = 0;
	  italic1    = 0;
	  underline1 = 0;
	  
	  context.lineWidth = 1;
	  context.strokeStyle = 'black';
    var tool = this;
    this.started = false;

    this.mousedown = function (ev) {
      tool.started = true;
      tool.x0 = ev._x;
      tool.y0 = ev._y;
    };

    this.mousemove = function (ev) {
      if (!tool.started) {
        return;
      }

      context.clearRect(0, 0, canvas.width, canvas.height);

      context.beginPath();
      context.moveTo(tool.x0, tool.y0);
      context.lineTo(ev._x,   ev._y);
      context.stroke();
      context.closePath();
    };

    this.mouseup = function (ev) {
      if (tool.started) {
        tool.mousemove(ev);
        tool.started = false;
        img_update();
      }
    };
  };
  
  


  init();

}, false); }

// vim:set spell spl=en fo=wan1croql tw=80 ts=2 sw=2 sts=2 sta et ai cin fenc=utf-8 ff=unix:

