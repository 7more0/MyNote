<?php
//configure database settings here
//put this file outside the accessible folder
    if ($dbc=mysqli_connect('localhost','root','install')){
        $name='sys';     //name of database
        $query="CREATE DATABASE IF NOT EXISTS $name";
        if (mysqli_query($dbc,$query)){
            //choose database
            mysqli_select_db($dbc,$name);
        }else{
//          could not find database, program initiate
            $err=mysqli_error($dbc);
            $query = "CREATE DATABASE myDB";
            mysqli_query($query);
//            $query = 'CREATE TABLE '
        }
    }else{
        $err=mysqli_error();
    }

