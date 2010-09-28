<?php

//require_once("testeCNFConverter.php");

/**
 * Classe que busca e casa padr�es em uma determinada arvore
 */
class PatternMatcher {
	/**
	 * Array que guarda os padr�es encontrados
	 */
	private $rootArray = array();
	
	/**
	 * Array que guarda a vers�o da regra utilizada.
	 */
	private $patternTypeArray = array();
	
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
						// Se o padrao ainda n�o se encontra na arvore...
						//if (!in_array($pattern->getTreeRoot(), $this->rootArray)) {
							//Empilha o padr�o encontrado no rootArray
							array_push( $this->rootArray, $pattern->getTreeRoot() );
							//Empilha a vers�o do padr�o encontrado no pattertypeArray
							array_push( $this->patternTypeArray, $pattern->getPatternType() );
						//}
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
								// Se o padrao ainda n�o se encontra na arvore...
								//if (!in_array($pattern->getTreeRoot(), $this->rootArray)) {
									//Empilha o padr�o encontrado no rootArray
									array_push( $this->rootArray, $pattern->getTreeRoot() );
									//Empilha a vers�o do padr�o encontrado no pattertypeArray
									array_push( $this->patternTypeArray, $pattern->getPatternType() );
								//}
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
									// Se o padrao ainda n�o se encontra na arvore...
									//if (!in_array($pattern->getTreeRoot(), $this->rootArray)) {
										//Empilha o padr�o encontrado no rootArray
										array_push( $this->rootArray, $pattern->getTreeRoot() );
										//Empilha a vers�o do padr�o encontrado no pattertypeArray
										array_push( $this->patternTypeArray, $pattern->getPatternType() );
									//}
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
	
	// Tentativa de casar os padr�es utilizando a associatividade. Infelizmente n�o esta completa,
	// casando uma m�sera parcela de casos. � possivel observar a imensa quantidade de combina��es
	// que ainda podem ser feitas.
	/*public function matchAssociatively (Node $tree, Pattern $pattern) {
		$t = new WFFTranslator();
		if ( $tree->content->content == "&" ){
			$tmpTree = clone $tree;
			$this->normalizeConjunctions($tree);
			echo "[conjunction]:".$t->showFormulaInfix($tree)."<br />";
			if ($tree != $tmpTree) {
				for ($i = 0; $i < count ($tree->children); $i++) {
					for ($j = $i+1; $j < count ($tree->children); $j++) {
						$auxTree = new Node( new Connective("&", 2, 350));
						array_push($auxTree->children, $tree->children[$i]);
						array_push($auxTree->children, $tree->children[$j]);
						
						$this->matchPattern($auxTree, $pattern);
					}
				}
			}
			else {
				$this->matchPattern($tree, $pattern);
			}
		}
		else {
			if ( $tree->content->content == "|" ){
				$tmpTree = clone $tree;
				$this->normalizeDisjunctions($tree);
				echo "[disjunction]:".$t->showFormulaInfix($tree)."<br />";
				if ($tree != $tmpTree) {
					for ($i = 0; $i < count ($tree->children); $i++) {
						for ($j = $i+1; $j < count ($tree->children); $j++) {
							$auxTree = new Node( new Connective("|", 2, 300));
							array_push($auxTree->children, $tree->children[$i]);
							array_push($auxTree->children, $tree->children[$j]);
							
							$this->matchPattern($auxTree, $pattern);
						}
					}
				}
				else {
					$this->matchPattern($tree, $pattern);					
				}
			}
			else {
				$this->matchPattern($tree, $pattern);
			}
		}
	}*/
	
	/**
	 * Fun��o que normaliza a arvore da FNC para que todas as conjun��es aninhadas 
	 * sejam representadas por uma �nica disjun��o.
	 *
	 * @param Node $tree
	 * @return Node
	 */
	public function normalizeConjunctions(&$tree) {
		if ($tree->content->content == "&") {	
			$root = new Node ( new Connective("&", 2, 350) );
			for ($i = 0; $i < count($tree->children); $i++) {
				if ($tree->children[$i]->content->content == "&") {
					array_push ($root->children, $tree->children[$i]->children[0]);
					array_push ($root->children, $tree->children[$i]->children[1]);
				}
				else {
					array_push ($root->children, $tree->children[$i]);
				}
			}
			if ($tree != $root) {
				$root = $this->normalizeConjunctions($root);
			}
			$tree = $root;
		}
		return $tree;
	}
	
