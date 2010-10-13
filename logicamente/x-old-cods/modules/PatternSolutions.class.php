<?php

/**
 * Class para resolver os padrões
 *
 */
class PatternSolutions {
	// Resolvendo doubleNegation
	public function solveDoubleNegation($tree) {
		$t= new WFFTranslator();
		echo "[Double Negation]:".$t->showFormulaInfix($tree)." => ";
		
		$tree->content = $tree->children[0]->children[0]->content;
		$tree->children = $tree->children[0]->children[0]->children;
		
		echo $t->showFormulaInfix($tree)."<br /><br />";
		
		return $tree;
	}
	
	// Resolvendo distributivity
	public function solveDistributivity($tree, $patternType) {
		$t = new WFFTranslator();
		//$autoPsol = new AutoPatternSolutions();
		$resultTree = new Node(new Connective("&",2,350));
		$fChild = new Node( new Connective("|",2,300));
		$sChild = new Node( new Connective("|",2,300));
		
		if ( $patternType == "distributivity2") {
			array_push($fChild->children, $tree->children[0]->children[0]);
			array_push($fChild->children, $tree->children[1]);
			array_push($sChild->children, $tree->children[0]->children[1]);
			array_push($sChild->children, $tree->children[1]);
			array_push($resultTree->children, $fChild);
			array_push($resultTree->children, $sChild);
			
			echo "[Distributivity2]:".$t->showFormulaInfix($tree)." => ";
			echo $t->showFormulaInfix($resultTree)."<br /><br />";
			
			$tree->content = $resultTree->content;
			$tree->children = $resultTree->children;
			return $tree;
		}
		else {
			array_push($fChild->children, $tree->children[0]);
			array_push($fChild->children, $tree->children[1]->children[0]);
			array_push($sChild->children, $tree->children[0]);
			array_push($sChild->children, $tree->children[1]->children[1]);
			array_push($resultTree->children, $fChild);
			array_push($resultTree->children, $sChild);
			
			echo "[Distributivity1]:".$t->showFormulaInfix($tree)." => ";
			echo $t->showFormulaInfix($resultTree)."<br /><br />";
			
			$tree->content = $resultTree->content;
			$tree->children = $resultTree->children;
			return $tree;
		}
	}
	
	// Resolvendo absorption
	public function solveAbsorption($tree, $patternType) {
		$t = new WFFTranslator();
		if ( $patternType == "absorption5" || $patternType == "absorption6" 
		   || $patternType == "absorption7" || $patternType == "absorption8") { 
			echo "[Absorption]:".$t->showFormulaInfix($tree)." => ";
			
			$tree->content = $tree->children[1]->content;
			$tree->children = $tree->children[1]->children;
			
			echo $t->showFormulaInfix($tree)."<br /><br />";
			return $tree;
		}
		else {
			echo "[Absorption]:".$t->showFormulaInfix($tree)." => ";
			
			$tree->content = $tree->children[0]->content;
			$tree->children = $tree->children[0]->children;
			
			echo $t->showFormulaInfix($tree)."<br /><br />";
			return $tree;
		}
	}
	
	// Resolvendo deMorgan
	public function solveDeMorgan($tree) {
		$t = new WFFTranslator;
		$autoPsol = new AutoPatternSolutions();
		if ($tree->children[0]->content->content == "|") {
			$resultTree = new Node(new Connective("&",2,350));
			$fChild = new Node( new Connective("~",1,400));
			$sChild = new Node( new Connective("~",1,400));
			
			array_push($fChild->children, $tree->children[0]->children[0]);
			array_push($sChild->children, $tree->children[0]->children[1]);
			array_push($resultTree->children, $fChild);
			array_push($resultTree->children, $sChild);
			
			echo "[De Morgan]:".$t->showFormulaInfix($tree)." => ";
			echo $t->showFormulaInfix($resultTree)."<br /><br />";
			$autoPsol->autoSolveDoubleNegation($resultTree);
			$autoPsol->autoNormalizeSupsAndInfs($resultTree);
	
			$tree->content = $resultTree->content;
			$tree->children = $resultTree->children;
			return $tree;
		}
		else {
			$resultTree = new Node(new Connective("|",2,300));
			$fChild = new Node( new Connective("~",1,400));
			$sChild = new Node( new Connective("~",1,400));
			
			array_push($fChild->children, $tree->children[0]->children[0]);
			array_push($sChild->children, $tree->children[0]->children[1]);
			array_push($resultTree->children, $fChild);
			array_push($resultTree->children, $sChild);
			
			echo "[De Morgan]:".$t->showFormulaInfix($tree)." => ";
			echo $t->showFormulaInfix($resultTree)."<br /><br />";
			$autoPsol->autoSolveDoubleNegation($resultTree);
			$autoPsol->autoNormalizeSupsAndInfs($resultTree);
			
			$tree->content = $resultTree->content;
			$tree->children = $resultTree->children;
			return $tree;
		}
		
	}
	
