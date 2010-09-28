<?php
/**
 * Classe que resolve automaticamente uma regra
 */
class AutoPatternSolutions {
	/**
	 * Construtor
	 */
	public function AutoPatternSolutions() {}
	
	/**
	 * Tal conjunto de resoluções automáticas auxilia na resolução 
	 * de outras regras (ex: Distributividade).
	 *
	 * @param Node $tree
	 */
	public function autoAux(Node $tree) {
		$this->autoSolveAbsorption($tree);
		$this->autoSolveIdempotence($tree);
		$this->autoSolveTautology($tree);
		$this->autoSolveAntilogy($tree);
		$this->autoSolveNeutralElement($tree);
		$this->autoSolveInfs($tree);
		$this->autoSolveSups($tree);
	}
	/**
	 * Resolve automaticamente os casos de dupla negação.
	 *
	 * @param Node $tree
	 */
	public function autoSolveDoubleNegation(Node $tree) {
		//echo "Solving cases of double negation if they exist...<br />";
		$psol = new PatternSolutions();
		
		$pm1 = new PatternMatcher();
		
		$pattern = PatternCreator::CreatePattern("doubleNegation", $tree);
		
		$pm1->matchPattern($tree, $pattern);
		
		$ra1 = $pm1->getRootArray();
		
		while ($pm1->hasMatched()) {
			$psol->solve($ra1[0],"doubleNegation", $pattern->getPatternType());
			$pm1->setRootArray(array());
			$pm1->matchPattern($tree, $pattern);
			$ra1 = $pm1->getRootArray();
		}
	}
	
	/**
	 * Resolve automaticamente os casos de distributividade.
	 *
	 * @param Node $tree
	 */
	public function autoSolveDistributivity(Node $tree) {	
	//	echo "Solving cases of distributivity if they exist...<br />";
		$psol = new PatternSolutions();
		
		$pm1 = new PatternMatcher();
		$pm2 = new PatternMatcher();
		
		$pattern1 = PatternCreator::CreatePattern("distributivity1", $tree);
		$pattern2 = PatternCreator::CreatePattern("distributivity2", $tree);
		
		$pm1->matchPattern($tree, $pattern1);
		$pm2->matchPattern($tree, $pattern2);
		
		$ra1 = $pm1->getRootArray();
		$ra2 = $pm2->getRootArray();
		while ($pm1->hasMatched() || $pm2->hasMatched()) {
			while ($pm1->hasMatched()) {
				$psol->solve($ra1[0],"distributivity", $pattern1->getPatternType());
				$this->autoAux($tree);
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				
								
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
			}
			while ($pm2->hasMatched()) {
				$psol->solve($ra2[0],"distributivity", $pattern2->getPatternType());
				$this->autoAux($tree);
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
			}
		}
	}
	
