/**
 * 
 *  JS for Magic Chess 
 *  
 *  All code related to selecting items
 *  Moving items, Synchronizing with other player
 *  Using Ajax long polling technique is written 
 *  in this file.
 *  
 *  
 *  */

$(document).ready(function(){
	/**
	 * Clears cache resources from outdated data 
	 */
	$.ajax({
		url: '../php/interpoll.php',
		data: {"flush":1},
		success: function( data ) {
		}
	});

	waitForMsg(); // long polling call
	$("#game_board").on('click', '.on', selectToMove);
	$(".item").click(toggleItem);
	$(".item").quickFlip();
});
/**
 * selects an item to move
 * 
 * @param event
 * @returns {Boolean}
 */
$checkSelectToMove=false;
function selectToMove (event){
		var $item = $(this).parent();
		if(!$('.selectedToMove').length){
			$item.addClass("selectedToMove");
			return false;
		}
		else
			move(event.target.id);
	
		if($item.children(".on").is(":visible").length <2){
			end_game($item);
		}
		$checkSelectToMove=false;
}

/**
 * Tells the server when the game ends
 * and announces the winner
 * 
 * @param $item
 */
function end_game(winner){

	if(endGamePoll){
		$.ajax({
			url: '../php/ajax.php',
			data: {type:'end', wins:winner},
			success: function( data ) {
				console.log(data);
			}
		});
		if(confirm (winner+ " won this game \n"+"Play again?"))
			location.href = "../php/lobby.php";
		else
			location.href = "../php/signup.php";
	}else{
		$.ajax({
			url: '../php/interpoll.php',
			data: {"func_name":"end_game","evt":winner},
			success: function( data ) {
			}
		});
	}
}
/**
 * Validates if an item can move according 
 * to rules
 * 
 * @param event
 * @returns {Boolean}
 */
$checkMove_Poll=true;
var cnt=0;
function move (event, from, attacker){
	$checkMove_Poll=true;
	if($checkMove_Poll){

	if(event == ''){return false;}//alert("passed event is null");
	
		if ( (typeof event === 'object'))
			$item = $("#"+event.target.id);
		else
			$item = $("#"+event);
		try{		
			var to = $item.metadata()["position"];
			if(from == null || from == "undefined")
				from = $('.selectedToMove').metadata()["position"];	
			if(attacker == null || attacker == "undefined")
				attacker = $('.selectedToMove').metadata()["toggle"];
			var attacked = $item.metadata()["toggle"];
		}catch(e){
			if(from !== 'undefined')
				$('#'+from).removeClass('selectedToMove');
			else
				$('.selectedToMove').removeClass('selectedToMove');
			return false;}
		
		if(from != to){
					check({"type": "move", "item":$item,"from":from, "to":to, "attacker":attacker, "attacked":attacked});
		}
		else {
			if(from !== 'undefined')
				$('#'+from).removeClass('selectedToMove');
			else
				$('.selectedToMove').removeClass('selectedToMove');

			return false;
			
		}
	}
}
/**
 * Toggles boxes to reveal items
 * in the game.
 * 
 * @param event
 * @returns {Boolean}
 */
$toggleItem_Poll = false;
function toggleItem(event){
	if($toggleItem_Poll){
		var $item = $(this);
		if($item.children(".off").is(":visible")){
			var css_class = $item.metadata()["toggle"];
			$item.children(".on").addClass(css_class);
			$item.quickFlipper();
			check({"type": "turn"})
		}
		$item = null;
		$toggleItem_Poll = false;
		$('.selectedToMove').removeClass('selectedToMove');
	}
	else{
		var $item = $(this);
		if($item.children(".off").is(":visible")){
			
			var evt = event.target.id;
			$.ajax({
				url: '../php/interpoll.php',
				data: {"func_name":"toggleItem","evt":evt},
				success: function( data ) {
				}
			});
		}
	}
}
/**
 * Queries server to check rules for changing turns
 * for items making movement, or capturing other items
 * 
 * @param args
 */
