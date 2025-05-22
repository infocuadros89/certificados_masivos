<?php
// Este archivo es parte de Moodle - http://moodle.org/

require_once(__DIR__ . '/../../config.php');
require_login();

use local_bulkcertdownload\form\bulkcertdownload_form;

$PAGE->set_url(new moodle_url('/local/bulkcertdownload/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('pluginname', 'local_bulkcertdownload'));
$PAGE->set_heading(get_string('pluginname', 'local_bulkcertdownload'));

$mform = new bulkcertdownload_form();

if ($data = $mform->get_data()) {
    // Procesamiento de formulario
    $courseid = $data->courseid;
    $certid = $data->certid;
    $groupid = $data->groupid ?? 0;

    $context = context_course::instance($courseid);
    require_capability('moodle/course:view', $context);

    // Verificar que el certificado existe y pertenece al curso
    $customcert = $DB->get_record('customcert', ['id' => $certid, 'course' => $courseid], '*', MUST_EXIST);

    // Aquí podrías continuar con la lógica para generar y descargar los certificados
    // Por ejemplo, llamar a una función que genere el ZIP con los certificados seleccionados.

    // Por ahora, sólo muestro mensaje de éxito (puedes reemplazar)
    echo $OUTPUT->header();
    echo $OUTPUT->notification(get_string('pluginname', 'local_bulkcertdownload') . ': Certificado seleccionado correctamente.', 'notifysuccess');
    echo $OUTPUT->continue_button(new moodle_url('/local/bulkcertdownload/index.php'));
    echo $OUTPUT->footer();
    exit;
} else {
    echo $OUTPUT->header();
    $mform->display();
    echo $OUTPUT->footer();
}

// Cargar JS AMD que actualiza certificados y grupos al cambiar curso
$PAGE->requires->js_call_amd('local_bulkcertdownload/main', 'init');
