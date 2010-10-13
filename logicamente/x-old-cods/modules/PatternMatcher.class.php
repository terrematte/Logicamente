<?php

/**
 * Classe que busca e casa padr�es em uma determinada arvore
 */
class PatternMatcher {
	/**
	 * Array que guarda os padr�es encontrados
	 */
	private $rootArray = array();
	
	/**
	 * Encontra na �rvore todas as sub�rvores que possuem o padr�o desej�do.
	 * @param Node $tree �rvore em que se procura o padr�o
	 * @param Pattern $pattern Padr�p procurado
	 */
	public function matchPattern(Node $tree, Pattern $pattern) {
		/*$t = new WFFTranslator();
		echo "[tree]:".$t->showFormulaInfix($tree)."<br />";
		echo "[pattern]:".$t->showFormulaInfix($pattern)."<br />";*/
		//Se o padr�o est� sendo bem sucedido em suas compara��es...
		if ( $pattern->getPatternRoot()->isSubstitutionOk() ) {
			//Se o conte�do da �rvore e do padr�o s�o iguais...
			if ( $tree->content == $pattern->content ) {
				//Se s�o iguais ao 'top' ou ao 'bottom'
				if ( $pattern->content->content == "0" || $pattern->content->content == "1" ) {
					//Se final de padr�o...
					if ($pattern->getEndOfPattern()) {
						//Empilha o padr�o encontrado no rootArray
						array_push( $this->rootArray, $pattern->getTreeRoot() );
					}
					//Se ainda n�o for um �tomo na �rvore
					if (!$tree->isAtom()) {
						//Reseta o padr�o e continua a busca
						$this->matchPattern($tree, PatternCreator::CreatePattern($pattern->getPatternType(), $tree));
					}
				}
				else {
					//Caminha na �rvore e no padr�o
					for ($i = 0; $i < count($tree->children); $i++) {
						$this->matchPattern($tree->children[$i], $pattern->children[$i]);
					}
				}
			}
			else {
				//Se o n� do padr�o � um �tomo (entao ele � uma vari�vel)...
				if ( $pattern->isAtom() ) {
					if ( ($pattern->content->content == "0" || $pattern->content->content == "1") ) {
						//O padr�o, da maneira que est�, n�o funcionar� mais para compara��es
						$pattern->getPatternRoot()->setSubstitutionOk(false);
						//Reseta o padr�o e continua a busca
						$this->matchPattern($tree, PatternCreator::CreatePattern($pattern->getPatternType(), $tree));
					}
					else {
						$list = $pattern->getPatternRoot()->getVariableList();
						//Se a vari�vel em quest�o n�o foi substitu�da ainda...
						if (!array_key_exists($pattern->content->content, $list)) {
							//Adiciona a substitui��o para a lista de vari�veis
							$list[$pattern->content->content] = $tree;
							$pattern->getPatternRoot()->setVariableList($list);
							//Se final de padr�o...
							if ($pattern->getEndOfPattern()) {
								//Empilha o padr�o encontrado no rootArray
								array_push( $this->rootArray, $pattern->getTreeRoot() );
							}
							//Se ainda n�o for um �tomo na �rvore
							if (!$tree->isAtom()) {
								//Reseta o padr�o e continua a busca
								$this->matchPattern($tree, PatternCreator::CreatePattern($pattern->getPatternType(), $tree));
							}
						}
						//Se a vari�vel j� foi substitu�da...
						else {
							//Se a �rvore n�o for a mesma que esta no array...
							if ($list[$pattern->content->content] != $tree) {
								//Reseta o padr�o e continua a busca
								$this->matchPattern($tree, PatternCreator::CreatePattern($pattern->getPatternType(), $tree));
								//O padr�o, da maneira que est�, n�o funcionar� mais para compara��es
								$pattern->getPatternRoot()->setSubstitutionOk(false);
							}
							//Se a �rvore for a mesma que est� no array
							else {
								//Se final de padr�o...
								if ($pattern->getEndOfPattern()) {
									//Empilha o padr�o encontrado no rootArray
									array_push( $this->rootArray, $pattern->getTreeRoot() );
								}
								//Se ainda n�o for um �tomo na �rvore
								if (!$tree->isAtom()) {
									//Reseta o padr�o e continua a busca
									$this->matchPattern($tree, PatternCreator::CreatePattern($pattern->getPatternType(), $tree));
								}
							}
							//Se ainda n�o for um �tomo na �rvore
							if (!$tree->isAtom()) {
								//Reseta o padr�o e continua a busca
								$this->matchPattern($tree, PatternCreator::CreatePattern($pattern->getPatternType(), $tree));
							}
						}
					}
				}
				//Se o n� do padr�o n�o e um �tomo (entao ele e um conectivo diferente do que est� na mesma posi��o da �rvore)
				else {
					//O padr�o, da maneira que est�, n�o funcionar� mais para compara��es
					$pattern->getPatternRoot()->setSubstitutionOk(false);
					//Se padr�o j� foi testado para o determinado n�...
					if ($pattern->isPatternTested()) {
						//Continua caminhando na �rvore e no padr�o
						for ($i = 0; $i < count($tree->children); $i++) {
							$this->matchPattern($tree->children[$i], PatternCreator::CreatePattern($pattern->getPatternType(), $tree->children[$i]));
						}
					//Se padr�o n�o foi testado para o determinado no...
					} else {
						$pattern = PatternCreator::CreatePattern($pattern->getPatternType(), $tree);
						$pattern->setPatternTested(true);
						$this->matchPattern($tree, $pattern);
					}
				}
			}
		}
		//O padr�o n�o est� sendo bem sucedido em suas compara��es...
		else {
			//Reseta o padr�o e continua a busca
			$this->matchPattern($tree, PatternCreator::CreatePattern($pattern->getPatternType(), $tree));
		}
	}
	
