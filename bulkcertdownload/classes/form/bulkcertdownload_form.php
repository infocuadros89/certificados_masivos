<?php
namespace local_bulkcertdownload\form;

use moodleform;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

class bulkcertdownload_form extends \moodleform {
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        // Curso
        $courses = get_courses(['sortorder' => 'asc']);
        $courseoptions = ['' => get_string('choosecourse', 'local_bulkcertdownload')];
        foreach ($courses as $course) {
            if ($course->id == SITEID) {
                continue;
            }
            $courseoptions[$course->id] = $course->fullname;
        }
        $mform->addElement('select', 'courseid', get_string('selectcourse', 'local_bulkcertdownload'), $courseoptions);
        $mform->setType('courseid', PARAM_INT);
        $mform->addRule('courseid', null, 'required', null, 'client');

        // Certificado (vacío inicialmente, se llenará vía JS)
        $certoptions = ['0' => get_string('choosecert', 'local_bulkcertdownload')];
        $mform->addElement('select', 'certid', get_string('selectcustomcert', 'local_bulkcertdownload'), $certoptions);
        $mform->setType('certid', PARAM_INT);
        $mform->addRule('certid', get_string('mustchoosecert', 'local_bulkcertdownload'), 'required', null, 'client');

        // Grupo (vacío inicialmente, se llenará vía JS)
        $groupoptions = ['0' => get_string('choosegroup', 'local_bulkcertdownload')];
        $mform->addElement('select', 'groupid', get_string('selectgroup', 'local_bulkcertdownload'), $groupoptions);
        $mform->setType('groupid', PARAM_INT);

        // Botón submit
        $mform->addElement('submit', 'submitbutton', get_string('download', 'local_bulkcertdownload'));
    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        if (!isset($data['courseid']) || (int)$data['courseid'] === 0) {
            $errors['courseid'] = get_string('mustchoosecourse', 'local_bulkcertdownload');
        }

        if (!isset($data['certid']) || (int)$data['certid'] === 0) {
            $errors['certid'] = get_string('mustchoosecert', 'local_bulkcertdownload');
        }

        // Grupo es opcional, no validar

        return $errors;
    }
}