	// Resolvendo implication
	public function solveImplication($tree) {
		$t = new WFFTranslator();
		$resultTree = new Node(new Connective("|",2,300));
		$fChild = new Node( new Connective("~",1,400));
		
		array_push($fChild->children, $tree->children[0]);
		array_push($resultTree->children, $fChild);
		array_push($resultTree->children, $tree->children[1]);
		
		echo "[Implication]:".$t->showFormulaInfix($tree)." => ";
		echo $t->showFormulaInfix($resultTree)."<br /><br />";
		
		$tree->content = $resultTree->content;
		$tree->children = $resultTree->children;
		return $tree;
	}
	
	// Resolvendo biimplication
	public function solveBiimplication($tree) {
		$t = new WFFTranslator();
		$resultTree = new Node(new Connective("&",2,350));
		$fChild = new Node( new Connective("|",2,300));
		$sChild = new Node( new Connective("|",2,300));
		$fChildLeft = new Node( new Connective("~",1,400));
		$sChildRight = new Node( new Connective("~",1,400));
		
		array_push($fChildLeft->children, $tree->children[0]);
		array_push($fChild->children, $fChildLeft);
		array_push($fChild->children, $tree->children[1]);
		array_push($sChildRight->children, $tree->children[1]);
		array_push($sChild->children, $tree->children[0]);
		array_push($sChild->children, $sChildRight);
		array_push($resultTree->children, $fChild);
		array_push($resultTree->children, $sChild);
		
		echo "[Biimplication]:".$t->showFormulaInfix($tree)." => ";
		echo $t->showFormulaInfix($resultTree)."<br /><br />";
		
		$tree->content = $resultTree->content;
		$tree->children = $resultTree->children;
		return $tree;
	}
	
	// Resolvendo idempotence
	public function solveIdempotence($tree) {
		$t = new WFFTranslator();
		echo "[Idempotence]:".$t->showFormulaInfix($tree)." => ";
		
		$tree->content = $tree->children[0]->content;
		$tree->children = $tree->children[0]->children;
		
		echo $t->showFormulaInfix($tree)."<br /><br />";
		
		return $tree;
	}
	
	//Resolvendo neutralElement
	public function solveNeutralElement($tree) {
		$t = new WFFTranslator();
		if ( ($tree->children[0]->content->content == "0") || ($tree->children[0]->content->content == "1") ){
			echo "[Neutral Element]:".$t->showFormulaInfix($tree)." => ";
			
			$tree->content = $tree->children[1]->content;
			$tree->children = $tree->children[1]->children;
			
			echo $t->showFormulaInfix($tree)."<br /><br />";
			return $tree;
		}
		else {
			echo "[Neutral Element]:".$t->showFormulaInfix($tree)." => ";
			
			$tree->content = $tree->children[0]->content;
			$tree->children = $tree->children[0]->children;
			
			echo $t->showFormulaInfix($tree)."<br /><br />";
			return $tree;
		}
	}
	
	//Resolvendo infs
	public function solveInfs($tree) {
		$t = new WFFTranslator();
		if ( ($tree->children[1]->content->content == "0") || ($tree->children[1]->content->content == "1") ){
			echo "[Infs]:".$t->showFormulaInfix($tree)." => ";
			
			$tree->content = $tree->children[1]->content;
			$tree->children = $tree->children[1]->children;
			
			echo $t->showFormulaInfix($tree)."<br /><br />";
			return $tree;
		}
		else {			
			echo "[Infs]:".$t->showFormulaInfix($tree)." => ";
			
			$tree->content = $tree->children[0]->content;
			$tree->children = $tree->children[0]->children;

			echo $t->showFormulaInfix($tree)."<br /><br />";
			return $tree;
		}
	}
	
