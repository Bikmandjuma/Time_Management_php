<script>
	window.setTimeout( function() {
	  window.location.reload();
	}, 1000);
</script>
<?php
	require "connect.php";
	date_default_timezone_set("Africa/Kigali");
	$day_date=date('Y-m-d');
	$day_name=date('l');
	$time=date('H:i:s a');

	//Set reminder sms of sunday to remind me to set time management of new week
	if ($day_name == 'Sunday') {

		if ($time == '21:00:00 pm' && $time == '21:10:00 pm') {
				
			//code of sms
			$senderName='SenderName';
			$phone='RecipientNumber';
			$data=array(
			        "sender"=>$senderName,
			        "recipients"=>$phone,
			        "message"=>"Message from (TMSR) : hi Bikman djuma today is ".$day_name." , remember to set your time management of a new week which will start tomorrow , hope this week was cool ,see u next ".$day_name." like this time , have good night !",
			      );

			$url="https://www.intouchsms.co.rw/api/sendsms/.json";
			$data=http_build_query($data);
			$username="Username";
			$password="Password";

	        $ch=curl_init();
	        curl_setopt($ch,CURLOPT_URL,$url);
	        curl_setopt($ch,CURLOPT_USERPWD,$username.":".$password);
	        curl_setopt($ch,CURLOPT_POST,true);
	        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
		    curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
		    $result=curl_exec($ch);
		    $httpcode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
			curl_close($ch);
		}
	}

	//Select a day and it's id
	$day_sql="SELECT * FROM days_of_week where name='$day_name'";
	$day_query=mysqli_query($conn,$day_sql);
	while ($day_row=mysqli_fetch_assoc($day_query) ) {
		$today=$day_row['name'];
		$today_id=$day_row['id'];
	}

	if ( $day_name === $today) {
		
		//Select time management thing to do sms
		$sql="SELECT thing_todo,period FROM timemanage inner join days_of_week on timemanage.fk_days_id = days_of_week.id where fk_days_id='$today_id' and dates='$day_date'";
		$query=mysqli_query($conn,$sql);
		while ($row=mysqli_fetch_assoc($query) ) {
			$Task=$row['thing_todo'];
			$Task_time=$row['period'];

			if ($time == $Task_time) {
				
				//code of sms
		        $senderName='sendername';
		        $phone='RecipientNumber';
		        $data=array(
		                    "sender"=>$senderName,
		                    "recipients"=>$phone,
		                    "message"=>"Message from (TMSR) : Hi Bikman djuma ,"." TMSR remind u that : time for ".$Task,
		              );

		          $url="https://www.intouchsms.co.rw/api/sendsms/.json";
		          $data=http_build_query($data);
		          $username="Username";
		          $password="Password";

		          $ch=curl_init();
		          curl_setopt($ch,CURLOPT_URL,$url);
		          curl_setopt($ch,CURLOPT_USERPWD,$username.":".$password);
		          curl_setopt($ch,CURLOPT_POST,true);
		          curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		          curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
		          curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
		          $result=curl_exec($ch);
		          $httpcode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
		          curl_close($ch);

				break;
			}

			echo date("H:i:s a");

		}

	}else{
		echo "False day";	
	}

?>