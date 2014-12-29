/**
 * 
/ *  JS for Lobby
 * 
 *  This file mimics a lobby with three tables
 *  A player can enter the lobby and select a table
 *  wait for other player to join on the table and
 *  get directed to start the game
 *  
 */  

$(document).ready(function(){
	waitForMsg(); /* Start the inital request for long polling */
	$(".table").one("click", addPlayer);
	$("#submitForm").one("click", joinGame);

});
/**
 * Join a game
 * @param event
 */
function joinGame(event){
	$.ajax({
		url: '../php/interpoll.php',
		data: {"player":"join"},
		success: function( data ) {
		}
	});
}
/**
 * Checks and responds on a long polling 
 * message
 * 
 */
var cnt_players=0;
function addmsg(type, msg){
	if(msg['msg'] == "join"){
		console.log("entered join");
		cnt_players++;
		if(cnt_players > 1){

			$('<input />').attr('type', 'hidden')
            .attr('name', 'submitForm')
            .attr('value', 'Start')
            .appendTo('#startGame');
			$('#startGame').submit();
		}
		$('#messages').html('waiting for second player to join');
	}
	
	if(msg['msg'].indexOf("table") >= 0){
		if(!$("#player1of"+msg['msg']).is(':visible')){
			$("#player1of"+msg['msg']).show();return false;
		}
		if(!$("#player2of"+msg['msg']).is(':visible')){
			$("#player2of"+msg['msg']).show();
			location.href = "startGame.php";
		}
	}
}
/** 
 * Adds player to the lobby
 * 
 * @param event
 * @returns {Boolean}
 */
function addPlayer(event){
	var currentTable = event.target.id;
	if(!$("#player1of"+currentTable).is(':visible')) {
		$.ajax({
			url: '../php/interpoll.php',
			data: {"table":currentTable.replace(/\n/g,'<br />')},
			success: function( data ) {
			}
	});
		return false;
	}
	else{
		if(!$("#player2of"+currentTable).is(':visible')) {
			$.ajax({
			url: '../php/interpoll.php',
			data: {"table":currentTable.replace(/\n/g,'<br />')},
			success: function( data ) {
			}
		});
			return false;
		}
	}	
}
/**
 * Long polling implementation
 */
var timestamp = null;
function waitForMsg(){
	$.ajax({
		type : 'Get',
		url  : '../php/msgsrv.php?timestamp=' + timestamp,
		async : true,
		cache : false,
		
		success : function(data) {
					var json = $.parseJSON(data);//eval('(' + data + ')');
						addmsg("new", json);  
					
					timestamp  = json['timestamp'];
					setTimeout('waitForMsg()', 1000);
		},
		error : function(XMLHttpRequest, textstatus, error) { 
					alert(error);
					setTimeout('waitForMsg()', 15000);
		}		
	});
};