<?php
/**
 * Serves as the first page of application
 * where user enters their name and are 
 * directed to the lobby after a simply name
 * check. 
 * 
 */
require_once 'autoload.php';

if(!isset($_SESSION)){session_start();}

if(isset($_POST) and isset($_POST['submitForm']) and $_POST['submitForm'] == "Login" )
{
			// get Db Configuration
			$db = Db_config::getInstance();
			// access collection
			$players = $db->players;
				
			$player = array("name" => $_POST['usr_name'],"playing_as" => "");
							
			if($players->findOne($player)){
				echo "$usr_name is taken, please choose another name";
			}else{ 
				if (!$_SESSION['player']){
					$_SESSION['player'][]=$_POST['usr_name'];
				header('Location:lobby.php');
				}
			}		
}
?>
<head>
	<script src="//code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>  <!-- Will include jquery 1.11.1 -->
	<script>
	$(document).ready(function(){		// Setting up long polling resources for multiplayer support
		$.ajax({
			url: '../php/interpoll.php',
			data: {"table":"")},
			success: function( data ) {
			}
			error : function(XMLHttpRequest, textstatus, error) { 
				alert("File required for multiplayer support: "+error);
			}
		});
	});
	</script>
</head>
<html>
<body>
<form action="signup.php" method="POST">
Name:
<input type="text" id="usr_name" name="usr_name"  />
<input  name="submitForm" id="submitForm" type="submit" value="Login" />
</form>
</body>
</html>