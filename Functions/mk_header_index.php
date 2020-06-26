<?php
    include 'Functions/StickyInput.php';
    function mk_header_index(){
        //print index in header
            include 'connect_db.php';
            //print elements whose flag=index
            $query="SELECT son FROM sys_index WHERE name='root'";
            $row=mysqli_fetch_array(mysqli_query($dbc,$query));
            $sons=explode(',',$row['son']);
//            ul
//              li>div> folder
//                  div>ul>li page
            print '<ul>';
            foreach ($sons as $key=>$value){
                print "<li><div><a href='index.php?folder={$value}'>$value</a></div>";
                //print pages
                $query="SELECT son FROM sys_index WHERE name='"."$value'";
                $row=mysqli_fetch_array(mysqli_query($dbc,$query));
                if (!empty($row['son'])){
                    $son_os=explode(',',$row['son']);
                    print '<div><ul>';
                    foreach ($son_os as $k=>$val){
                        $url=urldecode('index.php?page='.$val);
                        print "<li><a href=$url>$val</a></li>";
                    }
                    print '</ul></div>';
                }
                print '</li>';
            }
            //index control form
            print '<li><div><img src="Pics/manage.png" style="height: 20px;width: 40px;" onclick="javascript:show_dialog(\'dialog\',200,200)"></div>';
//              old version
//            print '<li style="border-right: none;width: auto;"><div><form method="post" action="Functions/edit_index.php"><p>';
//            echo 'Folder:<input type="text" name="name" autocomplete="off">';
//            echo '<input type="submit" name="add" value="+"><input type="submit" name="del" value="-"></p>';
//            print '</form></div>';
            echo '<div><ul>';
            $write = <<<heredoc
<li><a onclick="javascript:show_dialog('dialog_add',200,200)" href="#">New</a></li>
heredoc;
            echo $write;
            $write=<<<heredoc
<li><a onclick="javascript:show_dialog('dialog_del',200,200)" href="#">Delete</a></li>
heredoc;
            print $write;
            print '</ul></div></li>';
//            echo '</ul>';
            //user information
            $user=$_COOKIE['usrname'];
//            $time=date('m d',time());
            echo '<li>';
            $write=<<<heredoc
<div id='user_info'><a>$user</a></div>
heredoc;
            echo $write;
            echo "<div><ul><li><form method='post' action='login.php'><button id='logout' name='logout' value='logout'>Logout</button></form>";
            echo "</li></ul></div>";
            echo "</li></ul>";//end of index list
        mysqli_close($dbc);
    }
    //mk_header_index();


//dialog
    function mk_dialog_table_del(){
//        delete dialog table
        include 'connect_db.php';
        $query="SELECT son FROM sys_index WHERE name='root'";
        $row=mysqli_fetch_array(mysqli_query($dbc,$query));
        $sons=explode(',',$row['son']);
        $write=<<<heredoc
<table><tr><th><p><b>Delete folder/page:</b></p></th><th><img src='Pics/quit.png' onclick="javascript:hide_dialog('dialog_del')"></th></tr>
heredoc;
        echo $write;
//        echo '<tr><th><p><b>Delete folder/page:</b></p></th></tr>';
        print '<tr><th><ol>';
        foreach ($sons as $key=>$value) {
            //print folder
            print "<li><div>$value<input type='checkbox' name='del_sel[]' value=$value></div>";
            //print pages
            $query = "SELECT son FROM sys_index WHERE name='" . "$value'";
            $row = mysqli_fetch_array(mysqli_query($dbc, $query));
            if (!empty($row['son'])) {
                $son_os = explode(',', $row['son']);
                print '<ol>';
                foreach ($son_os as $k => $val) {
                    print "<li>$val<input type='checkbox' name='del_sel[]' value=$val></li>";
                }
                print '</ol>';
            }
            print '</li>';
        }
        print '</ol>';
        echo '<button name="dia_del" class="dialog_button" value="del">DEL</button></th></tr></table>';
    }


    function mk_dialog_table_add(){
//        add dialog table
        include 'connect_db.php';
        $query="SELECT son FROM sys_index WHERE name='root'";
        $row=mysqli_fetch_array(mysqli_query($dbc,$query));
        $sons=explode(',',$row['son']);
        $write=<<<heredoc
<table><tr><th><p><b>Add new foler/page:</b></p></th><th><img src='Pics/quit.png' onclick="javascript:hide_dialog('dialog_add')"></th></tr>
heredoc;
        echo $write;
//        echo '<tr><th><p><b>Add new foler/page:</b></p></th></tr>';
        echo '<tr><th>Type: <select name="dia_add_type" onclick="javascript:path_control()">';
        echo '<option value="folder">Folder</option><option value="page">Page</option></select>  ';
        echo 'Path: <select name="dia_add_path">';
        echo '<option value="root" name="add_path_root">root</option>';
        foreach ($sons as $key=>$value){
            echo "<option value=$value>$value</option>";
        }
        echo '</select></th></tr>';
        echo '<tr><th><p>Name: <input type="text" name="dia_add_input"></p>';
        echo '<button name="dia_add" class="dialog_button" value="add">ADD</button></th></tr></table>';

    }
