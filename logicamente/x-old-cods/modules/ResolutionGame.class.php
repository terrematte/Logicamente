<?php

class ResolutionGame {
	
	// Auxiliary variable used in method autoSolveAux to ensure that once a derivation has been found, the search is stopped.
	private $found = false;
	// Auxiliary array used in method autoSolveAux to ensure that no eliminations will produce an clausula already achieved.
	private $newClausulaList = array();
	// Array that stores all clausulas that can used to derive bottom.
	private $clausulaList = array();
	// Stores the clausula list at the time the game was created.
	private $originalClausulaList = array();
	
	/**
	 * Method used to add all clausulas from a converted tree
	 *
	 * @param MegaConjunction $tree
	 */
	public function addConvertedTree($tree) {
		$clausulas = $tree->children;
		for ($i = 0; $i < count($clausulas); $i++) {
			if ($clausulas[$i]->content->content != "|") {
				$newClausulaRoot = new Node(new Connective("|", 2, 300));
				array_push($newClausulaRoot->children, $clausulas[$i]);
				if (count($this->findComplementaryLiterals($newClausulaRoot, $newClausulaRoot)) == 0) {
					$this->removeRepeatedElements($newClausulaRoot->children);
					$this->addClausula($newClausulaRoot);
				}
			} else {
				if (count($this->findComplementaryLiterals($clausulas[$i], $clausulas[$i])) == 0) {
					$this->removeRepeatedElements($clausulas[$i]->children);
					$this->addClausula($clausulas[$i]);
				}
			}
		}
	}
	
	/**
	 * Auxiliary method used to eliminate repeated elements from an array. Used when two clausulas has one common literal.
	 *
	 * @param array $array
	 */
	public function removeRepeatedElements(&$array) {
		for ($i = 0; $i < count($array); $i++) {
			for ($j = $i+1; $j < count($array); $j++) {
				if ($array[$i] == $array[$j]) {
					unset($array[$j]);
					$array = array_merge($array, array());
				}
			}
		}
	}
	
	/**
	 * Method used to find pairs of complementary literals in the two clausulas.
	 *
	 * @param MegaDisjuntion $firstClausula
	 * @param MegaDisjuntion $secondClausula
	 * @return LiteralPairArray $literalPairArray Array that contains all pairs of complementary literals found.
	 */
	public function findComplementaryLiterals($firstClausula, $secondClausula) {
		$literalPairArray = array();
		foreach ($firstClausula->children as $firstClausulaLiteral) {
			if ($firstClausulaLiteral->content instanceof Connective) {
				$nodeToBeFound = $firstClausulaLiteral->children[0];
				foreach ($secondClausula->children as $secondClausulaLiteral) {
					if ($secondClausulaLiteral->content->content == $nodeToBeFound->content->content) {
						array_push($literalPairArray, array($firstClausulaLiteral, $secondClausulaLiteral));
					}
				}
			}
		}
		if ($firstClausula != $secondClausula) {
			foreach ($secondClausula->children as $secondClausulaLiteral) {
				if ($secondClausulaLiteral->content instanceof Connective) {
					$nodeToBeFound = $secondClausulaLiteral->children[0];
					foreach ($firstClausula->children as $firstClausulaLiteral) {
						if ($firstClausulaLiteral->content->content == $nodeToBeFound->content->content) {
							array_push($literalPairArray, array($secondClausulaLiteral, $firstClausulaLiteral));
						}
					}
				}
			}
		}
		return $literalPairArray;
	}
	
