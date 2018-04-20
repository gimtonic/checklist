<?php
/**
 * Created by PhpStorm.
 * User: toha
 * Date: 1/28/18
 * Time: 7:28 AM
 */
session_start();

require 'src/PgSQL.php';
require 'config.php';



if($_POST['status'] == "true") {

    $dbconn->select("INSERT INTO items_to_list (items_id, list_id) VALUES (".$_POST['value'].",".$_SESSION['list_id'][0]['id'].");");

}else {
    $dbconn->select("DELETE FROM items_to_list WHERE items_id=".$_POST['value']." AND list_id=".$_SESSION['list_id'][0]['id'].";");
}



//if($_POST['status'] == "true") {
//
//    $_SESSION[$_POST['id']] = 1 ;
//
//}else {
//    $_SESSION[$_POST['id']] = 0;
//}


//for($i=0; $i < count($_SESSION["items"]); $i++)
//{
//    if ($_POST['checkgroup'][$i]) {
//        $dbconn->select("INSERT INTO items_to_list (items_id, list_id) VALUES (".$_POST['checkgroup'][$i].",".$_SESSION['list_id'][0]['id'].");");
//    }else{
////        $dbconn->select("DELETE FROM items_to_list WHERE items_id=".$_SESSION['items'][$i]['id']." AND list_id=".$_SESSION['list_id'][0]['id'].";");
//    }
//
//
//
//
//}


?>
