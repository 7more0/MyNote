<?php
//apply operation on both pages and folders.
//include add/delete pages/folders.
include 'is_exist and del_page.php';
include 'connect_db.php';

function type_check($name, $dbc){
//    check type of object in selected list.
//    $folder_match=0;
    $query = "SELECT * FROM sys_index WHERE name='{$name}'";
    $result=mysqli_query($dbc, $query);
    $result=mysqli_fetch_array($result);
    if ($result['type']=='folder'){
        $folder_match=1;
    }else{
        $folder_match=0;
    }
    $path=$result['father'];
    return array($folder_match, $path);
//    if ($folders[0]==''){
//        echo '<h1>Datbase is empty!</h1>';
//    }else{
//        foreach ($folders as $key=>$val){
//            if ($val==$name){
//                $folder_match=1;
//                $path='root';
//            }
//        }
//        if ($folder_match==0){
//            //page; return type and path
//            $query = "SELECT * FROM sys_index WHERE name='{$name}'";
//            $result=mysqli_query($dbc, $query);
//            $path=mysqli_fetch_array($result)['father'];
//        }
//        return array($folder_match, $path);
//    }
}

if (isset($_POST['dia_add'])){
    //add folder/page
    $f_name=$_POST['dia_add_input'];
    if (is_numeric($f_name)){
        echo "<h1>Number is not supported to be page name!</h1>";
        echo '<meta http-equiv="refresh" content="1;url=\'../index.php\'">';
        return 0;
    }
    $f_type=$_POST['dia_add_type'];
    $f_path=$_POST['dia_add_path'];
    if ($f_type=='page'){
        //check if this page exists, add new page if not.
        is_exist($f_name, $f_path);
    }elseif ($f_type=='folder'){
//        check if folder already exists.
        $query="SELECT * FROM sys_index WHERE name='"."{$f_name}'";
        $result=mysqli_query($dbc,$query);
        if($row=mysqli_fetch_array($result)){
            //folder exists
            print '<h1>This folder already exists!</h1>';
            ?>
            <meta http-equiv="refresh" content="1;url='../index.php'">
            <?php
        }else{
            //insert new record into sys_index
            $query="INSERT INTO sys_index (name,type,father) VALUES ('"."{$f_name}','index','root')";
            mysqli_query($dbc,$query);
            //link new folder under root
            $query="SELECT * FROM sys_index WHERE name='root'";
            $result=mysqli_query($dbc,$query);
            $sons=mysqli_fetch_array($result)['son'];
            if ($sons[0]==''){
                //avoid spare ','
                $insert=$f_name;
            }else{
                $insert=','.$f_name;
            }
            $query="UPDATE sys_index SET son ='$sons"."{$insert}' WHERE name='root'";
            mysqli_query($dbc,$query);
            print '<h1>Folder added successfully!</h1>';
            ?>
            <meta http-equiv="refresh" content="1;url='../index.php'">
            <?php
        }
    }
}elseif (isset($_POST['dia_del'])){
    //del folder/page
    $del_sel=$_POST['del_sel'];     //delete list
    foreach ($del_sel as $item) {
        //  check object type and path
        [$type_mark, $path]=type_check($item, $dbc);//1 if type is folder
        if ($type_mark==1){
            //folder
            $query="SELECT * FROM sys_index WHERE name='"."{$item}'";
            $result=mysqli_query($dbc,$query);
            if(!$row=mysqli_fetch_array($result)){
                print "This folder doesn't exists!";
                ?>
                <meta http-equiv="refresh" content="1;url='../index.php'">
                <?php
            }else{
                //delete sons
                $query="SELECT son FROM sys_index WHERE name='{$item}'";
                $result=mysqli_query($dbc,$query);
                $sons=explode(',',mysqli_fetch_array($result)['son']);
                foreach ($sons as $key=>$val) {
                    //delete index in sys_index, delete table
                    $query="DELETE FROM sys_index WHERE name='{$val}';TRUNCATE TABLE {$val}";
                    mysqli_query($dbc,$query);
                }
                //delete folder record
                $query="DELETE FROM sys_index WHERE name='{$item}'";
                mysqli_query($dbc,$query);
                //unlink from root
                $query="SELECT * FROM sys_index WHERE name='root'";
                $result=mysqli_query($dbc,$query);
                $sons=mysqli_fetch_array($result)['son'];
                if ($item==$sons[0]){
                    //avoid additional ','
                    $search=$item;
                }else{
                    $search=','.$item;
                }
                //replace table name with ''
                $sons=str_ireplace($search,'',$sons);
                $query="UPDATE sys_index SET son ='"."$sons'"." WHERE name='root'";
                mysqli_query($dbc,$query);
                ?>
                <meta http-equiv="refresh" content="1;url='../index.php'">
                <?php
            }
        }else{
            //page
            del_page($item, $path, $dbc);
            print '<h2>Done!</h2><meta http-equiv="refresh" content="1;url=\'../index.php\'">';
        }
    }
}
    ?>