	/**
	 * Normaliza as disjun��es que s�o filhos da �rvore na FNC, realizando 
	 * a mesma id�ia da normalizeConjunctions.
	 *
	 * @param Node $tree
	 * @return Node
	 */
	public function normalizeDisjunctions(&$tree) {
		if ($tree->content->content == "|") {	
			$root = new Node ( new Connective("|", 2, 300) );
			for ($i = 0; $i < count($tree->children); $i++) {
				if ($tree->children[$i]->content->content == "|") {
					array_push ($root->children, $tree->children[$i]->children[0]);
					array_push ($root->children, $tree->children[$i]->children[1]);
				}
				else {
					array_push ($root->children, $tree->children[$i]);
				}
			}
			if ($tree != $root) {
				$root = $this->normalizeDisjunctions($root);
			}
			$tree = $root;
		}
		return $tree;
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
	 * Acessa o patternTypeArray
	 *
	 * @return array
	 */
	public function getPatternTypeArray() {
		return $this->patternTypeArray;
	}
	
	/**
	 * Atribui um novo valor ao patternTypeArray
	 *
	 * @param $newValue
	 */
	public function setPatternTypeArray($newValue) {
		$this->patternTypeArray = $newValue;
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
	 */
	public function oneMatched($pattern) {
		$t = new WFFTranslator();
		$psol = new PatternSolutions();
	
		echo "One match finded: ".$t->showFormulaInfix($this->rootArray[0])."<br />";
		echo "Solving...<br />";
		$psol->solve($this->rootArray[0], $pattern, $this->patternTypeArray[0]);
		$this->rootArray = array();
		$this->patternTypeArray = array();
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
			echo "<br />";
		}
	}
	
	/**
	 * Acha e armazena os casos de dupla nega��o que possam ocorrer na �rvore dada, imprimindo
	 * em uma lista indexada todas as ocorr�ncias encontradas.
	 * Caso haja somente uma ocorr�ncia, realiza-se a convers�o da dupla nega��o diretamente.
	 *
	 * @param Node $tree
	 * @param String $patternName
	 */
	public function matchDoubleNegation($tree, $patternName) {
		$pattern = PatternCreator::CreatePattern("doubleNegation", $tree);
		
		$this->matchPattern($tree, $pattern);
		
		if ( count($this->rootArray) == 1 ) {
			$this->oneMatched($patternName);
		}
		else {
			$this->printMatched();
		}
	}
	
	/**
	 * Acha e armazena os casos de distributividade que possam ocorrer na �rvore dada, imprimindo
	 * em uma lista indexada todas as ocorr�ncias encontradas.
	 * Caso haja somente uma ocorr�ncia, realiza-se a convers�o da distributividade diretamente.
	 *
	 * @param Node $tree
	 * @param String $patternName
	 */
	public function matchDistributivity($tree, $patternName) {
		$pattern1 = PatternCreator::CreatePattern("distributivity1", $tree);
		$pattern2 = PatternCreator::CreatePattern("distributivity2", $tree);
		
		$this->matchPattern($tree, $pattern1);
		$this->matchPattern($tree, $pattern2);
		
		if ( count($this->rootArray) == 1 ) {
			$this->oneMatched($patternName);
		}
		else {
			$this->printMatched();
		}
	}
	
	/**
	 * Acha e armazena os casos de absor��o que possam ocorrer na �rvore dada, imprimindo
	 * em uma lista indexada todas as ocorr�ncias encontradas.
	 * Caso haja somente uma ocorr�ncia, realiza-se a convers�o da absor��o diretamente.
	 *
	 * @param Node $tree
	 * @param String $patternName
	 */
	public function matchAbsorption($tree, $patternName) {
		$pattern1 = PatternCreator::CreatePattern("absorption1", $tree);
		$pattern2 = PatternCreator::CreatePattern("absorption2", $tree);
		$pattern3 = PatternCreator::CreatePattern("absorption3", $tree);
		$pattern4 = PatternCreator::CreatePattern("absorption4", $tree);
		$pattern5 = PatternCreator::CreatePattern("absorption5", $tree);
		$pattern6 = PatternCreator::CreatePattern("absorption6", $tree);
		$pattern7 = PatternCreator::CreatePattern("absorption7", $tree);
		$pattern8 = PatternCreator::CreatePattern("absorption8", $tree);
		
		$this->matchPattern($tree, $pattern1);
		$this->matchPattern($tree, $pattern2);
		$this->matchPattern($tree, $pattern3);
		$this->matchPattern($tree, $pattern4);
		$this->matchPattern($tree, $pattern5);
		$this->matchPattern($tree, $pattern6);
		$this->matchPattern($tree, $pattern7);
		$this->matchPattern($tree, $pattern8);
		
		if ( count($this->rootArray) == 1 ) {
			$this->oneMatched($patternName);
		}
		else {
			$this->printMatched();
		}
	}
	
	/**
	 * Acha e armazena os casos De Morgan que possam ocorrer na �rvore dada, imprimindo
	 * em uma lista indexada todas as ocorr�ncias encontradas.
	 * Caso haja somente uma ocorr�ncia, realiza-se a convers�o da De Morgan diretamente.
	 *
	 * @param Node $tree
	 * @param String $patternName
	 */
	public function matchDeMorgan($tree, $patternName) {
		$pattern1 = PatternCreator::CreatePattern("deMorgan1", $tree);
		$pattern2 = PatternCreator::CreatePattern("deMorgan2", $tree);
		
		$this->matchPattern($tree, $pattern1);
		$this->matchPattern($tree, $pattern2);
		
		if ( count($this->rootArray) == 1 ) {
			$this->oneMatched($patternName);
		}
		else {
			$this->printMatched();
		}
	}
	
	/**
	 * Acha e armazena os casos de implica��o que possam ocorrer na �rvore dada, imprimindo
	 * em uma lista indexada todas as ocorr�ncias encontradas.
	 * Caso haja somente uma ocorr�ncia, realiza-se a convers�o da implica��o diretamente.
	 *
	 * @param Node $tree
	 * @param String $patternName
	 */
	public function matchImplication($tree, $patternName) {
		$pattern = PatternCreator::CreatePattern("implication", $tree);
		
		$this->matchPattern($tree, $pattern);
		
		if ( count($this->rootArray) == 1 ) {
			$this->oneMatched($patternName);
		}
		else {
			$this->printMatched();
		}
	}
	
	/**
	 * Acha e armazena os casos de biimplica��o que possam ocorrer na �rvore dada, imprimindo
	 * em uma lista indexada todas as ocorr�ncias encontradas.
	 * Caso haja somente uma ocorr�ncia, realiza-se a convers�o da biimplica��o diretamente.
	 *
	 * @param Node $tree
	 * @param String $patternName
	 */
	public function matchBiimplication($tree, $patternName) {
		$pattern = PatternCreator::CreatePattern("biimplication", $tree);
		
		$this->matchPattern($tree, $pattern);
		
		if ( count($this->rootArray) == 1 ) {
			$this->oneMatched($patternName);
		}
		else {
			$this->printMatched();
		}
	}

	/**
	 * Acha e armazena os casos de idempot�ncia que possam ocorrer na �rvore dada, imprimindo
	 * em uma lista indexada todas as ocorr�ncias encontradas.
	 * Caso haja somente uma ocorr�ncia, realiza-se a convers�o da idempot�ncia diretamente.
	 *
	 * @param Node $tree
	 * @param String $patternName
	 */
	public function matchIdempotence($tree, $patternName) {
		$pattern1 = PatternCreator::CreatePattern("idempotence1", $tree);
		$pattern2 = PatternCreator::CreatePattern("idempotence2", $tree);
		
		$this->matchPattern($tree, $pattern1);
		$this->matchPattern($tree, $pattern2);
		
		if ( count($this->rootArray) == 1 ) {
			$this->oneMatched($patternName);
		}
		else {
			$this->printMatched();
		}
	}

	/**
	 * Acha e armazena os casos de elemento neutro que possam ocorrer na �rvore dada, imprimindo
	 * em uma lista indexada todas as ocorr�ncias encontradas.
	 * Caso haja somente uma ocorr�ncia, realiza-se a convers�o da elemento neutro diretamente.
	 *
	 * @param Node $tree
	 * @param String $patternName
	 */
	public function matchNeutralElement($tree, $patternName) {
		$pattern1 = PatternCreator::CreatePattern("neutralElement1", $tree);
		$pattern2 = PatternCreator::CreatePattern("neutralElement2", $tree);
		$pattern3 = PatternCreator::CreatePattern("neutralElement3", $tree);
		$pattern4 = PatternCreator::CreatePattern("neutralElement4", $tree);
		
		$this->matchPattern($tree, $pattern1);
		$this->matchPattern($tree, $pattern2);
		$this->matchPattern($tree, $pattern3);
		$this->matchPattern($tree, $pattern4);
		
		if ( count($this->rootArray) == 1 ) {
			$this->oneMatched($patternName);
		}
		else {
			$this->printMatched();
		}
	}

	/**
	 * Acha e armazena os casos de sups que possam ocorrer na �rvore dada, imprimindo
	 * em uma lista indexada todas as ocorr�ncias encontradas.
	 * Caso haja somente uma ocorr�ncia, realiza-se a convers�o da sups diretamente.
	 *
	 * @param Node $tree
	 * @param String $patternName
	 */
	public function matchSups($tree, $patternName) {
		$pattern1 = PatternCreator::CreatePattern("sups1", $tree);
		$pattern2 = PatternCreator::CreatePattern("sups2", $tree);
		
		$this->matchPattern($tree, $pattern1);
		$this->matchPattern($tree, $pattern2);
		
		if ( count($this->rootArray) == 1 ) {
			$this->oneMatched($patternName);
		}
		else {
			$this->printMatched();
		}
	}

	/**
	 * Acha e armazena os casos de infs que possam ocorrer na �rvore dada, imprimindo
	 * em uma lista indexada todas as ocorr�ncias encontradas.
	 * Caso haja somente uma ocorr�ncia, realiza-se a convers�o da infs diretamente.
	 *
	 * @param Node $tree
	 * @param String $patternName
	 */
	public function matchInfs($tree, $patternName) {
		$pattern1 = PatternCreator::CreatePattern("infs1", $tree);
		$pattern2 = PatternCreator::CreatePattern("infs2", $tree);
		
		$this->matchPattern($tree, $pattern1);
		$this->matchPattern($tree, $pattern2);
		
		if ( count($this->rootArray) == 1 ) {
			$this->oneMatched($patternName);
		}
		else {
			$this->printMatched();
		}
	}

	/**
	 * Acha e armazena os casos onde � poss�vel normalizar os sups e  os infs, imprimindo
	 * em uma lista indexada todas as ocorr�ncias encontradas.
	 * Caso haja somente uma ocorr�ncia, realiza-se a normaliza��o dos sups ou infs diretamente.
	 *
	 * @param Node $tree
	 * @param String $patternName
	 */
	public function matchNormalizeSupsAndInfs($tree, $patternName) {
		$pattern1 = PatternCreator::CreatePattern("normalizeSupsAndInfs1", $tree);
		$pattern2 = PatternCreator::CreatePattern("normalizeSupsAndInfs2", $tree);
		
		$this->matchPattern($tree, $pattern1);
		$this->matchPattern($tree, $pattern2);
		
		if ( count($this->rootArray) == 1 ) {
			$this->oneMatched($patternName);
		}
		else {
			$this->printMatched();
		}
	}

	/**
	 * Acha e armazena os casos de terceiro excluido que possam ocorrer na �rvore dada, imprimindo
	 * em uma lista indexada todas as ocorr�ncias encontradas.
	 * Caso haja somente uma ocorr�ncia, realiza-se a convers�o da terceiro excluido diretamente.
	 *
	 * @param Node $tree
	 * @param String $patternName
	 */
	public function matchExcludedMiddle($tree, $patternName) {
		$pattern1 = PatternCreator::CreatePattern("excludedMiddle1", $tree);
		$pattern2 = PatternCreator::CreatePattern("excludedMiddle2", $tree);
		
		$this->matchPattern($tree, $pattern1);
		$this->matchPattern($tree, $pattern2);
		
		if ( count($this->rootArray) == 1 ) {
			$this->oneMatched($patternName);
		}
		else {
			$this->printMatched();
		}
	}

	/**
	 * Acha e armazena os casos de explos�o que possam ocorrer na �rvore dada, imprimindo
	 * em uma lista indexada todas as ocorr�ncias encontradas.
	 * Caso haja somente uma ocorr�ncia, realiza-se a convers�o da explos�o diretamente.
	 *
	 * @param Node $tree
	 * @param String $patternName
	 */
	public function matchExplosion($tree, $patternName) {
		$pattern1 = PatternCreator::CreatePattern("explosion1", $tree);
		$pattern2 = PatternCreator::CreatePattern("explosion2", $tree);
		
		$this->matchPattern($tree, $pattern1);
		$this->matchPattern($tree, $pattern2);
		
		if ( count($this->rootArray) == 1 ) {
			$this->oneMatched($patternName);
		}
		else {
			$this->printMatched();
		}
	}
	
	/**
	 * Reune todas as fun��es de casamento de padr�es facilitando a manipula��o
	 * das mesmas.
	 *
	 * @param Node $tree
	 * @param String $patternName
	 */
	public function match($tree, $patternName) {
		switch ($patternName) {
			case "doubleNegation":
				$this->matchDoubleNegation($tree, $patternName);
				break;
			case "distributivity":
				$this->matchDistributivity($tree, $patternName);
				break;
			case "absorption":
				$this->matchAbsorption($tree, $patternName);
				break;
			case "deMorgan":
				$this->matchDeMorgan($tree, $patternName);
				break;
			case "implication":
				$this->matchImplication($tree, $patternName);
				break;
			case "biimplication":
				$this->matchBiimplication($tree, $patternName);
				break;
			case "idempotence":
				$this->matchIdempotence($tree, $patternName);
				break;
			case "neutralElement":
				$this->matchNeutralElement($tree, $patternName);
				break;
			case "sups":
				$this->matchSups($tree, $patternName);
				break;
			case "infs":
				$this->matchInfs($tree, $patternName);
				break;
			case "normalizeSupsAndInfs":
				$this->matchNormalizeSupsAndInfs($tree, $patternName);
				break;
			case "excludedMiddle":
				$this->matchExcludedMiddle($tree, $patternName);
				break;
			case "explosion":
				$this->matchExplosion($tree, $patternName);
				break;
		}
	}
}

?>
