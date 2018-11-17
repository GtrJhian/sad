<?php
session_start();
if(!($_SESSION['access']&0b11)) {
    header('location: session.php');
} else {
    require_once 'db.php';
    include_once "header.php";
?>

<title>Agency</title>
<div class="container-fluid container-main">

    <div class="card">

        <div class="header">
            <h1>
                Agency
                <button type="button" id="addmodal" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addagencymodal">
                <span class="glyphicon glyphicon-plus" style="margin-right: 4px;"></span> Add Agency</button>
            </h1>
        </div>
    
<div class="body">
    <table class="table table-hover table-bordered nowrap " id="agencylist">
        <thead>
        <tr>
            <th>Name</th>
            <th>General Manager</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

</div>   

<!--ADD AGENCY-->
<div id="addagencymodal" class="modal fade inline" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
                        
            <div class="modal-header">
                <h3>
                    New Agency
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </h3>
            </div>
            
            <div class="modal-body">
                <form id="add_agecy" method="post" action="addAgency.php">
                <table class="table table-bordered" id="fields1">
                    <tbody>
                        <tr>
                            <td><strong>Agency Name</strong></td>
                            <td><input name="agency_name" class="form-control" type="text" placeholder="Enter Agency Name" required></td>
                        </tr>
                        <tr>
                            <td><strong>General Manager First Name</strong></td>
                            <td><input name="gm_fname" class="form-control" type="text" placeholder="Enter First Name" required></td>
                        </tr>
                        <tr>
                            <td><strong>General Manager Middle Name</strong></td>
                            <td><input name="gm_mname" class="form-control" type="text" placeholder="Enter Middle Name"></td>
                        </tr>
                        <tr>
                            <td><strong>General Manager Last Name</strong></td>
                            <td><input name="gm_lname" class="form-control" type="text" placeholder="Enter Last Name" required></td>
                        </tr>
                        <tr>
                            <td><strong>E-mail</strong></td>
                            <td><input name="agency_gm_email" class="form-control" type="email" placeholder="Enter E-mail Address" required></td>
                        </tr>
                        <tr>
                            <td><strong>Contact Number</strong></td>
                            <td><input name="agency_contactNumber" class="form-control" type="text" placeholder="Enter Contact Number" required></td>
                        </tr>
                        <tr>
                            <td><strong>SSS Registration Date</strong></td>
                            <td><input name="sss_regdate" class="form-control" type="date"></td>
                        </tr>
                        <tr>
                            <td><strong>PhilHealth Registration Date</strong></td>
                            <td><input name="philhealth_regdate" class="form-control" type="date"></td>
                        </tr>
                        <tr>
                            <td><strong>PAGIBIG Registration Date</strong></td>
                            <td><input name="pagibig_regdate" class="form-control" type="date"></td>
                        </tr>
                        <tr>
                            <td><strong>TIN Number</strong></td>
                            <td><input name="" class="form-control" type="text" placeholder="Enter TIN Number"></td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                <select name="agency_status" class="form-control">
                                    <option selected hidden>Please Choose</option>
                                    <option value=1>Active</option>
                                    <option value=0>Inactive</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </form> 
            </div>
            
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name='submit'> 
                    <span class="glyphicon glyphicon-plus" style="margin-right: 4px;"></span>Add Agency
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <span class="glyphicon glyphicon-ban-circle" style="margin-right: 4px;"></span>Cancel
                </button>
            </div> 
            </form>
                        
            
        </div>
        </div>
        </div>
<!--ADD AGENCY-->

<!--VIEW INFO-->
<div id="viewagencymodal" class="modal fade inline" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title pull-left" id="agency_name"></h3>
                    <button class="btn btn-primary pull-right" id="editbtn">
                        <span class="glyphicon glyphicon-edit" style="margin-right: 4px"></span>Edit
                    </button>
                </div>
                <form id='editAgency' method="post" action="updateAgency.php">
                <div id="fields2" class="modal-body">  
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td><strong>General Manager First Name</strong></td>
                                <td><input id="gm_fname" name="agency_gm_fname" class="form-control" type="text"></td>
                            </tr>
                            <tr>
                                <td><strong>General Manager Middle Name</strong></td>
                                <td><input id="gm_mname" name="agency_gm_mname" class="form-control" type="text"></td>
                            </tr>
                            <tr>
                                <td><strong>General Manager Last Name</strong></td>
                                <td><input id="gm_lname" name="agency_gm_lname" class="form-control" type="text"></td>
                            </tr>
                            <tr>
                                <td><strong>E-mail</strong></td>
                                <td><input id="agency_gm_email" name="agency_gm_email" class="form-control" type="text"></td>
                            </tr>
                            <tr>
                                <td><strong>Contact Number</strong></td>
                                <td><input id="agency_gm_conNum" name="agency_gm_conNum" class="form-control" type="text"></td>
                            </tr>
                            <tr>
                                <td><strong>SSS Registration Date</strong></td>
                                <td><input id="agency_sss_regdate" name="agency_sss_regdate" class="form-control" type="date"></td>
                            </tr>
                            <tr>
                                <td><strong>PhilHealth Registration Date</strong></td>
                                <td><input id="agency_philhealth_regdate" name="agency_philhealth_regdate" class="form-control" type="date"></td>
                            </tr>
                            <tr>
                                <td><strong>PAGIBIG Registration Date</strong></td>
                                <td><input id="agency_pagibig_regdate" name="agency_pagibig_regdate" class="form-control" type="date"></td>
                            </tr>
                            <tr>
                                <td><strong>TIN Number</strong></td>
                                <td><input id="" name"" class="form-control" type="text"</td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>
                                    <select id="agency_status"name="agency_status" class="form-control">
                                        <option value=1>Active</option>
                                        <option value=0>Inactive</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>      
                </div> 
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#viewagencymodal" id='agency_id' name='id' value=''>
                        <span class="glyphicon glyphicon-download" style="margin-right: 4px;"></span>Save
                    </button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remove" style="margin-right: 4px;"></span>Close
                    </button>
                </div>
                </form>
            </div>
        </div>
        </div>
<!--VIEW INFO-->
<?php } ?>

    </div>
    </div>  
    
    </body>
    <script>
    $(document).ready( function() {
        $('#editbtn').click(function(){
            $('#editAgency input').prop('disabled',false);
            $('#editAgency select').prop('disabled',false);
        });
        $('#add_agency').submit(function(e){
           // $('#addagencymodal').modal('hide');
            //e.preventDefault();
           /* $.post(
                'addAgency.php',
                $(this).serialize()+"&submit=1",
                function(response){
                    console.log(response);
                    $('#agencylist').DataTable().ajax.url('ajax.php?table=agency').load()
                    $('#add_agency').trigger('reset');
                }
            );*/
           // return false;
            //return false;
        });
        $('#editAgency').submit(function(e){
           // $('#addagencymodal').modal('hide');
            //alert();
            e.preventDefault();
            $.post(
                'updateAgency.php',
                $(this).serialize()+'&id='+$('#agency_id').val(),
                function(data){
                    console.log(data);
                    $('#agencylist').DataTable().ajax.url('ajax.php?table=agency').load()
                    $('#editAgency').trigger('reset');
                }
            );
            return false;
            //return false;
        });

        $('#agencylist').DataTable(
            {
                "ajax":"ajax.php?table=agency",
                "lengthChange": false,
                "pageLength": 10,
                "lengthMenu": false,
                "order": [[0, 'asc']],
                "columns": [
                    {"type": "string", "width": '30%'},
                    null,
                    {"width": '25%', "className": "dt-center", "orderable": false}
                ]
            } );
    });

    function viewAgency(id){
        $('#editAgency input').prop('disabled',true);
        $('#editAgency select').prop('disabled',true);
        $.ajax({
            url:'ajax.php?agency_id='+id,
            success:function(result){
                var obj=JSON.parse(result);
                $('#agency_name').text(obj.agency_name);
                $('#gm_fname').val(obj.agency_gm_fname);
                $('#gm_mname').val(obj.agency_gm_mname);
                $('#gm_lname').val(obj.agency_gm_lname);
                $('#agency_gm_email').val(obj.agency_gm_email);
                $('#agency_gm_conNum').val(obj.agency_gm_conNum);
                $('#agency_sss_regdate').text(obj.agency_sss_regdate);
                $('#agency_philhealth_regdate').text(obj.agency_philhealth_regdate);
                $('#agency_pagibig_regdate').text(obj.agency_pagibig_regdate);
                $('#agency_status').val(obj.agency_status);
                $('#agency_id').val(obj.agency_id)
            }
        });

    }
    </script>
    
    <script>
        //$("#addagencymodal").hide();
        
        $("#viewagencymodal").hide();

        $("#modal").click(function(){
            $("#viewagencymodal").show();
            $("#gm").attr("disabled",true);
            $("#email").attr("disabled",true);
            $("#cm").attr("disabled",true);
            $("#status").attr("disabled",true);
        });

        $("#editbtn").click(function(){
            $("#gm").attr("disabled",false);
            $("#email").attr("disabled",false);
            $("#cm").attr("disabled",false); 
            $("#status").attr("disabled",false);          
        });

        $(".close").click(function(){
            $("#viewagencymodal").hide();;
        })

    </script>
    <script>
    $('.disabled').click(function(e){
    e.preventDefault();
});
</script>
    </html>