	/**
	 * Resolve automaticamente os casos de absorção.
	 *
	 * @param Node $tree
	 */
	public function autoSolveAbsorption(Node $tree) {	
		//echo "Solving cases of absorption if they exist...<br />";
		$psol = new PatternSolutions();
		
		$pm1 = new PatternMatcher();
		$pm2 = new PatternMatcher();
		$pm3 = new PatternMatcher();
		$pm4 = new PatternMatcher();
		$pm5 = new PatternMatcher();
		$pm6 = new PatternMatcher();
		$pm7 = new PatternMatcher();
		$pm8 = new PatternMatcher();
		
		$pattern1 = PatternCreator::CreatePattern("absorption1", $tree);
		$pattern2 = PatternCreator::CreatePattern("absorption2", $tree);
		$pattern3 = PatternCreator::CreatePattern("absorption3", $tree);
		$pattern4 = PatternCreator::CreatePattern("absorption4", $tree);
		$pattern5 = PatternCreator::CreatePattern("absorption5", $tree);
		$pattern6 = PatternCreator::CreatePattern("absorption6", $tree);
		$pattern7 = PatternCreator::CreatePattern("absorption7", $tree);
		$pattern8 = PatternCreator::CreatePattern("absorption8", $tree);
		
		$pm1->matchPattern($tree, $pattern1);
		$pm2->matchPattern($tree, $pattern2);
		$pm3->matchPattern($tree, $pattern3);
		$pm4->matchPattern($tree, $pattern4);
		$pm5->matchPattern($tree, $pattern5);
		$pm6->matchPattern($tree, $pattern6);
		$pm7->matchPattern($tree, $pattern7);
		$pm8->matchPattern($tree, $pattern8);
		
		$ra1 = $pm1->getRootArray();
		$ra2 = $pm2->getRootArray();
		$ra3 = $pm3->getRootArray();
		$ra4 = $pm4->getRootArray();
		$ra5 = $pm5->getRootArray();
		$ra6 = $pm6->getRootArray();
		$ra7 = $pm7->getRootArray();
		$ra8 = $pm8->getRootArray();
		while ( $pm1->hasMatched() || $pm2->hasMatched() || $pm3->hasMatched() || $pm4->hasMatched() 
			 || $pm5->hasMatched() || $pm6->hasMatched() || $pm7->hasMatched() || $pm8->hasMatched() ) {	
			
			while ($pm1->hasMatched()) {
				$psol->solve($ra1[0],"absorption", $pattern1->getPatternType());
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				$pm3->setRootArray(array());
				$pm3->matchPattern($tree, $pattern3);
				$ra3 = $pm3->getRootArray();
				$pm4->setRootArray(array());
				$pm4->matchPattern($tree, $pattern4);
				$ra4 = $pm4->getRootArray();
				$pm5->setRootArray(array());
				$pm5->matchPattern($tree, $pattern5);
				$ra5 = $pm5->getRootArray();
				$pm6->setRootArray(array());
				$pm6->matchPattern($tree, $pattern6);
				$ra6 = $pm6->getRootArray();
				$pm7->setRootArray(array());
				$pm7->matchPattern($tree, $pattern7);
				$ra7 = $pm7->getRootArray();
				$pm8->setRootArray(array());
				$pm8->matchPattern($tree, $pattern8);
				$ra8 = $pm8->getRootArray();
			}
			while ($pm2->hasMatched()) {
				$psol->solve($ra2[0],"absorption", $pattern2->getPatternType());
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				$pm3->setRootArray(array());
				$pm3->matchPattern($tree, $pattern3);
				$ra3 = $pm3->getRootArray();
				$pm4->setRootArray(array());
				$pm4->matchPattern($tree, $pattern4);
				$ra4 = $pm4->getRootArray();
				$pm5->setRootArray(array());
				$pm5->matchPattern($tree, $pattern5);
				$ra5 = $pm5->getRootArray();
				$pm6->setRootArray(array());
				$pm6->matchPattern($tree, $pattern6);
				$ra6 = $pm6->getRootArray();
				$pm7->setRootArray(array());
				$pm7->matchPattern($tree, $pattern7);
				$ra7 = $pm7->getRootArray();
				$pm8->setRootArray(array());
				$pm8->matchPattern($tree, $pattern8);
				$ra8 = $pm8->getRootArray();
			}
			while ($pm3->hasMatched()) {
				$psol->solve($ra3[0],"absorption", $pattern3->getPatternType());
				$pm3->setRootArray(array());
				$pm3->matchPattern($tree, $pattern3);
				$ra3 = $pm3->getRootArray();
				
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				$pm4->setRootArray(array());
				$pm4->matchPattern($tree, $pattern4);
				$ra4 = $pm4->getRootArray();
				$pm5->setRootArray(array());
				$pm5->matchPattern($tree, $pattern5);
				$ra5 = $pm5->getRootArray();
				$pm6->setRootArray(array());
				$pm6->matchPattern($tree, $pattern6);
				$ra6 = $pm6->getRootArray();
				$pm7->setRootArray(array());
				$pm7->matchPattern($tree, $pattern7);
				$ra7 = $pm7->getRootArray();
				$pm8->setRootArray(array());
				$pm8->matchPattern($tree, $pattern8);
				$ra8 = $pm8->getRootArray();
			}
			while ($pm4->hasMatched()) {
				$psol->solve($ra4[0],"absorption", $pattern4->getPatternType());
				$pm4->setRootArray(array());
				$pm4->matchPattern($tree, $pattern4);
				$ra4 = $pm4->getRootArray();
				
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				$pm3->setRootArray(array());
				$pm3->matchPattern($tree, $pattern3);
				$ra3 = $pm3->getRootArray();
				$pm5->setRootArray(array());
				$pm5->matchPattern($tree, $pattern5);
				$ra5 = $pm5->getRootArray();
				$pm6->setRootArray(array());
				$pm6->matchPattern($tree, $pattern6);
				$ra6 = $pm6->getRootArray();
				$pm7->setRootArray(array());
				$pm7->matchPattern($tree, $pattern7);
				$ra7 = $pm7->getRootArray();
				$pm8->setRootArray(array());
				$pm8->matchPattern($tree, $pattern8);
				$ra8 = $pm8->getRootArray();
			}
			while ($pm5->hasMatched()) {
				$psol->solve($ra5[0],"absorption", $pattern5->getPatternType());
				$pm5->setRootArray(array());
				$pm5->matchPattern($tree, $pattern5);
				$ra5 = $pm5->getRootArray();
				
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				$pm3->setRootArray(array());
				$pm3->matchPattern($tree, $pattern3);
				$ra3 = $pm3->getRootArray();
				$pm4->setRootArray(array());
				$pm4->matchPattern($tree, $pattern4);
				$ra4 = $pm4->getRootArray();
				$pm6->setRootArray(array());
				$pm6->matchPattern($tree, $pattern6);
				$ra6 = $pm6->getRootArray();
				$pm7->setRootArray(array());
				$pm7->matchPattern($tree, $pattern7);
				$ra7 = $pm7->getRootArray();
				$pm8->setRootArray(array());
				$pm8->matchPattern($tree, $pattern8);
				$ra8 = $pm8->getRootArray();
			}
			while ($pm6->hasMatched()) {
				$psol->solve($ra6[0],"absorption", $pattern6->getPatternType());
				$pm6->setRootArray(array());
				$pm6->matchPattern($tree, $pattern6);
				$ra6 = $pm6->getRootArray();
				
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				$pm3->setRootArray(array());
				$pm3->matchPattern($tree, $pattern3);
				$ra3 = $pm3->getRootArray();
				$pm4->setRootArray(array());
				$pm4->matchPattern($tree, $pattern4);
				$ra4 = $pm4->getRootArray();
				$pm5->setRootArray(array());
				$pm5->matchPattern($tree, $pattern5);
				$ra5 = $pm5->getRootArray();
				$pm7->setRootArray(array());
				$pm7->matchPattern($tree, $pattern7);
				$ra7 = $pm7->getRootArray();
				$pm8->setRootArray(array());
				$pm8->matchPattern($tree, $pattern8);
				$ra8 = $pm8->getRootArray();
			}
			while ($pm7->hasMatched()) {
				$psol->solve($ra7[0],"absorption", $pattern7->getPatternType());
				$pm7->setRootArray(array());
				$pm7->matchPattern($tree, $pattern7);
				$ra7 = $pm7->getRootArray();
				
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				$pm3->setRootArray(array());
				$pm3->matchPattern($tree, $pattern3);
				$ra3 = $pm3->getRootArray();
				$pm4->setRootArray(array());
				$pm4->matchPattern($tree, $pattern4);
				$ra4 = $pm4->getRootArray();
				$pm5->setRootArray(array());
				$pm5->matchPattern($tree, $pattern5);
				$ra5 = $pm5->getRootArray();
				$pm6->setRootArray(array());
				$pm6->matchPattern($tree, $pattern6);
				$ra6 = $pm6->getRootArray();
				$pm8->setRootArray(array());
				$pm8->matchPattern($tree, $pattern8);
				$ra8 = $pm8->getRootArray();
			}
			while ($pm8->hasMatched()) {
				$psol->solve($ra8[0],"absorption", $pattern8->getPatternType());
				$pm8->setRootArray(array());
				$pm8->matchPattern($tree, $pattern8);
				$ra8 = $pm8->getRootArray();
				
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				$pm3->setRootArray(array());
				$pm3->matchPattern($tree, $pattern3);
				$ra3 = $pm3->getRootArray();
				$pm4->setRootArray(array());
				$pm4->matchPattern($tree, $pattern4);
				$ra4 = $pm4->getRootArray();
				$pm5->setRootArray(array());
				$pm5->matchPattern($tree, $pattern5);
				$ra5 = $pm5->getRootArray();
				$pm6->setRootArray(array());
				$pm6->matchPattern($tree, $pattern6);
				$ra6 = $pm6->getRootArray();
				$pm7->setRootArray(array());
				$pm7->matchPattern($tree, $pattern7);
				$ra7 = $pm7->getRootArray();
			}
		}
	}
	
