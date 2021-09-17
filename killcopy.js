var isCtrl = false;
document.onkeyup=function(e) {
if(e.which == 17)
isCtrl=false; 
}
document.onkeydown=function(e)
{ if(e.which == 123)
isCtrl=true;
if (((e.which == 85) || (e.which == 65) || (e.which == 88) || (e.which == 67) || (e.which == 86) || (e.which == 2) || (e.which == 3) || (e.which == 123) || (e.which == 83)) && isCtrl == true) {

return false;
}
} // right click code

var isNS = (navigator.appName == "Netscape") ? 1 : 0; if(navigator.appName == "Netscape");

function mischandler(){

return false;
}
function mousehandler(e){
var myevent = (isNS) ? e : event;
var eventbutton = (isNS) ? myevent.which : myevent.button;
if((eventbutton==2)||(eventbutton==3)) return false;
}
document.oncontextmenu = mischandler;
document.onmousedown = mousehandler;
document.onmouseup = mousehandler;
//select content code disable alok goyal
function killCopy(e){
return false
}
function reEnable(){
return true
}
document.onselectstart=new Function ("return false")
if (window.sidebar){
document.onmousedown=killCopy
document.onclick=reEnable
}