// JavaScript Document
function showPos(event, text) {
var el, x, y;

el = document.getElementById('PopUp');
if (window.event) {
x = window.event.clientX + document.documentElement.scrollLeft
+ document.body.scrollLeft;
y = window.event.clientY + document.documentElement.scrollTop +
+ document.body.scrollTop;
}
else {
x = event.clientX + window.scrollX;
y = event.clientY + window.scrollY;
}
x -= 2; y -= 2;
y = y+15
el.style.left = x + "px";
el.style.top = y + "px";
el.style.display = "block";
document.getElementById('PopUpText').innerHTML = text;
}