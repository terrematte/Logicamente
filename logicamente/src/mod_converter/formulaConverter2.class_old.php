<?php

require_once("Atom.class.php");
require_once("Node.class.php");
require_once("Connective.class.php");
require_once("Term.class.php");
require_once("Function.class.php");
require_once("Variable.class.php");
require_once("Relation.class.php");
require_once("Constant.class.php");


class formulaConverter {
	/* Vetor onde s�o guardados os conectivos */
	private $connectivesArray;
	/* String dos quantificadores */
	private $quantifiers;
	/* Vetor onde s�o guardados os conectivos que n�o possuem associatividade*/
	private $noAssociativity;	
	/* String para top e bottom*/
	private $especialRelations;
	
	/**
	 * Construtor.
	 *
	 * @param String $type Letra inicial pindicando o formato da express�o.
	 * @return formulaConverter
	 */
	public function formulaConverter($type,$array) {
		if ($type == "T" | $type == "t") $this->TXTformulaConverter($array);
		elseif ($type == "P" | $type == "p") $this->polformulaConverter();
		elseif ($type == "F" | $type == "f") $this->funcformulaConverter();
	}

	/* M�dulo formulaConverter em formato TXT e
	Tamb�m deve ser usado paraos m�dulos ambiguityParser e parenthesesSaver. */
	public function TXTformulaConverter($ar) {
	if ($ar == "") {
		$this -> connectivesArray = Array();
		array_push ($this -> connectivesArray,new Connective("-->",2,250));
		array_push ($this -> connectivesArray,new Connective("<->",2,250));
		array_push ($this -> connectivesArray,new Connective("&",2,350));
		array_push ($this -> connectivesArray,new Connective("|",2,300));
		array_push ($this -> connectivesArray,new Connective("+",2,250));
		array_push ($this -> connectivesArray,new Connective("~",1,400));
		$this->quantifiers = "^((A|E|E!)";
		$this->noAssociativity["-->"] = false;
		$this->noAssociativity["+"] = false;
		$this->especialRelations = "^(1|0)";
		} else {
			$this -> connectivesArray = $ar;
			$this->quantifiers = "^((A|E|E!)";
			$this->noAssociativity["-->"] = false;
			$this->noAssociativity["+"] = false;
			$this->especialRelations = "^(1|0)";
		}
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
		$this->quantifiers = "^(([[][P|S|S1][]])";
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
		$this->quantifiers = "^((forall|exists|onlyOne)";
		$this->noAssociativity["imp"] = false;
		$this->noAssociativity["xor"] = false;
		$this->especialRelations = "^(top|bottom)";
	}
	
	/**
	 * M�todo para adicionar quantificadores, um por vez.
	 *
	 * @param String $string Quantificador no formato string.
	 */
	public function addQuantifier ($string) {
		$newQuantifiers = $this->quantifiers;
		/*Teste para saber se est� trabalhando com express�es funcionais ou n�o */
		if ($this->quantifiers[3] == "[") {
			$end = "][]])";
			$newQuantifiers = substr($quantifiers,0,strlen($quantifiers) - 6);
			$newQuantifiers .= "|" . $string . $end;
		} else {
			$newQuantifiers = substr($quantifiers,0,strlen($quantifiers) - 2);
			$newQuantifiers .= "|" . $string . ")";
		}
		$this->quantifiers = $newQuantifiers;
	}

	/**
	 * M�todo para adicionar conectivos, um por vez.
	 *
	 * @param String $connective O conectivo no formato em string.
	 * @param int $arity A aridade do conevctivo
	 * @param int $order A preced�ncia do conectivo
	 * @param boolean $associativity Indica se o conectivo possui associatividade.
	 * @param boolean $associativityLeft Indica se a associatividade e a esquerda.
	 */
	public function addConnectives ($connective,$arity,$order,$associativity,$associativityLeft ) {
		$this -> connectivesArray[$connective] = new Connective ($connective,$arity,$order);
		/*Testa se caso n�o for associativo insere no vetor de n�o associativos com a sua respectiva associatividade*/
		if (!$associativity) $this->noAssociativity[$connective] = $associativityLeft;
	}

	/**
	 * M�todo para pegar o operador e seus operandos.
	 * Recebe uma express�o prefixa parentetizada.
	 *
	 * @param String $expression
	 * @return array com duas posi��es:
	 * ['connective'] Guarda o operador, geralmente um conectivo.
	 * ['children'] Guarda os operandos.
	 */
	private static function connectiveChildren ($expression) {
		/*Testa se n�o h� '(' na express�o*/
		if (stristr($expression,'(') == false) return Array('connective' => $expression , 'children' =>  Array());
		$index = 0;
		/* La�o para ler a string at� um '(' ou at� o fim dela. */
		while($index < strlen($expression) - 1 && $expression[$index] != '(' ) {
			$index++;
		}
		$connective = substr($expression,0,$index);
		$rest = substr($expression,$index+ 1, strlen($expression) - $index - 2);
		$param = Array();
		$rest .= ',';
		$index = 0;
		$index2 = 0;
		$count = 0;
		/* La�o para pegar os argumentos do conectivo e colocar em um array*/
		while($index != strlen($rest)) {
			/*Testa se o caractere � um '(' e incrementa o contador se sim*/
			if($rest[$index] == '(') $count++;
			/*Testa se o caractere � um ')' e decrementa o contador se sim*/
			if($rest[$index] == ')') $count--;
			/*Testa se o contador � igual a 0*/
			if ($count == 0){
				/*Testa se encontrou uma virgula e adiciona no array a string at� ela caso encontre*/
				if($rest[$index] == ',') {
					array_push($param, substr($rest,$index2, $index - $index2));
					$index2 = $index + 1;
				}
			}
			$index++;
		}
		$array = Array('connective' => $connective , 'children' =>  $param);
		return $array;
	}


	/**
	 * M�todo para montar a �rvore.
	 * Para quantificadores, conectivos e rela��es.
	 *
	 * @param String $expression Express�o em formato prefixo parentetizada.
	 * @param array(array) $arrayLinked Vetor de vari�veis ligada (inicialmente vazio).
	 * @param array $arrayUnlinked Vetor de vari�veis desligada (cont�m todas as vari�veis da f�rmula).
	 * @param int $count Contador de quantificadores na f�rmula.
	 * @param int $count1 Contador de quantificadores em uma sub-�rvore.
	 * @param array(array) $arrayQuantifier Quantificadores relacionados da �rvore.
	 * @return node o n� raiz da �rvore pronta.
	 */
	private function  makeTree ($expression, $arrayLinked, $arrayUnlinked, $count, $count1, $arrayQuantifier){
		$array = $this->connectiveChildren($expression);
		$op = $array['connective'];
		/*Testa se op � um quantificador*/
		if ($this->isQuantifier($op)) {
			$node = new Node(new Connective($op,1,0));
			$index = 0;
			/*Testa se est� usando quantificador funcional ou n�o*/
			if ($this->quantifiers[3] == "f") {
				$index = 2;
				/*La�o que busca o inicio de uma variavel*/
				while (!$this->isVariable(substr($op,$index))) {
					$index++;
				}
			} else 
			/*La�o que busca o inicio de uma variavel*/	
				while (!$this->isVariable(substr($op,$index))) {
					$index++;
				}
			$var = substr($op,$index);
			$count1++;
			array_push($arrayQuantifier[$count],$count1);
			$arrayLinked[$count1] = Array($var => new Variable($var));
			$child = $array['children'][0];
			array_push($node->children, $this->makeTree($child,$arrayLinked, $arrayUnlinked, $count, $count1,$arrayQuantifier));
			$count++;
			return $node;
		/*Testa se op � um conectivo*/	
		} elseif ($this->isConnective($op)) {
			$arity = 0;
			$order = $this->connectiveOrder($op);
			$connective = new Connective($op,0,$order);
			$node = new Node($connective);
			/*La�o que cjama a recurs�o para cada argumento*/
			foreach ($array['children'] as $child) {
				$arity++;
				$nodes = $this->makeTree($child,$arrayLinked, $arrayUnlinked, $count, $count1,$arrayQuantifier);
				array_push($node->children, $nodes);
			}
			$connective->arity = $arity;
			$node->content = $connective;
			return $node;
		/*Testa se op � uma rela��o*/	
		} elseif($this->isRelation($op)) {
			$relation = new Relation($op);
			$node = new Node($relation);
			$arity = 0;
			/*Testa se n�o � uma rela��o zero-�ria*/
			if ($array['children'][0] != "") {
				/*La�o que chama a fun��o de tratamento de termos para cada argumento*/
				foreach ($array['children'] as $child){
					$arity++;
					$nodes = $this->makeTree2($child,$arrayLinked, $arrayUnlinked, $count, $count1,$arrayQuantifier);
					array_push($node->children, $nodes);
				}
			}
			$relation->arity = $arity;
			$this->arrays[0] = $arrayLinked;
			$this->arrays[1] = $arrayQuantifier;
			$node->content = $relation;
			return $node;
		}
	}
	
