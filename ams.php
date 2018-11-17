<?php
    session_start();
    if(!($_SESSION['access']&1)) {
        header('location: session.php');
    } else {
        require_once 'db.php';
        include_once "header.php";
    if(isset($_GET["action"])){
        $access=$_GET['access'];
        $id=$_GET['id'];
        $db->query("UPDATE users SET access=$access WHERE id=$id");
    }
?>
    <title>User Management</title>
    <div class="container-fluid container-main">
    <div class="card">
        <div class="header">
            <h1>
                User Management
                <button type="button" id="addUserBtn" class="btn btn-primary pull-right"
                    data-toggle="modal" data-target="#addUserModal">Add User</button>
            </h1>
        </div>
        
        <div class="body">
            <form method="post" action="ams.php" name="accessForm">            
                <table class="table table-hover table-bordered nowrap" id="usm">
                    <thead>
                    <tr>
                        <th>USERNAME</th>
                        <th>OPS</th>
                        <th>COMPBEN</th>
                        <th>HR</th>
                        <th>ACCO</th>
                        <th>ADMIN</th>
                        <th>SA</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            $x=0;
                            foreach($db->select_all("users") as $assoc){
                        ?>
                            <tr>
                                <td><?php echo $assoc['username']?></td>
                                <td><input class="checkbox" type='checkbox' disabled <?php if($assoc['access']&0b100000) echo "checked=true";?>></td>
                                <td><input class="checkbox" type='checkbox' disabled <?php if($assoc['access']&0b010000) echo "checked=true";?>></td>
                                <td><input class="checkbox" type='checkbox' disabled <?php if($assoc['access']&0b001000) echo "checked=true";?>></td>
                                <td><input class="checkbox" type='checkbox' disabled <?php if($assoc['access']&0b000100) echo "checked=true";?>></td>
                                <td><input class="checkbox" type='checkbox' disabled <?php if($assoc['access']&0b000010) echo "checked=true";?>></td>
                                <td><input class="checkbox" type='checkbox' disabled <?php if($assoc['access']&0b000001) echo "checked=true";?>></td>
                                <td hidden><input hidden type='number'  name='access' id="access<?php echo $assoc['id']?>"value=<?php echo $assoc['access']?> /></td>
                                <td>
                                    <input type="button" class="sample btn-primary" value="Edit" id="editbtn<?php echo $x ?>" onclick="enableCheckBox(<?php echo $x?>)">
                                    <input type="button" class="sample btn-danger" value="Cancel" hidden  id="cnclbtn<?php echo $x?>" onclick="disableCheckBox(<?php echo $x?>)"><br>
                                    <input type="button" class="sample btn-info" value="Save" id="savebtn<?php echo $x ?>"hidden onclick="save(<?php echo $assoc['id']?>,<?php echo $x++?>)">
                                </td>
                            </tr>
                        <?php   
                            }
                        ?>
                    </tbody>
                </table>
                <hr>
            </form>

            <!-- Modal -->
            <div class="modal fade" id="addUserModal" role="dialog" data-backdrop="static">
                <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3>
                            Add New User
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </h3>
                    </div>

                    <div class="modal-body">
                        <form action="amsScript.php" name="a">
                        <table class="table table-bordered" id="">
                            <tbody>
                                <tr>
                                    <td><strong>Username</strong></td>
                                    <td><input class="form-control username" type="text" name="username" required minlength=5></td>
                                </tr>
                                <tr>
                                    <td><strong>Password</strong></td>
                                    <td><input id="password1" class="form-control passwordField" type="password" name="password" required minlength=8></td>
                                </tr>
                                <tr>
                                    <td><strong>Confirm Password</strong></td>
                                    <td>
                                        <input id="password2" class="form-control passwordField" type="password" required>
                                        <span id="passwordError"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>E-mail</strong></td>
                                    <td><input class="form-control email" type="email" name="email" required></td>
                                </tr>
                                <tr>
                                    <td><strong>Level of Access</strong></td>
                                    <td style="padding-left: 30px;">
                                        <label><input type="checkbox" name="permissions[]" value="5">Operations</label><br>
                                        <label><input type="checkbox" name="permissions[]" value="4">Compensation & Benefit</label><br>
                                        <label><input type="checkbox" name="permissions[]" value="3">Human Resources</label><br>
                                        <label><input type="checkbox" name="permissions[]" value="2">Accounting</label><br>
                                        <label><input type="checkbox" name="permissions[]" value="1">Admin</label><br>
                                        <label><input type="checkbox" name="permissions[]" value="0">Super Admin</label><br>
                                    </td>
                                </tr>
                                <label>Coordinator: <input type="checkbox" id="isCoor"></label>
                                <select class="form-control" name="account_id" id="account_id">
                                    <?php
                                        $result=$db->query("SELECT account_id,account_principal FROM account_list");
                                        while($row=$result->fetch_assoc()){
                                            ?>
                                            <option value="<?=$row['account_id']?>"><?=$row['account_principal']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </tbody>
                        </table>
                        <div class="modal-footer">
                            <button id="addUser" type="submit" class="btn btn-primary" value="addUser" name="a">Add User</button>
                        </div>
                        </form>
                    </div>
                    
                </div>
                </div>
            </div>
 </body>
<?php } ?>
<script>
    function enableCheckBox(y){
                var x=document.getElementsByClassName("checkbox");
                for(ctr=0; ctr<6; ctr++){
                    x[ctr+(y*6)].disabled=false;
                }
                document.getElementById("savebtn"+y).hidden=false;
                document.getElementById("cnclbtn"+y).hidden=false;
                document.getElementById("editbtn"+y).hidden=true;
                //document.getElementById("savebtn"+y).hidden=false;
            }
            function disableCheckBox(y){
                var x=document.getElementsByClassName("checkbox");
                for(ctr=0; ctr<6; ctr++){
                    x[ctr+(y*6)].disabled=true;
                }
                document.getElementById("savebtn"+y).hidden=true;
                document.getElementById("cnclbtn"+y).hidden=true;
                document.getElementById("editbtn"+y).hidden=false;
            }
            function save(id,y){
                disableCheckBox(y);
                var x=document.getElementsByClassName("checkbox");
                var value=0;
                for(ctr=0; ctr<6; ctr++){
                    if(x[ctr+(y*6)].checked) value+=0b100000>>ctr;
                }
                console.log(value);
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        //document.getElementById("demo").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "ams.php?action=update&id="+id+"&access="+value, true);
                xhttp.send();
            }
</script>

<script>
$(document).ready(function() {
    


    $('#addUserBtn').click(function() {
    });
    $(".passwordField").change(function(){
        if($(".passwordField")[0].value!=$(".passwordField")[1].value){
            $(".passwordField")[1].setCustomValidity("Password Mismatch");
            //$("#addUser").prop("disabled",true);
        }
        else{            
            $(".passwordField")[1].setCustomValidity("");
            $("#addUser").prop("disabled",false);
        }
    });
    
    var ac_id=$('#account_id');
    ac_id.hide();
    $('#isCoor').change(function(){
        ac_id.toggle();
        if(ac_id.is(':hidden')){
            ac_id.prop('name','');
        }
        else ac_id.prop('name','account_id');
    });
    
    
    $('.email').change(function(){
        var emails=JSON.parse('<?=json_encode($db->query("SELECT email FROM users")->fetch_all(MYSQLI_NUM))?>');
        for(ctr=0; ctr<emails.length; ctr++){
            if($('.email')[0].value==emails[ctr]){
                $('.email')[0].setCustomValidity("Email is already in use");
                return;
            }
            $('.email')[0].setCustomValidity("");
        }
    });
    $('.username').change(function(){
        var users=JSON.parse('<?=json_encode($db->query("SELECT username FROM users")->fetch_all(MYSQLI_NUM))?>');
        for(ctr=0; ctr<users.length; ctr++){
            if($('.username')[0].value==users[ctr]){
                $('.username')[0].setCustomValidity("Username is already in use");
                return;
            }
            $('.username')[0].setCustomValidity("");
        }
    });
});
    

</script>