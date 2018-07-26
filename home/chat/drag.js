//Make the DIV element draggagle:
dragElement(document.getElementById("msg-box"));

function dragElement(elmnt) {
  var click = true, deltaX = 1, deltaY = 1;
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(elmnt.id + "-header")) {
    /* if present, the header is where you move the DIV from:*/
    document.getElementById(elmnt.id + "-header").onmousedown = dragMouseDown;
  } else {
    /* otherwise, move the DIV from anywhere inside the DIV:*/
    elmnt.onmousedown = dragMouseDown;
  }

  function dragMouseDown(e) {
    e = e || window.event;
    e.preventDefault();
    // get the mouse cursor position at startup:
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    // call a function whenever the cursor moves:
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.event;
    e.preventDefault();
    // calculate the new cursor position:
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    if (pos1 > deltaX || pos2 > deltaY) {
      click = false;
    }
    // set the element's new position:
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
    elmnt.style.bottom = "auto";
    elmnt.style.right = "auto";
  }

  function closeDragElement() {
    /* stop moving when mouse button is released:*/
    document.onmouseup = null;
    document.onmousemove = null;
    if (click) {
      toggleInputMessageCard(document.getElementById(elmnt.id + "-header"));
    }
    click = true;
  }

  function toggleInputMessageCard(element) {
    children = element.parentNode.children;
    for (var i = 0; i < children.length; i++) {
      if (children[i] != element) {
        if (children[i].style.display == "none") {
          children[i].style.display = "block";
        } else {
          children[i].style.display = "none";
        }
      }
    }
  }
}