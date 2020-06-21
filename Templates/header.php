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
    <script>
        import 'Functions/dialog.js';
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
            </div>
<!--            <div>-->
<!--                <form id='dialog' style="display: none;position: fixed">-->
<!--                    <table>-->
<!--                        <tr>-->
<!--                            <th>New</th>-->
<!--                            <th>Delete</th>-->
<!--                        </tr>-->
<!--                    </table>-->
<!--                </form>-->
		</div>