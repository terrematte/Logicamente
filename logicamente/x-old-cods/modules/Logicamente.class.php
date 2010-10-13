<?php
require_once("WFFGenerator.class.php");
require_once("readFormula.class.php");
class Logicamente{

	function showFormula($formula){
		if ( count($formula->children) > 0){
			echo ("(");
			for ($i = 0; $i < count ($formula->children); $i++){
				if ($formula->content->arity == 1)
					echo (" ".$formula->content->content." ");
				$this->showFormula ($formula->children[$i]);
				if ($i < (count ($formula->children) - 1))
					echo (" ".$formula->content->content." ");			
			}
			echo (")");
		} else
			echo (" ".$formula->content->content." ");
	}
	
	function generateFormulas($nConnectives, $nAtoms, $connectives){
		/*
		$connectives = array();
		
		foreach($symbol as $key => $value)
			array_push ($connectives, new Connective($value, $arity[$key]));
		*/
				
		$gerador = new WFFGenerator($nConnectives, $nAtoms, $connectives);
		$form = $gerador->getFormula();
		
		$this->showFormula( $form->root );
	}
	
	function checkFormula($formula, $connectives){
		$checker = new readFormula();
		$checker->checkFormula($formula, $connectives);
	}
}
?>