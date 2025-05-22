<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    // Creamos una categoría de administración para el plugin (opcional)
    $ADMIN->add('root', new admin_category('local_bulkcertdownloadcategory', get_string('pluginname', 'local_bulkcertdownload')));

    // Agregamos la página principal del plugin
    $ADMIN->add('local_bulkcertdownloadcategory', new admin_externalpage(
        'local_bulkcertdownload',
        get_string('pluginname', 'local_bulkcertdownload'),
        new moodle_url('/local/bulkcertdownload/index.php'),
        'local/bulkcertdownload:view'
    ));
}
