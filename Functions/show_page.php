<?php
//print contents of page

    include 'search.php';
    function write_contents($page,$row){
        //不同类型输出
        switch ($row['flag']) {
            case 'h1':
                print '<div class="contents_title">
                                        <h1>' . $row['contents'] . '</h1>
                                        <p>build time : ' . $row['create_time'] . '</p>';
                print '<p>last edited time : ' . $row['last_edit_time'] . '<form action="edit.php" method="post">
<input type="hidden" name="page" value="'.$page.'">
<input type="submit" value="Edit" name="edit"><input type="submit" value="Delete" name="del">'."</form></p><p>";

                for ($i = 1; $i < 180; $i++) {
                    print '-';
                }
                print '</p></div>';
//                if ($row['son']!=''){
//                    echo '<ol>';//begin of page list
//                }
                echo '<ol>';//content list start
                break;
            case 'h2':
                echo '<li class="h2_li"><span><b>'. $row['contents'] .'</b></span><br>';
//                print '<h2>' . $row['contents'] . '</h2>';
                echo '<ul class="h2_ol">';
                break;
            case 'h3':
                print '<li class="content_li"><h3>' . $row['contents'] . '</h3></li>';
                break;
            case 'text':
                print '<li class="content_li"><p style="text-indent: 2em;"><pre>'.$row['contents'].'</pre></p></li>';
                break;
            case "code":
                print '<li class="content_li"><div class="code">';
//                auto split into lines by delimiter
                $row['contents']=preg_replace(array('/\r\n/', '/\n/'), '', $row['contents']);//replace all switch line symbol
                $lines = explode('<br />', $row['contents']);
                print '<ol>';
                foreach ($lines as $key => $val) {
                    print '<li>' . $val . '</li>';
                }
                print '</ol></div>';
//                echo '<code>'.$row['contents'].'</code>';
                echo '</li>';
                break;
            case 'graph':
                echo "<li class=\"content_li\"><img class='contents_img' src={$row['contents']}></li>";
                break;
        }
    }
    function show_page($page){
        include 'connect_db.php';
        function index($id, $page)
        {
            //递归遍历并输出至子结点为空
            $res=search('id', $page, $id);
            $row = mysqli_fetch_array($res);
            write_contents($page,$row);
            //root first
            //if node has son_node,use index(son_node)
            if ($row['son']) {
                $sons = explode(',', $row['son']);
//                sort($sons);
                foreach ($sons as $key => $val) {
                    index($val, $page);
                }
//                return 1;       //traveled all sons
            }
            if ($row['flag']=='h1'){
                //page title, whole page printed
                echo '</ol>';
            }elseif ($row['flag']=='h2'){
                //end of a subtitle
                echo '</ul></li><br>';
            }
//            return 0;       //node have no son
        }
        $page=str_ireplace('\'', '', $page);//table name in ``
        $res=search('page', $page);
        $row=mysqli_fetch_array($res);
        if ($row['type']=='page'||$page=='root'){
            //viewing common page
            $id = 1;   //mysql table start id,page title id
            index($id,$page);
        }else{
            //in root page
            ?>
                <div style="height: 300px;align-content: center">
                    <p><h1>Select a note to review!</h1></div>
                </div>
            <?php
        }
    mysqli_close($dbc);
    }
    //show_page('Ubuntu');