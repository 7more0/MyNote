<?php
    include 'Functions/connect_db.php';
    function add_son($father_table,$table,$type,$contents,$father){
        $query="SELECT * FROM $table";
        if (!mysqli_query($dbc,$query)){
            //if table doesn't exist, create table and insert it into index
            $query="CREATE TABLE `".$table."` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
  `flag` varchar(255) NOT NULL,
  `son` varchar(255) DEFAULT NULL,
  `contents` varchar(255) DEFAULT NULL,
  `father` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `last_edit_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);INSERT INTO sys_index (name,type) VALUES ('".$table."','page')";
            //add table into sys_index
            mysqli_multi_query($dbc,$query);
            //index new added table
            $query="SELECT * FROM sys_index WHERE name='".$father_table."'";
            $result=mysqli_query($dbc,$query);
            $sons=mysqli_fetch_array($result)['son'];
            $query="UPDATE sys_index SET son ='$sons".",{$table}' WHERE name='root'";
            mysqli_query($dbc,$query);
        }
        //add record into table
        $change_time=date('Y m d h:i:s',time());
        $query="INSERT INTO $table (flag,contents,father,date) VALUES ('".$type."','".$contents."','".$father."','".$change_time."')";
        mysqli_query($dbc,$query);
        //index new add record
        $query="SELECT * FROM sys_index WHERE name='".$father."'";
        $result=mysqli_query($dbc,$query);
        $sons=mysqli_fetch_array($result)['son'];
        $query="SELECT id FROM $table WHERE contents='".$contents."'";
        $result=mysqli_query($dbc,$query);
        $id=mysqli_fetch_array($result)['id'];
        $query="UPDATE $table SET son ='$sons".",{$id}' WHERE name='".$father."'";
        mysqli_query($dbc,$query);
        mysqli_close($dbc);
    }