	/**
	 * Resolve automaticamente os casos de De Morgan.
	 *
	 * @param Node $tree
	 */
	public function autoSolveDeMorgan(Node $tree) {	
		//echo "Solving cases of De Morgan if they exist...<br />";
		$psol = new PatternSolutions();
		
		$pm1 = new PatternMatcher();
		$pm2 = new PatternMatcher();
		
		$pattern1 = PatternCreator::CreatePattern("deMorgan1", $tree);
		$pattern2 = PatternCreator::CreatePattern("deMorgan2", $tree);
		
		$pm1->matchPattern($tree, $pattern1);
		$pm2->matchPattern($tree, $pattern2);
		
		$ra1 = $pm1->getRootArray();
		$ra2 = $pm2->getRootArray();
		
		while ($pm1->hasMatched() || $pm2->hasMatched()) {
			while ($pm1->hasMatched()) {
				$psol->solve($ra1[0],"deMorgan", $pattern1->getPatternType());
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
			}
			while ($pm2->hasMatched()) {
				$psol->solve($ra2[0],"deMorgan", $pattern2->getPatternType());
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();

				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
			}
		}
	}
	
	/**
	 * Resolve automaticamente os casos de implicação.
	 *
	 * @param Node $tree
	 */
	public function autoSolveImplication(Node $tree) {
	//	echo "Solving cases of implication if they exist...<br />";
		$psol = new PatternSolutions();
		
		$pm1 = new PatternMatcher();
		
		$pattern = PatternCreator::CreatePattern("implication", $tree);
		
		$pm1->matchPattern($tree, $pattern);
		
		$ra1 = $pm1->getRootArray();
		
		while ($pm1->hasMatched()) {
			$psol->solve($ra1[0],"implication", $pattern->getPatternType());
			$pm1->setRootArray(array());
			$pm1->matchPattern($tree, $pattern);
			$ra1 = $pm1->getRootArray();
		}
	}
	
