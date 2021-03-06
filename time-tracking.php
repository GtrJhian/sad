<?php
    session_start();
    if(!($_SESSION['access']&1)) {
        header('location: session.php');
    } else {
        require_once 'db.php';
        include_once "header.php";
?>
    <title>Time Tracking</title>
    <div class="container-fluid container-main">
        <div class="card">
            <div class="header">
                <h1>Time Tracking</h1>
            </div>

            <div class="body">
                <strong>Date : </strong>
                <input type="date" class="input-sm" name="" id="date">
                <br>
                <br>
                <table class="table table-hover table-bordered nowrap" id="time">
                    <thead>
                    <tr>
                        <th>Agency</th>
                        <th>Account</th>
                        <th>Name</th>
                        <th></th>
                    </tr>
                    </thead>
                        
                    <tbody>
                    <tr>
                        <td>Agency A</td>
                        <td>Account A</td>
                        <td>Name</td>
                        <td style="padding-left: 80px;">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#inputTime">
                                Input Time
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!--inputTime Modal-->
                <div id="inputTime" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close btn btn-default" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <div class="modal-body">
                        <form id='setTime'>
                            <table class="table table-bordered">
                                <tbody>
                                    <input type='text'name='date' id='__date' hidden>
                                    <tr>
                                        <td><strong>Date</strong></td>
                                        <td><span type="text" id='_date'></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Agency</strong></td>
                                        <td><span id='_agency'></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Account</strong></td>
                                        <td><span id='_account'></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Employee</strong></td>
                                        <td>
                                            <span id='_employee'></span><br><br>
                                            <input type="radio" name="dayStat" value="0"> Absent <br>
                                            <input type="radio" name="dayStat" value="1" > Present <br>
                                            <input type="radio" name="dayStat" value="2"> Day off <br>
                                            <span id="timeIn">
                                                <br>
                                                <label>Time In:
                                                    <input class="form-control" type="time" name='time_in'>
                                                </label><br>

                                                <label>Time Out:</label>
                                                <input class="form-control" type="time" name='time_out'>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> 
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" data-toggle="modal"  data-target='#inputTime' name='emp_id' id='_id'>
                                <strong class="glyphicon glyphicon-download" style="margin-right: 4px;"></strong>
                                Save
                            </button>
                        </div>
                        </form>
                    </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
<?php } ?>

    <script>
        function setTime(id){
            $.post('ajax.php?setTime=1&emp_id='+id,function(data){
                var obj=JSON.parse(data);
                $('#_id').val(id);
                $('#_date').text($('#date').val());
                $('#__date').val($('#date').val());
                $('#_agency').text(obj.agency_name);
                $('#_account').text(obj.account_principal);
                $('#_employee').text(obj.name);
            });
        }
    $(document).ready( function() {
       // $('#date').datetimepicker();
        $('#timeIn').hide();
        $('#date').val('<?php echo date('Y-m-d');?>');        
        $('#date').change(function(){
            $('#time').DataTable().ajax.url('ajax.php?table=dtr&date='+$('#date').val()).load();
        });
        $('#setTime').submit(function(e){
           e.preventDefault();
            $.post('time_script.php',$(this).serialize()+'&emp_id='+$('#_id').val(),function(data){
                console.log(data);
                $('#time').DataTable().ajax.url('ajax.php?table=dtr&date='+$('#date').val()).load();
            });
            return false;
        });
        $('#time').DataTable({
            searching: true,
            "lengthChange": true,
            "pageLength": 10
        });
        $('#time').DataTable().ajax.url('ajax.php?table=dtr&date='+$('#date').val()).load();
        $('input[type=radio][name=dayStat]').change(function() {
        if (this.value == 0 || this.value == 2) {
            $('#timeIn').hide();
            $('#timeIn').hide();
        } else if (this.value == 1) {
            $('#timeIn').show();
            $('#timeIn').show();
        }
    });
    });
    </script>