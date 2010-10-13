<?php
session_start();
$_SESSION['con'];

require_once("Logicamente.class.php");

	//display modules
	if (isset($_POST['module'])){
		switch ($_POST['module']){
			case "menuGenerator" : require_once("../system/html/generator.php");  break;
			case "menuSettings"  : require_once("../system/html/settings.php");	  break;
			case "menuTranslator": require_once("../system/html/translator.php"); break;
			case "menuChecker"   : require_once("../system/html/checker.php");    break;
			default: echo ("zzzzzz");
		}
	}

	//display helpmodules
	if (isset($_POST['helpModule'])){
		switch ($_POST['helpModule']){
			case "menuGenerator": include ("../system/html/help/generator.php");	break;
			case "menuSettings" : include ("../system/html/help/settings.php");		break;
			default: include ("../system/html/help/logicamente.php");
		}
	}
	
	//up javasript
	if (isset($_POST['js'])){
		switch ($_POST['js']){
			case "menuGenerator" : require_once("../system/script/formGenerator.js");  break;
			case "menuSettings"  : require_once("../system/script/formSettings.js");   break;
			case "menuTranslator": require_once("../system/script/formTranslator.js"); break;
			case "menuChecker"   : require_once("../system/script/formCheck.js");      break;
			//default: echo ("zzzzzz");
		}
	}
	
	//up css
	if (isset($_POST['css'])){
		switch ($_POST['css']){
			case "menuSettings": print ("../css/settings.css");	break;
			case "menuChecker" : print ("../css/checker.css");  break;
			default: echo ("zzzzzz");
		}
	}	
	
	//exec Logicamente
	if (isset($_POST['action'])){
		switch ($_POST['action']){
			case "generateFormulas": generateFormulas($_POST['nConnective'],$_POST['nAtom']);              break;
			case "setConnectives"  : setConnectives( $_POST['symbol'], $_POST['arity'], $_SESSION['con'], 0 ); break;
			case "checkFormula"    : checkFormula($_POST['formula']);                                       break;
			default: echo ("zzzzzz");
		}	
	}
	
	//interface between Logicamente and HTML

	//unserialize
	function Connective_Callback($classname){
		//require_once("Connective.class.php");
	}	
	
	function generateFormulas($nConnective, $nAtoms){
		$cons = array();		

		ini_set('unserialize_callback_func', 'Connective_Callback');
		
		foreach($_SESSION['con'] as $value)
			array_push($cons, unserialize($value));	

		$logica = new Logicamente();
		$tree = $logica->generateFormulas($nConnective, $nAtoms, $cons);	
	}

	function setConnectives($symbol, $arity, $order){
		$local = array();
		foreach($symbol as $key => $value){
		
			//$a = array();
			//array_push($a, htmlentities($value));
		
			$c = new Connective($value, $arity[$key], $order);
			//$value = '';
			//print "<br/>".html_entity_decode($value)." ".htmlentities($value)." ".htmlspecialchars($value)."<br/>";
			
			array_push($local, serialize($c));
		}
		$_SESSION['con'] = $local;
		
		//print_r($a);
	}
		
	function checkFormula($formula){
		$logica = new Logicamente();
		$cons = array();		

		ini_set('unserialize_callback_func', 'Connective_Callback');
		
		foreach($_SESSION['con'] as $value)
			array_push($cons, unserialize($value));
		$logica->checkFormula($formula, $cons);	
	}
?>
