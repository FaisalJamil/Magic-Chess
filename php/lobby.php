<?php
/**
 * This files serves as template for lobby
 * having 3 tables, and a place for players
 * to get ready and start a game. 
 * 
 */
require_once '../php/autoload.php';
if(!isset($_SESSION)){session_start();}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>Lobby</title>
	<meta http-equiv="Content-Type"
		content="application/xhtml+xml; charset=utf-8" />
	<link rel="stylesheet" href="../css/lobby.css" type="text/css" />
	<script src="//code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>  <!-- Will include jquery 1.11.1 -->
	<script type="text/javascript" src="../js/lobby.js"></script>
</head>
	<body>
		<div class="container">
			<?php for ($i=0; $i<3; $i++){?>
				<div id="table<?=$i?>" class="circle table">
					<div id="player1oftable<?=$i?>" class="circle player" style="display:none;"></div>
					<div id="player2oftable<?=$i?>" class="circle player" style="display:none;"></div>					
				</div> 
			<?}?>
		</div>
    <div id="messages">
        <div class="msg old">
            <!-- Message requester! -->
        </div>
    </div>
		
	</body>
</html>