	/**
	 * Method used to eliminate a given pair of complementary literals in two clausulas.
	 *
	 * @param LiteralPairArray $literalPair Array containing a pair of complementary literals.
	 * @param MegaDisjunction $firstClausula 
	 * @param MegaDisjunction $secondClausula
	 * @return MegaDisjunction $result Result of the elimination.
	 */
	private function eliminateComplementaryLiterals($literalPair, $firstClausula, $secondClausula) {
		for ($i = 0; $i < count($firstClausula->children); $i++) {
			if ($firstClausula->children[$i] == $literalPair[0]) {
				for ($j = 0; $j < count($secondClausula->children); $j++) {
					if ($secondClausula->children[$j] == $literalPair[1]) {
						$teste1 = new Node(null);
						$teste1->content = $firstClausula->content;
						$teste1->children = $firstClausula->children;
						$teste2 = new Node(null);
						$teste2->content = $secondClausula->content;
						$teste2->children = $secondClausula->children;
						unset($teste1->children[$i]);
						unset($teste2->children[$j]);
						foreach ($teste1->children as $node) {
							if (in_array($node, $teste2->children)) {
								$found = array_search($node, $teste2->children);
								unset($teste2->children[$found]);
							}
						}
						$result = new Node(new Connective("|", 2, 300));
						$result->children = array_merge($teste1->children, $teste2->children);
						if (count($result->children) == 0) {
							return;
						}
						return $result;
					}
				}
			}
			if ($firstClausula->children[$i] == $literalPair[1]) {
				for ($j = 0; $j < count($secondClausula->children); $j++) {
					if ($secondClausula->children[$j] == $literalPair[0]) {
						$teste1 = new Node(null);
						$teste1->content = $firstClausula->content;
						$teste1->children = $firstClausula->children;
						$teste2 = new Node(null);
						$teste2->content = $secondClausula->content;
						$teste2->children = $secondClausula->children;
						unset($teste1->children[$i]);
						unset($teste2->children[$j]);
						foreach ($teste1->children as $node) {
							if (in_array($node, $teste2->children)) {
								$found = array_search($node, $teste2->children);
								unset($teste2->children[$found]);
							}
						}
						$result = new Node(new Connective("|", 2, 300));
						$result->children = array_merge($teste1->children, $teste2->children);
						if (count($result->children) == 0) {
							return;
						}
						return $result;
					}
				}
			}
		}
	}
	
	/**
	 * Auxiliary function to print a mega disjunction.
	 *
	 * @param Mega Disjunction $clausula
	 * @return String corresponding to the Mega Disjunction passed as argument
	 */
	private function printMegaDisjunction($clausula) {
		$result = "";
		if ($clausula->children[0]->content instanceof Connective) {
			$result = "".$clausula->children[0]->content->content.$clausula->children[0]->children[0]->content->content;	
		} else {
			$result .= "".$clausula->children[0]->content->content;
		}
		for ($i = 1; $i < count($clausula->children); $i++) {
			if ($clausula->children[$i]->content instanceof Connective) {
				$result .= " | ".$clausula->children[$i]->content->content.$clausula->children[$i]->children[0]->content->content;	
			} else {
				$result .= " | ".$clausula->children[$i]->content->content;
			}
		}
		return "$result<br/>";
	}
	