	/**
	 * M�todo para juntar o quantificador a sua variavel no formato funcional.
	 *
	 * @param String $exp Express�o a ser ajustada.
	 * @return String Express�o devidamente ajustada.
	 */
	public function functionalToPrefix ($expression) {
		$array = Array();
		$array = $this -> connectiveChildren($expression);
		$connective = $array['connective'];
		/*Testa se n�o � um conectivo nem um quantificador funcional*/
		if (!$this -> isQuantifierFunctional($connective) && !$this -> isConnective($connective)) return $expression;
		$expressionFinal = "";
		/*Testa se � um quantificador funcional*/
		if ($this -> isQuantifierFunctional($connective)) {
			$expressionFinal = $connective . $array['children'][0];
			$expression = $connective . $array['children'][0] . "(" . $array['children'][1] . ")";
		} else $expressionFinal = $connective;
		$array = Array();
		$array = $this -> connectiveChildren($expression);
		$tmp = "";
		/* La�o para tratar recursivamente todos os argumentos do conectivo*/
		foreach ($array['children'] as $term){
			/*Testa se a string tmp n�o � vazia*/
			if ($tmp != "") $tmp .= ",";
			$tmp = $tmp . ($this -> functionalToPrefix($term));
		}
		return $expressionFinal . "(" . $tmp . ")";
	}

	/**
	 * M�todo para montar a �rvore.
	 * Para fun��es, constantes, vari�veis.
	 *
	 * @param String $expression Express�o em formato prefixo parentetizada.
	 * @param array(array) $arrayLinked Vetor de vari�veis ligada (inicialmente vazio).
	 * @param array $arrayUnlinked Vetor de vari�veis desligada (cont�m todas as vari�veis da f�rmula).
	 * @param int $count Contador de quantificadores na f�rmula.
	 * @param int $count1 Contador de quantificadores em uma sub-�rvore.
	 * @param array(array) $arrayQuantifier Quantificadores relacionados da �rvore.
	 * @return node o n� raiz da �rvore pronta.
	 */
	private function  makeTree2 ($expression, $arrayLinked, $arrayUnlinked, $count, $count1, $arrayQuantifier){
		$array = $this->connectiveChildren($expression);
		$op = $array['connective'];
		/*Testa se h� argumentos e � uma fun��o*/
		if (sizeof($array['children']) != 0 && $this->isFunction($op)) {
			$function = new Func($op);
			$node = new Node($function);
			$arity = 0;
			/* La�o para tratar recursivamente todos os argumentos do conectivo*/
			foreach ($array['children'] as $child){
				$arity++;		
				$nodes = $this->makeTree2($child,$arrayLinked, $arrayUnlinked, $count, $count1,$arrayQuantifier);
				array_push($node->children, $nodes);
			}
			$function->arity = $arity;
			$node->content = $function;
			return $node;
		/*Testa se � uma vari�vel*/	
		} elseif ($this->isVariable($op)){
			$f = true;
			/* La�o para tratar se uma vari�vel � ligada ou n�o*/
			foreach ($arrayQuantifier[$count] as $q) {
				/*Testa se � uma vari�vel ligada*/
				if (isset($arrayLinked[$q][$op])) {
					$var = $arrayLinked[$q][$op];
					$f = false;
				}
			}
			/*Testa se � uma vari�vel desligada*/
			if($f) $var = $arrayUnlinked[$op];
			$node = new Node($var);
			return $node;
		/*Testa se � uma constante*/	
		} elseif ($this-> isConstant($op)) {
			$var = $arrayUnlinked[$op];
			//array_push($tmp->children,$var);
			$node = new Node($var);
			return $node;
		} else {
			echo "Erro: '$op' n�o � um tipo conhecido! <br/>";
		}
	}
	
	/**
	 * M�todo para verificar se um express�o inicia com uma vari�vel.
	 *
	 * @param String $term Express�o a ser testada.
	 * @return boolean
	 */
	private function isVariable($term){
		return (ereg("^(([u-z]|[U-Z])([a-z]|[A-Z])*[0-9]*)",$term));
	}
	
	/**
	 * M�todo para verificar se um express�o inicia com uma constante.
	 *
	 * @param String $term Express�o a ser testada.
	 * @return boolean
	 */
	private function isConstant($term){
		return (ereg("^((([a-n]|[A-N])([a-z]|[A-Z])*[0-9]*)|([0-9]+))",$term));

	}
	
	/**
	 * M�todo para verificar se um express�o inicia com uma fun��o.
	 *
	 * @param String $term Express�o a ser testada.
	 * @return boolean
	 */
    private function isFunction($term){
		return (ereg("^(([a-h]|[A-H])([a-z]|[A-Z])*[0-9]*)",$term));
	}
	
	/**
	 * M�todo para verificar se um express�o inicia com uma rela��o.
	 *
	 * @param String $term Express�o a ser testada.
	 * @return boolean
	 */
	private function isRelation($term){
		return (ereg("^(([a-z]|[A-Z])+[0-9]*)|".$this->especialRelations,$term));
	}

	/**
	 * M�todo para verificar se um express�o inicia com um quantificador.
	 *
	 * @param String $term Express�o a ser testada.
	 * @return boolean
	 */
	private function isQuantifier($term) {
		$quantifiers = $this->quantifiers;
		return (ereg(($quantifiers."([u-z]|[U-Z])([a-z]|[A-Z])*[0-9]*)"),$term));
	}
	
	
	/**
	 * M�todo para verificar se um express�o inicia com um quantificador.
	 * usado para o formato funcional.
	 *
	 * @param String $term Express�o a ser testada.
	 * @return boolean
	 */
	private function isQuantifierFunctional($term) {
		$quantifiers = $this->quantifiers;
		return (ereg($quantifiers.")",$term));
	}

	/**
	 * M�todo para verificar se um express�o come�a com um conectivo.
	 *
	 * @param String $term Express�o a ser testada.
	 * @return boolean
	 */
    private function isConnective($term){
		$flag = false;
		$indexEnd = 0;
		/*La�o para verificar se no inicio da string tem um conectivo*/
		while ($indexEnd < strlen($term)) {
			$indexEnd++;
			/*La�o que percorre o array de conectivos*/
			foreach ($this->connectivesArray as $t) {
				/*Testa se o conectivo foi encontrado*/
				if ($t->content == substr($term,0,$indexEnd)) $flag = true;
			}
		}
		return $flag;
	}
   
