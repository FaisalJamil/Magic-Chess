<?php
/**
 * This files server as config for different rules 
 * defined, like which units will appear double, which
 * will appear 5 times. It also describes hierarchy of
 * units, on which capturing of items depends.
 * 
 */
require_once 'autoload.php';
session_start();

// All the chess unit files we have
$units = array("../img/black_ADVISER.png","../img/red_ADVISER.png",
		"../img/black_BISHOP.png","../img/red_BISHOP.png",
		"../img/black_CANNON.png","../img/red_CANNON.png",
		"../img/black_KNIGHT.png","../img/red_KNIGHT.png",
		"../img/black_PAWN.png","../img/red_PAWN.png",
		"../img/black_ROOK.png","../img/red_ROOK.png",
		"../img/black_KING.png","../img/red_KING.png"
		);

// repeat rules for board
$double = array("../img/black_BISHOP.png", "../img/black_CANNON.png", "../img/black_KNIGHT.png",
		 		"../img/black_ROOK.png","../img/red_BISHOP.png", "../img/red_CANNON.png", "../img/red_KNIGHT.png", 
				"../img/red_ROOK.png",	"../img/black_ADVISER.png","../img/red_ADVISER.png");
$five =  array ("../img/black_PAWN.png", "../img/red_PAWN.png");

$heirarchy = array ('KING', 'ADVISER', 'BISHOP', 'ROOK', 'KNIGHT', 'CANNON', 'PAWN');

?>