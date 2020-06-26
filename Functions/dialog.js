//process dialog form format
function hide_dialog(id) {
    //hide dialog form
    var obj = document.getElementById(id);
    obj.style.display = "none";
    obj.style.position='absolute';
}
function show_dialog(id, width, height) {
    //show object with input id.
    var obj  = document.getElementById(id);
    var winWidth = document.documentElement.clientWidth;
    var winHeight = document.documentElement.clientHeight;
    var offsetTop = document.documentElement.offsetTop;
    var left = (winWidth - width)/2;
    var top  = (winHeight - height)/3 + offsetTop;
    obj.style.position='absolute';
    obj.style.top = top + "px";
    obj.style.left = left + "px";
    obj.style.display = "block";
    obj.style.zIndex=10000;
    path_control();
}
function path_control() {
    //control file path when adding new folder/pages.
    var type=document.getElementsByName('dia_add_type')[0];
    type=type.selectedOptions[0].value;
    var path=document.getElementsByName('add_path_root')[0];
    var path_sel=document.getElementsByName('dia_add_path')[0].options;
    if (type=='folder'){
        //add folder
        //disable all options except root
        for(var i=0;i<path_sel.length;i++){
            path_sel[i].style='display:none';
        }
        //enable root only
        path.style='display:block';
        //set selected option
        path_sel=document.getElementsByName('dia_add_path')[0];
        path_sel.selectedIndex=0;
    }else{
        //add page
        //disable root
        for(var i=0;i<path_sel.length;i++){
            path_sel[i].style='display:block';
        }
        path.style='display:none';
        //set selected option, avoid selected value remains 'root'
        path_sel=document.getElementsByName('dia_add_path')[0];
        path_sel.selectedIndex=1;
    }
}

// hide_dialog();
// show_dialog('dialog', 200,200);