	/**
	 * Acessa o rootArray
	 *
	 * @return array
	 */
	public function getRootArray() {
		return $this->rootArray;
	}
	
	/**
	 * Atribui um novo valor ao rootArray
	 *
	 * @param $newValue
	 */
	public function setRootArray($newValue) {
		$this->rootArray = $newValue;
	}
	
	/**
	 * Verifica se algum padr�o foi encontrado
	 *
	 * @return boolean
	 */
	public function hasMatched() {
		if (count($this->rootArray) == 0 ) {
			return false;
		}
		else {
			return true;
		}
	}
	
	/**
	 * Verifica se foi encontrado exatamente um padr�o
	 *
	 * @param $pattern String que determina a regra a ser aplicada
	 * @param $patternType String que determina a vers�o da regra aplicada
	 */
	public function oneMatched($pattern, $patternType) {
		$t = new WFFTranslator();
		$psol = new PatternSolutions();
		if ( count($this->rootArray) == 1 ) {
			echo "One match finded: ".$t->showFormulaInfix($this->rootArray[0])."<br />";
			echo "Solving...<br />";
			$psol->solve($this->rootArray[0], $pattern, $patternType);
		}
	}
	
	/**
	 * Imprime os padr�es encontrados. Se n�o for o caso, imprime uma mensagem de erro para o usu�rio.
	 * Com ela e possivel atribuir �ndices a cada padr�o encontrado para que o usu�rio tenha acesso a escolher um.
	 */
	public function printMatched() {
		if ( !$this->hasMatched() ) {
			echo "<strong style='color:#000066;'>[Error]: The chosen pattern has no matches.</strong><br />";
		}
		else {
			$translator = new WFFTranslator();
			for ($i = 0; $i < count($this->rootArray); $i++) { 
				echo "[".$i."] => ".$translator->showFormulaInfix($this->rootArray[$i])."<br />";
			}
		}
	}
}

?>