	//Resolvendo infs
	public function solveSups($tree) {
		$t = new WFFTranslator();
		if ( ($tree->children[1]->content->content == "0") || ($tree->children[1]->content->content == "1") ){
			echo "[Sups]:".$t->showFormulaInfix($tree)." => ";
			
			$tree->content = $tree->children[1]->content;
			$tree->children = $tree->children[1]->children;
			
			echo $t->showFormulaInfix($tree)."<br /><br />";
			return $tree;
		}
		else {
			echo "[Sups]:".$t->showFormulaInfix($tree)." => ";
			
			$tree->content = $tree->children[0]->content;
			$tree->children = $tree->children[0]->children;
			
			echo $t->showFormulaInfix($tree)."<br /><br />";
			return $tree;
		}
	}
	
	//Normalizando Sups&Infs
	public function normalizeSupsAndInfs($tree) {
		$t = new WFFTranslator();
		if ($tree->children[0]->content->content == "0") {
			$resultTree = new Node(new Atom("1"));
			
			echo "[Normalizing Sups and Infs]:".$t->showFormulaInfix($tree)." => ";
			echo $t->showFormulaInfix($resultTree)."<br /><br />";
			
			$tree->content = $resultTree->content;
			$tree->children = $resultTree->children;
			return $tree;
		}
		else {
			$resultTree = new Node(new Atom("0"));
			
			echo "[Normalizing Sups and Infs]:".$t->showFormulaInfix($tree)." => ";
			echo $t->showFormulaInfix($resultTree)."<br /><br />";
			
			$tree->content = $resultTree->content;
			$tree->children = $resultTree->children;
			return $tree;
		}
	}
	
	//Resolvendo tautologias
	public function solveTautology($tree) {
		$t = new WFFTranslator();
	
		$resultTree = new Node(new Atom("1"));
		
		echo "[Tautology]:".$t->showFormulaInfix($tree)." => ";
		echo $t->showFormulaInfix($resultTree)."<br /><br />";
		
		$tree->content = $resultTree->content;
		$tree->children = $resultTree->children;
		return $tree;
	}
	
	//Resolvendo antilogias
	public function solveAntilogy($tree) {
		$resultTree = new Node(new Atom("0"));
		
		echo "[Antilogy]:".$t->showFormulaInfix($tree)." => ";
		echo $t->showFormulaInfix($resultTree)."<br /><br />";
		
		$tree->content = $resultTree->content;
		$tree->children = $resultTree->children;
		return $tree;
	}
	
	/**
	 * Escolhe o tipo de solução desejada para cada regra
	 *
	 * @param Node $tree Árvore em que se aplicara a regra.
	 * @param $pattern String que determina a regra a ser aplicada
	 * @param $patternType String que determina a versão da regra aplicada (Só necessita na distributividade e na absorção)
	 * @return Node Árvore depois que a regra foi aplicada.
	 */
	public function solve($tree, $pattern, $patternType) {
		$sp = new PatternSolutions();
		switch ($pattern) {
			case "doubleNegation":
				return $sp->solveDoubleNegation($tree);
			case "distributivity":
				return $sp->solveDistributivity($tree, $patternType);
			case "absorption":
				return $sp->solveAbsorption($tree, $patternType);
			case "deMorgan":
				return $sp->solveDeMorgan($tree);
			case "implication":
				return $sp->solveImplication($tree);
			case "biimplication":
				return $sp->solveBiimplication($tree);
			case "idempotence":
				return $sp->solveIdempotence($tree);
			case "neutralElement":
				return $sp->solveNeutralElement($tree);
			case "infs":
				return $sp->solveInfs($tree);
			case "sups":
				return $sp->solveSups($tree);
			case "normalizeSupsAndInfs":
				return $sp->normalizeSupsAndInfs($tree);
			case "tautology" :
				return $sp->solveTautology($tree);
			case "antilogy" :
				return $sp->solveAntilogy($tree);
		}
	}
}

?>