	/**
	 * M�todo para retornar a preced�ncia de um conectivo.
	 *
	 * @param String $term Um conectivo.
	 * @return int Ordem de preced�ncia do conectivo.
	 */
	private function connectiveOrder($term){
		$order = 0;
		$tmp = $this -> connectivesArray;
		/*La�o para procuarar a precedencia de um conectivo*/
		while($t = array_pop($tmp)){
			/*Testa se t � nulo*/
			if($t == null) break;
			/*Testa se encontrou o conectivo*/
			if ($t->content == $term) $order = $t->order;
		}
		return $order;
	}

	/**
	 * M�todo para retornar a aridade de um conectivo
	 *
	 * @param String $term Um conectivo.
	 * @return int Aridade do conectivo.
	 */
	private function connectiveArity($term){
		$arity = 0;
		$connectivesArray = $this -> connectivesArray;
		/*Testa se a express�o come�a com um quantificador*/
		if ($this->isQuantifier($term)) return ($arity + 1);
		/*La�o procurar a aridade de um conectivo*/
		while($t = array_pop($connectivesArray)){
			/*Testa se t � nulo*/
			if($t == null) break;
			/*Testa se encontrou o conectivo*/
			if ($t->content == $term) $arity = $t->arity;
		}
		return $arity;
	}

	/**
	 * M�todo para montar o vetor de vari�veis desligadas.
	 *
	 * @param String $expression Express�o prefixa parentetizada.
	 * @return array O vetor de vari�veis desligadas.
	 */
	private function makeArrayUnlinked($expression) {
		$tmp = ($this->connectiveChildren($expression));
		$array = $tmp['children'];
		$arrayFinal = Array();
		/*La�o para pegar todas as vari�veis e constantes existentes na express�o
		 e coloc�-las em um array*/
		while ($tmp = array_pop($array)) {
			/*Testa se tmp � nulo*/
			if ($tmp == null) break;
			$tmp2 = $this->connectiveChildren($tmp);
			/*Testa se n�o h� argumentos*/
			if (sizeof($tmp2['children']) == 0) {
				/*Testa se � uma vari�vel*/
				if ($this->isVariable($tmp)){
					$t = new Variable($tmp);
					$t->value = 1;
					$arrayFinal[$tmp] = $t;
				/*Testa se � uma constante*/
				} elseif ($this->isConstant($tmp) && !$this->isQuantifier($tmp)) {
					$arrayFinal[$tmp] = new Constant($tmp);
				} 
			} else {
				$tmp = $this-> connectiveChildren($tmp);
				$tmp = $tmp['children'];
				/*Testa se o primeiro argumento de tmp n�o � nulo*/
				if ($tmp[0] != null) {
					/*La�o que coloca todos argumentos no array*/
					foreach ($tmp as $t){
						array_push($array,$t);
					}
				} else $tmp = 1;
			}
		}
	return $arrayFinal;
	}
	
	/**
	 * M�todo para retornar se um conectivo possui ou n�o associatividade.
	 *
	 * @param String $connective
	 * @return boolean
	 */
	private function haveAssociativity ($connective) {
		/*Testa s eo conectivo est� no vetor de conectivos n�o associativos*/
		if (isset($this->noAssociativity[$connective])) return false;
		else return true;
	}

	/**
	 * M�todo para testar se o primeiro conectivo tem preced�ncia maior que o segundo.
	 *
	 * @param String $exp1 Conectivo 1 a ser analizado.
	 * @param String $exp2 Conectivo 2 a ser analizado.
	 * @return boolean
	 */
	private function priorityOrder($exp1,$exp2){
		/*Testa se exp2 � um quantificador ou exp1 um '(' ou exp1 nulo*/
		if ($this->isQuantifier($exp2)|| $exp1 == '(' || $exp1 == null) return false;
		/*Testa se exp1 � um quantificador*/
		elseif ($this->isQuantifier($exp1)) return true;
		else return ($this->connectiveOrder($exp1) >= $this->connectiveOrder($exp2));
	}

	/**
	 * M�todo para montar a �rvore de uma express�o Infixa (TXT).
	 *
	 * @param String $expression Express�o em formato TXT.
	 * @return node O n� raiz da a �rvore montada.
	 */
	public function infixToTree($expression,$type) {
		/*Testa se existe a mesma quantidade de '(' e ')'*/
		if ($this->testParentheses($expression)) {
			$arrayExpression = array();
			if ($type) {
				$arrayExpression = $this->firstToArray($expression,$arrayExpression);
			} else {
				$arrayExpression = $this->propToArray($expression,$arrayExpression);
			}
			$expression = $this->toPrefix($arrayExpression, false);
			$arrayExpression = Array();
			if ($type) {
				$arrayExpression = $this->firstToArray($expression,$arrayExpression);
			} else {
				$arrayExpression = $this->propToArray($expression,$arrayExpression);
			}
			$arrayExpression = $this->putParentheses($arrayExpression);
			$expression = $arrayExpression[0];
			if ($type) {
				$arrayLinked = Array(Array());
				$arrayUnlinked = $this->makeArrayUnlinked($expression);
				$arrayQuantifier = Array(array());
				return $this->makeTree($expression,$arrayLinked,$arrayUnlinked,0,0,$arrayQuantifier);
			} else {
				return $this->propMakeTree($expression);
			}
		} else return "";
	}

	/**
	 * M�todo para montar a �rvore de uma expres�o Prefixa (Polonesa).
	 *
	 * @param String $expression Express�o em formato polon�s.
	 * @return node O n� raiz da a �rvore montada.
	 */
	public function prefixToTree($expression,$type) {
		/*Testa se existe a mesma quantidade de '(' e ')'*/
		if ($this->testParentheses($expression)) {
			$arrayExpression = array();
			$arrayExpression = $this->prefixToArray($expression,$arrayExpression);
			$expression = $this->toPrefix($arrayExpression, true);
			$arrayExpression = Array();
			$arrayExpression = $this->prefixToArray($expression,$arrayExpression);
			$arrayExpression = $this->putParentheses($arrayExpression);
			$expression = $arrayExpression[0];
			if ($type) {
				$arrayLinked = Array(Array());
				$arrayUnlinked = $this->makeArrayUnlinked($expression);
				$arrayQuantifier = Array(array());
				return $this->makeTree($expression,$arrayLinked,$arrayUnlinked,0,0,$arrayQuantifier);
			} else {
				return $this->propMakeTree($expression);
			}
			
		} else return "";
	}
	
	/**
	 * M�todo para montar a �rvore de uma express�o funcional.
	 *
	 * @param String $expression Express�o em formato funcional
	 * @return node O n� raiz da a �rvore montada.
	 */
	public function functionalToTree($expression,$type) {
		/*Testa se existe a mesma quantidade de '(' e ')'*/
		if ($this->testParentheses($expression)) {
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
			if ($type) {
				$expression = $this -> functionalToPrefix($expression);
				$arrayLinked = Array(Array());
				$arrayUnlinked = $this->makeArrayUnlinked($expression);
				$arrayQuantifier = Array(array());
				return $this->makeTree($expression,$arrayLinked,$arrayUnlinked,0,0,$arrayQuantifier); 
			} else {
				return $this->propMakeTree($expression);
			}
		} else return "";
	}

