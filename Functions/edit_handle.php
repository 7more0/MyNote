<?php
//handle data edit_page submit
include 'connect_db.php';
    function insert_new($dbc,$page,$node){
        //insert new record,return id
        $query="INSERT INTO $page (flag,contents) VALUES ('{$node->flag}','{$node->contents}')";
        mysqli_query($dbc,$query);
        $node_id=mysqli_insert_id($dbc);
        return $node_id;
    }
    function add_son($dbc,$page,$father_id,$node_id){
        //add record as a new son to father node
        //set new_node.father
        $query="UPDATE $page SET father={$father_id} WHERE id={$node_id}";
        mysqli_query($dbc,$query);
        //add new_son to father_id
        $query="SELECT son FROM $page WHERE id=$father_id";
        if ($res=mysqli_query($dbc,$query)){
            $sons=mysqli_fetch_array($res)['son'];
        }else{
            $sons=false;
        }
        if (empty($sons)){
            $query="UPDATE $page SET son='"."$node_id"."' WHERE id=$father_id";
        }else{
            $query="UPDATE $page SET son='".$sons.",$node_id"."' WHERE id=$father_id";
        }
        mysqli_query($dbc,$query);
    }
    function complete_tree($page,$nodes){
        //complete page tree
        include 'connect_db.php';
        //reset all tree index
        //clear father and son except title
        $query="UPDATE $page SET father='',son='' WHERE father<>'root'";mysqli_multi_query($dbc,$query);
        $query="UPDATE $page SET son='' WHERE father='root'";mysqli_multi_query($dbc,$query);
        $weight=array('h1'=>6,'h2'=>5,'h3'=>4,'text'=>3,'code'=>3,'graph'=>3);
        foreach ($nodes as $n=>$node){
            if (is_numeric($node->id)){
                //former node
                $node_id=$node->id;
                //update content
                $query="UPDATE $page SET contents='{$node->contents}' WHERE id='{$node_id}'";
                mysqli_query($dbc,$query);
            }else {
                //new node
                $node_id = insert_new($dbc, $page, $node);
                $node->id=$node_id;      //update id data
            }
            //build family tree
            $pointer=$n-1;
            while (($pointer>=0)){
                //trace back by nodes and insert operating record to nearest higher level record
                $father=$nodes[$pointer];
                if ($weight[$father->flag]>$weight[$node->flag]){
                    add_son($dbc,$page,$father->id,$node_id);
                    break;
                }else{
                    $pointer--;
                }
            }
        }
        //clear all nodes not in index(deleted records)
        $query="DELETE FROM $page WHERE father=''";
        mysqli_query($dbc,$query);
        $query="DELETE FROM $page WHERE father IS NULL";
        mysqli_query($dbc,$query);
        mysqli_close($dbc);
    }
    //var_dump($_POST);
    $unit_num=$_POST['unit_num'];
    if ($_POST['contents1']=='Welcome to MyNote!'){
        $page='root';
    }else{
        $page=$_POST['contents1'];
    }
    class node{
        public $id;
        public $flag;
        public $contents;
    }
    $nodes=array();  //all records
    for ($i=1;$i<=$unit_num;$i++){
        $node=new node();
        //if ($_POST['id'.$i]){
            $node->id=trim(htmlspecialchars($_POST['id'.$i]));
        //}
        $node->flag=trim(htmlspecialchars($_POST['flag'.$i]));
        if ($node->flag=='graph'){
            //for file or photo objects, store file path in database
            global $upload_base;
            global $read_base;
            $path=$upload_base.$_FILES['contents'.$i]['name'];
            move_uploaded_file($_FILES['contents'.$i]['tmp_name'], $path);//store
            $path=$read_base.$_FILES['contents'.$i]['name'];
            $node->contents=$path;
        }else{
            $node->contents=nl2br(strip_tags($_POST['contents'.$i]));
        }
        array_push($nodes,$node);
    }
    complete_tree($page,$nodes);
    //complete_tree('RaspberryPi',$nodes);
    ?>
    <meta http-equiv="refresh" content="1;url=../index.php?page=<?php print $page; ?>">

