<?php
require_once("Node.class.php");
require_once("Variable.class.php");
require_once("Constant.class.php");
require_once("Relation.class.php");
require_once("Function.class.php");
require_once("Quantifier.class.php");
require_once("Connective.class.php");
require_once("mod_converter/formulaConverter2.class.php");

/**
 * Classe para substituir um termo livre para uma vari�vel na f�rmula
 * 
 * @class SubstitutionMaster
 * 
 * @author Luciano Pereira Vieira
 * @version 2.0
 */


class SubstitutionMaster extends formulaConverter {
	public $varsTerm = array();  # Vetor contendo todas as vari�veis do termo
	private $quantificadores = "A|E|E!"; #Quantificadores (POG pq a classe formulaConverter n�o est� funcionando para 1� ordem)
	private $livre = true; #Vari�vel para guardar se a termo � livre ou n�o para a vari�vel na f�rmula
	
	/**
	 * Construtor da classe SubstitutionMaster
	 */
	public function __construct(){
		parent::formulaConverter("t", ""); # Construtor da classe herdada
	}
	
	/**
	 * M�todo para setar as vari�veis ligadas e livres da f�rmula
	 *
	 * @param Node $formula
	 * @param Array $vl
	 * @return void
	 */
	public function setVars(&$formula, $vl = array()){
		$node = $formula->content;
		if ($node instanceof Connective && ereg($this->quantificadores,$node->content)){
			array_push($vl,substr($node->content,1,1));
		}
		else if ($node instanceof Variable) {
			if (array_search($node->content,$vl) === false){
				$node->isLinked = false;
			}
			else {
				$node->isLinked = true;
			}
		}
		
		foreach ($formula->children as $n){
			$this->setVars($n,$vl);
		}
	}
        
	/**
	 * M�todo para pegar todas as vari�veis do termo
	 *
	 * @param Node $term (N� raiz do termo)
	 * @return void
	 */
	private function getVariablesTerm(&$term){
		$node = $term->content;
		if ($node instanceof Variable){
			$this->varsTerm[] = $node->content;
		}
		else {
			foreach ($term->children as $son){
				$this->getVariablesTerm($son);
			}
		}
	}
	
	/**
	 * M�todo para avaliar se o termo � livre para a vari�vel na f�rmula
	 *
	 * @param String $var
	 * @param Node $formula
	 * @param array $vl
	 */
	private function isFree(&$var, &$formula, $vl = array()){
		$node = $formula->content;
		if ($node instanceof Connective && ereg($this->quantificadores,$node->content)){
			substr($node->content,1,1) != $var->content ? array_push($vl,substr($node->content,1,1)) :  null;
		}
		
		if ($node instanceof Variable){
			if ($node->content == $var->content){
				if (count(array_intersect($vl, $this->varsTerm)) > 0){
					$this->livre = false;
				}
				else {
					foreach ($formula->children as $n){
						$this->isFree($var, $n, $vl);
					}
				}
			}
			else {
				foreach ($formula->children as $n){
					$this->isFree($var, $n, $vl);
				}
			}
		}
		else {
			foreach ($formula->children as $n){
				$this->isFree($var, $n, $vl);
			}
		}
	}
	
	/**
	 * M�todo para avaliar e substituir um termo por uma vari�vel na f�rmula
	 *
	 * @param Node $termo
	 * @param Variable $var
	 * @param Node $formula
	 */
	public function substitua(&$termo, &$var, &$formula){
		$this->setVars($formula);
		$this->getVariablesTerm($termo);
		$this->isFree($var,$formula);
		if ($this->livre){
			$this->__substitua($termo, $var, $formula);
			echo "O termo &eacute; livre para a vari&aacute;vel na f&oacute;rmula.";
		}
		else {
			echo "O termo n&atilde;o &eacute; livre para a vari&aacute;vel na f&oacute;rmula.";
		}
	}
	
	/**
	 * M�todo que realmente substitue se for o caso, a vari�vel pelo termo na f�rmula
	 *
	 * @param Node $termo
	 * @param Variable $var
	 * @param Node $formula
	 */
	private function __substitua(&$termo, &$var, &$formula){
		$node = $formula->content;
		if ($node instanceof Variable){
			if ($node->content == $var->content && !$node->isLinked){
				$formula->content = $termo->content;
				$formula->children = $termo->children;
			}
		}
		else {
			foreach ($formula->children as $n){
				$this->__substitua($termo, $var, $n);
			}
		}
	}
	
	/**
	 * Destrutor da classe, zera as vari�veis
	 *
	 */
	public function __destruct(){
		$this->livre = true;
		$this->varsTerm = array();
	}
}


/************** EXEMPLO DE USO DA CLASSE **************/

/*
$formulaConverter = new formulaConverter("t","");

$RaizFormula = $formulaConverter->infixToTree("Ax(Ey(P(x,y) <-> ((P(x,y) --> (R(f(w),z) | Az(Q(y,h(z)) & Q(z,h(w))))) --> P(x,y))))",true);
$Termo = $formulaConverter->infixToTree("f(w)", true);

$SubMaster = new SubstitutionMaster();
$SubMaster->substitua($Termo, new Variable("z"), $RaizFormula);
echo "<p></p>";
$formulaConverter->printTree($RaizFormula,"");
*/
?>
