<?php
    //display all contents in hand for editing
    //include 'search.php';
    function br2nl($text){
        //<br> to \r or \r\n
        return preg_replace('/<br\\s*?\/??>/i','',$text);
    }
    function write_contents_edit($row){
        //不同类型输出
        print '<div class="node_div">';
        print "<input type='hidden' value='{$row['flag']}'>";
        print '<input type="checkbox" name="checkbox">';
        if ($row['flag']=='h1'||$row['flag']=='h2'||$row['flag']=='h3'){
            print "<input type='text' value='{$row['contents']}'>";
            print "<input type='hidden' value='{$row['id']}'>";
            print '</div>';
        }elseif ($row['flag']=='text'||$row['flag']=='code'){
            $contents=br2nl($row['contents']);//replace <br/> with \r
            print "<textarea>{$contents}</textarea>";
            print "<input type='hidden' value='{$row['id']}'>";
            print '</div>';
        }elseif ($row['flag']=='graph'){
            echo "<img src='{$row['contents']}' height='200px'>";
            print "<input type='file' value='{$row['contents']}'>";
            print "<input type='hidden' value='{$row['id']}'>";
            print '</div>';
        }else{
            print "<input type='file' value='{$row['contents']}'>";
            print "<input type='hidden' value='{$row['id']}'>";
            print '</div>';
        }
    }
    //此处index不可定义在print_unit内，因为与print_page不同，print_unit需要多次重复运行，会出现index重复定义错误
    function index($id, $page){
        //递归遍历并输出至子结点为空
        $res=search('id', $page, $id);
        $row = mysqli_fetch_array($res);
        write_contents_edit($row);
        //root first
        //if node has son_node,use index(son_node)
        if ($row['son']) {
            $sons = explode(',', $row['son']);
            foreach ($sons as $key => $val) {
                index($val, $page);
            }
        }
    }
    function print_unit($page){
        //print units in edit form
        //require: fun[search.php;connect_db.php]
        //include 'connect_db.php';
        $id = 1;   //mysql table start id,page title id
        index($id,$page);
        //mysqli_close($dbc);
    }
    //print_unit('root');
    ?>