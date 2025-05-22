define(['jquery'], function($) {
    return {
        init: function() {
            $('#id_courseid').change(function() {
                var courseid = $(this).val();

                if (courseid == 0 || courseid === '') {
                    $('#id_certid').html('<option value="0">' + M.util.get_string('choosecert', 'local_bulkcertdownload') + '</option>');
                    $('#id_groupid').html('<option value="0">' + M.util.get_string('choosegroup', 'local_bulkcertdownload') + '</option>');
                    return;
                }

                // Obtener certificados
                $.getJSON(M.cfg.wwwroot + '/local/bulkcertdownload/ajax.php', {action: 'getcertificates', courseid: courseid}, function(data) {
                    var options = '<option value="0">' + M.util.get_string('choosecert', 'local_bulkcertdownload') + '</option>';
                    $.each(data.customcerts, function(id, name) {
                        options += '<option value="' + id + '">' + name + '</option>';
                    });
                    $('#id_certid').html(options);
                }).fail(function() {
                    alert("Error al cargar certificados.");
                });

                // Obtener grupos
                $.getJSON(M.cfg.wwwroot + '/local/bulkcertdownload/ajax.php', {action: 'getgroups', courseid: courseid}, function(data) {
                    var options = '<option value="0">' + M.util.get_string('choosegroup', 'local_bulkcertdownload') + '</option>';
                    $.each(data.groups, function(id, name) {
                        options += '<option value="' + id + '">' + name + '</option>';
                    });
                    $('#id_groupid').html(options);
                }).fail(function() {
                    alert("Error al cargar grupos.");
                });
            });
        }
    };
});
