<?
class readFormula{
	function convertToRE($string){
		$string = str_replace("|","\\|",$string);
		$string = str_replace("+","\\+",$string);
		$string = str_replace("?","\\?",$string);
		$string = str_replace("-","\\-",$string);
		return $string;
	}
	
	function readFormula(){}
	
	function checkFormula($formula,$connectives){
	
		$auxUc = array();
		$auxZc = array();
		$auxC = array();
		
		foreach ($connectives as $c){
			if ($c->arity == 0) array_push($auxZc,$this->convertToRE($c->content));
			else if ($c->arity == 1) array_push($auxUc,$this->convertToRE($c->content));
			else array_push($auxC,$this->convertToRE($c->content));
		}
		
		$auxOr = ""; $ucs = "";
		foreach($auxUc as $uc){ $ucs .= $auxOr.$uc; $auxOr = "|"; }

		$auxOr = ""; $zcs = "";
		foreach($auxZc as $zc){ $zcs .= $auxOr.$zc; $auxOr = "|"; }

		$auxOr = ""; $cs = "(";
		foreach($auxC as $c){ $cs .= $auxOr.$c; $auxOr = "|"; }
		$cs .= ")";
	
		//echo ($ucs."<br>");
		//echo($zcs."<br>");
		//echo($cs."<br>");
		
		if ($ucs != "()") $ucs = "|".$ucs;
		else $ucs = "";
		
		if ($zcs != "") $zcs = "|".$zcs;
		else $zcs = "";
		
		if ($cs == "()") $cs = "";
		
		$v = "(\\(| ".$ucs.")*(([a-z]|[A-Z])+[0-9]+".$zcs.")( |\\))*";
	
		//echo ($v."(".$cs.$v.")*");
		
		if (ereg("^".$v."(".$cs.$v.")*$",$formula)){			
			$p = 0;
			for ($i = 0; $i < strlen($formula); $i++){
				if ($formula[$i] == "(") $p ++;
				else if ($formula[$i] == ")"){
					$p --;
					if ($p < 0){
						echo ("ERRO!<br>");
						break;
					}
				}
			}
			if ($p != 0) echo ("ERRO!<br>");
			else{
				echo ("OK!<br>");
				$this->toTree($formula,$connectives);
			}
		} else echo ("ERROR!<br>");
	}
	
	function getExternalConnective($formula, $connectives){
	}
	
	function toTree($formula, $connectives){
		//echo ("<br>");
		
		$v = "([a-z]+|[A-Z]+)+[0-9]+";
		$c = "";
		$auxOr = "";
		for ($i = 0; $i < sizeof($connectives); $i++){ $c .= $auxOr.$this->convertToRE($connectives[$i]->content); $auxOr = "|"; }
		$re = "(".$v."|".$c."|\(|\))";
		
		//echo ($re."<br>".$formula."<br>");
		
		preg_match_all($re,$formula,$partes);
		
		
		for ($i = 0; $i < sizeof($partes[0]); $i++){
			echo ("[".trim($partes[0][$i])."] ");
		}
	}
	
	/*if (isset($_POST['f'])){
	
		$connectives = array();
		array_push ($connectives,new Connective("-->",2,4));
		array_push ($connectives,new Connective("<->",2,5));
		array_push ($connectives,new Connective("&",2,1));
		array_push ($connectives,new Connective("|",2,2));
		array_push ($connectives,new Connective("+",2,3));
		array_push ($connectives,new Connective("~",1,0));
		array_push ($connectives,new Connective("@",0,10));
	
		echo (checkFormula2($_POST['f'], $connectives));
	}

?>

<form action="readFormula.php" method="post">
	<input name="f" /><input type="submit" value="read" />
</form>*/
}
?>