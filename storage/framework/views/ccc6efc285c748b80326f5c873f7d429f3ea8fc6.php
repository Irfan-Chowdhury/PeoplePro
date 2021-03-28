    $('#qualification-table').DataTable().clear().destroy();
    var date = $('.date');
    date.datepicker({
        format: '<?php echo e(env('Date_Format_JS')); ?>',
        autoclose: true,
        todayHighlight: true
    });


    var table_table = $('#qualification-table').DataTable({
        initComplete: function () {
            this.api().columns([0]).every(function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo($(column.footer()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>');
                    $('select').selectpicker('refresh');
                });
            });
        },
        responsive: true,
        fixedHeader: {
            header: true,
            footer: true
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo e(route('qualifications.show',$employee->id)); ?>",
        },

        columns: [

            {
                data: 'institution_name',
                name: 'institution_name',

            },
            {
                data: null,
                render: function (data, type, row) {
    return row.from_year +' to ' + row.to_year;
                }
            },
            {
                data: 'education_level',
                name: 'education_level',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            }
        ],


        "order": [],
        'language': {
            'lengthMenu': '_MENU_ <?php echo e(__('records per page')); ?>',
            "info": '<?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)',
            "search": '<?php echo e(trans("file.Search")); ?>',
            'paginate': {
                'previous': '<?php echo e(trans("file.Previous")); ?>',
                'next': '<?php echo e(trans("file.Next")); ?>'
            }
        },
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 3],
            },
        ],


        'select': {style: 'multi', selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    new $.fn.dataTable.FixedHeader(table_table);


    $('#create_qualification_record').click(function () {

        $('.modal-title').text('<?php echo e(__('Add Qualification')); ?>');
        $('#qualification_action_button').val('<?php echo e(trans('file.Add')); ?>');
        $('#qualification_action').val('<?php echo e(trans('file.Add')); ?>');
        $('#QualificationformModal').modal('show');
    });

    $('#qualification_sample_form').on('submit', function (event) {
        event.preventDefault();
        if ($('#qualification_action').val() === '<?php echo e(trans('file.Add')); ?>') {

            $.ajax({
                url: "<?php echo e(route('qualifications.store',$employee->id)); ?>",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    var html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#qualification_sample_form')[0].reset();
                        $('select').selectpicker('refresh');
                        $('.date').datepicker('update');
                        $('#qualification-table').DataTable().ajax.reload();
                    }
                    $('#qualification_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }

            });
        }

        if ($('#qualification_action').val() === '<?php echo e(trans('file.Edit')); ?>') {
            $.ajax({
                url: "<?php echo e(route('qualifications.update')); ?>",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    var html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }

                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        setTimeout(function () {
                            $('#QualificationformModal').modal('hide');
                            $('.date').datepicker('update');
                            $('select').selectpicker('refresh');
                            $('#qualification-table').DataTable().ajax.reload();
                            $('#qualification_sample_form')[0].reset();
                        }, 2000);

                    }
                    $('#qualification_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });
        }
    });


    $(document).on('click', '.qualification_edit', function () {

        var id = $(this).attr('id');

        var target = "<?php echo e(route('qualifications.index')); ?>/" + id + '/edit';


        $.ajax({
            url: target,
            dataType: "json",
            success: function (html) {

                let id = html.data.id;

                $('#institution_name').val(html.data.institution_name);
                $('#qualification_from_date').val(html.data.from_year);
                $('#qualification_to_date').val(html.data.to_year);
                $('#qualification_description').val(html.data.description);
                $('#education_level_id').selectpicker('val', html.data.education_level_id);
                $('#language_skill_id').selectpicker('val', html.data.language_skill_id);
                $('#general_skill_id').selectpicker('val', html.data.general_skill_id);



                $('#qualification_hidden_id').val(html.data.id);
                $('.modal-title').text('<?php echo e(trans('file.Edit')); ?>');
                $('#qualification_action_button').val('<?php echo e(trans('file.Edit')); ?>');
                $('#qualification_action').val('<?php echo e(trans('file.Edit')); ?>');
                $('#QualificationformModal').modal('show');
            }
        })
    });


    let qualification_delete_id;

    $(document).on('click', '.qualification_delete', function () {
    qualification_delete_id = $(this).attr('id');
        $('.confirmModal').modal('show');
        $('.modal-title').text('<?php echo e(__('DELETE Record')); ?>');
        $('.qualification-ok').text('<?php echo e(trans('file.OK')); ?>');
    });


    $('.qualification-close').click(function () {
        $('#qualification_sample_form')[0].reset();
        $('select').selectpicker('refresh');
        $('.date').datepicker('update');
        $('.confirmModal').modal('hide');
        $('#qualification-table').DataTable().ajax.reload();
    });

    $('.qualification-ok').click(function () {
        let target = "<?php echo e(route('qualifications.index')); ?>/" + qualification_delete_id + '/delete';
        $.ajax({
            url: target,
            beforeSend: function () {
                $('.qualification-ok').text('<?php echo e(trans('file.Deleting...')); ?>');
            },
            success: function (data) {
                setTimeout(function () {
                    $('.confirmModal').modal('hide');
                    $('#qualification-table').DataTable().ajax.reload();
                }, 2000);
            }
        })
    });

<?php /**PATH C:\laragon\www\peoplepro\resources\views/employee/qualifications/index_js.blade.php ENDPATH**/ ?>