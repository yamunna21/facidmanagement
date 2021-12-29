<?php

//Patient.php

include('../class/Appointment.php');

$object = new Appointment;

if(!$object->is_login())
{
    header("location:".$object->base_url."admin");
}



include('header.php');

?>
                     <!-- This HTML will display the patient list -->
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Patient Management</h1>

                    <!-- DataTales Example -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col">
                                    <h6 class="m-0 font-weight-bold text-primary">Patient List</h6>
                                </div>
                                  <div class="col" align="right">
                                     <form  method="post" action="export.php">  
                                      <input type="submit" name="Export" value="Click here to export the record" class="btn btn-outline-success" />  
                                    </form>  
                                </div>
                                <div>
                                    <button type="button" name="add_patient" id="add_patient" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="patients_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Identity Card No</th>
                                            <th>Patient Registration ID</th>
                                            <th>Patient Name</th>
                                            <th>Patient Phone No.</th>
                                            <th>Quarantine Reason</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                       <br>
                    </div>

                <?php
                include('footer.php');
                ?>
<!-- This HTML to add the new patient in the patient list -->
<div id="pModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="patient_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Patient</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Identity Card No</label>
                                <input type="text" name="patient_ic" id="patient_ic" class="form-control"  data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>Patient Registration ID <span class="text-danger">*</span></label>
                                <input type="text" name="patient_reg_id" id="patient_reg_id" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Patient Name <span class="text-danger">*</span></label>
                                <input type="text" name="patient_name" id="patient_name" class="form-control" required data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>Patient Phone No. <span class="text-danger">*</span></label>
                                <input type="text" name="patient_phone_no" id="patient_phone_no" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Patient Address </label>
                                <input type="text" name="patient_address" id="patient_address" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label>Admission Date </label>
                                <input type="text" name="admission_date" id="admission_date" readonly class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Quarantine Days <span class="text-danger">*</span></label>
                                <input type="text" name="quarantine_days" id="quarantine_days" class="form-control" required data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>Quarantine Reason <span class="text-danger">*</span></label>
                                <input type="text" name="quarantine_reason" id="quarantine_reason" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Patient Image <span class="text-danger">*</span></label>
                        <br />
                        <input type="file" name="patient_profile_image" id="patient_profile_image" />
                        <div id="uploaded_image"></div>
                        <input type="hidden" name="hidden_patient_profile_image" id="hidden_patient_profile_image" />
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- This HTML to view patient details from the patient list -->
<div id="viewModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">View Patient Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="patient_details">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>

    //javascript for print out the patient list, datatable json

