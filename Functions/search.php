<?php
    function search($type,$key_val,$con=''){
        //search database for login-check or page-print
        //require connect_db
        include 'connect_db.php';
        if($dbc){
            switch ($type) {
                case 'usr':
                    //search for user, return user's password
                    $query = "SELECT passwd FROM usrs WHERE usrname='"."$key_val'";
                    $result = mysqli_query($dbc, $query);
                    $row=mysqli_fetch_array($result);
                    mysqli_close($dbc);
                    return $row['passwd'];
                case 'page':
                    //search for page, return link to table select result
                    $query = "SELECT * FROM sys_index WHERE name='{$key_val}'";
                    $result = mysqli_query($dbc, $query);
                    mysqli_close($dbc);
                    return $result;
                case 'id':
                    //search for record in page,return link to record
                    $query="SELECT * FROM $key_val WHERE id=$con";
                    $result=mysqli_query($dbc,$query);
                    mysqli_close($dbc);
                    return $result;
            }
        }else{
            print 'Action failed due to connection error!';
        }
    }
    //search('usr','root');
    //search('id','test',0);