<?php
/**
 * Board class
 * 
 * Implements a board by using pool of objects pattern.
 * A pool of Units class objects are created and saved.
 * Units are then shuffled to disperse on the board
 * Html for board is also formatted in this class
 *  
 * @author faisal
 *
 */

namespace ChessNS;
if(!isset($_SESSION)){session_start();}

class Board
{
	private $css = array();
	private $units = array();
	private $units_names = array();
	private $double = array();
	private $five = array();
	private $cols = 0;
	private $rows = 0;
   /**
    * It was decided to use singleton pattern for the board, but on further 
    * investigation it was revealed that singletons cannot persist if users 
    * are connected over different browsers. But still method is left in place 
    * for any future use. 
    * 
    * @param unknown $level
    * @param unknown $unit_files
    * @param unknown $double
    * @param unknown $five
    * @param unknown $cols
    */ 
 	public static function getInstance($level, $unit_files, $double, $five, $cols)
	{
		static $instance = null;
		
		if (null === $instance) {
			$instance = new static();
			$instance = new Board($level, $unit_files, $double, $five, $cols); 
			
		}
		return $instance;
	}
 	/**
 	 * Makes a board and initial places Units on it, then shuffle it.
 	 */
	function __construct($level, $unit_files, $double, $five, $cols) {
		$num_of_units = count($unit_files);
		$this->double = $double;
		$this->five = $five;	
		// Get the unit objects, using Factory and Pool of objects Pattern
		$units = array();
		for ( $i = 0; $i < $num_of_units; $i++ ){
			$cnt = 0;
			do{
				$cnt++;
				$units[] = new Units($unit_files[$i]);
				$this->css[] = $units[count($units)-1]->get_css_block();
				if(in_array($unit_files[$i], $this->double, true)) $result = 2; else if(in_array($unit_files[$i], $this->five, true)) $result = 5; else  $result = 0;
			}while($cnt < $result);
		}
		$this->units = $units;
			
		// Shuffle the units to create the order on the board
		shuffle($this->units);
			
		// set the number of rows & cols for the board
		$num = count($this->units);
		$sr = sqrt($num);
		$this->rows = floor($sr);
		while ( $num % $this->rows ){
			--$this->rows;
		}
		$this->cols = $cols;
	}
	/*
	 * Gets design css for the board
	 */
	function get_css(){
		return implode("\n",$this->css);
	}

	function debug_print(){
		$p_rslt = array("units"=>$this->units, "rows"=>$this->rows, "cols"=>$this->cols);
		print "<br/ >".json_encode($p_rslt);
	}
	/**
	 * Outputs number of rows for a board
	 * @return number
	 */
	function get_rows(){
		return $this->rows;
	}
/**
 * Number of columns for a board
 * @return number
 */
	function get_cols(){
		return $this->cols;
	}
/**
 * Info about units on board
 * @return multitype:
 */
	function get_units(){
		return $this->units;
	}
/**
 * Gets total number of units on board
 * @return number
 */
	function get_size(){
		return count($this->units);
	}
/**
 * Gets a single unit 
 * @param unknown $index
 */
	function get_unit($index){
		return $this->units[$index];
	}
/**
 * Formats HTML to show on template
 */
	function get_html(){
		// For each unit
		for ( $i = 0 ; $i < $this->get_size() ; ++$i ){
			// Check if it's time for a new row
			if ( ($i % $this->get_cols()) == 0 ){
				print "\r<div class=\"clear\"></div>";
			}
			// Set position for each unit on the board
			$this->get_unit($i)->set_position($i);
			print $this->get_unit($i)->get_html_block();
		}
	}
} // end of Board class
