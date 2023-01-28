<?php
session_start();
require "connect.php";
include "phpcodes.php";
if (!$_SESSION['email']) {
	header('location:login.php');
}
$day_id=$_REQUEST['id'];
$day_name=$_REQUEST['day'];
$allfiledrequired=null;
$data=new TimeManagement;
	
	$allfiledrequired=$dataInsertedWell=$ErrorInsertedWell=null;
	if (isset($_POST['submitdata'])) {
		$stuff=$_POST['thing_todo'];
		$start=$_POST['start_time'];
		$end=$_POST['end_time'];
		$status=$_POST['status'];
		$day=$_POST['day'];
		date_default_timezone_set("Africa/Kigali");
		$date=date('Y-m-d');
		$month=date('M');
		$year=date('Y');

		if (empty($stuff) || empty($start) || empty($status) || empty($end) || empty($day)) {
			$allfiledrequired="<span style='color:red;'>All fields are required !</span>";
		}else{
			$sql="INSERT INTO timemanage values ('','$stuff','$start','$end','$status','$day','$date','$month','$year')";
			$query=mysqli_query($conn,$sql);

			if ($query) {
				$dataInsertedWell="data inserted well";
			}else{
				$ErrorInsertedWell="Error to insert data";
			}
		}

	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Time management</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="card icon" href="style/dist/img/smartcard.jpg">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="style/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="style/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="style/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="style/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="style/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="style/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="style/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.0.1/css/bootstrap-toaster.min.css" integrity="sha512-RLiJ5uLcu8jWxsJBevOZWLU0zWv51vwpha0Gh4jRKOqkcWbVR7+U8kKaiGsMhSua3fIkviCHRClSH+XZYKIoZA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.0.1/css/bootstrap-toaster.css" integrity="sha512-BqX9iUcQY8V8QeSbSjk/vL2CQk8TT5SEp8OeuRO6MMSYfRtVE0DW4eqjmD7Iew2XAoa+iEXIkJQPYXaP0FqWrA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.0.1/js/bootstrap-toaster.js" integrity="sha512-4JwsWzz1l6JIsCUPi1bopU+79qHRCUlOJhYapg5dRuXjFFgXPazVnoOgrvrUMckjJl6LPOM4GncDv3ilou8avQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.0.1/js/bootstrap-toaster.min.js" integrity="sha512-YmkrdAXo8RdHV1JFfepR7QWLDfF7vs8Mc/t+6qKIxrEFeWbi0u/lajryYSPK6GC5nupW5t6XfPdxQpIY79+USg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <style type="text/css">
  	::-webkit-scrollbar{
  		display: none;
  	}
  </style>
</head>
<body style="background-color:#eee;">

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<h2><?php echo $_SESSION['fullname'];?></h2>
				<a href="Logout.php" class="float-right"><i class="fa fa-lock"></i>&nbsp;Logout</a>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4">
			<div class="card">
				<div class="card-header bg-info text-center">Time management</div>
				<div class="card-body">
					<?php echo $allfiledrequired.$dataInsertedWell.$ErrorInsertedWell;
					?>
					<form method="POST">
						<label>Things to do</label>
						<textarea name="thing_todo" rows="3" placeholder="Typing things to do . . . . " class="form-control" autofocus></textarea>
						<div class="row">
							<div class="col-md-6">
								<label>Start_time</label>
								<input type="text" name="start_time" placeholder="08:30:00 am" class="form-control" />
							</div>
							<div class="col-md-6">
								<label>End_time</label>
								<input type="text" name="end_time" placeholder="13:00:00 pm" class="form-control" />
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<label>Status</label>
								<select  name="status" class="form-control"><br>
									<option value="">Select status . . . </option>	
									<option value="Coding">Coding</option>	
									<option value="Not_Coding">Others</option>	
								</select>
							</div>
							<div class="col-md-6">
								<label>Day of week</label>
								<select  name="day" class="form-control"><br>
									<option value="">Select day . . . </option>
									<?php
										$sqlx="SELECT * FROM days_of_week";
										$queryx=mysqli_query($conn,$sqlx);
										while ($row=mysqli_fetch_assoc($queryx)) {
											if ($row['name'] == $day_name && $row['id'] == $day_id) {
												echo '<option value='.$row["id"].' selected>'.$row["name"].'</option>';
											}else{
												echo '<option value='.$row["id"].'>'.$row["name"].'</option>';
											}

										}
									?>									
								</select>
							</div>
						</div>
						<br>
						<button type="submit" name="submitdata" class="btn btn-warning">Submit</button>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-8">

			<div class="card">
				<div class="card-body" style="overflow: auto;">
					<div class="text-center">
						<?php
							$sqlb="SELECT * FROM days_of_week";
							$queryb=mysqli_query($conn,$sqlb);
							while ($row=mysqli_fetch_assoc($queryb)) {
								if ($day_id == $row["id"] && $day_name == $row["name"]) {
									echo '<a href="SingleDay.php?id='.$row["id"].'&day='.$row["name"].'"><button class="btn btn-warning">'.$row["name"].'</button></a>&nbsp;&nbsp;&nbsp;';
								}else{
									echo '<a href="SingleDay.php?id='.$row["id"].'&day='.$row["name"].'"><button class="btn btn-info">'.$row["name"].'</button></a>&nbsp;&nbsp;&nbsp;';

								}
							}
						?>		
					</div>
				</div>
			</div>

			<br>

			<div class="card">
				<div class="card-body" style="overflow: auto;">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>N<sup>o</sup></th>
								<th>Stuff to do</th>
								<th>Start_time</th>
								<th>End_time</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php echo $data->select_time_manag(); ?>
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>

	<script>

		var start_time = document.getElementById('start_Input');
		var end_time = document.getElementById('end_Input');
		function onTimeChange_start() {
		  var timeSplit = start_time.value.split(':'),
		    hours,
		    minutes,
		    meridian;
		  hours = timeSplit[0];
		  minutes = timeSplit[1];
		  if (hours > 12) {
		    meridian = 'PM';
		    hours -= 12;
		  } else if (hours < 12) {
		    meridian = 'AM';
		    if (hours == 0) {
		      hours = 12;
		    }
		  } else {
		    meridian = 'PM';
		  }
		  alert(hours + ':' + minutes + ' ' + meridian);
		}

		function onTimeChange_end() {
		  var timeSplit = end_time.value.split(':'),
		    hours,
		    minutes,
		    meridian;
		  hours = timeSplit[0];
		  minutes = timeSplit[1];
		  if (hours > 12) {
		    meridian = 'PM';
		    hours -= 12;
		  } else if (hours < 12) {
		    meridian = 'AM';
		    if (hours == 0) {
		      hours = 12;
		    }
		  } else {
		    meridian = 'PM';
		  }
		  alert(hours + ':' + minutes + ' ' + meridian);
		}
	</script>
  
<!-- jQuery -->
<script src="style/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="style/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Bootstrap 4 -->
<script src="style/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="style/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="style/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="style/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="style/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="style/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="style/plugins/moment/moment.min.js"></script>
<script src="style/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="style/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="style/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="style/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="style/dist/js/adminlte.js"></script>
<script src="jquery.min.js"></script>
<script src="jquery.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="style/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="style/dist/js/pages/dashboard.js"></script>
</body>
</html>