<?php

require_once('../../config.php');
require_once($CFG->dirroot . '/blocks/staffenroll/lib.php');

$site = get_site();

$courseid = required_param('courseid', PARAM_INT);
$parentid = required_param('parentid', PARAM_INT);

$coursecontext = context_course::instance($courseid);
$PAGE->set_context($coursecontext);

$pageurl = new moodle_url(
    '/blocks/staffenroll/enroll.php',
    array('courseid' => $courseid, 'parentid' => $parentid)
);
$PAGE->set_url($pageurl);

$titleParts = array();
$titleParts[] = get_string('pluginname', 'block_staffenroll');
$titleParts[] = get_string('course', 'block_staffenroll');
$titleParts[] = $courseid;
$title = implode(': ', $titleParts);
$PAGE->set_title($title);
$PAGE->set_heading($title);

$breadcrumbs = staffenroll_getbreadcrumbs($parentid);
foreach ($breadcrumbs as $bc) {
    $PAGE->navbar->add($bc['name'], $bc['href']);
}

$ok = staffenroll_validatenetworkhost();
if(! $ok) {
    // FIXME: abort processing on this error
    error_log('!!! invalid ip: ' . $_SERVER['REMOTE_ADDR']);
}

// print the header
echo $OUTPUT->header();
echo html_writer::div('courseid: ' . $courseid);
echo $OUTPUT->footer();

// this is enrol/unenroll code taken from previous version of plugin
// this file should contain actual enroll/unenroll code
// FIXME: needs review throughout

/*
 * FIXME: handle unenrol somewhere else

// this handles if they are unenrolling
// unenroll them then redirect to the main page
$action = isset($_REQUEST['enrl_action']) ? $_REQUEST['enrl_action'] : NULL;
if (isset($action) && $action == 'unenroll') {
    $course = $DB->get_record('course', array('id' => $courseid));
    if (!$course) {
        print_error('cannot_retrieve_course', 'local_support_staff_enroll');
    }

    support_staff_enroll_enroll_user($USER, $course, '', 'unenroll');

    redirect($CFG->wwwroot);
}
 */

/*
 * FIXME: this might be better handled in another file

 // if they chose to enroll, enroll them then redirect to course
if (isset($_REQUEST['enroll'])) {
    $type = $_REQUEST['enrl_type'];

    if (!isset($courseid) || !isset($type)) {
        print_error('must_supply_crs_and_enrl_type',
                     'local_support_staff_enroll');
    }

    $enrollments = support_staff_enroll_get_enrollments($USER->id);
    if (isset($enrollments[$courseid])) {
        print_error('already_enrolled', 'local_support_staff_enroll');
    }

    $allowed = support_staff_enroll_can_enroll_as($type, $env);
    if (!$allowed) {
        print_error('no_permission_enroll', 'local_support_staff_enroll');
    }

    $course = $DB->get_record('course', array('id' => $courseid));
    if (!$course) {
        print_error('cannot_retrieve_course', 'local_support_staff_enroll');
    }

    support_staff_enroll_enroll_user($USER, $course, $type);

    redirect($CFG->wwwroot.'/course/view.php?id='.$course->id);
}
 */

