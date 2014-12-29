<?php
/**
 * this class describes a player having a 
 * name and a color on which they'll be 
 * playing
 * 
 * @author faisal
 *
 */
namespace ChessNS;
/**
 * Player class
 * @author faisal
 *
 */
class Player{

	/**
	 * Name of the player
	 */
	protected $name;
	protected $playing_as;

	/**
	 * Constructor
	 * Sets the name as a player name.
	 * Sets playing_as the color 
	 * @param string $name
	 */
	function __construct($name, $playing_as) {
		$this->name = $name;
		$this->playing_as = $playing_as;
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
