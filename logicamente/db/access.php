<?php
$mod_logicamente_capabilities = array(
    'mod/logicamente:view' => array( //Allow to view complete logicamente description
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'legacy' => array(
           'guest' => CAP_PREVENT,
           'student' => CAP_ALLOW,
           'teacher' => CAP_ALLOW,
           'editingteacher' => CAP_ALLOW,
           'coursecreator' => CAP_ALLOW,
           'admin' => CAP_ALLOW
        )
    ),

    'mod/logicamente:submit' => array( //Allow to submit a logicamente assingment
        'captype' => 'write',
        'contextlevel' => CONTEXT_MODULE,
        'legacy' => array(
           'guest' => CAP_PROHIBIT,
           'student' => CAP_ALLOW,
           'teacher' => CAP_PREVENT,
           'editingteacher' => CAP_ALLOW,
           'coursecreator' => CAP_ALLOW,
           'admin' => CAP_ALLOW
        	)
    ),

    'mod/logicamente:grade' => array( //Allow to grade a logicamente submission
        'captype' => 'write',
        'contextlevel' => CONTEXT_MODULE,
        'legacy' => array(
           'guest' => CAP_PROHIBIT,
           'student' => CAP_PREVENT,
           'teacher' => CAP_ALLOW,
           'editingteacher' => CAP_ALLOW,
           'coursecreator' => CAP_ALLOW,
           'admin' => CAP_ALLOW
        	)
        ),
    'mod/logicamente:similarity' => array( //Allow to show submissions similarity
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'legacy' => array(
           'guest' => CAP_PROHIBIT,
           'student' => CAP_PREVENT,
           'teacher' => CAP_ALLOW,
           'editingteacher' => CAP_ALLOW,
           'coursecreator' => CAP_ALLOW,
           'admin' => CAP_ALLOW
        	)
        ),
    'mod/logicamente:manage' => array( //Allow to manage a logicamente instance
        'captype' => 'write',
        'contextlevel' => CONTEXT_MODULE,
        'legacy' => array(
           'guest' => CAP_PROHIBIT,
           'student' => CAP_PROHIBIT,
           'teacher' => CAP_PREVENT,
           'editingteacher' => CAP_ALLOW,
           'coursecreator' => CAP_ALLOW,
           'admin' => CAP_ALLOW
        	)
        ),
    'mod/logicamente:setjails' => array( //Allow to set the jails for a logicamente instance
        'captype' => 'write',
        'contextlevel' => CONTEXT_MODULE,
        'legacy' => array(
           'guest' => CAP_PROHIBIT,
           'student' => CAP_PROHIBIT,
           'teacher' => CAP_PROHIBIT,
           'editingteacher' => CAP_PREVENT,
           'coursecreator' => CAP_PREVENT,
           'admin' => CAP_ALLOW
        	)
        )
 );
?>
