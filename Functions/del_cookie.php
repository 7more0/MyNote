<?php
    function del_cookie($co_li){
        foreach ($co_li as $item=>$value){
            setcookie($value,'',time()-1000);
        }
    }
    ?>