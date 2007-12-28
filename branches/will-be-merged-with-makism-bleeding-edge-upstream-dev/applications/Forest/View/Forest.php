<script type="text/javascript">
var srcForest = false;

function ForestGet()
{
	if (srcForest==false)
		srcForest = document.getElementById("leaf_Forest");
}


//*****************************************************************************
// Do not remove this notice.
//
// Copyright 2001 by Mike Hall.
// See http://www.brainjar.com for terms of use.
//*****************************************************************************
var browser = new Browser();
var dragObj = new Object();
dragObj.zIndex = 0;

function dragGo(event) {
  var x, y;
  
  if (browser.isIE) {
	x = window.event.clientX + document.documentElement.scrollLeft
	  + document.body.scrollLeft;
	y = window.event.clientY + document.documentElement.scrollTop
	  + document.body.scrollTop;
  }
  if (browser.isNS) {
	x = event.clientX + window.scrollX;
	y = event.clientY + window.scrollY;
  }
  
  dragObj.elNode.style.left = (dragObj.elStartLeft + x - dragObj.cursorStartX) + "px";
  dragObj.elNode.style.top  = (dragObj.elStartTop  + y - dragObj.cursorStartY) + "px";
  
  if (browser.isIE) {
	window.event.cancelBubble = true;
	window.event.returnValue = false;
  }
  if (browser.isNS)
	event.preventDefault();
}

function dragStop(event) {

  if (browser.isIE) {
	document.detachEvent("onmousemove", dragGo);
	document.detachEvent("onmouseup",   dragStop);
  }
  if (browser.isNS) {
	document.removeEventListener("mousemove", dragGo,   true);
	document.removeEventListener("mouseup",   dragStop, true);
  }
}
  
function Browser() {

  var ua, s, i;
  
  this.isIE    = false;
  this.isNS    = false;
  this.version = null;
  
  ua = navigator.userAgent;
  
  s = "MSIE";
  if ((i = ua.indexOf(s)) >= 0) {
	this.isIE = true;
	this.version = parseFloat(ua.substr(i + s.length));
	return;
  }

  s = "Netscape6/";
  if ((i = ua.indexOf(s)) >= 0) {
	this.isNS = true;
	this.version = parseFloat(ua.substr(i + s.length));
	return;
  }
  
  s = "Gecko";
  if ((i = ua.indexOf(s)) >= 0) {
	this.isNS = true;
	this.version = 6.1;
	return;
  }
}

function dragStart(event, id) {
	
  var el;
  var x, y;
	
  id = 'leaf_Forest';
  
  if (id)
	dragObj.elNode = document.getElementById(id);
  else {
	if (browser.isIE)
	  dragObj.elNode = window.event.srcElement;
	if (browser.isNS)
	  dragObj.elNode = event.target;

	// If this is a text node, use its parent element.

	if (dragObj.elNode.nodeType == 3)
	  dragObj.elNode = dragObj.elNode.parentNode;
  }
  
  if (browser.isIE) {
	x = window.event.clientX + document.documentElement.scrollLeft
	  + document.body.scrollLeft;
	y = window.event.clientY + document.documentElement.scrollTop
	  + document.body.scrollTop;
  }
  
  if (browser.isNS) {
	x = event.clientX + window.scrollX;
	y = event.clientY + window.scrollY;
  }
  
  dragObj.cursorStartX = x;
  dragObj.cursorStartY = y;
  dragObj.elStartLeft  = parseInt(dragObj.elNode.style.left, 10);
  dragObj.elStartTop   = parseInt(dragObj.elNode.style.top,  10);

  if (isNaN(dragObj.elStartLeft)) dragObj.elStartLeft = 0;
  if (isNaN(dragObj.elStartTop))  dragObj.elStartTop  = 0;
  
  dragObj.elNode.style.zIndex = ++dragObj.zIndex;
  
  if (browser.isIE) {
	document.attachEvent("onmousemove", dragGo);
	document.attachEvent("onmouseup",   dragStop);
	window.event.cancelBubble = true;
	window.event.returnValue = false;
  }
  if (browser.isNS) {
	document.addEventListener("mousemove", dragGo,   true);
	document.addEventListener("mouseup",   dragStop, true);
	event.preventDefault();
  }
}

</script>
<style type="text/css">
	#leaf_Forest {
		position: absolute;
		top: 10px;
		left: 10px;
		z-position: 10;
		width: 250px;
		font-size: 14px;
		font-family: Tahoma, sans;
	}

	#leaf_Forest #leaf_Forest_Move {
		float: left;
		clear: right;
	}

	#leaf_Forest #leaf_Forest_Move img {
		cursor: move;
	}

	#leaf_Forest #leaf_Forest_Contents {
		margin: 0px 0px 0px 5px;
		width: 225px;
		float: left;
		clear: right;
		border: 1px solid #f0f0f0;
		background-color: #f9f9f9;
	}
</style>

<div id="leaf_Forest">
	<div id="leaf_Forest_Move">
		<img src="/leaf/content/icons/anchor.png" alt="icon: anchor" onmousedown="dragStart(event);" />
	</div>
	<div id="leaf_Forest_Contents">
		stats
	</div>
</div>