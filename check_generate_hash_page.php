<?php
/**
 * Created by PhpStorm.
 * User: toha
 * Date: 1/27/18
 * Time: 11:06 AM
 */
require 'src/PgSQL.php';
require 'config.php';
session_start();


//_POST data and create hash
$data=$_POST;
$hash=md5($data['title']);

//Insert data in table LIST
$dbconn->select("INSERT INTO list (title, note, hash) VALUES ('".$data['title']."','".$data['note']."','".$hash."');");

//Create SESSION
$_SESSION['list_id']=$dbconn->select("SELECT id FROM list WHERE hash='".$hash."';");


$text='
<?php
session_start();

require "src/PgSQL.php";
require "config.php";

$items=$dbconn->select("SELECT id,text FROM items;");


function checkbox()
{


if(empty($_SESSION["items_to_list"])) return "";
else return "checked=\' checked\'";

}




?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Checklist</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/fonts.css" />
	<link rel="stylesheet" href="css/main.css" />
	<link rel="stylesheet" href="css/skins/tomato.css" />
	<link rel="stylesheet" href="css/media.css" />
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="wrapper-items">
                <div class="text-center">
                                <span class="wrapper-items-text">Заголовок</span><br />
                                <h4>Название</h4>
                                <p>'.$data['title'].' </p>
                                <h4>Описание</h4>
                                <p>'.$data['note'].' </p></br> 
                                <h4>text</h4> <br>  
                
                </div>
                                    <div class="wrapper-checklist">
                                        <form method="POST" action="check_ajax.php" class="form_class">   
                                        <?php
                                                foreach ($items as $k=>$v){
                                                
                                                        $_SESSION["items_to_list"]=$dbconn->select("SELECT * FROM items_to_list WHERE list_id=".$_SESSION["list_id"][0]["id"]." AND items_id=".$items[$k]["id"].";");
            
                                                    
                                                        echo "<input ". checkbox()." type=\"checkbox\" name=\"checkgroup[]\" id=\"checkboxG".$items[$k]["text"]."\" 
                                                        
                                                        class=\"css-checkbox\" value=".$items[$k]["id"]."><label for=\"checkboxG".$items[$k]["text"]."\" 
                                                        
                                                        class=\"css-label\"></label><span class=\"text-span\">".$items[$k]["text"]."</span><br>";   
 
                                                }
                                                                                                                                      
                                          ?>                              

                                        </form>     
                                    </div>
                 </div>
         </div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="js/common.js"></script>                   
</body>
</html>';


//Create and close hash file
$hash=substr($hash,0,6);
if (!file_exists($hash.".php")) {
    $hf= fopen($hash.".php","x") or die("Error!");

    fwrite($hf,$text);
    fclose($hf);
}

header( 'Location:'.$hash.'.php');

$dbconn->close();