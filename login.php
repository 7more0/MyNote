<?php
    define('TITLE','Login');
    include 'Functions/StickyInput.php';
    include 'Functions/del_cookie.php';
    include 'Functions/search.php';
?>
<?php
    if (isset($_POST['usrname'])&&isset($_POST['passwd'])&&search('usr',$_POST['usrname'])&&search('usr',$_POST['usrname'])==crypt($_POST['passwd'],'passwd')){
        //var_dump($_POST);
        setcookie('usrname',$_POST['usrname'],time()+1000);
        header('Location:./index.php');
        exit();
    }elseif (isset($_POST['logout'])){
        //logout
        setcookie('usrname','none',time()-1000);
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
                    <input type="submit" class="login_bu" value="Submit" name="submit" style="margin-left: 40%">
                </div>
            </form>
        </div>
    </body>
</html>
<?php
    }
?>