	/**
	 * Resolve automaticamente os casos de biimplicação.
	 *
	 * @param Node $tree
	 */
	public function autoSolveBiimplication(Node $tree) {
		//echo "Solving cases of biimplication if they exist...<br />";
		$psol = new PatternSolutions();
		
		$pm1 = new PatternMatcher();
		
		$pattern = PatternCreator::CreatePattern("biimplication", $tree);
		
		$pm1->matchPattern($tree, $pattern);
		
		$ra1 = $pm1->getRootArray();
		
		while ($pm1->hasMatched()) {
			$psol->solve($ra1[0],"biimplication", $pattern->getPatternType());
			$pm1->setRootArray(array());
			$pm1->matchPattern($tree, $pattern);
			$ra1 = $pm1->getRootArray();
		}
	}
	
	/**
	 * Resolve automaticamente os casos de idempotência.
	 *
	 * @param Node $tree
	 */
	public function autoSolveIdempotence(Node $tree) {	
		//echo "Solving cases of idempotence if they exist...<br />";
		$psol = new PatternSolutions();
		
		$pm1 = new PatternMatcher();
		$pm2 = new PatternMatcher();
		
		$pattern1 = PatternCreator::CreatePattern("idempotence1", $tree);
		$pattern2 = PatternCreator::CreatePattern("idempotence2", $tree);
		
		$pm1->matchPattern($tree, $pattern1);
		$pm2->matchPattern($tree, $pattern2);
		
		$ra1 = $pm1->getRootArray();
		$ra2 = $pm2->getRootArray();
		
		while ($pm1->hasMatched() || $pm2->hasMatched()) {
			while ($pm1->hasMatched()) {
				$psol->solve($ra1[0],"idempotence", $pattern1->getPatternType());
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
			}
			while ($pm2->hasMatched()) {
				$psol->solve($ra2[0],"idempotence", $pattern2->getPatternType());
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
			}
		}
	}
	
