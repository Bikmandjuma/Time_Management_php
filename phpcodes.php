<?php
	class TimeManagement{
		function add_time_manag(){
			require "connect.php";
			$allfiledrequired=null;
			if (isset($_POST['submitdata'])) {
				$stuff=$_POST['thing_todo'];
				$start_time=$_POST['start_time'];
				$end_time=$_POST['end_time'];
				$status=$_POST['status'];
				$day=$_POST['day'];

				if (empty($stuff) || empty($period) || empty($status) || empty($day)) {
					$allfiledrequired="<span style='color:red;'>All fields are required !</span>";
				}else{
					$sql="INSERT INTO timemanage values ('','$stuff','$start_time','$end_time','$status','$day')";
					$query=mysqli_query($conn,$sql);

					if ($query) {
						echo "data inserted well";
					}
				}
			}
			
			
		}

		function select_time_manag(){
			require "connect.php";
			$day_id=$_REQUEST['id'];
			$day_name=$_SESSION['today']=$_REQUEST['day'];
			$sql="SELECT * FROM timemanage where fk_days_id =".$day_id."";
			$query=mysqli_query($conn,$sql);
			$numbers=mysqli_num_rows($query);;
			$count=1;
			while ($row=mysqli_fetch_assoc($query) ) {
				
				 echo "
					 	<tr>
							<td>".$count++."</td>
							<td>".$row['thing_todo']."</td>
							<td>".$row['period']."</td>
							<td>".$row['end_time']."</td>
							<td>".$row['coding']."</td>
							<td>"."<a href='#edit' class='btn btn-info'>Edit</a>"."</td>
						</tr>
				 ";
			}			

			if ($numbers == 0) {
				echo "
						<tr class='text-center'>
						<td colspan='6'>No result of <b>".$day_name."</b> found !</td>
						</tr>
					";
			}
		}

	}
?>