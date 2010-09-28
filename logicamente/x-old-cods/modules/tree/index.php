<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Exibição de Arvores</title>
<LINK REL="STYLESHEET" TYPE="text/css" HREF="tree.css">
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}

<?php
$variables = 5;
?>
-->
</style></head>

<body>
<div>
  <div align="center">
    <table width="100" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><?php
include('ViewTree.php');
include('../WFFGenerator.class.php');
	$cons = array();
	array_push($cons, new Connective("~",1,0));
	array_push($cons, new Connective("&",2,0));
	array_push($cons, new Connective("|",2,0));
	array_push($cons, new Connective("+",2,0));
	array_push($cons, new Connective("-->",2,0));
	array_push($cons, new Connective("<->",2,0));
	
	$g = new WFFGenerator(10 , $variables , $cons);
	$t = new WFFTranslator();
	$ft = $g->getFormula();
	$centralRoot = $ft->root;
viewTree($centralRoot);
?></td>
      </tr>
    </table>
<?php
echo ("<br>".$t->showFormulaInfix($centralRoot));
?>
  </div>
</div>
</body>
</html>
