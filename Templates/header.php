<?php
?>
    <!DOCTYPE html>
<html>
<head>
	<title>HOME</title>
	<style type="text/css">
		@import "CSS/header.css";
        @import "CSS/body.css";
        @import "CSS/footer.css";
	</style>
    <script type="text/javascript" src="Functions/dialog.js">
    </script>
</head>
<body>
	<div class="main">
		<div class="header">
			<div class="header_img_div">
                <img src="Pics/header_1.png">
                <div style="float: right">
                    <h1>MyNote</h1>
                </div>
            </div>
            <div class="header_index_div">
                <?php
                    mk_header_index();
                ?>
                <div id='dialog_add' class="dialog" title="Page Management" style="display: none">
                    <form style="background: var(--header-bgcolor)" action="Functions/opt_all.php" method="post">
                        <?php
                            mk_dialog_table_add();
                        ?>
                    </form>
                </div>
                <div id="dialog_del" class="dialog" title="Page Management" style="display: none">
                    <form style="background: var(--header-bgcolor)" action="Functions/opt_all.php" method="post">
                        <?php
                            mk_dialog_table_del();
                        ?>
                    </form>
                </div>
            </div>

		</div>