	/**
	 * M�todo para que transforma um vetor em uma express�o prefixa.
	 * 
	 * @param array $arrayExpression Vetor da express�o original.
	 * @param boolean $type Indica que tipo de express�o est� recebendo.
	 * 	true para express�o prefixa n�o virgulada e false para express�o infixa
	 * @return String Express�o prefixa virgulada
	 */
	private function toPrefix($arrayExpression, $type) {
		$index = 0;
		$tmp = "";
		$top = "";
		$final = "";
		$pilha = array();
		/*La�o para tratar cada termo do array*/
		while ($index < sizeof($arrayExpression)){
			$tmp = $arrayExpression[$index];
			/*Testa se tmp � um '('*/
			if ($tmp == '(') {
				array_push($pilha,$tmp);
			/*Testa se tmp � um ')'*/
			} elseif($tmp == ')') {
				/*La�o para tratamento de parenteses, desempilha tudo da pilha at� um '('*/
				while ($top = array_pop($pilha)){
					/*Testa se top � um '('*/
					if ($top == '(') break;
					/*Testa se top � um quantificador*/
					if ($this->isQuantifier($top)) $final = " " . $final;
					$final = $top . $final;
				}
			/*Testa se tmp n�o � conectivo nem quantificador*/	
			} elseif (!$this->isConnective($tmp) && !$this->isQuantifier($tmp)) {
				/*Testa se type � true, a express�o � prefixa*/
				if ($type) {
					/*Testa se final � vazia, se o topo da pilha � uma nega��o ou final come�a com ')'*/
					if ($final == "" || $final[0] == ')') $final .= $tmp;
					else $final .= ',' .  $tmp;
				} else {
					/*Testa se final � vazia, se o topo da pilha � uma nega��o ou final come�a com ')'*/
					if ($final == "" || $final[0] == ')') $final = $tmp.$final;
					else $final = $tmp .',' . $final;
				}
			} else {
				$top = array_pop($pilha);
				/*La�o para encontrar na pilha um conectivo de precedencia menor que tmp*/
				while ($this->priorityOrder($top,$tmp)) {
					/*Testa se top � nulo*/
					if ($top == null) break;
					/*Testa se tmp n�o possui associatividade, n�o � a esquerda e � igual a top*/
					if (!$this->haveAssociativity($tmp) && !$this->noAssociativity[$tmp] && $top == $tmp) {
						array_push($pilha,$top);
						break;
					}
					/*Testa se tmp � diferente da nega��o e n�o � vazia*/
					if ($tmp != '~' && $final != "") {
						/*Testa se top � um quantificador ou type � true, a express�o � prefixa*/
						if ($this->isQuantifier($top) || $type) $final = " " . $final;
						$final = $top . $final;
						$top = array_pop($pilha);
					} else {
						$final = $final;
						array_push($pilha,$top);
						$top = null;
					}
				}
				/*Testa se a precedencia de tmp � maior que a de top e top n�o � nulo */
				if (!$this->priorityOrder($top,$tmp) && $top != null ) array_push($pilha,$top);
				array_push($pilha,$tmp);
			}
		$index++;
		}
		/*La�o para desempilhar todos os conectivos ainda existentes na pilha*/
		while (true) {
			$top = array_pop($pilha);
			/*Testa se top e nulo*/
			if ($top == null) break;
			/*Testa se top � diferente de '('*/
			if ($top != '(') {
				/*Testa se top � um quantificador ou type � true, a express�o � prefixa*/
				if ($this->isQuantifier($top) || $type) $final = " " . $final; 
				$final = $top . $final;
			}
		}
		return $final;
	}
	
	/**
	 * M�todo que monta um vetor para uma express�o de 1� ordem.
	 * Cada campo do vetor ser� um quantificador, um conectivo, uma rela��o ou um par�ntese.
	 *
	 * @param String $expression Express�o de 1� ordem.
	 * @param array $arrayExpression Vetor da express�o.
	 * @return array Vetor da express�o.
	 */
	private function firstToArray($expression,$arrayExpression) {
		$indexEnd = 0;
		$countParentheses = 0;
		/*Testa se a express�o n�o � vazia*/
		if ($expression != "") {
			$expression = $this->removeSpaces($expression);
			$indexEnd = 0;
			/*Testa se a express�o come�a com um quantificador*/
			if ($this->isQuantifier($expression)) {
				/* La�o para encontrar um " " ou um '('*/
				while($expression[$indexEnd] != " ") {
					/*Testa se o caractere � um '('*/
					if ($expression[$indexEnd] == '(') break;
					$indexEnd++;
				}
				array_push($arrayExpression, substr($expression,0,$indexEnd));
				/*Testa se o caractere � um " "*/
				if ($expression[$indexEnd] == " ") $indexEnd++;
				$expression = substr($expression,$indexEnd);
				$arrayExpression = $this->firstToArray($expression, $arrayExpression);
			/*Testa se a express�o come�a com uma rela��o*/	
			} elseif ($this->isRelation($expression)) {
				/*La�o para encontrar um '('*/
				while($expression[$indexEnd] != '(') {
					$indexEnd++;
				}
				$indexEnd++;
				$countParentheses++;
				/*La�o para pegar a string do '(' at� o seu ')' correspondente */
				while ($countParentheses != 0) {
					/*Testa se o caractere � um ')'*/
					if ($expression[$indexEnd] == ')') {
						$countParentheses--;
					/*Testa se o caractere � um '('*/	
					} elseif ($expression[$indexEnd] == '(') {
						$countParentheses++;
					}
					$indexEnd++;
				}
				array_push($arrayExpression, substr($expression,0,$indexEnd));
				$expression = substr($expression,$indexEnd);
				$arrayExpression = $this->firstToArray($expression, $arrayExpression);
			/*Testa se o caractere � um '('*/	
			} elseif ($expression[$indexEnd] == '(') {
				array_push($arrayExpression, $expression[$indexEnd]);
				$countParentheses++;
				$indexEnd++;
				/*La�o para pegar a string do '(' at� o seu ')' correspondente e aplicar a recurs�o nela*/
				while ($countParentheses != 0) {
					/*Testa se o caractere � um ')'*/
					if ($expression[$indexEnd] == ')') {
						$countParentheses--;
					/*Testa se o caractere � um '('*/	
					} elseif ($expression[$indexEnd] == '(') {
						$countParentheses++;
					}
					$indexEnd++;
				}
				$arrayExpression = $this->firstToArray(substr($expression,1,$indexEnd-2), $arrayExpression);
				array_push($arrayExpression,$expression[$indexEnd-1]);
				$expression = substr($expression,$indexEnd);
				$arrayExpression = $this->firstToArray($expression, $arrayExpression);
			/*Testa se o caractere � um ','*/	
			} elseif ($expression[0] == ',') {
				array_push($arrayExpression,$expression[0]);
				$expression = substr($expression,1);
				$arrayExpression = $this->firstToArray($expression, $arrayExpression);
				$indexEnd++;
			} else {
				/*La�o para pegar o conectivo do in�cio da string */
				while(true) {
					/*Testa se o caractere � um '(' ou se o caractere � um '~'*/
					if ($expression[$indexEnd] == '(' || $expression[$indexEnd] == '~') break;
					/*Testa se a express�o a partir daquele caractere � uma rela��o*/
					if ($this->isRelation(substr($expression,$indexEnd))) break;
					/*Testa se a express�o a partir daquele caractere � um conectivo*/
					if ($this->isConnective(substr($expression,0,$indexEnd))) break;
					$indexEnd++;
				}
				array_push($arrayExpression, substr($expression,0,$indexEnd));
				/*Testa se o caractere � um '~'*/
				if ($expression[$indexEnd] == '~') {
					array_push($arrayExpression,$expression[$indexEnd]);
					$indexEnd++;
				}
				$expression = substr($expression,$indexEnd);
				$arrayExpression = $this->firstToArray($expression, $arrayExpression);
			}
		}
		/*La�o para remover parenteses em apenas uma rela��o. Ex.: (R(x))*/
		while ($indexEnd < sizeof($arrayExpression)) {
			/*Testa se h� parenteses em volta de uma rela��o*/
			if ( $indexEnd < (sizeof($arrayExpression) - 2) && $arrayExpression[$indexEnd] == '(' && $arrayExpression[$indexEnd+2] == ')') {
				array_splice($arrayExpression,$indexEnd,1);
				array_splice($arrayExpression,$indexEnd+1,1);
			}
			$indexEnd++;
		}
		return $arrayExpression;
	}

