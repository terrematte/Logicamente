
	<script src="js/validation/scriptaculous/lib/prototype.js"></script>
	<script src="js/validation/scriptaculous/src/effects.js"></script>
	<script src="js/validation/validation.js"></script>
	<script src="js/validation/fabtabulous.js"></script>
	<script src="js/jquery.js"></script>
	<script src="js/jquery.corner.js"></script>
	<script src="js/shortcut.js"></script>
	<script src="js/interface.js"></script>
	<script src="manager.js"></script>
	<!-- <script id="js"></script> -->

	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="" id="css"/>
	<style>

                @import "css/default.css";
		@import "css/menuItems.css";
		@import "mod_resolutiongame/resolutionGame.css";

	</style>
	<link rel="shortcut icon" href="src=css/images/logo.gif"/>


<?php  // $Id: view.php,v 1.6.2.3 2009/04/17 22:06:25 skodak Exp $
header("Content-Type: text/html;  charset=ISO-8859-1",true);
/**
 * This page prints a particular instance of logicamente
 *
 * @author  Your Name <your@email.address>
 * @version $Id: view.php,v 1.6.2.3 2009/04/17 22:06:25 skodak Exp $
 * @package mod/logicamente
 */

/// (Replace logicamente with the name of your module and remove this line)
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

//include(dirname(__FILE__).'/libs_js.php');

$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$a  = optional_param('a', 0, PARAM_INT);  // logicamente instance ID

if ($id) {
    if (! $cm = get_coursemodule_from_id('logicamente', $id)) {
        error('Course Module ID was incorrect');
    }

    if (! $course = get_record('course', 'id', $cm->course)) {
        error('Course is misconfigured');
    }

    if (! $logicamente = get_record('logicamente', 'id', $cm->instance)) {
        error('Course module is incorrect');
    }

} else if ($a) {
    if (! $logicamente = get_record('logicamente', 'id', $a)) {
        error('Course module is incorrect');
    }
    if (! $course = get_record('course', 'id', $logicamente->course)) {
        error('Course is misconfigured');
    }
    if (! $cm = get_coursemodule_from_instance('logicamente', $logicamente->id, $course->id)) {
        error('Course Module ID was incorrect');
    }

} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

add_to_log($course->id, "logicamente", "view", "view.php?id=$cm->id", "$logicamente->id");

/// Print the page header
$strlogicamentes = get_string('modulenameplural', 'logicamente');
$strlogicamente  = get_string('modulename', 'logicamente');

$navlinks = array();
//$navlinks[] = array('name' => $strlogicamentes, 'link' => "index.php?id=$course->id", 'type' => 'activity');
//$navlinks[] = array('name' => format_string($logicamente->name), 'link' => '', 'type' => 'activityinstance');
$navlinks[] = array('name' => $strlogicamentes, 'link' => "index.php?id=$course->id");
$navlinks[] = array('name' => format_string($logicamente->name), 'link' => '');

$navigation = build_navigation($navlinks);

print_header_simple(format_string($logicamente->name), '', $navigation, '', '', true,
              update_module_button($cm->id, $course->id, $strlogicamente), navmenu($course, $cm));

ob_start();
session_start();



require(dirname(__FILE__).'/header.php');
require(dirname(__FILE__).'/footer.php');

/// Finish the page
print_footer($course);

?>


