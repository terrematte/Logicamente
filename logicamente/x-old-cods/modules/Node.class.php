<?php

	class Node{
		public $content;
		public $children;
	
		function Node($content){
			$this->content = $content;
			$this->children = array();
		}

		
		function isAtom(){
			return is_a($this->content, "Atom");
		}
		

		function arity(){
			return count($this->children);
		}
	}
?>