$(document).ready(function(){

    var dataTable = $('#patients_table').DataTable({
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "ajax" : {
            url:"patient_action1.php",
            type:"POST",
            data:{action:'fetch'}
        },
        "columnDefs":[
            {
                "targets":[0, 1, 2, 4, 5, 6, 7],
                "orderable":false,
            },
        ],
    });

    $('#admission_date').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

    $('#add_patient').click(function(){
        
        $('#patient_form')[0].reset();

        $('#patient_form').parsley().reset();

        $('#modal_title').text('Add Patient');

        $('#action').val('Add');

        $('#submit_button').val('Add');

        $('#pModal').modal('show');

        $('#form_message').html('');

    });

    $('#patient_form').parsley();

    $('#patient_form').on('submit', function(event){
        event.preventDefault();
        if($('#patient_form').parsley().isValid())
        {       
            $.ajax({
                url:"patient_action1.php",
                method:"POST",
                data: new FormData(this),
                dataType:'json',
                contentType: false,
                cache: false,
                processData:false,
                beforeSend:function()
                {
                    $('#submit_button').attr('disabled', 'disabled');
                    $('#submit_button').val('wait...');
                },
                success:function(data)
                {
                    $('#submit_button').attr('disabled', false);
                    if(data.error != '')
                    {
                        $('#form_message').html(data.error);
                        $('#submit_button').val('Add');
                    }
                    else
                    {
                        $('#pModal').modal('hide');
                        $('#message').html(data.success);
                        dataTable.ajax.reload();

                        setTimeout(function(){

                            $('#message').html('');

                        }, 5000);
                    }
                }
            })
        }
    });


    $(document).on('click', '.edit_button', function(){

        var patient_id = $(this).data('id');

        $('#patient_form').parsley().reset();

        $('#form_message').html('');

        $.ajax({

            url:"patient_action1.php",

            method:"POST",

            data:{patient_id:patient_id, action:'fetch_single'},

            dataType:'JSON',

            success:function(data)
            {

                $('#patient_ic').val(data.patient_ic);

                $('#patient_ic').val(data.patient_ic);
                $('#patient_reg_id').val(data.patient_reg_id);
                $('#patient_name').val(data.patient_name);
                $('#uploaded_image').html('<img src="'+data.patient_profile_image+'" class="img-fluid img-thumbnail" width="150" />')
                $('#hidden_patient_profile_image').val(data.patient_profile_image);
                $('#patient_phone_no').val(data.patient_phone_no);
                $('#patient_address').val(data.patient_address);
                $('#admission_date').val(data.admission_date);
                $('#quarantine_days').val(data.quarantine_days);
                $('#quarantine_reason').val(data.quarantine_reason);

                $('#modal_title').text('Edit Patient');

                $('#action').val('Edit');

                $('#submit_button').val('Edit');

                $('#pModal').modal('show');

                $('#hidden_id').val(patient_id);

            }

        })

    });


    $(document).on('click', '.status_button', function(){
        var id = $(this).data('id');
        var status = $(this).data('status');
        var next_status = 'QUARANTINE';
        if(status == 'QUARANTINE')
        {
            next_status = 'COVID-19+';
        }
        if(confirm("This Patient Status will be changed to "+next_status+". Press OK to confirm the action."))
        {

            $.ajax({

                url:"patient_action1.php",

                method:"POST",

                data:{id:id, action:'change_status', status:status, next_status:next_status},

                success:function(data)
                {

                    $('#message').html(data);

                    dataTable.ajax.reload();

                    setTimeout(function(){

                        $('#message').html('');

                    }, 5000);

                }

            })

        }
    });

    $(document).on('click', '.view_button', function(){
        var patient_id = $(this).data('id');

        $.ajax({

            url:"patient_action1.php",

            method:"POST",

            data:{patient_id:patient_id, action:'fetch_single'},

            dataType:'JSON',

            success:function(data)
            {
                var html = '<div class="table-responsive">';
                html += '<table class="table">';

                html += '<tr><td colspan="2" class="text-center"><img src="'+data.patient_profile_image+'" class="img-fluid img-thumbnail" width="150" /></td></tr>';

                html += '<tr><th width="40%" class="text-right">Patient No IC</th><td width="60%">'+data.patient_ic+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Patient Registration ID</th><td width="60%">'+data.patient_reg_id+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Patient Name</th><td width="60%">'+data.patient_name+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Patient Phone No.</th><td width="60%">'+data.patient_phone_no+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Patient Address</th><td width="60%">'+data.patient_address+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Admission Date</th><td width="60%">'+data.admission_date+'</td></tr>';
                html += '<tr><th width="40%" class="text-right">Quarantine Days</th><td width="60%">'+data.quarantine_days+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Quarantine Reason</th><td width="60%">'+data.quarantine_reason+'</td></tr>';

                html += '</table></div>';

                $('#viewModal').modal('show');

                $('#patient_details').html(html);

            }

        })
    });

    $(document).on('click', '.delete_button', function(){

        var id = $(this).data('id');

        if(confirm("Are you sure you want to remove it?"))
        {

            $.ajax({

                url:"patient_action1.php",

                method:"POST",

                data:{id:id, action:'delete'},

                success:function(data)
                {

                    $('#message').html(data);

                    dataTable.ajax.reload();

                    setTimeout(function(){

                        $('#message').html('');

                    }, 5000);

                }

            })

        }

    });



});
</script>