	/**
	 * Resolve automaticamente os casos de elemento neutro.
	 *
	 * @param Node $tree
	 */
	public function autoSolveNeutralElement(Node $tree) {	
	//	echo "Solving cases of neutral elements if they exist...<br />";
		$psol = new PatternSolutions();
		
		$pm1 = new PatternMatcher();
		$pm2 = new PatternMatcher();
		$pm3 = new PatternMatcher();
		$pm4 = new PatternMatcher();
		
		$pattern1 = PatternCreator::CreatePattern("neutralElement1", $tree);
		$pattern2 = PatternCreator::CreatePattern("neutralElement2", $tree);
		$pattern3 = PatternCreator::CreatePattern("neutralElement3", $tree);
		$pattern4 = PatternCreator::CreatePattern("neutralElement4", $tree);
		
		$pm1->matchPattern($tree, $pattern1);
		$pm2->matchPattern($tree, $pattern2);
		$pm3->matchPattern($tree, $pattern3);
		$pm4->matchPattern($tree, $pattern4);
		
		$ra1 = $pm1->getRootArray();
		$ra2 = $pm2->getRootArray();
		$ra3 = $pm3->getRootArray();
		$ra4 = $pm4->getRootArray();
		while ( $pm1->hasMatched() || $pm2->hasMatched() || $pm3->hasMatched() || $pm4->hasMatched() ) {
			while ($pm1->hasMatched()) {
				$psol->solve($ra1[0],"neutralElement", $pattern1->getPatternType());
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				$pm3->setRootArray(array());
				$pm3->matchPattern($tree, $pattern3);
				$ra3 = $pm3->getRootArray();
				$pm4->setRootArray(array());
				$pm4->matchPattern($tree, $pattern4);
				$ra4 = $pm4->getRootArray();
			}
			while ($pm2->hasMatched()) {
				$psol->solve($ra2[0],"neutralElement", $pattern2->getPatternType());
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				$pm3->setRootArray(array());
				$pm3->matchPattern($tree, $pattern3);
				$ra3 = $pm3->getRootArray();
				$pm4->setRootArray(array());
				$pm4->matchPattern($tree, $pattern4);
				$ra4 = $pm4->getRootArray();
			}
			while ($pm3->hasMatched()) {
				$psol->solve($ra3[0],"neutralElement", $pattern3->getPatternType());
				$pm3->setRootArray(array());
				$pm3->matchPattern($tree, $pattern3);
				$ra3 = $pm3->getRootArray();
				
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				$pm4->setRootArray(array());
				$pm4->matchPattern($tree, $pattern4);
				$ra4 = $pm4->getRootArray();
			}
			while ($pm4->hasMatched()) {
				$psol->solve($ra4[0],"neutralElement", $pattern4->getPatternType());
				$pm4->setRootArray(array());
				$pm4->matchPattern($tree, $pattern4);
				$ra4 = $pm4->getRootArray();
				
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				$pm3->setRootArray(array());
				$pm3->matchPattern($tree, $pattern3);
				$ra3 = $pm3->getRootArray();
			}
		}
	}
	
	/**
	 * Resolve automaticamente os casos de infs.
	 *
	 * @param Node $tree
	 */
	public function autoSolveInfs(Node $tree) {	
		//echo "Solving cases of infs if they exist...<br />";
		$psol = new PatternSolutions();
		
		$pm1 = new PatternMatcher();
		$pm2 = new PatternMatcher();
		
		$pattern1 = PatternCreator::CreatePattern("infs1", $tree);
		$pattern2 = PatternCreator::CreatePattern("infs2", $tree);
		
		$pm1->matchPattern($tree, $pattern1);
		$pm2->matchPattern($tree, $pattern2);
		
		$ra1 = $pm1->getRootArray();
		$ra2 = $pm2->getRootArray();
		
		while ($pm1->hasMatched() || $pm2->hasMatched()) {
			while ($pm1->hasMatched()) {
				$psol->solve($ra1[0],"infs", $pattern1->getPatternType());
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
			}
			while ($pm2->hasMatched()) {
				$psol->solve($ra2[0],"infs", $pattern2->getPatternType());
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
			}
		}
	}
	