	/**
	 * M�todo para testar se para cada um "(" exite um ")" correspondente.
	 *
	 * @param String $expression
	 * @return boolean
	 */
	private function testParentheses($expression) {
		$index = 0;
		$countParentheses = 0;
		/*La�o para testar se existe a mesma quantidade de '(' e ')'*/
		while($index < strlen($expression)) {
			/*Testa se o caractere � um ')'*/
			if ($expression[$index] == ')') {
				$countParentheses--;
			/*Testa se o caractere � um '('*/
			} elseif ($expression[$index] == '(') {
				$countParentheses++;
			}
			$index++;
		}
		return ($countParentheses == 0);
	}

	/**
	 * M�todo para reduzir ao m�ximo o n�mero de par�nteses, sem
	 * modificar o valor da express�o.
	 *
	 * @param String $expression Express�o de a ser simplificada.
	 * @param boolean $type Indica se a express�o � de 1� ordem ou proposicional.
	 * 	true para 1� ordem e false para proposicional.
	 * @return String Express�o simplificada.
	 */
	public function parenthesesSaver ($expression, $type) {
		$correctExpression = "";
		$indexIni = 0;
		$indexEnd = 0;
		$countParentheses = 0;
		$arrayParentheses = array();
		$testArray = array();
		$arrayExpression = array();
		$testExpression = "";
		/*Testa se h� a mesma quantidade de '(' e ')'*/
		if ($this->testParentheses($expression)) {
			/*Testa se type � true, a express�o � de 1� ordem*/
			if ($type) {
				$arrayExpression = $this->firstToArray($expression,$arrayExpression);
			} else {
				$arrayExpression = $this->propToArray($expression,$arrayExpression);
			}
			$correctExpression = $this->toPrefix($arrayExpression, false);
			/*Testa se type � true, a express�o � de 1� ordem*/
			if ($type) {
				$testArray = ($this->putParentheses($this->firstToArray($correctExpression, $testArray)));
			} else {
				$testArray = ($this->putParentheses($this->propToArray($correctExpression, $testArray)));
			}
			$correctExpression = $testArray[0];
			$testArray = array();
			/*La�o para percorrer o array em busca de '('*/
			while ($indexEnd < sizeof($arrayExpression)) {
				/*Testa se a string � um '('*/
				if ($arrayExpression[$indexEnd] == '(') {
					$countParentheses++;
					$indexEnd;
					$indexIni = $indexEnd;
					/*La�o para encontrar o respectivo ')' para o '(' encontrado */
					while ($countParentheses != 0) {
						$indexEnd++;
						/*Testa se a string � um ')'*/
						if ($arrayExpression[$indexEnd] == ')') {
							$countParentheses--;
						/*Testa se a string � um '('*/	
						} elseif ($arrayExpression[$indexEnd] == '(') {
							$countParentheses++;
						}
						/*Testa se o contador � diferente de 0*/
						if ($countParentheses != 0)  $testExpression = $testExpression . $arrayExpression[$indexEnd];
						/*Testa se a string � um quantificador*/
						if ($this->isQuantifier($arrayExpression[$indexEnd])) $testExpression .= " ";
					}
					$testExpression = $this->parenthesesSaver($testExpression,$type);
					/*Testa se type � true, a express�o � de 1� ordem*/
					if ($type) {
						$arrayParentheses = $this->firstToArray($testExpression,$arrayParentheses);
					} else {
						$arrayParentheses = $this->propToArray($testExpression,$arrayParentheses);
					}
					array_splice($arrayExpression, $indexIni, ($indexEnd - $indexIni + 1 ), $arrayParentheses);
					$tmp = $arrayExpression;
					$testExpression = "";
					/*La�o para transformar o array tmp em uma string*/
					while ($top = array_pop($tmp)) {
						/*Testa se top � nulo*/
						if ($top == null) break;
						/*Testa se top � um quantificador*/
						if ($this->isQuantifier($top)) $testExpression = " " . $testExpression;
						$testExpression = $top . $testExpression;
					}
					/*Testa se type � true, a express�o � de 1� ordem*/
					if ($type) {
						$testExpression = $this->toPrefix($this->firstToArray($testExpression, $testArray),false);
						$testArray = ($this->putParentheses($this->firstToArray($testExpression, $testArray)));
					} else {
						$testExpression = $this->toPrefix($this->propToArray($testExpression, $testArray),false);
						$testArray = ($this->putParentheses($this->propToArray($testExpression, $testArray)));
					}
					$testExpression = $testArray[0];
					$testArray = array();
					/*Testa se as express�es s�o iguais*/
					if ($this->expressionComparator($correctExpression,$testExpression)) {
						$correctExpression = $testExpression;
						$testExpression = "";
						$arrayParentheses = Array();
						$indexEnd = 0;
					} else {
						$indexEnd = 0;
						$testExpression = ")";
						/*La�o para transformar o array arrayParentheses em uma string*/
						while ($top = array_pop($arrayParentheses)) {
							/*Testa se top � nulo*/
							if ($top == null) break;
							/*Testa se top � um quantificador*/
							if ($this->isQuantifier($top)) $top .= " ";
							$testExpression = $top . $testExpression;
							$indexEnd++;
						}
						$testExpression = "(" . $testExpression;
						array_push($arrayParentheses, $testExpression);
						array_splice($arrayExpression, $indexIni, $indexEnd, $arrayParentheses);
						$indexEnd = 0;
						$testExpression = "";
						$arrayParentheses = Array();
					}
					$testArray = array();
				} else {
					$indexEnd++;
				}
			}
		}
		$correctExpression = "";
		/*La�o para transformar o array arrayExpression em uma string*/
		while ($top = array_pop($arrayExpression)) {
			/*Testa se top � nulo*/
			if ($top == null) break;
			/*Testa se top � um quantificador*/
			if ($this->isQuantifier($top)) $top .= " ";
			$correctExpression = $top . $correctExpression;
		}
		return $correctExpression;
	}

