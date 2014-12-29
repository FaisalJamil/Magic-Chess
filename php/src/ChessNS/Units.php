<?php

namespace ChessNS;
/**
 * Units are chessmen that are placed on the board
 * This class defines characteristics and behaviour 
 * of a unit
 * 
 * @author faisal
 *
 */
class Units{
	private $css_class = "";
	private $url = "";
	private $position = "";
/**
 * Creates a unit with an image file and its name
 * @param unknown $url
 */
	function __construct($url) {
		$this->url = $url;
		$this->css_class = $this->extract_name($url);
	}
/**
 * Sets position of a unit on the board
 * @param unknown $index
 */
	function set_position($index){
		$this->position = $index;
	}
	/**
	 * Get name of a unit
	 */
	function get_name(){
		return $this->css_class;
	}
/**
 * Design css for a unit
 * @return string
 */
	function get_css_block(){
		return "\n.".$this->get_name()."{background:url(".$this->url.") center center no-repeat;}";
	}
/**
 * Simple html block with just name of unit used. 
 * @return string
 */
	function get_html_simple_block(){
		return "\r<div class=\"item {toggle:'".$this->get_name()."'}\" toggle ='".$this->get_name()."'></div>";
	}
/**
 * Real HTML block that will be used in the template
 * @return string
 */
	function get_html_block(){
		return "\r<div id='".$this->position."' class=\"item {toggle:'".$this->get_name()."', position:'".$this->position."'}\" toggle ='".$this->get_name()."' position='".$this->position."'>
		\r<div id=".$this->position." class=\"off\"></div>
		\r<div id=".$this->position." class=\"on\"></div>
			</div>";
	}
	private function extract_name($str){
		$tmp = pathinfo($str);
		return $tmp['filename'];
	}
}
