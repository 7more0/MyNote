<?php
//add or delete page from form in left_guide
//require is_exist() del_page() connect_db
    include 'is_exist and del_page.php';
    include 'connect_db.php';
    if (isset($_POST['name'])&&($_POST['folder']!='root')){
        //not in root folder
        if (isset($_POST['add_page'])){
            //check existence and add page
            is_exist($_POST['name'],$_POST['folder']);
            ?>
            <!--redirect to current folder-->
            <meta http-equiv="refresh" content="1;url='../index.php?folder=<?php print $_POST['folder']; ?>'">
            <?php
        }elseif (isset($_POST['del_page'])){
            //delete page
            del_page($_POST['name'],$_POST['folder']);
            ?>
            <!--redirect to current folder-->
            <meta http-equiv="refresh" content="1;url='../index.php?folder=<?php print $_POST['folder']; ?>''">
            <?php
        }
        else{
            print "Something Wrong!";
        }
    }elseif ($_POST['folder']=='root'){
        //in root folder
        print '<h2>You should not add new folder from here!</h2>';
        ?>
        <meta http-equiv="refresh" content="1;url='../index.php'">
        <?php
    }
    mysqli_close($dbc);
    ?>