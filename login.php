<?php
    define('TITLE','Login');
    include 'Functions/StickyInput.php';
    include 'Functions/del_cookie.php';
    include 'Functions/search.php';
?>
<?php
    if (isset($_POST['logout'])){
        //logout
//        setcookie('usrname','none',time()-100);
//        setcookie('privilege', 'none', time()-100);
        del_cookie(['usrname', 'privilege']);
        header('Location:./index.php');
        exit();
    }elseif(isset($_POST['usrname'])&&isset($_POST['passwd'])&&search('usr',$_POST['usrname'])&&search('usr',$_POST['usrname'])[0]==crypt($_POST['passwd'],'passwd')){
        //login
        //var_dump($_POST);
        $privilege=search('usr',$_POST['usrname'])[1];
        setcookie('usrname',$_POST['usrname'],time()+1000);
        setcookie('privilege', $privilege, time()+1000);
        header('Location:./index.php');
        exit();
    }elseif(isset($_GET['usrname'])&&$_GET['usrname']=='visitor'){
        //visitor
        setcookie('usrname',$_GET['usrname'],time()+1000);
        setcookie('privilege', 'none', time()+1000);
        header('Location:./index.php');
    }else{
        //print_r($_POST);
        ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <title>Login</title>
            <meta charset="UTF-8">
            <style type="text/css" >
                @import "CSS/login.css";
                @import "CSS/animate.min.css";
            </style>
        </head>
        <body>
            <div id="title">
                <h1 class="animated bounceInDown" align="center"><b>Login</b></h1>
            </div>  
            <div class="c2">
                <form method="post" action="">                
                    <div class="c3">
                        <div class="c4">
                            <?php
                                sticky_input('UserName','usrname','text',30,'login_input');
                                ?>
                        </div>
                        <div class="c4">
                            <?php
                                sticky_input('PassWord','passwd','password',30,'login_input');
                                ?>
                        </div>
                        <p><input type="submit" class="login_bu" value="Submit" name="submit" style="margin-left: 40%">
                            <a href="login.php?usrname=visitor">visitor</a></p>
                </div>
            </form>
        </div>
    </body>
</html>
<?php
    }
?>



