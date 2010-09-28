<?php
require_once("formulaConverter2.class.php");

class readFormula{
	
	/* Identificador para o tipo de express�o a ser trabalhada*/
	private $type;
	
	/**
	 * Construtor.
	 *
	 * @param String $type Letra inicial pindicando o formato da express�o.
	 * @return formulaConverter
	 */
	public function readFormula($type) {
		$this->type = new formulaConverter($type);
	}
	
		/* M�dulo formulaConverter em formato TXT e
	Tamb�m deve ser usado paraos m�dulos ambiguityParser e parenthesesSaver. */
	public function TXTformulaConverter() {
		$this -> connectivesArray = Array();
		array_push ($this -> connectivesArray,new Connective("-->",2,250));
		array_push ($this -> connectivesArray,new Connective("<->",2,250));
		array_push ($this -> connectivesArray,new Connective("&",2,350));
		array_push ($this -> connectivesArray,new Connective("|",2,300));
		array_push ($this -> connectivesArray,new Connective("+",2,250));
		array_push ($this -> connectivesArray,new Connective("~",1,400));
		$this->noAssociativity["-->"] = false;
		$this->noAssociativity["+"] = false;
		$this->especialRelations = "^(1|0)";
	}
	
	/* M�dulo formulaConverter em formato polon�s. */
	public function polformulaConverter() {
		$this -> connectivesArray = Array();
		array_push ($this -> connectivesArray,new Connective("C",2,250));
		array_push ($this -> connectivesArray,new Connective("E",2,250));
		array_push ($this -> connectivesArray,new Connective("K",2,350));
		array_push ($this -> connectivesArray,new Connective("A",2,300));
		array_push ($this -> connectivesArray,new Connective("X",2,250));
		array_push ($this -> connectivesArray,new Connective("N",1,400));
		$this->noAssociativity["C"] = false;
		$this->noAssociativity["X"] = false;
		$this->especialRelations = "^(I|O)";
		
	}
	
	/* M�dulo formulaConverter em formato funcional. */
	public function funcformulaConverter() {
		$this -> connectivesArray = Array();
		array_push ($this -> connectivesArray,new Connective("imp",2,250));
		array_push ($this -> connectivesArray,new Connective("eq",2,250));
		array_push ($this -> connectivesArray,new Connective("and",2,350));
		array_push ($this -> connectivesArray,new Connective("or",2,300));
		array_push ($this -> connectivesArray,new Connective("xor",2,250));
		array_push ($this -> connectivesArray,new Connective("neg",1,400));
		$this->noAssociativity["imp"] = false;
		$this->noAssociativity["xor"] = false;
		$this->especialRelations = "^(top|bottom)";
	}
	
	/**
	 * M�todo para montar a �rvore de uma express�o Infixa (TXT).
	 *
	 * @param String $expression Express�o em formato TXT.
	 * @return node O n� raiz da a �rvore montada.
	 */
	public function infixToTree($expression) {
		/*Testa se existe a mesma quantidade de '(' e ')'*/
		if ($this->type->testParentheses($expression)) {
			$arrayExpression = array();
			$arrayExpression = $this->type->propToArray($expression,$arrayExpression);
			$expression = $this->type->toPrefix($arrayExpression, false);
			$arrayExpression = Array();
			$arrayExpression = $this->type->propToArray($expression,$arrayExpression);
			$arrayExpression = $this->type->putParentheses($arrayExpression);
			$expression = $arrayExpression[0];
			return $this->makeTree($expression);
		} else return "";
	}

	/**
	 * M�todo para montar a �rvore de uma expres�o Prefixa (Polonesa).
	 *
	 * @param String $expression Express�o em formato polon�s.
	 * @return node O n� raiz da a �rvore montada.
	 */
	public function prefixToTree($expression) {
		/*Testa se existe a mesma quantidade de '(' e ')'*/
		if ($this->type->testParentheses($expression)) {
			$arrayExpression = array();
			$arrayExpression = $this->type->prefixToArray($expression,$arrayExpression);
			$expression = $this->type->toPrefix($arrayExpression, true);
			$arrayExpression = Array();
			$arrayExpression = $this->type->prefixToArray($expression,$arrayExpression);
			$arrayExpression = $this->type->putParentheses($arrayExpression);
			$expression = $arrayExpression[0];
			return $this->makeTree($expression);
		} else return "";
	}
	
	/**
	 * M�todo para montar a �rvore de uma express�o funcional.
	 *
	 * @param String $expression Express�o em formato funcional
	 * @return node O n� raiz da a �rvore montada.
	 */
	public function functionalToTree($expression) {
		/*Testa se existe a mesma quantidade de '(' e ')'*/
		if ($this->type->testParentheses($expression)) {
			$index = 0;
			/*La�o para remover todos os espa�os existentes na express�o*/
			while (!ctype_graph($expression)) {
				/*La�o que busca um espa�o*/
				while ($expression[$index] != " ") {
					$index++;
				}
				/*Testa se index � igual a 0*/
				if ($index == 0) $expression = substr($expression,1);
				else $expression = substr($expression,0,$index) . substr($expression,$index+1);
			}
			return $this->makeTree($expression);
		} else return "";
	}
	
	private function makeTree($expression) {
		$array = $this->type->connectiveChildren($expression);
		$connective = $array['connective'];
		/*Testa se op � um conectivo*/	
		if ($this->type->isConnective($connective)) {
			$arity = 0;
			$order = $this->type->connectiveOrder($connective);
			$tree = new Connective($connective,0,$order);
			/*La�o que cjama a recurs�o para cada argumento*/
			foreach ($array['children'] as $child) {
				$arity++;
				$children = $this->makeTree($child);
				array_push($tmp->children, $children);
			}
			$tree->arity = $arity;
			return $tree;
		/*Caso contr�rio � um �tomo*/	
		} else {
			$tree = new Atom($connective);
			return $tree;
		}
	}
	
	public function printTree ($node,$ident) {
		$this->type->printTree($node,$ident);
	}
}
?>