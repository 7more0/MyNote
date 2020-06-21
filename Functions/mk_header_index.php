<?php
    include 'Functions/StickyInput.php';
    function mk_header_index(){
        //print index in header
            include 'connect_db.php';
            //print elements whose flag=index
            $query="SELECT son FROM sys_index WHERE name='root'";
            $row=mysqli_fetch_array(mysqli_query($dbc,$query));
            $sons=explode(',',$row['son']);
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
            //print index control form
            print '<li><div><img src="Pics/manage.png" style="height: 20px;width: 40px;"></div>';
//            print '<li style="border-right: none;width: auto;"><div><form method="post" action="Functions/edit_index.php"><p>';
//            echo 'Folder:<input type="text" name="name" autocomplete="off">';
//            echo '<input type="submit" name="add" value="+"><input type="submit" name="del" value="-"></p>';
//            print '</form></div>';
            echo '<div><ul>';
            echo "<li><a>New Folder</a></li>";
            print "<li><a>New Page</a></li>";
            //echo '<li><div><b><h1 style="float: left; width: 50px">MyNote</h1></b></div></li>';
            print '</div></ul></li></ul>';
        mysqli_close($dbc);
    }
    //mk_header_index();
