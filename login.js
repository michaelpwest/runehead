function capsDetect(e) {
  if(!e) {
    e = window.event;
  }
  if(!e) {
    return;
  }
  var key = e.charCode? e.charCode: (e.keyCode? e.keyCode: (e.which? e.which: 0));
  key = (0 < key && key <= 255? String.fromCharCode(key): '');
  var shift = e.shiftKey || (e.modifiers && e.modifiers & 4);
  if (key != key.toUpperCase() || key != key.toLowerCase()) {
    var state = (key == key.toLowerCase() && shift) || (key == key.toUpperCase() && !shift);
    window.capslockState = state;
    showWarning(state);
  }
}

function capsToggle(e) {
  if(!e) {
    e = window.event;
  }
  if(!e) {
    return;
  }
  var key = (e.keyCode? e.keyCode: 0);
  if (key == 20 && (window.capslockState == false || window.capslockState ==  true)) {
    window.capslockState = !window.capslockState;
    showWarning(window.capslockState);
  }
}

function capsReset(e) {
  window.capslockState = null;
  showWarning(false);
}

function showWarning(v) {
  if (document.getElementById) {
    document.getElementById('capsWarning').style.display = v?'block':'none';
    document.getElementById('capsWarningAdmin').style.display = v?'block':'none';	
  }
}