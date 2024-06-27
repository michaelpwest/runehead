hue = 60;
adeg = 60;
sat = 1;
val = 1;
squarecolor = "#ffff00"; //starting hue
pickindex = 0;

threec = new Array("#666666", "#555555", "#545657"); // the three colors

// code from Browser Detect Lite  v2.1
// http://www.dithered.com/javascript/browser_detect/index.html
// modified by Chris Nott (chris@NOSPAMdithered.com - remove NOSPAM)
// modified by Michael Lovitt to include OmniWeb and Dreamcast
// modified by Jemima Pereira to detect only relevant browsers

function BrowserDetectXLite() {
  var ua = navigator.userAgent.toLowerCase(); 
  this.ua = ua;

  // browser name
  this.isIE = ( (ua.indexOf("msie") != -1) && (ua.indexOf("opera") == -1) && (ua.indexOf("webtv") == -1) ); 
  this.isSafari = (ua.indexOf('safari') != - 1);

  // browser version
  this.versionMinor = parseFloat(navigator.appVersion); 

  // correct version number for IE4+ 
  if (this.isIE && this.versionMinor >= 4) {
    this.versionMinor = parseFloat( ua.substring( ua.indexOf('msie ') + 5 ) );
  }

  this.versionMajor = parseInt(this.versionMinor); 

  // platform
  this.isWin   = (ua.indexOf('win') != -1);
  this.isWin32 = (this.isWin && ( ua.indexOf('95') != -1 || ua.indexOf('98') != -1 || ua.indexOf('nt') != -1 || ua.indexOf('win32') != -1 || ua.indexOf('32bit') != -1) );
  this.isMac   = (ua.indexOf('mac') != -1);

  this.isIE4x = (this.isIE && this.versionMajor == 4);
  this.isIE4up = (this.isIE && this.versionMajor >= 4);
  this.isIE5x = (this.isIE && this.versionMajor == 5);
  this.isIE55 = (this.isIE && this.versionMinor == 5.5);
  this.isIE5up = (this.isIE && this.versionMajor >= 5);
  this.isIE6x = (this.isIE && this.versionMajor == 6);
  this.isIE6up = (this.isIE && this.versionMajor >= 6);
  this.isIE4xMac = (this.isIE4x && this.isMac);
}
var browser = new BrowserDetectXLite();
//end of browser detector

//fix for IE's png stupidity
function deMoronize(id) {//now the onload function
  // detect moronic browsers
  if (!((browser.isIE55 || browser.isIE6up) && browser.isWin32)) {
    // demoronize div#wheel image if browser is non-moronic
    document.getElementById("wheel").innerHTML = "<img src='images/hsvwheel.png' style='border: 0px; cursor: pointer;' alt='' onclick='colourchosen(\"" + id + "\");' />";
  }
  // start capturing the mouse
  capture();
}

// HSV conversion algorithm adapted from easyrgb.com
function hsv2rgb(Hdeg,S,V) {
  H = Hdeg/360;     // convert from degrees to 0 to 1
  if (S==0) {       // HSV values = From 0 to 1
    R = V*255;     // RGB results = From 0 to 255
    G = V*255;
    B = V*255;
  } else {
    var_h = H*6;
    var_i = Math.floor( var_h );     //Or ... var_i = floor( var_h )
    var_1 = V*(1-S);
    var_2 = V*(1-S*(var_h-var_i));
    var_3 = V*(1-S*(1-(var_h-var_i)));
    if (var_i==0)      {var_r=V ;    var_g=var_3; var_b=var_1}
    else if (var_i==1) {var_r=var_2; var_g=V;     var_b=var_1}
    else if (var_i==2) {var_r=var_1; var_g=V;     var_b=var_3}
    else if (var_i==3) {var_r=var_1; var_g=var_2; var_b=V}
    else if (var_i==4) {var_r=var_3; var_g=var_1; var_b=V}
    else               {var_r=V;     var_g=var_1; var_b=var_2}
    R = Math.round(var_r*255);   //RGB results = From 0 to 255
    G = Math.round(var_g*255);
    B = Math.round(var_b*255);
  }
  return new Array(R,G,B);
}

function rgb2hex(rgbary) {
  cary = new Array; 
  cary[3] = "#";
  for (i=0; i < 3; i++) {
    cary[i] = parseInt(rgbary[i]).toString(16);
    if (cary[i].length < 2) cary[i] = "0"+ cary[i];
    cary[3] = cary[3] + cary[i];
    cary[i+4] = rgbary[i]; //save dec values for later
  }
  // function returns hex color as an array of three two-digit strings
  // plus the full hex color and original decimal values
  return cary;
}