	/**
	 * M�todo para verificar a igualdade de duas express�es na forma prefixa parentetizada.
	 *
	 * @param String $expression1 Express�o 1 a ser comparada.
	 * @param String $expression2 Express�o 2 a ser comparada.
	 * @return boolean
	 */
	public function expressionComparator ($expression1,$expression2) {
		/*Testa se as strings s�o iguais */
		if ($expression1 == $expression2) return true;
		else {
			$result = true;
			$arrayExpression1 = $this->connectiveChildren($expression1);
			$arrayExpression2 = $this->connectiveChildren($expression2);
			/*Testa se os conectivos s�o diferentes*/
			if ($arrayExpression1['connective'] != $arrayExpression2['connective']) return false;
			else {
				$index1 = 0;
				/*La�o para unificar argumentos de conectivos iguais*/
				while ($index1 < sizeof($arrayExpression1['children'])) {
					$term1 = $arrayExpression1['children'][$index1];
					$array1 = $this->connectiveChildren($term1);
					/*Testa se os conectivos s�o iguais*/
					if ($array1['connective'] == $arrayExpression1['connective']) {
						/*Testa se o conectivo n�o possui associatividade*/
						if (!$this->haveAssociativity($arrayExpression1['connective'])) break;
						array_splice($arrayExpression1['children'],$index1,1);
						/*La�o para colocar no arrayExpression os argumentos do seu argumento de mesmo conectivo*/
						foreach ($array1['children'] as $t1) {
							array_push($arrayExpression1['children'], $t1);
						}
						$index1 = 0;
					} else $index1++;
				}
				$index2 = 0;
				/*La�o para unificar argumentos de conectivos iguais*/
				while ($index2 < (sizeof($arrayExpression2['children']))) {
					$term2 = $arrayExpression2['children'][$index2];
					$array2 = $this->connectiveChildren($term2);
					/*Testa se os conectivos s�o iguais*/
					if ($array2['connective'] == $arrayExpression2['connective']) {
						/*Testa se o conectivo n�o possui associatividade*/
						if (!$this->haveAssociativity($arrayExpression2['connective'])) break;
						array_splice($arrayExpression2['children'],$index2,1);
						/*La�o para colocar no arrayExpression os argumentos do seu argumento de mesmo conectivo*/
						foreach ($array2['children'] as $t2) {
							array_push($arrayExpression2['children'], $t2);
						}
						$index2 = 0;
					} else $index2++;
					
				}
				$index2 = 0;
				/*La�o para comparar se duas express�es s�o iguais, comparando os argumentos 
				independentemente da posi��o */
				while ($index2 < (sizeof($arrayExpression2['children']))) {
					$index1 = array_search($arrayExpression2['children'][$index2],$arrayExpression1['children']);
					/*Testa se um argumento de uma express�o ocorre nos argumentos da outra*/
					if ($index1 === false) {
					/*La�o que chama a recurs�o para cada argumento coso sejam diferentes*/	
					foreach ($arrayExpression1['children'] as $term1) {
							$result = $result && $this->expressionComparator($arrayExpression2['children'][$index2],$term1);
						}
					} else $result = $result && true;
					$index2++;
				}
			}
			return $result;
		}
	}

	/**
	 * M�todo para colocar par�nteses em um vetor de express�o prefixa virgulada.
	 *
	 * @param  $array Vetor de express�o prefixa virgulada.
	 * @return Um vetor com a express�o parentetizada.
	 */
	private function putParentheses ($array) {
		/*Testa se o array s� possui um elemento*/
		if (sizeof($array) == 1) return $array;
		$indexUlt = 0;
		$index = -1;
		$newTerm = "";
		$arity = 0;
		/*La�o para buscar o �ltimo conectivo no array*/
		while ($index < (sizeof($array) - 1)) {
			$index++;
			/*Testa se o elemento � um conectivo ou quantificador e n�o � o �ltimo elemento do array 
			e n�o possui parenteses*/
			if (($this->isConnective($array[$index]) ||	$this->isQuantifier($array[$index]))
				&& $index != (sizeof($array) - 1) && $this->noParentheses($array[$index]))
			$indexUlt = $index;
		}
		$arity = $this->connectiveArity($array[$indexUlt]);
		$index = $indexUlt;
		$newTerm .= $array[$indexUlt] . '(';
		/*La�o para colocar a quantidade argumentos, de acordo com a aridade do conectivo,
		na string newTerm*/
		while ($arity > 0) {
			$index++;
			/*Testa se � o �ltimo elemento do array ou se o pr�ximo elemento � uma virgula*/
			if ($index == (sizeof($array) - 1 ) || $array[$index+1] == ',') $arity--;
			$newTerm .= $array[$index];
		}
		$newTerm .= ')';
		$arrayParentheses = array ();
		array_push($arrayParentheses,$newTerm);
		/*Testa se o �ndice do �ltimo conectivo � 0*/
		if ($indexUlt == 0) $array = $arrayParentheses;
		else array_splice($array,$indexUlt,($index+1-$indexUlt),$arrayParentheses);
		$array = $this->putParentheses($array);
		return $array;
	}

	/**
	 * M�todo para verificar se a express�o n�o cont�m par�nteses.
	 *
	 * @param String $string Express�o a ser testada.
	 * @return boolean
	 */
	private function noParentheses ($string) {
		$flag = true;
		$index = 0;
		/*La�o para verificar se h� parenteses na express�o*/
		while ($flag) {
			/*Testa se � o �ndice j� ultrapassou a string*/
			if ($index == strlen($string)) break;
			/*Testa se o caractere e um '('*/
			if ($string[$index] == '(') $flag = false;
			$index++;
		}
		return $flag;
	}

	/**
	 * M�todo para transformar uma express��o prefixa parentetizada em uma express�o infixa. 
	 *
	 * @param String $expressionPrefix Express�o prefixa parentetizada.
	 * @return String Express�o infixa.
	 */
	private function toInfix($expressionPrefix) {
		/*Testa se a express�o come�a com um quantificador ou n�o � come�a com uma rela��o e o primeiro caractere diferente de '(' */
		if ($this->isQuantifier($expressionPrefix) || (!$this->isRelation($expressionPrefix) && $expressionPrefix[0] != "(")) {
			$term = "";
			$arrayExpresion = $this->connectiveChildren($expressionPrefix);
			$index = sizeof($arrayExpresion['children']) - 1;
			$connective = $arrayExpresion['connective'];
			$expressionInfix = $arrayExpresion['children'][$index];
			/*Testa se a express�o come�a com um quantificador*/
			if ($this->isQuantifier($expressionInfix)) 
				$expressionInfix = ($this->toInfix($expressionInfix));
			/*Testa se a express�o nao come�a com uma rela��o*/
			elseif (!$this->isRelation($expressionInfix))
				$expressionInfix = "(" . ($this->toInfix($expressionInfix));
			/*Testa se o conectivo tem aridade 1*/	
			if (sizeof($arrayExpresion['children']) == 1)
				$expressionInfix = "(" . $connective . $expressionInfix;
			/*La�o para chamar recurs�o para cada argumento e acrescent�-lo na string*/
			while ($index > 0) {
				$index--;
				$term = $arrayExpresion['children'][$index];
				/*Testa se term n�o come�a com uma rela��o*/
				if (!$this->isRelation($term))
					$term = "(" . $this->toInfix($term) . ")";
				/*Testa se � um conectivo e a aridade � diferente de 1*/	
				if ($this->isConnective($connective) && sizeof($arrayExpresion['children']) != 1)
					$expressionInfix .= $connective;
				 $expressionInfix .= $term;
			}
			/*La�o para enquanto houver '(' sem um ')' coloque um ')'*/
			while (!$this->testParentheses($expressionInfix)) {
				$expressionInfix .= ")";
			}
			return $this->toInfix($expressionInfix);
		} else return $expressionPrefix;
	}

	/**
	 * M�todo para retornar todas as formas poss�veis de parentetiza��o,
	 * destacando a correta.
	 *
	 * @param String $incorrectExpression Express�o a ser avaliada.
	 * @param boolean $type Indica se a express�o � de 1� ordem ou proposicional.
	 * 	true para 1� ordem e false para proposicional.
	 * @return array Vetor contendo todas as formas poss�veis de parentetiza��o.
	 * 	['correct'] Cont�m a express�o correta.
	 */
	public function ambiguityParser ($incorrectExpression, $type) {
		$arrayExpression = array();
		/*Testa se type � true, uma express�o de 1�ordem*/
		if ($type) {
			$arrayExpression = $this->firstToArray($incorrectExpression,$arrayExpression);
		} else {
			$arrayExpression = $this->propToArray($incorrectExpression,$arrayExpression);
		}
		$expression = $this->toPrefix($arrayExpression,false);
		$arrayGeneral = $this ->removeParentheses($arrayExpression);
		$arrayExpression = array();
		/*Testa se type � true, uma express�o de 1�ordem*/
		if ($type) {
			$arrayExpression = $this->firstToArray($expression,$arrayExpression);
		} else {
			$arrayExpression = $this->propToArray($expression,$arrayExpression);
		}
		$expression = $this->putParentheses($arrayExpression);
		$expression = $expression[0];
		$arrayExpression = array();
		$arrayExpression['correct'] = $this->toInfix($expression);
		$arrayExpression = $this->arrayParentheses($arrayGeneral,$arrayExpression);
		return $arrayExpression;
	}
	
