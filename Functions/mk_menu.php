<?php
    function mk_menu($name,$list){
        print '<select id="menu">'.$name;
        foreach ($list as $item =>$value){
            print "\n".'<option value="'.$value.'">'.$value.'</option>';
        }
        print '</select>';
    }
    ?>
