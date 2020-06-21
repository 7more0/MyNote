<?php
    include 'connect_db.php';
    //add folder which directly linked to root
//require connect_db
    $query="SELECT * FROM sys_index";
    if (!mysqli_query($dbc,$query)){
        $query="CREATE TABLE `sys_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `father` varchar(255) DEFAULT NULL,
  `son` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`));
  INSERT INTO sys_index (id,name,type) VALUES (1,'root','index')";
        mysqli_multi_query($dbc,$query);
    }
    if (isset($_POST['name'])){
        if (isset($_POST['add'])){
            //add folder
            $query="SELECT * FROM sys_index WHERE name='"."{$_POST['name']}'";
            $result=mysqli_query($dbc,$query);
            if($row=mysqli_fetch_array($result)){
                print 'This folder already exists!';
                ?>
                <meta http-equiv="refresh" content="1;url='../index.php'">
                <?php
            }else{
                //insert new record into sys_index
                $query="INSERT INTO sys_index (name,type,father) VALUES ('"."{$_POST['name']}','index','root')";
                mysqli_query($dbc,$query);
                //link to root
                $query="SELECT * FROM sys_index WHERE name='root'";
                $result=mysqli_query($dbc,$query);
                $sons=mysqli_fetch_array($result)['son'];
                if ($sons[0]==''){
                    //avoid spare ','
                    $insert=$_POST['name'];
                }else{
                    $insert=','.$_POST['name'];
                }
                $query="UPDATE sys_index SET son ='$sons"."{$insert}' WHERE name='root'";
                mysqli_query($dbc,$query);
                print 'Folder added successfully!';
                ?>
                <meta http-equiv="refresh" content="1;url='../index.php'">
                <?php
            }
        }elseif (isset($_POST['del'])){
            //delete folder
            $query="SELECT * FROM sys_index WHERE name='"."{$_POST['name']}'";
            $result=mysqli_query($dbc,$query);
            if(!$row=mysqli_fetch_array($result)){
                print "This folder doesn't exists!";
                ?>
                <meta http-equiv="refresh" content="1;url='../index.php'">
                <?php
            }else{
                //delete sons
                $query="SELECT son FROM sys_index WHERE name='{$_POST['name']}'";
                $result=mysqli_query($dbc,$query);
                $sons=explode(',',mysqli_fetch_array($result)['son']);
                foreach ($sons as $key=>$val) {
                    $query="DELETE FROM sys_index WHERE name='{$val}'";
                    mysqli_query($dbc,$query);
                }
                //delete table
                $query="DELETE FROM sys_index WHERE name='{$_POST['name']}'";
                mysqli_query($dbc,$query);
                //unlink from root
                $query="SELECT * FROM sys_index WHERE name='root'";
                $result=mysqli_query($dbc,$query);
                $sons=mysqli_fetch_array($result)['son'];
                if ($_POST['name']==$sons[0]){
                    //avoid additional ','
                    $search=$_POST['name'];
                }else{
                    $search=','.$_POST['name'];
                }
                //replace table name with ''
                $sons=str_ireplace($search,'',$sons);
                $query="UPDATE sys_index SET son ='"."$sons'"." WHERE name='root'";
                mysqli_query($dbc,$query);
                ?>
                <meta http-equiv="refresh" content="1;url='../index.php'">
                <?php
            }
        }
    }
    mysqli_close($dbc);
    ?>