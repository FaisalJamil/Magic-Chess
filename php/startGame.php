<?php
/**
 * This file is responsible to prepare resources
 * to start a game, such as checking if the two 
 * players are ready, making their objects, preparing
 * a board that will be shared, and starting a game
 * 
 */
require_once 'autoload.php';
include 'config.php';

if(!isset($_SESSION)){session_start();}

use \ChessNS\Units;
use \ChessNS\Board;
use \ChessNS\Player;
use \ChessNS\Game;

$level = 1; $cols = 8;

$memcache = new Memcache;
//Connect to Memcached.
$memcache->connect('localhost') or die ("Could not connect to Memcached server!");

// get Db Configuration
$db = Db_config::getInstance();
// access collection
$players = $db->players;
$game = $db->games;

/**
 * Checks if both players are ready
 */
if(isset($_POST['submitForm']) and $_POST['submitForm'] == "Start" )
{
	if (!$_SESSION['player']){
		echo "Players data not available";	
	}
	else{ 
		/**
		 * Generates objects of each player
		 */
		if(!$temp = $memcache->get('newPlayer1')){
			$memcache->set('newPlayer1', $_SESSION['player'][0], MEMCACHE_COMPRESSED, 0);
		}
		else
			$memcache->set('newPlayer2', $_SESSION['player'][0], MEMCACHE_COMPRESSED, 0);
				
			$_SESSION["game"]["player1"] = new Player($memcache->get('newPlayer1'), "red");
			$_SESSION["game"]["player2"] = new Player($memcache->get('newPlayer2'), "black");
		 
	}
	/**
	 * Generates a shuffled game board for each game
	 * sanitizing technique was used to share the same
	 * board between two players.
	 * 
	 */
	if (!isset($_SESSION['game']['board'])){
		
		$buffer = new Board($level, $units, $double, $five, $cols);
		if(!$temp = $memcache->get('newBoard')/* file_get_contents($file) */){
			$serial_obj = serialize($buffer);
			$memcache->set('newBoard', $serial_obj, MEMCACHE_COMPRESSED, 0);
			$temp = $memcache->get('newBoard');
		}
		$_SESSION['game']['board'] = unserialize($temp);
	}
	/**
	 * Generates a game that holds 2 persons and a board to play and some heirarchy rules
	 * to follow
	 */
	if (!$_SESSION['game']['mc']){
		$_SESSION['game']['mc'] = new Game($_SESSION['game']['player1'], $_SESSION['game']['player2'], $_SESSION['game']['board'], $heirarchy);
	
		//if they haven't started a game yet let's load one
		$_SESSION['game']['mc']->start();
	}
	
	header('Location: ../templates/template.php');
}
?>

<html>
<head>
	<script src="//code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>  <!-- Will include jquery 1.11.1 -->
	<script type="text/javascript" src="../js/lobby.js"></script>
</head>
<body>
	<form id="startGame" action="startGame.php" method="POST">
		Press Start!:
		<input  name="submitForm" id="submitForm" type="button" value="Start" />
	</form>
	<div id="messages">
    </div>
</body>
</html>