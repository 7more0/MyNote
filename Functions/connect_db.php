<?php
//configure database settings here
//put this file outside the accessible folder

//global variables config
$upload_base='E://A/WorkShop/XAMPP/htdocs/www/MyNote/Storage/';//base path of upload file(such as file/photo)
$read_base='Storage/';

//configure database
//$database_type='sqlite';
$database_type='mysql';
$name='sys';//database name

if ($database_type=='mysql'){
    //database connection config for mysql
        if ($dbc=mysqli_connect('localhost','root','install')){
//            $query="CREATE DATABASE IF NOT EXISTS $name";
            if (mysqli_select_db($dbc,$name)){
                //choose database
            }else{
    //          could not find database, program initiate
                $err=mysqli_error($dbc);
                $query = "CREATE DATABASE IF NOT EXISTS $name";
                mysqli_query($dbc, $query);
                mysqli_select_db($dbc, $name);
                $query=<<<EOF
CREATE TABLE usrs(id INT NOT NULL,
            usrname VARCHAR(10) NOT NULL,
            passwd VARCHAR(50) NOT NULL,
            privilege VARCHAR(10) NOT NULL,
            reg_time datetime DEFAULT NULL,
            pages VARCHAR(10) DEFAULT NULL,
            PRIMARY KEY (id));
EOF;
                mysqli_query($dbc, $query);
                mysqli_query($dbc, "INSERT INTO usrs (id, usrname, passwd, privilege) VALUES (0, 'root', 'paIZ4ohqoSopg', 'all');");
                mysqli_query($dbc, "INSERT INTO usrs (id, usrname, passwd, privilege) VALUES (1, 'admin', 'paT/1YTFu9I5w', 'all');");
                mysqli_query($dbc, "INSERT INTO usrs (id, usrname, passwd, privilege) VALUES (2, 'visitor', 'pa8a2pQQs9oAk', 'none');");
//                $err=mysqli_error($dbc);
////                echo $err;
                $query=<<<EOF
CREATE TABLE sys_index(
            `id` INT PRIMARY KEY  NOT NULL,
            `name` VARCHAR(30) NOT NULL ,
            type VARCHAR(30) NOT NULL ,
            father varchar(30) not null ,
            son varchar(30) default null );
EOF;
                mysqli_query($dbc, $query);
                mysqli_query($dbc, "INSERT INTO sys_index (id, name, type, father, son) VALUES (0, 'root', 'index', 'r', '');");
                $query=<<<EOF
CREATE TABLE root (
            `id` int(11) NOT NULL AUTO_INCREMENT,
  `flag` VARCHAR(512) NOT NULL,
  `son` VARCHAR (512) DEFAULT NULL,
  `contents` VARCHAR(512) DEFAULT NULL,
  `father` VARCHAR(512) DEFAULT NULL,
  create_time datetime DEFAULT NULL,
  `last_edit_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);
EOF;
                mysqli_query($dbc, $query);
                mysqli_query($dbc, "INSERT INTO root(id, flag, son, contents, father, create_time) VALUES (1, 'h1', '2,5', 'Welcome to MyNote!', 'root', SYSDATE());");
                mysqli_query($dbc, "INSERT INTO root(id, flag, son, contents, father, create_time) VALUES (2, 'h2', '3,4', 'Write down your ideas and what you have learned here.', 1, SYSDATE());");
                mysqli_query($dbc, "INSERT INTO root(id, flag, son, contents, father, create_time) VALUES (3, 'text', '', 'You can also share your notes with chosen users.<br/>We support both English and Chinese.', 2, SYSDATE());");
                mysqli_query($dbc, "INSERT INTO root(id, flag, son, contents, father, create_time) VALUES (4, 'code', '', '# --------------------------------------------<br />
# This is an example of code in MyNote<br />
git clone https://github.com/7more0/MyNote.git', 2, SYSDATE());");
                mysqli_query($dbc, "INSERT INTO root(id, flag, son, contents, father, create_time) VALUES (5, 'h2', '', 'Get started now!', 1, SYSDATE());");
            }
        }else{
            $err=mysqli_error();
        }
}