	/**
	 * M�todo para transformar um vetor em uma string
	 *
	 * @param array $array Vetor contendo uma express�o
	 * @return String Express�o correspondente.
	 */
	private function toString ($array) {
		$string = "";
		/*La�o par transformar um array em uma string*/
		foreach ($array as $term) {
			$string .= $term;
		}
		return $string;
	}
	
	/**
	 * M�todo para retornar o n�mero de operandos e operadores unit�rios. 
	 *
	 * @param array $array Vetor contendo a express�o
	 * @return int n�mero de operandos e operadores unit�rios.
	 */
	private function numberTerms ($array) {
		$number = 0;
		$index = 0;
		/*La�o para contar quantos termos h� no vetor, seja um termo uma rela��o ou conectivo un�rio*/
		while ($index < sizeof($array)) {
			/*Testa se n�o � um conectivo ou � um conectivo de aridade 1*/
			if ((!$this->isConnective($array[$index]) || $this->connectiveArity($array[$index]) == 1)
				&& $array[$index][0] != "(")
				$number++;
			$index++;
		}
		return $number;
	}
	
	/**
	 * M�todo para remover par�nteses de um vetor contendo uma express�o.
	 *
	 * @param array $arrayExpression Vetor contendo uma express�o.
	 * @return array Vetor contendo a express�o sem par�nteses.
	 */
	private function removeParentheses ($arrayExpression) {
		$index = 0;
		/*La�o para remover todos os parenteses existentes no array*/
		while ($index < sizeof($arrayExpression)) {
			/*Testa se � um parentese*/
			if ($arrayExpression[$index] == "(" || $arrayExpression[$index] == ")")
				array_splice($arrayExpression,$index,1);
			$index++;
		}
		return $arrayExpression;
	}
	
	/**
	 * M�todo para retornar todas as formas poss�veis de parentetiza��o.
	 *
	 * @param array $incorrectExpression Vetor contendo todas as express�o sem par�nteses.
	 * @param array $arrayTotal Vetor contendo todas as express�es poss�veis.
	 * @return array Vetor contendo todas as express�es poss�veis.
	 */
	private function arrayParentheses ($incorrectExpression,$arrayTotal) {
		$indexIni = 0;
		$indexEnd = 0;
		$expression = $this->toString($incorrectExpression);
		/* As linhas abaixo podem ser descomentadas para visualizar as espress�es
		durante a execu��o do programa */
		/*$number = sizeof($arrayTotal) - 1;
		if (!isset($arrayTotal[$expression]))
			echo ("[$number] => ".$expression."<br/>");*/
		$arrayTotal[$expression] = $expression;
		/*Testa se o array s� possui 1 elemento*/
		if (sizeof($incorrectExpression) == 1) return $arrayTotal;
		$arrayAux = array();
		$arrayExpression = $incorrectExpression;
		$numberTerms = $this->numberTerms($incorrectExpression);
		/*La�o que continua enquanto houver termos*/
		while ($numberTerms > 0) {
			/*La�o que percorre todos os elementos do array*/
			while($indexEnd < sizeof($arrayExpression)) {
				$string = "(" . $arrayExpression[$indexIni];
				$term = $arrayExpression[$indexEnd];
				$index = $indexIni+1;
				/*La�o que coloca todos elementos do array at� �ndice indicado*/
				while ($index <= $indexEnd) {
					$term = $arrayExpression[$index];
					$string .= $term;
					$index++;
				}
				$term = $arrayExpression[$indexEnd];
				/*La�o que coloca todos elementos do array do �ndice indicado at� o final*/
				while ($indexEnd < (sizeof($arrayExpression) - 1)) {
					/*Testa se term � uma rela��o e n�o um quantificador*/
					if ($this->isRelation($term) && !$this->isQuantifier($term)) break;
					$indexEnd++;
					$term = $arrayExpression[$indexEnd];
					$string .= $term;
					/*Testa se o primeiro caractere do term � um '(' e term � diferente da rela��o inicial*/
					if ($term[0] == "(" && $term != $arrayExpression[$indexIni]) break;
				}
				$string2 = $string . ")";
				array_push($arrayAux, $string2);
				array_splice($arrayExpression,$indexIni, ($indexEnd+1-$indexIni) ,$arrayAux); 
				$arrayTotal = $this->arrayParentheses($arrayExpression,$arrayTotal);
				$arrayExpression = $incorrectExpression;
				$indexEnd++;
				$arrayAux = array();
			}
			$string = "";
			$indexIni++;
			/*Testa se o �ndice � menor que o array*/
			if ($indexIni < (sizeof($arrayExpression) - 1)) {
				$term = $arrayExpression[$indexIni];
				/*La�o que busca uma rela��o, um quantificador ou conectivo de aridade 1 at� o fim do array */
				while (!$this->isRelation($term) && $indexIni < (sizeof($arrayExpression) - 1)) {
					/*Testa se term � um quantificador*/
					if	($this->isQuantifier($term)) break;
					/*Testa se term � um conectivo de aridade 1*/
					if ($this->connectiveArity($term) == 1) break;
					$indexIni++;
					$term = $arrayExpression[$indexIni];
				}
			}
			$indexEnd = $indexIni;
			$numberTerms--;
		}
		return $arrayTotal;
	}
	
	/**
	 * M�todo para montar um vetor de uma express�o proposicional
	 *
	 * @param String $expression Express�o proposicional.
	 * @param array $arrayExpression Vetor da express�o.
	 * @return array Vetor da express�o.
	 */
	public function propToArray ($expression,$arrayExpression) {
		/*Testa se a string n�o � vazia*/
		if ($expression != "") {
			$index = 0;
			/*La�o para remover todos os espa�os*/
			while (!ctype_graph($expression)) {
				/*La�o que busca um espa�o*/
				while ($expression[$index] != " ") {
					$index++;
				}
				/*Testa se index � igual a 0*/
				if ($index == 0) $expression = substr($expression,1);
				else $expression = substr($expression,0,$index) . substr($expression,$index+1);
			}
			$index = 0;
			/*Testa se a express�o come�a com uma rela��o*/
			if ($this->isRelation($expression)) {
				/*La�o para buscar uma virgula, um ')' ou um conectivo */
				while (!$this->isConnective(substr($expression,$index))) {
					/*Testa se index � o �ltimo caractere*/
					if ($index == (strlen($expression))) break;
					/*Testa se o caractere � uma ','*/
					if ($expression[$index] == ",") break;
					/*Testa se o caractere � uma ')'*/
					if ($expression[$index] == ")") break;
					$index++;
				}
				/*Testa se index � igual a 0*/
				if ($index == 0) $index++;
				array_push($arrayExpression,substr($expression,0,$index));
				$arrayExpression = $this->propToArray(substr($expression,$index), $arrayExpression);
			} elseif ($this->isConnective(substr($expression,$index))) {
				/*La�o para buscar uma virgula, um ')', um conectivo ou um rela��o*/
				while (!$this->isRelation(substr($expression,$index))) {
					/*Testa se index � igual a '('*/
					if ($expression[$index] == "(") break;
					/*Testa se index � o �ltimo caractere*/
					if ($index == (strlen($expression) - 1)) break;
					/*Testa se index � igual a ','*/
					if ($expression[$index] == ",") break;
					$index++;
					/*Testa se a partir de index � um conectivo*/
					if ($this->isConnective(substr($expression,$index))) break;
				}
				/*Testa se index � igual a 0*/
				if ($index == 0) $index++;
				array_push($arrayExpression,substr($expression,0,$index));
				$arrayExpression = $this->propToArray(substr($expression,$index), $arrayExpression);
			}else {
				$index++;
				array_push($arrayExpression,substr($expression,0,$index));
				$arrayExpression = $this->propToArray(substr($expression,$index), $arrayExpression);
			}
		}
		return $arrayExpression;
	}
	