function check (args){
	var result;
	switch (args['type']){
		case 'turn' : 
			$.ajax({
				url: '../php/ajax.php',
				data: {type:'turn'},
				success: function( data ) {
					$("#turn span").html(data); 
				}
		});break;
		case 'move' : 

			$.ajax({
				url: '../php/ajax.php',
				data: {"type": "move", "from":args['from'], "to":args['to'], "attacker":args['attacker'], "attacked":args['attacked']},
				success: function( data ) {
					if(data){
						var winner =false;
						try{
							var looser = args['item'].metadata()["toggle"].split("_");
							if($('.on:visible').length == 32){
								if($('[class*="on '+looser[0]+'"]').length == 1){
									winner =  $('#'+args['from']).metadata()["toggle"].split("_");
									winner = winner[0];
								}
							}
							args['item'].replaceWith("\r" +
									"<div id='"+args['to']+"' class=\"item {toggle:'"+$('#'+args['from']).metadata()["toggle"]+"', position:'"+args['to']+"'}\" toggle ='"+"' position='"+"'> \r" +
									"<div id='"+args['to']+"'class=\"off\" style=\"display:none;\"></div>\r" +
									"<div id='"+args['to']+"'class=\"on "+$('#'+args['from']).metadata()["toggle"]+"\" style=\"display:block; height:"+args['item'].children(".on").height()+"px;\">"+"</div>"+
							"</div>");
							$('#'+args['from']).replaceWith("\r" +
									"<div id='"+args['from']+"'class=\"item {toggle:'', position:'"+args['from']+"'}\" toggle ='' position=''> \r" +
									"<div id='"+args['from']+"'class=\"off\" style=\"display:none;\"></div>\r" +
									"<div id='"+args['from']+"'class=\"on \" style=\"display:block; height:"+$('#'+args['from']).children(".on").height()+"px;\">"+"</div>"+
							"</div>");
							
						}catch(e){
							if(args['from'] !== 'undefined')
								$('#'+args['from']).removeClass('selectedToMove');
							else
								$('.selectedToMove').removeClass('selectedToMove');
							return false;
						}
						$.ajax({
							url: '../php/interpoll.php',
							data: {"func_name":"move","evt":args['to'],"from":args['from'],"attacker":args['attacker']},
							success: function( data ) {
							}
						});
						if(winner){
							endGamePoll=false;
							return end_game(winner);
						}
						check({"type": "turn"});
					}else{
						try{
							if(args['from'] !== 'undefined'){
								$('#'+args['from']).removeClass('selectedToMove');
							}
							else{
								$('.selectedToMove').removeClass('selectedToMove');
							}
						}catch(e){alert (e)}
					}
				}
			});break;
	}
}
/** 
 * Binds with the internal logic of this 
 * game and helps implement long polling
 * to share the events between two players
 * 
 * @param type
 * @param msg
 * @returns {Boolean}
 */
function poll(type, msg){
	try {
		var data = $.parseJSON(msg["msg"]);
	} catch (e) {
	    // not json
		return false;
	}
	if(typeof data =='object')
	{
		switch(data['func_name']){
			case "toggleItem": $toggleItem_Poll=true;$("#"+data['obj']).trigger("click");break;
			case "move": $checkMove_Poll=true;
			console.log("inside move"+data[0][0]+" "+data[0][1]);
							if(typeof(data[0][0]) != "undefined" && data[0][0] !== null)
								if(typeof(data[0][1]) != "undefined" && [0][1] !== null)
									move(data['obj'], data[0][0], data[0][1]);
									break;
			case "selectToMove": $checkSelectToMove=true;$("#"+data['obj']).trigger("click"); break;
			case "end_game": endGamePoll=true;end_game(data['obj']);break;
		}
	}
	else
	{
	  if(response ===false)
	  {
		  //the response was a string "false", parseJSON will convert it to boolean false
	  }
	  else
	  {
	    //the response was something else
	  }
	}
	
	
	
}
/**
 * 
 * Implements long polling client that makes and 
 * sustains a connection to sense any change on 
 * server.
 * 
 */
var timestamp = null;
function waitForMsg(){
	$.ajax({
		type : 'Get',
		url  : '../php/msgsrv.php?timestamp=' + timestamp,
		async : true,
		cache : false,
		
		success : function(data) {
					var json = $.parseJSON(data);
					console.log("poller "+json);
					poll("new", json);  
					
					timestamp  = json['timestamp'];
					setTimeout('waitForMsg()', 1000);
		},
		error : function(XMLHttpRequest, textstatus, error) { 
					alert(error);
					setTimeout('waitForMsg()', 1500);
		}		
	});
}
