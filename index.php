<?php
    if (!(isset($_COOKIE['usrname']))){
        header('Location:login.php');
        exit();
    }
    include 'Functions/mk_header_index.php';
    include 'Functions/show_guide.php';
    include 'Functions/show_page.php';
    ?>
        <?php
        include 'Templates/header.php';
        ?>
		<div class="body">
            <div class="guide_left">
                <?php
                    show_guide();
                ?>
            </div>
            <div class="contents">
                <?php
                    if (!isset($_GET['page'])){
                        show_page('root');
                    }else{
                        show_page($_GET['page']);
                    }
                ?>
            </div>
        </div>
        <?php
            include 'Templates/footer.php';
            ?>