
<?php   
    require_once $_SERVER['DOCUMENT_ROOT'].'/psa_hris/db.php';
    
    session_start();
    include 'header.php';

    date_default_timezone_set('Asia/Manila');
    $datenow = date("Y-m-d");
    $fields=[];
    $types="";
    $fields+=["emp_status"=>0];
    $types.="ss";
    $db->update_one("employee_list",$fields,$types,"emp_endDate <",$datenow);

   $fields=[];
    $types="";
    $fields+=["emp_man_NBI_expDate"=>NULL];
    $types.="ss";
    $db->update_one("employee_list",$fields,$types,"emp_man_NBI_expDate <",$datenow);

    $fields=[];
    $types="";
    $fields+=["emp_man_status"=>1];
    $types.="ss";
    $db->update_one("employee_list",$fields,$types,"emp_man_SSS IS NOT NULL
                                                    AND emp_man_PhilHealth IS NOT NULL
                                                    AND ((emp_man_NBI_expDate IS NOT NULL OR emp_man_NBI_expDate != 0000-00-00) OR emp_man_NBI_ORNum IS NOT NULL) 
                                                    AND emp_man_polClear IS NOT NULL
                                                    AND emp_man_brgyClear IS NOT NULL
                                                    AND emp_man_polClear != 0
                                                    AND emp_man_brgyClear !",'0');

    
    $fields=[];
    $types="";
    $fields+=["emp_man_status"=>0];
    $types.="ss";
    $db->update_one("employee_list",$fields,$types,"emp_man_SSS IS NULL
                                                    OR emp_man_PhilHealth IS NULL
                                                    OR emp_man_PAGIBIG IS NULL
                                                    OR ((emp_man_NBI_expDate IS NULL OR emp_man_NBI_expDate = 0000-00-00) AND (emp_man_NBI_ORNum IS NULL OR emp_man_NBI_ORNum =''))
                                                    OR emp_man_polClear IS NULL
                                                    OR emp_man_brgyClear IS NULL
                                                    OR emp_man_polClear = 0
                                                    OR emp_man_brgyClear",0);



?>
<body>

<title>Employee</title>
<div class="container-fluid container-main">
    <div class="card">
        <div class="header">
            <h1>
                Employee
                <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#addModal"> <i class="glyphicon glyphicon-plus" style="margin-right: 4px;"></i> Add Employee </button>
            </h1>
        </div>
       
        <div class="body">
            <table id="employeelist" class="table table-hover table-bordered nowrap">
            <thead class="">
                <tr>
                    <th>Name</th>
                    <th>fname</th>
                    <th>Birthday</th>
                    <th>Employment Status</th>
                    <th>End Date</th>
                    <th>Agency</th>
                    <th>Account</th>
                    <th>Start Date</th>
                    <th>Mandatories</th>
                    <th></th>
                </tr>
            </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade inline" data-backdrop="static" id="addModal" tabindex="-1" role="dialog">
  <div class="modal-lg modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
            <h3>
                Add Employee
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </h3>
        </div>
         <div class="modal-body">
           
        <form class="form-horizontal" id="addForm" action="employeesCRUD.php" method="POST">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td><strong>Employee First Name</strong></td>
                    <td><div class="form-group"><input type="text" class="form-control" name="empfname" id="empfname" placeholder="Enter First Name"></div></td>
                </tr>
                <tr>
                    <td><strong>Employee Last Name</strong></td>
                    <td><div class="form-group"><input type="text" class="form-control" name="emplname" id="emplname" placeholder="Enter Last Name"></div></td>
                </tr>
                <tr>
                    <td><strong>Employee Middle Name</strong></td>
                    <td><div class="form-group"><input type="text" class="form-control" name="empmname" id="empmname" placeholder="Enter Middle Name"></div></td>
                </tr>
                <tr>
                    <td><strong>Account Name</strong></td>
                    <td><div class="form-group"><select class='form-control' name="empacct" id="empacct">
                        <option selected hidden>Please Choose</option>
                        <?php foreach($db->select_all("account_list WHERE account_status='1' ORDER by account_principal ASC ") as $assocaccount){?>
                            <option id='<?php echo $assocaccount['account_principal']?>' value='<?php echo $assocaccount['account_id']?>'><?php echo $assocaccount['account_principal']?></option>
                        <?php }?>
                        </select></div>
                    </td>
                </tr>
                
                <tr>
                    <td><strong>Birth Date</strong></td>
                    <td><div class="form-group"><input type="date" class="form-control" name="empbday" id="empbday"></div></td>
                </tr>
                 <tr>
                    <td><strong>Gender</strong></td>
                    <td>
                        <div class="form-group"><select class="form-control" name="empsex" id="empsex">
                            <option selected hidden>Please Choose</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select></div>
                    </td>
                </tr>
                <tr>
                    <td><strong>E-mail</strong></td>
                    <td><div class="form-group"><input type="text" class="form-control" name="empemail" id="empemail" placeholder="Enter E-mail Address"></div></td>
                </tr>
                <tr>
                    <td><strong>Contact Number</strong></td>
                    <td><div class="form-group"><input type="number" class="form-control" name="empcn" id="empcn" placeholder="Enter Contact Number"></div></td>
                </tr>
                <tr>
                    <td><strong>Agency</strong></td>
                    <td>
                        <div class="form-group">
                            <select class="form-control" name="" id="">
                                <option selected hidden>Please Choose</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Account</strong></td>
                    <td>
                        <div class="form-group">
                            <select class="form-control" name="" id="">
                                <option selected hidden>Please Choose</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Employee Position</strong></td>
                    <td>
                        <div class="form-group">
                        <!--<input type="text" class="form-control" name="emppos" id="emppos">-->
                            <select class="form-control" name="emppos" id="emptype">
                                <option selected hidden>Please Choose</option>
                                <?php
                                    $result=$db->query("SELECT * FROM position");
                                    while($row=$result->fetch_assoc()){
                                        echo "<option value=".$row['pos_id'].">".$row['job_pos']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Employment Type</strong></td>
                    <td>
                        <div class="form-group"><select class="form-control" name="emptype" id="emptype">
                            
                            <?php
                                $result=$db->query("SELECT * from employment_type");
                                while($row=$result->fetch_assoc()){
                                    ?>
                                    <option value="<?=$row['emp_type_id']?>"><?=$row['emp_type']?></option>
                                    <?php
                                }
                            ?>
                        </select></div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Start Date</strong></td>
                    <td><div class="form-group"><input type="date" class="form-control" name="empdh" id="empdh"></div></td>
                </tr>
                <tr>
                <!--
                    <td><strong>End Date</strong></td>
                    <td><div class="form-group"><input type="date" class="form-control" name="emped" id="emped"></div></td>
                </tr>
                -->
                <tr>
                    <td><strong>Address</strong></td>
                    <td><div class="form-group"><textarea class="form-control" name="empadd" id="empadd" placeholder="Enter Complete Address"></textarea> </div></td>
                </tr>
                <tr>
                    <td><strong>Emergency Contact Person</strong></td>
                    <td><div class="form-group"><input type="text" class="form-control" name="empecp" id="empecp" placeholder="Enter Complete Name"></div></td>
                </tr>
                <tr>
                    <td><strong>Emergency Contact Number</strong></td>
                    <td><div class="form-group"><input type="number" class="form-control" name="empecn" id="empecn" placeholder="Enter Contact Number"></div></td>
                </tr>
                 <tr>
                    <td><strong>Civil Status</strong></td>
                    <td>
                        <div class="form-group">
                            <!--<input type="text" class="form-control" name="empcs" id="empcs">-->
                            <select class="form-control" name="empcs" id="empcs">
                                <option selected hidden>Please Choose</option>
                                <option value='SINGLE'>Single</option>
                                <option value='MARRIED'>Married</option>
                                <option value='WIDOWED'>Widowed</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Number Of Children<br></strong>
                        <em class="small">If none, select 0.</em>
                    </td>
                    <td><div class="form-group"><input type="number" min='0' class="form-control" name="empchiln" id="empchiln" placeholder="X"></div></td>
                </tr>
                <tr>
                    <td><strong>SSS Registration Number</strong></td>
                    <td><input type="text" class="form-control" name="SSS" id="SSS" placeholder="XX-XXXXXXX-X"></td>
                </tr>
                <tr>
                    <td><strong>PhilHealth Registration Number</strong></td>
                    <td><input type="text" class="form-control" name="Philhealth" id="Philhealth" placeholder="XX-XXXXXXXXX-X"></td>
                </tr>
                <tr>
                    <td><strong>PAG-IBIG Registration Number</strong></td>
                    <td><input type="text" class="form-control" name="Pag-ibig" id="Pag-ibig" placeholder="XXXX-XXXX-XXXX"></td>
                </tr>
                <tr>
                    <td>
                        <strong>NBI Clearance<br></strong>
                        <em class="small">Please choose one.</em>
                    </td>
                    <td>
                        <input type="date" class="form-control" placeholder="Expiration Date"  name="NBI1" id="NBI1"><br>
                        <input type="text" class="form-control" placeholder="O.R. Number" name="NBI2" id="NBI2">
                    </td>
                </tr>
                <tr>
                    <td><strong>Police Clearance</strong></td>
                    <td>
                        <select class="form-control" name="Policeclr" id="Policeclr">
                            <option selected hidden>Please Choose</option>
                            <option value='0'>Not Submitted</option>
                            <option value='1'>Submitted</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Barangay Clearance</strong></td>
                    <td>
                        <select class="form-control" name="Brgyclr" id="Brgyclr">
                            <option selected hidden>Please Choose</option>
                            <option value='0'>Not Submitted</option>
                            <option value='1'>Submitted</option>
                        </select>
                    </td>
                </tr>
                </tbody>
            </table>
             
            
         
          <div class="modal-footer">
            <button type="submit" name="addemployee" value="add" class="btn btn-primary">
                <span class="glyphicon glyphicon-check" style="margin-right: 4px;"></span> Submit
            </button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">
                <span class="glyphicon glyphicon-remove" style="margin-right: 4px;"></span> Close
            </button>
          </div>
         </form>
     </div>
    </div>
  </div>
</div>


 <div id="EmpHismodal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h3>
                Employment History
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </h3>
        </div>
        
        <div class="modal-body">
           
            <table class="table table-bordered" id="employeehistory">
                <label></label>
                <thead>
                <tr>
                    <th>Agency</th>
                    <th>Account</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reason for Leaving</th>
                </tr>
                </thead>
                
                <tbody>
                    <tr>
                        
                    </tr>
                </tbody>
            </table>
        </div>      
    </div>
    </div>
</div>

<div id="upManModal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h3>
                Mandatories
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </h3>
        </div>

        <div class="modal-body">
            <form id="manform">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td><strong>SSS Registration Number</strong></td>
                    <td><input type="text" class="form-control" name="vmSSS" id="vmSSS" placeholder="XX-XXXXXXX-X"></td>
                </tr>
                <tr>
                    <td><strong>PhilHealth Registration Number</strong></td>
                    <td><input type="text" class="form-control" name="vmPhilhealth" id="vmPhilhealth" placeholder="XX-XXXXXXXXX-X"></td>
                </tr>
                <tr>
                    <td><strong>PAG-IBIG Registration Number</strong></td>
                    <td><input type="text" class="form-control" name="vmPag-ibig" id="vmPag-ibig" placeholder="XXXX-XXXX-XXXX"></td>
                </tr>
                <tr>
                    <td>
                        <strong>NBI Clearance<br></strong>
                        <em class="small">Please choose one.</em>
                    </td>
                    <td>
                        <input type="date" class="form-control" placeholder="Expiration Date"  name="vmNBI1" id="vmNBI1"><br>
                        <input type="text" class="form-control" placeholder="O.R. Number" name="vmNBI2" id="vmNBI2">
                    </td>
                </tr>
                <tr>
                    <td><strong>Police Clearance</strong></td>
                    <td>
                        <select class="form-control" name="vmPoliceclr" id="vmPoliceclr">
                            <option selected hidden>Please Choose</option>
                            <option value='0'>Not Submitted</option>
                            <option value='1'>Submitted</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Barangay Clearance</strong></td>
                    <td>
                        <select class="form-control" name="vmBrgyclr" id="vmBrgyclr">
                            <option selected hidden>Please Choose</option>
                            <option value='0'>Not Submitted</option>
                            <option value='1'>Submitted</option>
                        </select>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
        </div>

        <div class="modal-footer">
        </div>
    </div>
    </div>
</div>


 <script type="text/javascript">
    
function edit(row = null){
    var today = new Date().toISOString().split('T')[0];
    //replace end date column
    var endate = $('#endate'+row).html();
    var endateAr = endate.split('-');
    var newendate = endateAr[0] + '-' + endateAr[1] + '-' + endateAr[2];
    var rep = "<td><input type='date' min='"+today+"'  id='emp_endDate"+row+"'  value='"+$.trim(newendate)+"' class='form-control'></td>"
    $('#endate'+row).replaceWith(rep);

    //replace action column
    var repA ="<td id='action"+row+"' style='text-align:center;'><button type='button' onclick='upEdate("+row+")'class='btn btn-primary save_a'><span class='glyphicon glyphicon-check' style='margin-right: 4px;'></span> Save</button><button type='button' class='btn btn-primary cancel_a'><span class='glyphicon glyphicon-ban-circle' style='margin-right: 4px;'></span>Cancel</button></td>"
    $('#action'+row).replaceWith(repA);

    //replace hired date column
    var hiredate = $('#hiredate'+row).html();
    var hiredateAr = hiredate.split('-');
    var newhiredate = hiredateAr[0] + '-' + hiredateAr[1] + '-' + hiredateAr[2];
    var repH = "<td><input id='emp_startDate"+row+"' min='"+today+"'type='date' value='"+$.trim(newhiredate)+"' class='form-control'></td>"
    $('#hiredate'+row).replaceWith(repH);

     //replace account column
    var account = $('#account'+row).text();
    $.ajax({ 
            type: "POST",
            datatype:"json",
            url: "employeesCRUD.php",   
            data:"fetchAccount=" + 1 + "&empId=" + row,      
            success: function(data){
                $('#account'+row).replaceWith(data);
                $('#accountinput'+row+ ' option[id="'+account+'"]').attr("selected","true");
            }
    });
    

}

function viewHistory(row = null){

    
   $.ajax({ 
            type: "POST",
            datatype:"json",
            url: "employeesCRUD.php",   
            data:"&empId=" + row +"&retrievehistory="+1,      
            success: function(data){
                if (!$.trim(data)){ 
                var td = '<td class="text-center" colspan="5">No Records Found</td>';   
                    $("#employeehistory tbody tr").html(td);   
                }
                else{   
                   var rdata = JSON.parse(data);
                           var td = '<td>'+rdata.empmHisto_agency+'</td>'+
                                    '<td>'+rdata.empmHisto_account+'</td>'+
                                    '<td>'+rdata.empmHisto_sDate+'</td>'+
                                    '<td>'+rdata.empmHisto_eDate+'</td>'+
                                    '<td>'+rdata.empmHisto_RFL+'</td>'; 
                    $("#employeehistory tbody tr").html(td);                      
                    
                }
            }
        });
}
function updateMan(row = null){
    var thisform = $('#manform');
    var disabled = thisform.find(':input:disabled').removeAttr('disabled');
    var serialized = thisform.serialize();
    disabled.attr('disabled','true');
     $.ajax({ 
            type: "POST",
            datatype:"json",
            url: "employeesCRUD.php",   
            data:serialized + "&updateMan=" + 1 + "&empId=" + row,      
            success: function(data){
            }
    });

}

function viewMan(row = null){
    
  var manStat = $('#mandatory'+row).attr('complete');
  if(manStat == 'true'){
    $('#upManModal input ').attr('disabled','true')
    $('#upManModal select').attr('disabled','true')
    var footerButton1 = "<div class='modal-footer'><button type='button' class='btn btn-primary' data-dismiss='modal'><span class='glyphicon glyphicon-remove' style='margin-right:  4px'></span>Close</button></div>"
    $('#upManModal .modal-footer ').replaceWith(footerButton1);

    $.ajax({ 
            type: "POST",
            datatype:"json",
            url: "employeesCRUD.php",   
            data:"&empId=" + row + 
                "&fetchMandatory="+1,      
            success: function(data){
                //alert(data);
                var rdata = JSON.parse(data);
                $('#vmSSS').val(rdata.emp_man_SSS);
                $('#vmPhilhealth').val(rdata.emp_man_PhilHealth);
                $('#vmPag-ibig').val(rdata.emp_man_PAGIBIG);
                $('#vmNBI1').val(rdata.emp_man_NBI_expDate);
                $('#vmNBI2').val(rdata.emp_man_NBI_ORNum);
                $('#vmPoliceclr').val(rdata.emp_man_polClear);
                $('#vmBrgyclr').val(rdata.emp_man_brgyClear);
                
            }
    });
  }else{
    $('#upManModal input').removeAttr('disabled')
    $('#upManModal select').removeAttr('disabled')
    var footerButton2 = "<div class='modal-footer'><button type='button' class='btn btn-primary' data-dismiss='modal' onclick='updateMan("+row+")' ><span class='glyphicon glyphicon-check'style='margin-right: 4px;'></span>Save</button><button type='button' class='btn btn-primary' data-dismiss='modal'><span class='glyphicon glyphicon-ban-circle' style='margin-right: 4px;'></span>Cancel</button></div>"
    $('#upManModal .modal-footer ').replaceWith(footerButton2);
    $.ajax({ 
            type: "POST",
            datatype:"json",
            url: "employeesCRUD.php",   
            data:"&empId=" + row + 
                "&fetchMandatory="+1,      
            success: function(data){
                var rdata = JSON.parse(data);
                
                if(rdata.emp_man_SSS == null || rdata.emp_man_SSS == ''){
                     $('#vmSSS').val(null);
                }else{
                    $('#vmSSS').val(rdata.emp_man_SSS);
                    $('#vmSSS').attr('disabled','true');
                }
                if(rdata.emp_man_PhilHealth == null || rdata.emp_man_PhilHealth == ''){
                    $('#vmPhilhealth').val('');
                }else{
                    $('#vmPhilhealth').val(rdata.emp_man_PhilHealth);
                    $('#vmPhilhealth').attr('disabled','true');
                }
                if(rdata.emp_man_PAGIBIG == null || rdata.emp_man_PAGIBIG == ''){
                     $('#vmPag-ibig').val(null);
                }else{
                    $('#vmPag-ibig').val(rdata.emp_man_PAGIBIG);
                    $('#vmPag-ibig').attr('disabled','true');
                }
                if(rdata.emp_man_NBI_expDate == null|| rdata.emp_man_NBI_expDate =='0000-00-00'){
                    $('#vmNBI1').val(null);
                }else{
                    $('#vmNBI1').val(rdata.emp_man_NBI_expDate);
                    $('#vmNBI1').attr('disabled','true');
                }
                if(rdata.emp_man_NBI_ORNum == null){
                    $('#vmNBI2').val();
                }else {
                    $('#vmNBI2').val(rdata.emp_man_NBI_ORNum);
                    $('#vmNBI2').attr('disabled','true');
                }
                if(rdata.emp_man_polClear ==1){
                    $('#vmPoliceclr').val(1);
                    $('#vmPoliceclr').attr('disabled','true');
                }else{
                    $('#vmPoliceclr').val(0);
                }
                if(rdata.emp_man_brgyClear ==1){
                    $('#vmBrgyclr').val(1);
                    $('#vmBrgyclr').attr('disabled','true');
                }else{
                    $('#vmBrgyclr').val(0);
                }
                
            }
    });
    
  }
}

function upEdate(row = null){
    var enddate = $('#emp_endDate'+row).val();
    var updateaccount = $('#accountinput'+row).val();
    var startdate = $('#emp_startDate'+row).val();
    
   if(!$.trim(updateaccount) || !$.trim(startdate)){
         $.ajax({ 
            type: "POST",
            datatype:"json",
            url: "employeesCRUD.php",   
            data:"&empId=" + row + 
                "&enddate=" + enddate +
                "&updateEnd="+1,      
            success: function(data){
                location.reload();
            }
        });

   }else{
        var datainput = "&empId=" + row + 
                        "&enddate=" + enddate +
                        "&updateaccount=" + updateaccount +
                        "&startdate=" +startdate +
                        "&updateAll="+ 1;
        $.ajax({ 
            type: "POST",
            datatype:"json",
            url: "employeesCRUD.php",   
            data:datainput,      
            success: function(data){
                location.reload();
            }
        });
   }
}

 $(document).ready(function() {
    var today = new Date().toISOString().split('T')[0];
    $('#employeelist').DataTable({
            "scrollX": true,
            "lengthChange": true,
            "pageLength": 10,
            lengthMenu: [[10,25, 100, -1], [10, 25, 100, "All"]],
            dom: 'lBfrtip',
            'autowidth': true,
            buttons: [{
            extend: 'excelHtml5',
            text: '<img style="height:25px" src="https://png.icons8.com/color/50/000000/ms-excel.png">',
            exportOptions: {
                    columns: "0,2,3,4,5,6,7"},
        }],
            "processing": true,
            "serverSide": true,
            "ajax": "fetch.php?fetch=employee",

            "columnDefs": [
                {"render": function ( data, type, row ){
                    return '<div data-target="#EmpHismodal" data-toggle="modal" onclick="viewHistory('+row[9]+')" style="cursor:pointer;">'+row[0]+', '+row[1]+'</div>'; },
                    "targets": 0 },
                { "visible": false,  "targets": [ 1 ] },
                {"render": function ( data, type, row ){
                    if(row[3]==1){
                        return '<div class="text-center"><span class="label label-success">Active</span></div>';
                    }else{
                        return '<div class="text-center"><span class="label label-danger">Inactive</span></div>';
                }; },
                "targets": 3 },
                {"render": function ( data, type, row ){
                    if(row[3]==1){
                        return '<div id ="endate'+row[9]+'" style="text-align:center"><input min="'+today+'" id="emp_endDate' +row[9]+'" type="date" value="'+row[4]+'" class="form-control"></div>';
                    }else{
                        return '<div id ="endate'+row[9]+'" style="text-align:center">'+row[4]+'</div>';
                }; },
                "targets": 4 },
                {"render": function ( data, type, row ){
                    return '<p id="account'+row[9]+'">'+row[6]+'</p>';
                },
                "targets": 6},
                {"render": function ( data, type, row ){
                    return '<div id ="hiredate'+row[9]+'">'+row[7]+'</div>';
                },
                "targets": 7, },
                {"render": function ( data, type, row ){
                    if(row[8]==1){
                        return '<div style="text-align:center;"><button type="button" data-target="#upManModal" data-toggle="modal" id="mandatory'+row[9]+'" complete="true" onclick="viewMan('+row[9]+')" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open" style="margin-right: 4px;"></span>View</button></div>';
                    }else{
                        return '<div style="text-align:center;"><button type="button" complete="false" data-target="#upManModal" id="mandatory'+row[9]+'"  data-toggle="modal" onclick="viewMan('+row[9]+')" class="btn btn-primary edit_a"><span class="glyphicon glyphicon-pencil" style="margin-right: 4px;"></span>Update</button></div>';
                    }; },
                "targets": 8 },
                {"render": function ( data, type, row ){
                    if(row[3]==1){
                        return '<div id="action'+row[9]+'" style="text-align:center;"><button type="submit" onclick="upEdate('+row[9]+')" class="btn btn-primary save_a"><span class="glyphicon glyphicon-check" style="margin-right: 4px;"></span>Save</button>'+
                    '<button type="button" class="btn btn-primary cancel_a"><span class="glyphicon glyphicon-ban-circle" style="margin-right: 4px;"></span>Cancel</button></div>';
                    }else{
                        return '<div id="action'+row[9]+'" style="text-align:center;"><button type="button"  onclick="edit('+row[9]+')" class="btn btn-primary edit_a"><span class="glyphicon glyphicon-edit" style="margin-right: 4px;"></span>Edit</button></div>';
                    }; },
                "targets": 9 },
            ]
    });
   
    $('#employeelist_wrapper .row:nth-child(2)').css("overflow-x","scroll");

    $.validator.setDefaults({
            errorClass:"help-block",
            highlight: function(element){
                $(element)
                .closest('.form-group')
                .addClass('has-error');
            },
            unhighlight: function(element){
                $(element)
                .closest('.form-group')
                .removeClass('has-error');
            }
        });

    $('#addForm').validate({
            
            rules:{
                empfname:{
                    required:true,
                },
                emplname:{
                    required:true,
                },
                empmname:{
                    required:true,
                },
                empbday:{
                    required:true,
                },
                empacct:{
                    required:true,
                },
                empemail:{
                    required:true,
                },
                empcn:{
                    required:true,
                },
                emppos:{
                    required:true,
                },
                emptype:{
                    required:true,
                },               
                empdh:{
                    required:true,
                },
                emped:{
                    required:true,
                },
                empadd:{
                    required:true,
                },
                empecp:{
                    required:true,
                },
                empcs:{
                    required:true,
                },
               
            }
                });

});



 </script>


</body>