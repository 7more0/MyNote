<?php
    include 'Functions/mk_menu.php';
    include 'Functions/search.php';
    include 'Functions/is_exist and del_page.php';
    include 'Functions/print_unit.php';
    $page=$_POST['page'];
    $folder=mysqli_fetch_array(search('page',$page))['father'];
    if (isset($_POST['del'])){
        del_page($_POST['page'],$folder);
        ?>
        <meta http-equiv="refresh" content="1;url=./index.php">
        <?php
    }else{
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit</title>
            <meta charset="UTF-8">
            <style>
                @import "CSS/edit.css";
                @import "CSS/footer.css";
            </style>
            <script type="text/javascript">
                function del_node() {
                    var nodes=document.getElementsByName('checkbox');
                    for (var i=0;i<nodes.length;i++){
                        if (nodes[i].checked){
                            var unit=nodes[i].parentNode;
                            unit.parentNode.removeChild(unit);
                        }
                    }
                }
                function add_node() {
                    let div=document.createElement('div');
                    div.className='node_div';
                    let flag_item = document.getElementById('menu');
                    let index=flag_item.selectedIndex;
                    let flag=flag_item.options[index].value;
                    let input_flag=document.createElement('input');
                    input_flag.type="hidden";
                    input_flag.value=flag;
                    let input_id=document.createElement('input');
                    input_id.type='hidden';
                    let input_father=document.createElement('input');
                    input_father.type="hidden";
                    let input_contents;
                    if (flag=='text'||flag=='code'){
                        input_contents=document.createElement('textarea');
                    }else if (flag=='graph'){
                        input_contents=document.createElement('input');
                        input_contents.type='file';
                    }else {
                        input_contents=document.createElement('input');
                        input_contents.type='text';
                    }
                    let check=document.createElement('input');
                    check.type="checkbox";
                    check.name='checkbox';
                    div.appendChild(input_flag);
                    div.appendChild(check);
                    div.appendChild(input_contents);
                    div.appendChild(input_id);
                    //N++;
                    return div;
                }
                function set_child(parent) {
                    //clear parent's children which is not actual html element
                    var children=parent.childNodes;
                    for(var i=0; i<children.length;i++){
                        if(children[i].nodeName == "#text"){
                            children[i].remove();
                        }
                    }
                }
                function name_nodes() {
                    //name all units before submit
                    var units=document.getElementsByClassName('node_div');
                    var N=1;
                    for (var i=0;i<units.length;i++){
                        var children=units[i].childNodes;
                        if (children[2]){
                            children[0].name='flag'+N;
                            children[3].name='id'+N;
                            children[2].name='contents'+N;
                            N++;
                        }
                    }
                    //return num of units
                    var num=document.getElementsByName('unit_num');//group of elements whose name is unit_num
                    num[0].value=N-1;
                    alert('Submit successfully!');
                }
                function insert_node_after() {
                    var new_node=add_node();
                    var node=document.getElementsByName('checkbox');
                    var main_form=document.getElementById('main_form');
                    var checked=new Array();
                    for (var i=0;i<node.length;i++){
                        if (node[i].checked){
                            checked.push(node[i]);
                        }
                    }
                    //insert new unit in the bottom of chosen unit
                    if (checked.length==1){
                        var parent=checked[0].parentNode;
                        if (parent==main_form.lastChild){
                            //selected unit is the last child of parent, directly append new_node
                            main_form.appendChild(new_node);
                        }else {
                            //selected unit in middle of the form, insert new_node after
                            main_form.insertBefore(new_node,parent.nextSibling);
                        }
                    }else if (main_form.length==1){
                        main_form.appendChild(new_node);
                    }else{
                        alert("You should choose one unit when adding new unit!");
                    }
                }
            </script>
        </head>
        <body>
            <div class="tools">
                <p><h1><?php print '<h1>'.$page.'</h1>' ?></h1></p>
                <p>
                    Type:
                    <?php
                    mk_menu('type',array('h1','h2','h3','text','code','graph'));
                    ?>
                    <button value="Insert" onclick="insert_node_after()">Insert</button>
                    <button onclick="del_node()">Delete</button>
                </p>
            </div>
            <div class="body">
                <form id="main_form" action="Functions/edit_handle.php" method="post" onsubmit="name_nodes()">
                    <input type="submit" value="Save">
                    <input type="hidden" name="unit_num">
                    <?php
                        print_unit($page);
                    ?>
                </form>
            </div>
        <?php
    }
    include 'Templates/footer.php';

