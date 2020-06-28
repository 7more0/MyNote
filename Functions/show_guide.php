<?php
    function show_guide(){
        include 'connect_db.php';
        //set index(folder)
        if (isset($_GET['page'])){
            //ask for page
            $_GET['page']=str_ireplace('\'', '', $_GET['page']);
            if ($_GET['page']=='root'){
                $index='root';
            }else{
                $query="SELECT father FROM sys_index WHERE name='"."{$_GET['page']}'";
                $index=mysqli_fetch_array(mysqli_query($dbc,$query))['father'];
            }
        }elseif (isset($_GET['folder'])){
            //in root menu change folder
            $index=$_GET['folder'];
        }
        else{
            //login
            $index='root';
        }
        //$index='System';
        $query="SELECT son from sys_index WHERE name='"."$index'";
        $sons=explode(',',mysqli_fetch_array(mysqli_query($dbc,$query))['son']);
        print "<p><a href='index.php' class='home'>HOME</a><h1>$index</h1>";
//  process page level operations in old version.
//        <form action='Functions/opr_page.php' method='post'>
//        <input type='hidden' name='folder' value='".$index."'>";
//        "<input type='text' name='name' autocomplete=\"off\">
//        <input type='submit' value='+'  name='add_page'>
//        <input type='submit' value='-'  name='del_page'></form>
//        </p>\n";
        print '<h2>IN THIS FOLDER:</h2>';
        if ($sons){
            //子结点不为空（为空时划分字符串得到数组有唯一元素'')
            print '<ol>';
            foreach ($sons as $key=>$val){
                if (!($val=='')){
                    if ($index=='root'){
                        $url="index.php?folder=$val";
                    }else{
                        $url="index.php?page='{$val}'";
                    }
                    print '<li><a href="'.$url.'">'.$val.'</a></li>';
                }
            }
            print '</ol>';
        }
        mysqli_close($dbc);
        //unset($_GET['page']);
        //unset($_GET['folder']);
    }
    //show_guide();