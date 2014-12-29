<?php
/**
 * Serves as the basic template for the game
 * it makes the board and holds all html and 
 * css design
 */
require_once '../php/autoload.php';

if(!isset($_SESSION)){session_start();}

?>
		
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>Magic_Chess_Game</title>
	<meta http-equiv="Content-Type"
		content="application/xhtml+xml; charset=utf-8" />
	<link rel="stylesheet" href="../css/game.css" type="text/css" />
	<script src="//code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>  <!-- Will include jquery 1.11.1 -->
	<script type="text/javascript" src="../js/jquery.metadata.js"></script>
	<script type="text/javascript" src="../js/jquery.quickflip.js"></script>
	<script type="text/javascript" src="../js/game.js"></script>
</head>
<style>
	<?php
		print $_SESSION['game']['mc']->board->get_css();
	?>
</style>
<body>
	<h3>Magic_Chess_Game</h3>
	<div id="game_board" style="width:<?php print $_SESSION['game']['mc']->board->get_cols()*75; ?>px;">
	<?php
		print $_SESSION['game']['mc']->board->get_html();
	?>
	</div>
	<div id="turn">
		<span><?php echo $_SESSION['game']['mc']->turn ?></span> Go!
	</div>
	<div id="player_won"></div>
	<div id="start_again">
		<a id="again" href="#">Click here to play again</a>
	</div>
</body>
</html>
