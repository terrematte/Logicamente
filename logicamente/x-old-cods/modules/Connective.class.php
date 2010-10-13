<?php

	class Connective{
		public $content;
		public $arity;
		public $order;
		public $value;
		
		function Connective($content, $arity, $order=''){
			$this->content = $content;
			$this->arity = $arity;
			$this->order = $order;
			$this->value = 0;
		}
	}
?>
