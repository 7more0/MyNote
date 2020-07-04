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
function edit_select() {
    //get select node and set checkbox
    var selected_node=document.getSelection();
    if(!evnt){
        var evnt = window.event;
    }
    //clicked element
    var tar = evnt.target;
    var selected_node=tar.parentElement;
    var checkbox=selected_node.childNodes[1];
    var node=document.getElementsByName('checkbox');
    for (var i=0;i<node.length;i++){
        //clear selected checkbox
        node[i].checked=0;
    }
    checkbox.checked=1;
}