function webRounder(c,d) {//d is the divisor
  //safe divisor is 51, smart divisor is 17 
  thec = "#";
  for (i=0; i<3; i++) {
    num = Math.round(c[i+4]/d) * d; //use saved rgb value
    numc = num.toString(16);
    if (String(numc).length < 2) numc = "0" + numc;
    thec += numc;
  }
  return thec;
}

function hexColorArray(c) { //now takes string hex value with #
  threec[2] = c[3];
  threec[1] = webRounder(c,17);
  threec[0] = webRounder(c,51);
  return false;
}

function capture() {
  hoverColor();
  if(document.layers) {
    layobj = document.layers['wheel'];
    layobj.document.captureEvents(Event.MOUSEMOVE);
    layobj.document.onmousemove = mouseMoved;
  } else if (document.all) {
    layobj = document.all["wheel"];
    layobj.onmousemove = mouseMoved;
  } else if (document.getElementById) {
    window.document.getElementById("wheel").onmousemove = mouseMoved;
  }
}

function greyMoved(x,y) {
  adeg = hue;
  xside = (x<=553)?x - 296:256;
  yside = (y<=256)?y:256;
  sat = xside/256;
  val = 1 - (yside/256);
  c = rgb2hex(hsv2rgb(hue,sat,val));
  hexColorArray(c);
  hoverColor();
  return false;
}

function mouseMoved(e) {
  if (document.layers) {
    x = e.layerX;
    y = e.layerY;
  } else if (document.all) {
    x = event.offsetX;
    y = event.offsetY;
  } else if (document.getElementById) {
    x = (e.pageX - document.getElementById("wheel").offsetLeft);
    y = (e.pageY - document.getElementById("wheel").offsetTop);
  }
  if (x >= 296) {
	greyMoved(x,y);
    return false;
  }
  if (y > 256) {
	return false;
  }
  cartx = x - 128;
  carty = 128 - y;
  cartx2 = cartx * cartx;
  carty2 = carty * carty;
  cartxs = (cartx < 0)?-1:1;
  cartys = (carty < 0)?-1:1;
  cartxn = cartx/128;                      //normalize x
  rraw = Math.sqrt(cartx2 + carty2);       //raw radius
  rnorm = rraw/128;                        //normalized radius
  if (rraw == 0) {
    sat = 0;
    val = 0;
    rgb = new Array(0,0,0);
  } else {
    arad = Math.acos(cartx/rraw);            //angle in radians 
    aradc = (carty>=0)?arad:2*Math.PI - arad;  //correct below axis
    adeg = 360 * aradc/(2*Math.PI);  //convert to degrees
    if (rnorm > 1) {    // outside circle
      rgb = new Array(255,255,255);
      sat = 1;
      val = 1;            
    } else if (rnorm >= .5) {
      sat = 1 - ((rnorm - .5) *2);
      val = 1;
      rgb = hsv2rgb(adeg,sat,val);
    } else {
      sat = 1;
      val = rnorm * 2;
      rgb = hsv2rgb(adeg,sat,val);
    }
  }
  c = rgb2hex(rgb);
  hexColorArray(c);
  hoverColor();
  return false;
}

function hoverColor() {
  if (document.layers) {
    document.layers["hexcolour"].bgColor = threec[1];
  } else if (document.all) {
    document.all["hexcolour"].style.backgroundColor = threec[1];
    document.getElementById("hexcode").innerHTML = threec[1].toUpperCase();
  } else if (document.getElementById) {
    document.getElementById("hexcolour").style.backgroundColor = threec[1];
    document.getElementById("hexcode").innerHTML = threec[1].toUpperCase();
  }
  return false;
}

function setSquare(deg) {
  hue = deg;
  adeg = deg;
  c = rgb2hex(hsv2rgb(hue,1,1));
  squarecolor = c[3];
  if (document.layers) {
    document.layers["wheel"].bgColor = squarecolor;
  } else if (document.all) {
    document.all["wheel"].style.backgroundColor = squarecolor;
  } else if (document.getElementById) {
    document.getElementById("wheel").style.backgroundColor = squarecolor;
  }
}

function theToggle(divid,disp) {
  var elements = document.getElementsByTagName("div");
  for(var i = 0; i < elements.length; i++) {
    if (elements.item(i).id == divid) {
      elements.item(i).style.display = disp;
    }
  }
}

function reHue(deg) {
  deg = deg % 360;
  setSquare(deg);
  rgb = hsv2rgb(deg,sat,val);
  c = rgb2hex(rgb);
  hexColorArray(c);
  hoverColor();
  return false;
}

function colourchosen(id){
  opener.document.getElementById(id).value = document.getElementById("hexcode").innerHTML;
  opener.document.getElementById(id + "Display").style.backgroundColor = document.getElementById("hexcode").innerHTML;
  opener.mlPreview();
  window.close();
}