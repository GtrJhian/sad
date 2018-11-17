<?php
	session_start();	
	include_once "header.php";
	include_once "db.php";

	$sql1 = "SELECT * FROM position";
	$sql2 = "SELECT * FROM account_pos";
	$sql3 = "SELECT * FROM employment_type";

	$res1 = $db->query($sql1);
	$res2 = $db->query($sql2);
	$res3 = $db->query($sql3);
    
?>
<html>
<head>
	</head>
		<div class="container-fluid container-main">
			<div class="card">
				
                <div class="header">
					<h1>Content Management</h1>
				</div>

				<div class="body">
					<h3>
						Employees' Job Position
						<input type="button" value="Add Position" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addPosModal">
					</h3>

					<table class="table table-bordered table-hover nowrap tables">
						<thead>
							<th>Position</th>
							<th>Rate</th>
						</thead>
						<tbody>
<?php
					if($res1->num_rows > 0){
						while ($r1 = mysqli_fetch_assoc($res1)) {
?>
							<tr>
								<td><?php echo $r1['job_pos']; ?></td>
								<td><?php echo $r1['rate']; ?></td>
							</tr>
<?php 
						} 
					} else {
						echo 'no data';
					}
?>
						</tbody>
					</table>
				<!--Job Position Modal-->
					<div id="addPosModal" class="modal fade" data-backdrop="static" role="dialog">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h3>
										Add Employee Job Position
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</h3>
								</div>
								<div class="modal-body" id="">
									<form action="empPos.php" method="post">
										<label for="job_pos">Job Position</label>
										<br>
										<input type="text" name="job_pos" id="" required>
										<br>

										<label for="rate">Rate per hour</label>
										<br>
										<input type="number" name="rate" id="" required>
										<br>
								</div>
								<div class="modal-footer">
										<input name="submit" type="submit" value="Add Position" class="btn btn-primary pull-right" data-toggle="modal">
								</div>
									</form>
								     
							</div>
						</div>
					</div>
				<!--Job Position Modal-->
				</div>
            <!--EMPLOYEE JOB POSITION-->


            <!--ACCOUNT PERSONS POSITION-->

				<div class="body">
					<h3>
						Account Persons' Position
						<input type="button" value="Add Position" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addPerModal">
					</h3>

					<table class="table table-bordered table-hover nowrap tables">
						<thead>
							<th>Position</th>
						</thead>

						<tbody>
<?php
					if($res2->num_rows > 0){
						while ($r2 = mysqli_fetch_assoc($res2)) {
?>
							<tr>
								<td><?php echo $r2['position']; ?></td>
							</tr>
<?php 
						} 
					} else {
						echo 'no data';
					}
?>
						</tbody>
					</table>
				<!--Account Persons Position Modal-->
                    <div id="addPerModal" class="modal fade" data-backdrop="static" role="dialog">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h3>
										Add Account Person Job Position
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</h3>
								</div>
								<div class="modal-body" id="">
									<form action="accPos.php" method="post">
										<label for="position">Position</label>
										<br>
										<input type="text" name="position" id="">
										<br>
								</div>
								<div class="modal-footer">
										<input name="submit" type="submit" value="Add Position" class="btn btn-primary pull-right" data-toggle="modal">
								</div>
									</form>
								     
							</div>
						</div>
					</div>
				<!--Account Persons Position Modal-->
				</div>

            <!--ACCOUNT PERSONS POSITION-->

			<!--EMPLOYMENT TYPE-->

				<div class="body">
					<h3>
						Employment Type
						<input type="button" value="Add Type" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addTypeModal">
					</h3>

					<table class="table table-bordered table-hover nowrap tables">
						<thead>
							<th>Employment Type</th>
						</thead>

						<tbody>
<?php
					if($res3->num_rows > 0){
						while ($r3 = mysqli_fetch_assoc($res3)) {
?>
							<tr>
								<td><?php echo $r3['emp_type']; ?></td>
							</tr>
<?php 
						} 
					} else {
						echo 'no data';
					}
?>
						</tbody>
					</table>
				<!--Employment Type Modal-->
                    <div id="addTypeModal" class="modal fade" data-backdrop="static" role="dialog">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h3>
										Add Employment Type
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</h3>
								</div>
								<div class="modal-body" id="">
									<form action="empType.php" method="post">
										<label for="emp_type">Employment Type</label>
										<br>
										<input type="text" name="emp_type" id="">
										<br>
								</div>
								<div class="modal-footer">
										<input name="submit" type="submit" value="Add Type" class="btn btn-primary pull-right" data-toggle="modal">
								</div>
									</form>
								     
							</div>
						</div>
					</div>
				<!--Account Persons Position Modal-->
				</div>

            <!--ACCOUNT PERSONS POSITION-->


			</div>
		</div>
	</body>
</html>
<script>
	$(document).ready(function(){
		$(".tables").DataTable({
			"lengthChange": true,
            "pageLength": 10,
            lengthMenu: [[10,25, 100, -1], [10, 25, 100, "All"]],
            "autoWidth": true
		});
	});
</script>