	/**
	 * Auxiliary method used to check if method autoSolveAux reached the end of a derivation 
	 *
	 * @param Mega Disjunction $clausula1
	 * @param Mega Disjunction $clausula2
	 * @return boolean true if both clausulas contains, each one, only a member of a pair of complementary literals; false otherwise.
	 */
	private function checkEnd($clausula1, $clausula2) {
		if (count($clausula1->children) == 1 && count($clausula2->children) == 1 && $clausula1->children[0]->content instanceof Connective && $clausula1->children[0]->children[0]->content->content == $clausula2->children[0]->content->content) {
			return true;
		} elseif (count($clausula2->children) == 1 && count($clausula1->children) == 1 && $clausula2->children[0]->content instanceof Connective && $clausula2->children[0]->children[0]->content->content == $clausula1->children[0]->content->content) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Method that finds the number of literals to be eliminated and evaluates it, printing
	 * an error message if there's no pair, executing an elimination, if there's only one pair
	 * or returning the array containing all pairs found.
	 *
	 * @param MegaDisjunction $firstClausula
	 * @param MegaDisjunction $secondClausula
	 * @return LiteralPairArray $literalPairArray If there's more than one pair, null otherwise.
	 */
	public function solve($firstClausula, $secondClausula) {
		$literalPairArray = $this->findComplementaryLiterals($firstClausula, $secondClausula);
		$nPairs = count($literalPairArray);
		if ($nPairs == 0) {
			echo "No literals to be eliminated";
			return;
		} elseif ($nPairs == 1) {
			echo $this->printMegaDisjunction($firstClausula);
			echo $this->printMegaDisjunction($secondClausula);
			$newClausula = $this->eliminateComplementaryLiterals($literalPairArray[0], $firstClausula, $secondClausula);
			if ($newClausula == null) {
				echo "0<br /><b>End of derivation</b>";
				return;
			} else {
				echo $this->printMegaDisjunction($newClausula);
			}
			echo "<br/>";
			array_push($this->clausulaList, $newClausula);
			return;
		} else {
			return $literalPairArray;
		}
	}
	
	/**
	 * Auxiliary method used to implement the automatic resolution.
	 *
	 * @param Mega Disjunction $secondClausula 
	 * @param String $resp String modified by the algorithm to contain every step it has made to realize the derivation
	 * @return true if the
	 */
	private function autoSolveAux($secondClausula, &$resp) {
		if (!$this->found) {
			for ($i = 0; $i < count($this->clausulaList); $i++) {
				$firstClausula = $this->clausulaList[$i];
				if ($firstClausula != $secondClausula) {
					$pair = $this->findComplementaryLiterals($firstClausula, $secondClausula);
					if (count($pair) == 1) {
						if ($this->checkEnd($firstClausula, $secondClausula)) {
							$resp .= array_search($firstClausula, $this->clausulaList)." ".$this->printMegaDisjunction($firstClausula);
							$resp .= $this->printMegaDisjunction($secondClausula);
							$resp .= "0<br />";
							$this->found = true;
							break;
						} else {
							$newClausula = $this->eliminateComplementaryLiterals($pair[0], $firstClausula, $secondClausula);
							if (!in_array($newClausula, $this->newClausulaList)) {
								$this->removeRepeatedElements($newClausula->children);
								array_push($this->newClausulaList, $newClausula);
								$resp .= array_search($firstClausula, $this->clausulaList)." ".$this->printMegaDisjunction($firstClausula);
								$resp .= $this->printMegaDisjunction($secondClausula);
								$resp .= count($this->clausulaList)." ".$this->printMegaDisjunction($newClausula)."<br/>";
								if ($newClausula != null) {
									if (!in_array($newClausula, $this->clausulaList)) {		
										array_push($this->clausulaList, $newClausula);
									}
									$this->autoSolveAux($newClausula, $resp);
									break;
								}
							} else {
								continue;
							}
						}
					} else {
						continue;
					}
				}
			}
		}
		if (in_array($secondClausula, $this->newClausulaList)) {
			$i = array_search($secondClausula, $this->newClausulaList);
			$i = array_search($secondClausula, $this->clausulaList);
			unset($this->clausulaList[$i]);
			$this->clausulaList = array_merge($this->clausulaList, array());
			unset($this->newClausulaList[$i]);
			$this->newClausulaList = array_merge($this->newClausulaList, array());
		}
	}
	
	/**
	 * Method that, using a list of clausulas, returns the derivation, if it's possible
	 * or returns "Impossible deriation" otherwise.
	 *
	 */
	public function autoSolve() {
		for ($i = 0; $i < count($this->clausulaList); $i++) {
			$resp = "";
			$secondClausula = $this->clausulaList[$i];
			$bool = $this->autoSolveAux($secondClausula, $resp);
			$this->newClausulaList = array();
			if ($this->found) {
				echo $resp;
				echo "<b>End of derivation</b>";
				return;
			}
		}
		echo "<b>Impossible derivation</b>";
		$this->resetClausulaList();
	}
	
	/**
	 * Method used to set the list of clausulas that will be used on the game.
	 *
	 * @param Mega Disjunction array $newList Array containing the clausulas to be used on the game
	 */
	public function setClausulaList($newList) {
		$this->clausulaList = $newList;
	}
	
	/**
	 * Add a clausula to the list being used on the game
	 *
	 * @param Mega Disjunction $newClausula Clausula to be added
	 */
	public function addClausula($newClausula) {
		array_push($this->clausulaList, $newClausula);
		array_push($this->originalClausulaList, $newClausula);
	}
	
	/**
	 * Returns a clausula stored in the list being used on the game
	 *
	 * @param int $i Index
	 * @return Mega Disjunction $newClausula
	 */
	public function getClausula($i) {
		return $this->clausulaList[$i];
	}
	
	/**
	 * Returns the clausula list being used on the game
	 *
	 * @return array Clausula List
	 */
	public function getClausulaList() {
		return $this->clausulaList;
	}
	
	public function resetClausulaList() {
		$this->clausulaList = $this->originalClausulaList;
	}
	
	/**
	 * Print the game's list of clausulas
	 *
	 */
	public function printListOfClausulas() {
		echo "<b>List of clausulas:<br /></b>";
		for ($i = 0; $i < count($this->clausulaList); $i++) {
			echo "$i -> ".$this->printMegaDisjunction($this->clausulaList[$i]);
		}
		echo "<b>End of list<br /></b>";
	}
}
?>