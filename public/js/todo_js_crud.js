
$(document).ready(function () {

    //set up date -- isn't there an easier way to do this? 
    var today = new Date();

    var month = today.getMonth() + 1;
    var date = today.getDate();

    if (month < 10) {
        month = '0' + month.toString();
    }
    if (date < 10) {
        date = '0' + date.toString();
    }

    //short cut - get today date
    $('#btn_today').click(function () {
        $('#due_date').val(today.getFullYear() + "-" + month + "-" + date);
        $('#due_date').text(today.getFullYear() + "-" + month + "-" + date);
    });

    //show the modal and buttons
    $('#add_task_btn').click(function () {

        $('#add_task_modal').modal('toggle');
        $('#modal_heading').text("Create New Task");
        $('#edit_task_btn').hide();
        $('#submit_task_btn').show();
    });

    //submit a new task - modal btn
    $('#submit_task_btn').click(function () {
        //button type is button - No form - hence NO preventDefault.

        //hide text
        if ($('table tr').length > 0) {
            $('.custom_strong').toggle();
        }

        //close the modal
        $('#add_task_modal').modal('toggle');

        //get the csrf_token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //do POST
        $.ajax({
            method: 'POST', // Type of request and matches the route
            url: 'task', // send date to this route
            data: {
                task_name: $('#task_name').val(),
                due_date: $('#due_date').val()
            }, // a JSON object to send back
            success: function (response) { // What to do on success
                $('.task_table > tbody:last-child').append(
                        '<tr><td class="text-truncate data" id="td-task-name-' + response.id + '">' + response.task_name +
                        '</td><td class="data" id="td-task-due-date-' + response.id + '">' + response.due_date +
                        '</td><td><button type="button" id="delete-task-' + response.id +
                        '"class="btn btn-danger"><i class="far fa-trash-alt"></i></button>\n\
                         <button type="button" id="edit-task-' + response.id +
                        '"class="btn btn-info" data-target="#add_task_modal" data-toggle="modal"><i class="far fa-edit"></i></button></td></tr>'
                        );
            },
            error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });


    });//end of ajax post for submit button

    //for dynamic button id's - DELETE AJAX Functionality
    $(document).on("click", ".btn-danger", function () {

        //remove the tr
        $(this).closest('tr').remove();

        //regex pattern match - get all digits -delete-task-IDNUMBER
        var id_pattern = /[\d+]/;
        var id = $(this).attr('id').match(/\d+/);
        //get the csrf_token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //do DELETE
        $.ajax({
            url: 'task/' + id, // send date to this route
            method: 'delete',
            data: {
                id: id
            }, // a JSON object to send back
            success: function (response) { // What to do on success - remove row                
                $(this).closest('tr').remove();
                
            },
            error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    });

    //SHOW edit modal
    $(document).on("click", ".btn-info", function (){
    //$('.btn-info').click(function () {

        //regex pattern match - get all digits - edit-task-IDNUMBER
        var id_pattern = /[\d+]/;
        //alert('clicked delete button' + $(this).attr('id'));
        var id = $(this).attr('id').match(/\d+/);
        var task_name = $('td:first', $(this).parents('tr')).text();
        var due_date = $('td:nth-child(2)', $(this).parents('tr')).text();



        //set modal task_id hidden field
        $('#task_id').attr('value', id);
        $('#task_name').val(task_name);
        $('#task_name').text(task_name);
        $('#due_date').val(due_date);
        $('#due_date').text(due_date);


        //hide modal button submit and replace with edit
        $('#modal_heading').text("Edit Task");
        $('#submit_task_btn').hide();
        $('#edit_task_btn').show();

        $('#add_task_modal').modal('toggle');
    });//end of edit button click

    //edit an existing task - EDIT - AJAX functionality
    $('#edit_task_btn').click(function () {
        $('#add_task_modal').modal('toggle');
        $('#submit_task_btn').show();

        //regex pattern match - get all digits - edit-task-IDNUMBER
        var id_pattern = /[\d+]/;
        var id = $('#task_id').val();
        //get the csrf_token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        //do UPDATE
        $.ajax({
            url: 'task/' + id, // send id to this route
            method: 'put',
            data: {
                id: id,
                task_name: $('#task_name').val(),
                due_date: $('#due_date').val()
            }, // a JSON object to send back
            success: function (response) { // What to do on success - remove row  
                $('#td-task-name-' + id).text(response.task_name);
                $('#td-task-due-date-' + id).text(response.due_date);
            },
            error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    });


});//end of document.ready function

         