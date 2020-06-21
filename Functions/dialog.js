//process dialog form format
function hide_dialog(id) {
    var obj = document.getElementById(id);
    obj.style.display = "none";
    position: absolute;
}
function show_dialog(id, width, height) {
    var obj  = document.getElementById(id);
    var winWidth = document.documentElement.clientWidth;
    var winHeight = document.documentElement.clientHeight;
    var offsetTop = document.documentElement.offsetTop;
    var left = (winWidth - width)/2;
    var top  = (winHeight - height)/2 + offsetTop;
    obj.style.top = top + "px";
    obj.style.left = left + "px";
    obj.style.display = "block";
}

hide_dialog('dialog');
