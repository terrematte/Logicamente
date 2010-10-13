<html>
<head>
<title> .: Logicamente :. </title>
	<script src="../../libs/validation/scriptaculous/lib/prototype.js"></script>
	<script src="../../libs/validation/scriptaculous/src/effects.js"></script>
	<script src="../../libs/validation/validation.js"></script>
	<script src="../../libs/validation/fabtabulous.js"></script>
	<script src="../../libs/jquery.js"></script>
	<script src="../../libs/jquery.corner.js"></script>
	<script src="../../libs/shortcut.js"></script>
	<script src="../../libs/interface.js"></script>
	<script src="../../system/script/manager.js"></script>
	<!-- <script id="js"></script> -->

	<link rel="stylesheet" type="text/css" href="../../libs/validation/style.css" />
	<link rel="stylesheet" type="text/css" href="" id="css"/>
	<style>
		@import "../../system/css/default.css";
		@import "../../system/css/menuItems.css";
		@import "../../system/css/resolutionGame.css";
	</style>
	<link rel="shortcut icon" href="logo.gif"/>
</head>
<body>
<div id="header"><a href="index.php"><img src="images/logo.jpg" border="0" /></a></div>
<div id="menu">
	<ul>
		<li id="menuSettings">
			<a href="#menuSettings" accesskey="S">
				<img width="100%" height="100%" src="images/transp.gif" border="0"/>
			</a>
		</li>
		<li id="menuGenerator">
			<a href="#menuGenerator" accesskey="G">
				<img width="100%" height="100%" src="images/transp.gif" border="0"/>
			</a>
		</li>
		<li id="menuDiagnoser" style="display:none;">
			<a href="#menuDiagnoser">
				<img width="100%" height="100%" src="images/transp.gif" border="0"/>
			</a>
		</li>
		<li id="menuTranslator" style="display:none;">
			<a href="#menuTranslator">
				<img width="100%" height="100%" src="images/transp.gif" border="0"/>
			</a>
		</li>
		<li id="menuChecker" style="display:none;">
			<a href="#menuChecker">
				<img width="100%" height="100%" src="images/transp.gif" border="0"/>
			</a>
		</li>
		<li id="menuReadFormula">
			<a href="#menuReadFormula" accesskey="F">
				<img width="100%" height="100%" src="images/transp.gif" border="0"/>
			</a>
		</li>
		<li id="menuTruthTable">
			<a href="#menuTruthTable" accesskey="T">
				<img width="100%" height="100%" src="images/transp.gif" border="0"/>
			</a>
		</li>
		<li id="menuTreeInteraction">
			<a href="#menuTreeInteraction" accesskey="I">
				<img width="100%" height="100%" src="images/transp.gif" border="0"/>
			</a>
		</li>
		<li id="menuSubstitutionMaster">
			<a href="#menuSubstitutionMaster">
				<img width="100%" height="100%" src="images/transp.gif" border="0"/>
			</a>
		</li>
        <li id="menuPrenex">
			<a href="#menuPrenex">
				<img width="100%" height="100%" src="images/transp.gif" border="0"/>
			</a>
		</li>
		<li id="menuSkolemizer">
			<a href="#menuSkolemizer">
				<img width="100%" height="100%" src="images/transp.gif" border="0"/>
			</a>
		</li>
		<li id="menuResolutionGame">
			<a href="#menuResolutionGame" accesskey="R">
				<img width="100%" height="100%" src="images/transp.gif" border="0"/>
			</a>
		</li>
		<li id="menuTester">
			<a href="#menuTester" accesskey="E">
				<img width="100%" height="100%" src="images/transp.gif" border="0"/>
			</a>
		</li>
	</ul>
</div>
<div id="conentBase">
	<div id="content">
		<p>Seja bem vindo &agrave; pagina do <strong>Projeto Logicamente</strong>.</p>
		<p>Para acessar um m&oacute;dulo do programa, basta clicar em sua aba correspondente.A qualquer momento voc&ecirc; pode obter
		ajuda para o m&oacute;dulo que est&aacute; sendo utilizado apenas apertando as teclas <strong>Ctrl+Shift+h</strong>. A ajuda desta p&aacute;gina inicial cont&eacute;m diversos atalhos &uacute;teis para
		tornar mais &aacute;gil o acesso aos diversos m&oacute;dulos do programa.</p>
	</div>
	<fieldset id="fieldsetSettings">
		<legend>Settings</legend>
		<div id="config"></div>
	</fieldset>
	<fieldset id="fieldsetTransfer">
		<legend>Transfer Area</legend>
		<div id="transfer">
			<div id='cont'>0</div>
		</div>
	</fieldset>
</div>

<div id="footer">
	Copyright &copy; Logicamente - 2007<br/>All rights reserved
</div>

<div id="js">
</div>

<img src="images/menuGeneratorBtnHover.jpg" style="display:none;"/>
<img src="images/menuTranslatorBtnHover.jpg" style="display:none;"/>
<img src="images/menuDiagnoserBtnHover.jpg" style="display:none;"/>
<img src="images/menuCheckerBtnHover.jpg" style="display:none;"/>
<img src="images/menuSettingsBtnHover.jpg" style="display:none;"/>
<img src="images/menuReadFormulaBtnHover.jpg" style="display:none;"/>
<img src="images/menuResolutionGameBtnHover.jpg" style="display:none;"/>
<img src="images/menuTruthTableBtnHover.jpg" style="display:none;"/>

<div id="blackground"></div>
<div id="helpBorder"><div id="helpContent"></div></div>
</body>
</html>
