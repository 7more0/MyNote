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
                break;
            case 'h2':
                print '<h2>' . $row['contents'] . '</h2>';
                break;
            case 'h3':
                print '<h3>' . $row['contents'] . '</h3>';
                break;
            case 'text':
                print '<p><pre>'.$row['contents'].'</pre></p>';
                break;
            case "code":
                print '<div class="code">';
////                auto split into lines by delimiter
//                $lines = explode(';', $row['contents']);
//                print '<ul>';
//                foreach ($lines as $key => $val) {
//                    print '<li>' . $val . '</li>';
//                }
//                print '</ul></div>';
                echo '<code>'.$row['contents'].'</code>';
                echo '</div>';
                break;
            case 'graph':
                echo "<img class='contents_img' src={$row['contents']}>";
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
                foreach ($sons as $key => $val) {
                    index($val, $page);
                }
            }
        }
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