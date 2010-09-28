<?php

/**
 * Classe que busca e casa padrões em uma determinada arvore
 */
class PatternMatcher {
	/**
	 * Array que guarda os padrões encontrados
	 */
	private $rootArray = array();
	
	/**
	 * Encontra na árvore todas as subárvores que possuem o padrão desejádo.
	 * @param Node $tree Árvore em que se procura o padrão
	 * @param Pattern $pattern Padrãp procurado
	 */
	public function matchPattern(Node $tree, Pattern $pattern) {
		/*$t = new WFFTranslator();
		echo "[tree]:".$t->showFormulaInfix($tree)."<br />";
		echo "[pattern]:".$t->showFormulaInfix($pattern)."<br />";*/
		//Se o padrão está sendo bem sucedido em suas comparações...
		if ( $pattern->getPatternRoot()->isSubstitutionOk() ) {
			//Se o conteúdo da árvore e do padrão são iguais...
			if ( $tree->content == $pattern->content ) {
				//Se são iguais ao 'top' ou ao 'bottom'
				if ( $pattern->content->content == "0" || $pattern->content->content == "1" ) {
					//Se final de padrão...
					if ($pattern->getEndOfPattern()) {
						//Empilha o padrão encontrado no rootArray
						array_push( $this->rootArray, $pattern->getTreeRoot() );
					}
					//Se ainda não for um átomo na árvore
					if (!$tree->isAtom()) {
						//Reseta o padrão e continua a busca
						$this->matchPattern($tree, PatternCreator::CreatePattern($pattern->getPatternType(), $tree));
					}
				}
				else {
					//Caminha na árvore e no padrão
					for ($i = 0; $i < count($tree->children); $i++) {
						$this->matchPattern($tree->children[$i], $pattern->children[$i]);
					}
				}
			}
			else {
				//Se o nó do padrão é um átomo (entao ele é uma variável)...
				if ( $pattern->isAtom() ) {
					if ( ($pattern->content->content == "0" || $pattern->content->content == "1") ) {
						//O padrão, da maneira que está, não funcionará mais para comparações
						$pattern->getPatternRoot()->setSubstitutionOk(false);
						//Reseta o padrão e continua a busca
						$this->matchPattern($tree, PatternCreator::CreatePattern($pattern->getPatternType(), $tree));
					}
					else {
						$list = $pattern->getPatternRoot()->getVariableList();
						//Se a variável em questão não foi substituída ainda...
						if (!array_key_exists($pattern->content->content, $list)) {
							//Adiciona a substituição para a lista de variáveis
							$list[$pattern->content->content] = $tree;
							$pattern->getPatternRoot()->setVariableList($list);
							//Se final de padrão...
							if ($pattern->getEndOfPattern()) {
								//Empilha o padrão encontrado no rootArray
								array_push( $this->rootArray, $pattern->getTreeRoot() );
							}
							//Se ainda não for um átomo na árvore
							if (!$tree->isAtom()) {
								//Reseta o padrão e continua a busca
								$this->matchPattern($tree, PatternCreator::CreatePattern($pattern->getPatternType(), $tree));
							}
						}
						//Se a variável já foi substituída...
						else {
							//Se a árvore não for a mesma que esta no array...
							if ($list[$pattern->content->content] != $tree) {
								//Reseta o padrão e continua a busca
								$this->matchPattern($tree, PatternCreator::CreatePattern($pattern->getPatternType(), $tree));
								//O padrão, da maneira que está, não funcionará mais para comparações
								$pattern->getPatternRoot()->setSubstitutionOk(false);
							}
							//Se a árvore for a mesma que está no array
							else {
								//Se final de padrão...
								if ($pattern->getEndOfPattern()) {
									//Empilha o padrão encontrado no rootArray
									array_push( $this->rootArray, $pattern->getTreeRoot() );
								}
								//Se ainda não for um átomo na árvore
								if (!$tree->isAtom()) {
									//Reseta o padrão e continua a busca
									$this->matchPattern($tree, PatternCreator::CreatePattern($pattern->getPatternType(), $tree));
								}
							}
							//Se ainda não for um átomo na árvore
							if (!$tree->isAtom()) {
								//Reseta o padrão e continua a busca
								$this->matchPattern($tree, PatternCreator::CreatePattern($pattern->getPatternType(), $tree));
							}
						}
					}
				}
				//Se o nó do padrão não e um átomo (entao ele e um conectivo diferente do que está na mesma posição da árvore)
				else {
					//O padrão, da maneira que está, não funcionará mais para comparações
					$pattern->getPatternRoot()->setSubstitutionOk(false);
					//Se padrão já foi testado para o determinado nó...
					if ($pattern->isPatternTested()) {
						//Continua caminhando na árvore e no padrão
						for ($i = 0; $i < count($tree->children); $i++) {
							$this->matchPattern($tree->children[$i], PatternCreator::CreatePattern($pattern->getPatternType(), $tree->children[$i]));
						}
					//Se padrão não foi testado para o determinado no...
					} else {
						$pattern = PatternCreator::CreatePattern($pattern->getPatternType(), $tree);
						$pattern->setPatternTested(true);
						$this->matchPattern($tree, $pattern);
					}
				}
			}
		}
		//O padrão não está sendo bem sucedido em suas comparações...
		else {
			//Reseta o padrão e continua a busca
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
	 * Verifica se algum padrão foi encontrado
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
	 * Verifica se foi encontrado exatamente um padrão
	 *
	 * @param $pattern String que determina a regra a ser aplicada
	 * @param $patternType String que determina a versão da regra aplicada
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
	 * Imprime os padrões encontrados. Se não for o caso, imprime uma mensagem de erro para o usuário.
	 * Com ela e possivel atribuir índices a cada padrão encontrado para que o usuário tenha acesso a escolher um.
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