	/**
	 * M�todo para imprimir o Ambiguity Parser em html.
	 *
	 * @param array $array Array com todas as express�es poss�veis.
	 */
	public function printArrayAmbiguityParser ($array) {
		echo "<b>Ambiguity Parser expression:<br /></b>";
		$index = 0;
		$correct = $array['correct'];
		echo "<i>Correct expression:</i><br /><dd>$correct<br />";
		echo "<i>Other expressions:<br /></i>";
		/*La�o para imprimir todos os elementos do array*/
		foreach ($array as $expression) {
			/*Testa se a express��o � diferente da correta*/
			if ($expression != $correct) {
				echo "<DD>[$index] => $expression<br />";
				$index++;
			}
		}
	}
	
	/**
	 * M�todo para imprimir uma �rvore em html.
	 *
	 * @param Node $node �rvore a ser impressa.
	 * @param String $ident Identador, inicialmente deve ser vazio.
	 */
	public function printTree ($tree,$ident) {
		echo "<DL>";
		$ident .= "<DD>";
		/*Testa se � um conectivo*/
		$node = $tree->content;
		if ($node instanceof Connective) {
			echo $ident."<i><b>Connective Object</b></i><br />";
			echo $ident."[<i>content</i>] => $node->content<br />";
			echo $ident."[<i>arity</i>] => $node->arity<br />";
			echo $ident."[<i>order</i>] => $node->order<br />";
			echo $ident."[<i>value</i>] => $node->value<br />";
			echo $ident."[<i>children</i>] => ";
			/*La�o que chama a recurs�o para cada argumento*/
			foreach ($tree->children as $term) {
				$this->printTree($term,$ident);
			}
		/*Testa se � uma rela��o*/	
		} elseif ($node instanceof Relation) {
			echo $ident."<i><b>Relation Object</b></i><br />";
			echo $ident."[<i>content</i>] => $node->content<br />";
			echo $ident."[<i>arity</i>] => $node->arity<br />";
			echo $ident."[<i>value</i>] => $node->value<br />";
			echo $ident."[<i>children</i>] => ";
			/*La�o que chama a recurs�o para cada argumento*/
			foreach ($tree->children as $term) {
				$this->printTree($term,$ident);
			}
		/*Testa se � uma fun��o*/	
		} elseif ($node instanceof Func) {
			echo $ident."<i><b>Function Object</b></i><br />";
			echo $ident."[<i>content</i>] => $node->content<br />";
			echo $ident."[<i>arity</i>] => $node->arity<br />";
			echo $ident."[<i>value</i>] => $node->value<br />";
			echo $ident."[<i>children</i>] => ";
			/*La�o que chama a recurs�o para cada argumento*/
			foreach ($tree->children as $term) {
				$this->printTree($term,$ident);
			}
		/*Testa se � uma vari�vel*/	
		} elseif ($node instanceof Variable) {
			echo $ident."<i><b>Variable Object</b></i><br />";
			echo $ident."[<i>content</i>] => $node->content<br />";
			echo $ident."[<i>value</i>] => $node->value<br />";
		/*Testa se � uma constante*/	
		} elseif ($node instanceof Constant) {
			echo $ident."<i><b>Constant Object</b></i><br />";
			echo $ident."[<i>content</i>] => $node->content<br />";
			echo $ident."[<i>value</i>] => $node->value<br />";
		} elseif ($node instanceof Atom) {
			echo $ident."<i><b>Atom Object</b></i><br />";
			echo $ident."[<i>content</i>] => $node->content<br />";
			echo $ident."[<i>value</i>] => $node->value<br />";
		}
		echo "</DL>";
	}
	
	/**
	 * M�todo para remover todos os espa�os desnecess�rios uma express�o.
	 *
	 * @param String $expression Express�o a ser desparentetizada.
	 * @return String Express�o j� desparentetizada.
	 */
	private function removeSpaces ($expression) {
		$indexEnd = 0;
		$testExpression = "";
		/*La�o que continua at� n�o houver mais espa�os*/
		while (!ctype_graph($expression)) {
			/*La�o que busca um espa�o na express�o*/
			while ($expression[$indexEnd] != " ") {
				/*Testa se a partir de indexEnd � um quantificador*/
				if($this->isQuantifier(substr($expression,$indexEnd))) {
					/*La�o que busca um espa�o na express�o e mant�m caso vier ap�s um quantificador*/
					while ($expression[$indexEnd] != " ") {
						$indexEnd++;
					}
					$indexEnd++;
					$testExpression = substr($expression,0,$indexEnd);
					$testExpression .= $this->removeSpaces(substr($expression,$indexEnd));
					return $testExpression;
				}
				$indexEnd++;
			}
			/*Testa se indexEnd � igual a 0*/
			if ($indexEnd == 0) $expression = substr($expression,1);
			else $expression = substr($expression,0,$indexEnd) . substr($expression,$indexEnd+1);		
		}
		return $expression;
	}

	/**
	 * M�todo para formar um vetor a partir de uma express�o prefixa.
	 *
	 * @param String $expression Express�o a ser transformada.
	 * @param array $arrayExpression Array onde ficar� a express�o
	 * @return array O Array terminado.
	 */
	private function prefixToArray ($expression, $arrayExpression) {
		$index = 0;
		/*La�o para percorrer a express�o em busca de um espa�o ou virgula, 
		acrescentar no array e chamar recursivamente*/
		while ($index < strlen($expression)) {
			/*Testa se o caractere � um espa�o e index � igual a 0*/
			if ($expression[$index] == " " && $index == 0) {
				$arrayExpression = $this -> prefixToArray(substr($expression,1), $arrayExpression);
				return $arrayExpression;
			/*Testa se o caractere � um espa�o ou se o caractere � uma virgula*/
			} elseif ($expression[$index] == " " || $expression[$index] == ",") {
				array_push($arrayExpression, substr($expression,0,$index));
				/*Testa se o caractere � um virgula*/
				if ($expression[$index] == ",") array_push($arrayExpression, $expression[$index]);
				$arrayExpression = $this -> prefixToArray(substr($expression,$index+1), $arrayExpression);
				return $arrayExpression;
			}
			$index++;
		}
		array_push($arrayExpression,$expression);
		return $arrayExpression;
	}
	
	/**
	 * M�todo para montar a �rvore.
	 * Conectivos e �tomos.
	 *
	 * @return node o n� raiz da �rvore pronta.
	 */
	private function propMakeTree($expression) {
		$array = $this->connectiveChildren($expression);
		$connective = $array['connective'];
		/*Testa se op � um conectivo*/	
		if ($this->isConnective($connective)) {
			$arity = 0;
			$order = $this->connectiveOrder($connective);
			$tree = new Connective($connective,0,$order);
			$node = new Node($tree);
			/*La�o que chama a recurs�o para cada argumento*/
			/*foreach ($array['children'] as $child) {
				$arity++;
				$children = $this->propMakeTree($child);
				array_push($node->children, $children);
			}*/
			for ($i = sizeof($array['children']) - 1; $i >= 0; $i--) {
				$arity++;
				$child = $array['children'][$i];
				$children = $this->propMakeTree($child);
				array_push($node->children, $children);
			}
			$tree->arity = $arity;
			$node->content = $tree;
			return $node;
		/*Caso contr�rio � um �tomo*/	
		} else {
			$tree = new Node (new Atom($connective));
			return $tree;
		}
	}
	
	
	
}

?>
