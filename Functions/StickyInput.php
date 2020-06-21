<?php
    function sticky_input($label,$name,$type,$size=20,$class=''){
        print '<p><lable>'.$label.':';
        print '<input style="float: right;" class="'.$class.'" autocomplete="off" name="'.$name.'" type="'.$type.'" size="'.$size.'"';
        if (isset($_POST[$name])){
            print 'value="'.htmlspecialchars($_POST[$name]).'"';
        }
        print '/></label></p>';
    }
    ?>
