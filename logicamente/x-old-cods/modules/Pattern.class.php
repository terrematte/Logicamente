<?php

/**
 * Classe que gera a estrutura de um padrao.
 *
 */
class Pattern extends Node {
	private $treeRoot; //variavel de referencia para a raiz da arvore onde possa haver um padrao
	private $patternRoot; //variavel de referencia para a raiz do padrao
	private $patternType; //tipo do padrao
	private $variableList; //array onde sao guardadas as substituições às variaveis do padrao
	private $patternTested; //utilizada para saber se o padrao ja foi testado sobre um determinado no
	private $endOfPattern; //identifica fim do padrao
	private $substitutionOk; //garante que não haja problemas sobre a substituicao de uma variavel do padrao
	
	/**
	 * Construtor
	 */
	public function Pattern($content, $patternType, $patternRoot){
		$this->content = $content;
		$this->children = array();
		$this->treeRoot = null;
		$this->patternRoot = $patternRoot;
		$this->patternType = $patternType;
		$this->variableList = array();
		$this->patternTested = false;
		$this->endOfPattern = false;
		$this->substitutionOk = true;
	}
	
	/**
	 * Atribui ao treeRoot uma nova arvore
	 *
	 * @param Node $newTreeRoot
	 */
	public function setTreeRoot($newTreeRoot) {
		$this->treeRoot = $newTreeRoot;
	}
	
	/**
	 * Recupera o treeRoot
	 *
	 * @return Node
	 */
	public function getTreeRoot() {
		return $this->treeRoot;
	}
	
	/**
	 * Atribui um novo valor ao patternRoot
	 *
	 * @param Pattern $newPatternRoot
	 */
	public function setPatternRoot($newPatternRoot) {
		$this->patternRoot = $newPatternRoot;
	}
	
	/**
	 * Recupera o patternRoot
	 *
	 * @return Pattern
	 */
	public function getPatternRoot() {
		return $this->patternRoot;
	}
	
	
	/**
	 * Recupera o tipo do padrao
	 */
	public function getPatternType() {
		return $this->patternType;
	}
	
	/**
	 * Recupera a variableList
	 */
	public function getVariableList() {
		return $this->variableList;
	}
	
	/**
	 * Atribui um novo array a variableList
	 */
	public function setVariableList($newList) {
		$this->variableList = $newList;
	}
	
	/**
	 * Verifica se o padrao jah foi testado
	 *
	 * @return boolean
	 */
	public function isPatternTested() {
		return $this->patternTested;
	}
	
	/**
	 * Verifica se, caso tem ocorrido, todas as subistituicoes foram feitas corretamente
	 *
	 * @return boolean
	 */
	public function isSubstitutionOk() {
		return $this->substitutionOk;
	}
	
	/**
	 * Atribui um novo valor a substitutionOK
	 *
	 * @param boolean $newValue
	 */
	public function setSubstitutionOk($newValue) {
		$this->substitutionOk = $newValue;
	}
	
	/**
	 * Atribui um novo valor a patternTested
	 *
	 * @param boolean $newValue
	 */
	public function setPatternTested($newValue) {
		$this->patternTested = $newValue;
	}
	
	/**
	 * Atribui um novo valor a endOfPattern
	 *
	 * @param boolean $newValue
	 */
	public function setEndOfPattern($newValue) {
		$this->endOfPattern = $newValue;
	}
	
	/**
	 * Recupera o endOfPattern
	 *
	 * @return boolean
	 */
	public function getEndOfPattern() {
		return $this->endOfPattern;
	}
}
/*
$pattern = new Pattern("doubleNegation");
print_r ($pattern->children);
echo "<br/><br/>".$pattern->getPatternType()."<br/>";

echo "<br/><b>Testando se o no é atomo</b><br/>";
echo $pattern->children[0]->children[0]->isAtom();

//---------------------------------------------------------------
print "<br/><br/><b>Numero de variaveis do padrao...</b><br/>";
echo $pattern->getNumberOfVariables();
print "<br/><b>Setando numero de variaveis do padrao...</b><br/>";
echo $pattern->setNumberOfVariables(0);
print "<b>Numero de variaveis apos metodo set:</b>";
echo "<br/>".$pattern->getNumberOfVariables()."<br/>";
//---------------------------------------------------------------

echo "<br/>".$pattern->getVariableList();
*/
?>