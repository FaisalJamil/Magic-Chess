<?php
/**
 * Architecture and functionality of Game is 
 * provided by this class. It contains objects 
 * of various other classes like Board and 
 * Players
 * 
 * @author faisal
 *
 */
namespace ChessNS;

Class Game {
	
	protected $board;
	protected $item_hierarchy;
	protected $players;
	protected $turn;
	protected $over;
	protected $won;
	/**
	 * Initiates a Game
	 */
	function __construct (Player $player1, Player $player2, Board $board, $hierarchy){
		$this->players = array($player1, $player2);
		$this->board = $board;
		$this->item_hierarchy = $hierarchy;
	}
	/**
	 * Starts a game
	 */
	public function start(){
		$this->turn = 'red';
		$this->over = false;
		$this->won = false;
	}
	/**
	 * Sets the current turn
	 */
	public function set_turn(){
		if($this->turn == 'red')
			$this->turn = 'black';
		else
			$this->turn = 'red';
	}
	/**
	 * Validates the current move
	 * checks with defined rules
	 * 
	 * @param unknown $request
	 * @return boolean
	 */
	public function check_move($request){
		$attacker = explode('_', $request['attacker']);
		$attacked = explode('_', $request['attacked']);
		
		$direction = (	$request['from'] == $request['to'] + 8 ||
				$request['from'] == $request['to'] - 8 ||
				$request['from'] == $request['to'] - 1 ||
				$request['from'] == $request['to'] + 1 )
				? true : false;
		
 		$color = (	$attacker[0] != $attacked[0])	&&
					$attacker[0] == $this->turn
				 	? true : false;
		
		$heirarchy =	(	(array_search($attacker[1], $this->item_hierarchy) 			<
							array_search($attacked[1], $this->item_hierarchy)) 			||
							(array_search($attacker[1], $this->item_hierarchy) == 6		&&
							array_search($attacked[1], $this->item_hierarchy) == 0))	? true :
							array_search($attacked[1], $this->item_hierarchy) == ''		||
							array_search($attacker[1], $this->item_hierarchy) == array_search($attacked[1], $this->item_hierarchy)
							? true : false;
		
		return $direction &&  $color  && $heirarchy;
	}
	
	public function end($winner){
		$this->over = true;
		$this->won = $winner;
		return $this->won;
	}

	/**
	 * PHP Magic getter
	 * @param string $property
	 */
	public function __get($property)
	{
		if (property_exists($this, $property)) {
			return $this->$property;
		}
	}
}