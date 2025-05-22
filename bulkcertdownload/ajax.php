<?php
// local/bulkcertdownload/ajax.php

require_once(__DIR__ . '/../../config.php');
require_login();

global $DB;

$action = required_param('action', PARAM_ALPHA);
$courseid = required_param('courseid', PARAM_INT);

$context = context_course::instance($courseid);
require_capability('moodle/course:view', $context);

header('Content-Type: application/json');

if ($action === 'getcertificates') {
    $customcerts = $DB->get_records('customcert', ['course' => $courseid]);

    $response = ['customcerts' => []];
    foreach ($customcerts as $cert) {
        $response['customcerts'][$cert->id] = format_string($cert->name);
    }

    echo json_encode($response);
    exit;
}

if ($action === 'getgroups') {
    $groups = groups_get_all_groups($courseid);

    $response = ['groups' => []];
    foreach ($groups as $group) {
        $response['groups'][$group->id] = format_string($group->name);
    }

    echo json_encode($response);
    exit;
}

// ✅ NUEVA ACCIÓN: getall
if ($action === 'getall') {
    $customcerts = $DB->get_records('customcert', ['course' => $courseid]);
    $groups = groups_get_all_groups($courseid);

    $response = [
        'customcerts' => [],
        'groups' => []
    ];

    foreach ($customcerts as $cert) {
        $response['customcerts'][$cert->id] = format_string($cert->name);
    }

    foreach ($groups as $group) {
        $response['groups'][$group->id] = format_string($group->name);
    }

    echo json_encode($response);
    exit;
}

// Acción no válida
http_response_code(400);
echo json_encode(['error' => 'Acción no válida']);
exit;
