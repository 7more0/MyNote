<?php
    function is_exist($table,$folder){
        //check if $table exists and insert $table if not
        include 'connect_db.php';
        $query="SELECT * FROM $table";
        if(!mysqli_query($dbc,$query)){
            $query="CREATE TABLE `".$table."` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
  `flag` varchar(255) NOT NULL,
  `son` varchar(255) DEFAULT NULL,
  `contents` varchar(255) DEFAULT NULL,
  `father` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `last_edit_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);";
            //add table into sys_index
            mysqli_query($dbc,$query);
            //insert record(id=0) title(h1)
            $date=date('Y-m-d H:i:s',time());
            $query="INSERT INTO $table (id,flag,contents,father,date) VALUES (0,'h1','{$table}','root','{$date}')";
            mysqli_query($dbc,$query);
            $query="INSERT INTO sys_index (name,type,father) VALUES ('"."{$table}','page','{$folder}')";
            mysqli_query($dbc,$query);
            $query="SELECT son FROM sys_index WHERE name='".$folder."'";
            $result=mysqli_query($dbc,$query);
            $sons=mysqli_fetch_array($result)['son'];
            if ($sons==''){
                //empty folder
                $sons=$table;
            }else{
                $sons=$sons.",{$table}";
            }
            $query="UPDATE sys_index SET son ='{$sons}' WHERE name='".$folder."'";
            mysqli_query($dbc,$query);
            print '<h1>Successfully add a new page!</h1><meta http-equiv="refresh" content="1;url=\'../index.php\'">';
        }else{
            print '<h1>This page already exists!</h1><meta http-equiv="refresh" content="1;url=\'../index.php\'">';
        }
        mysqli_close($dbc);

    }

    function del_page($table, $folder, $dbc){
        //delete $table and clear the index_tree
//        include 'connect_db.php';
        //delete table
        $query="DROP TABLE $table";
        mysqli_query($dbc,$query);
        $query="DELETE FROM sys_index WHERE name='{$table}'";
        mysqli_query($dbc,$query);
//        print mysqli_error($dbc);
        //clear the index tree
        $query="SELECT son FROM sys_index WHERE name='".$folder."'";
        $result=mysqli_query($dbc,$query);
        $sons=mysqli_fetch_array($result)['son'];
        if (count(explode(',', $sons))==1){
            $search=$table;
        }else{
            $search=",".$table;
        }
        $sons=str_ireplace($search,'',$sons);
        $query="UPDATE sys_index SET son ='{$sons}' WHERE name='{$folder}'";
        mysqli_query($dbc,$query);
        mysqli_close($dbc);
    }

    //is_exsit('test','sys');
    //del_page('test','sys');