	/**
	 * Resolve automaticamente os casos de sups.
	 *
	 * @param Node $tree
	 */
	public function autoSolveSups(Node $tree) {	
		//echo "Solving cases of sups if they exist...<br />";
		$psol = new PatternSolutions();
		
		$pm1 = new PatternMatcher();
		$pm2 = new PatternMatcher();
		
		$pattern1 = PatternCreator::CreatePattern("sups1", $tree);
		$pattern2 = PatternCreator::CreatePattern("sups2", $tree);
		
		$pm1->matchPattern($tree, $pattern1);
		$pm2->matchPattern($tree, $pattern2);
		
		$ra1 = $pm1->getRootArray();
		$ra2 = $pm2->getRootArray();
		
		while ($pm1->hasMatched() || $pm2->hasMatched()) {
			while ($pm1->hasMatched()) {
				$psol->solve($ra1[0],"sups", $pattern1->getPatternType());
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
			}
			while ($pm2->hasMatched()) {
				$psol->solve($ra2[0],"sups", $pattern2->getPatternType());
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
			}
		}
	}
	
	/**
	 * Normaliza automaticamente os casos de ~0 e ~1.
	 *
	 * @param Node $tree
	 */
	public function autoNormalizeSupsAndInfs(Node $tree) {
		$psol = new PatternSolutions();
		
		$pm1 = new PatternMatcher();
		$pm2 = new PatternMatcher();
		
		$pattern1 = PatternCreator::CreatePattern("normalizeSupsAndInfs1", $tree);
		$pattern2 = PatternCreator::CreatePattern("normalizeSupsAndInfs2", $tree);
		
		$pm1->matchPattern($tree, $pattern1);
		$pm2->matchPattern($tree, $pattern2);
		
		$ra1 = $pm1->getRootArray();
		$ra2 = $pm2->getRootArray();
		
		while ($pm1->hasMatched() || $pm2->hasMatched()) {
			while ($pm1->hasMatched()) {
				$psol->solve($ra1[0],"normalizeSupsAndInfs", $pattern1->getPatternType());
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
			}
			while ($pm2->hasMatched()) {
				$psol->solve($ra2[0],"normalizeSupsAndInfs", $pattern2->getPatternType());
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
			}
		}
	}
	
	/**
	 * Resolve automaticamente os casos de tautologias.
	 *
	 * @param Node $tree
	 */
	public function autoSolveTautology(Node $tree) {
		//echo "Solving cases of tautology if they exist...<br />";
		$psol = new PatternSolutions();
		
		$pm1 = new PatternMatcher();
		$pm2 = new PatternMatcher();
		
		$pattern1 = PatternCreator::CreatePattern("tautology1", $tree);
		$pattern2 = PatternCreator::CreatePattern("tautology2", $tree);
		
		$pm1->matchPattern($tree, $pattern1);
		$pm2->matchPattern($tree, $pattern2);
		
		$ra1 = $pm1->getRootArray();
		$ra2 = $pm2->getRootArray();
		
		while ($pm1->hasMatched() || $pm2->hasMatched()) {
			while ($pm1->hasMatched()) {
				$psol->solve($ra1[0],"tautology", $pattern1->getPatternType());
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
			}
			while ($pm2->hasMatched()) {
				$psol->solve($ra2[0],"tautology", $pattern2->getPatternType());
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
			}
		}
	}
	
	/**
	 * Resolve automaticamente os casos de antilogias.
	 *
	 * @param Node $tree
	 */
	public function autoSolveAntilogy(Node $tree) {
		//echo "Solving cases of antilogy if they exist...<br />";
		$psol = new PatternSolutions();
		
		$pm1 = new PatternMatcher();
		$pm2 = new PatternMatcher();
		
		$pattern1 = PatternCreator::CreatePattern("antilogy1", $tree);
		$pattern2 = PatternCreator::CreatePattern("antilogy2", $tree);
		
		$pm1->matchPattern($tree, $pattern1);
		$pm2->matchPattern($tree, $pattern2);
		
		$ra1 = $pm1->getRootArray();
		$ra2 = $pm2->getRootArray();
		while ($pm1->hasMatched() || $pm2->hasMatched()) {
			while ($pm1->hasMatched()) {
				$psol->solve($ra1[0],"antilogy", $pattern1->getPatternType());
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
				
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
			}
			while ($pm2->hasMatched()) {
				$psol->solve($ra2[0],"antilogy", $pattern2->getPatternType());
				$pm2->setRootArray(array());
				$pm2->matchPattern($tree, $pattern2);
				$ra2 = $pm2->getRootArray();
				
				$pm1->setRootArray(array());
				$pm1->matchPattern($tree, $pattern1);
				$ra1 = $pm1->getRootArray();
			}
		}
	}
}

?>