//global javascript functions used in multiple files

function getElementViewTop(element){
    //top offset to view window
    var actualTop = element.offsetTop;
    var current = element.offsetParent;

    while (current !== null){
        actualTop += current. offsetTop;
        current = current.offsetParent;
    }
    if (document.compatMode == "BackCompat"){
        var elementScrollTop=document.body.scrollTop;
    } else {
        var elementScrollTop=document.documentElement.scrollTop;
    }

    return actualTop-elementScrollTop;
}
function adjust_footer() {
    var win_height= window.innerHeight
        || document.documentElement.clientHeight
        || document.body.clientHeight;
    var footer=document.getElementsByClassName('footer')[0];
    var footer_ver_pos=getElementViewTop(footer);
    if (((win_height-footer.clientHeight)>footer_ver_pos)){
        //not enough contents in current page
        footer.style.position='absolute';
    }else{
        footer.style.position='relative';
    }
}