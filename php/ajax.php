<?php
/**
 * Ajax interface of application
 * 
 * This file serves as basic ajax facility for the app.
 * ajax requests regarding the game are served here like, 
 * checking for movements, turns and winnings. 
 * 
 */
require_once 'autoload.php';
include 'config.php';

if(!isset($_SESSION)){session_start();}

use \ChessNS\Units;
use \ChessNS\Board;
use \ChessNS\Player;
use \ChessNS\Game;

$request = $_GET;

//respond to AJAX requests
/**
 * Determines type of request coming
 */
switch ($request['type'])
{
	case "turn":
			$_SESSION['game']['mc']->set_turn();
			echo checkTurn(false);			
			break;
	case "move":
			echo checkMove($request);
			break;
	case "end":
			echo endGame($request['wins']);
			
			// resets the session data for the rest of the runtime
			unset($_SESSION['game']['board']);
			unset($_SESSION['game']['mc']);
				
			break;
	default:
		echo "Invalid option selected.";
}
/**
 * Checks current turn 
 * @param unknown $data
 */
function checkTurn($data){
	// check turn
	return $_SESSION['game']['mc']->turn;
}
/**
 * Checks and validates the move in question
 * @param unknown $request
 */
function checkMove($request){
	return $_SESSION['game']['mc']->check_move($request);
}
/**
 * Ends a game and announces winner
 * @param unknown $request
 */
function endGame($winner){
	return $_SESSION['game']['mc']->end($winner);
}