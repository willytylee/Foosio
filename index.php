<form action="index.php">
	Start Date: <input type="datetime-local" name="date_time" required><br>
	Recovery Hour: <input type="text" name="hour" required><br>
	<input type="submit" value="Submit">
</form>

<?php
if (isset($_GET["date_time"]) && isset($_GET["hour"])) {
    $input_date = date_create($_GET["date_time"]);
    $start_date = date_create($_GET["date_time"]);
    $recover_hour = $_GET["hour"];

    $day_of_week = date_format($start_date, 'N');
    $hour = date_format($start_date, 'H');

    if ($day_of_week <= 5 && $day_of_week >= 1) {
        if ($hour < 10) {
            $end_hour = 10 + $recover_hour;
            $minutes = "00";
        }
        if ($hour >= 10 && $hour < 16){
        	$end_hour = $hour + $recover_hour;
        	$minutes = date_format($start_date, 'i');;	
        }
        if ($hour >= 16){
        	if ($day_of_week == 5){
				date_add($start_date, date_interval_create_from_date_string('3 days'));
				$end_hour = 10 + $recover_hour;
				$minutes = "00";
        	}else{
        		date_add($start_date, date_interval_create_from_date_string('1 days'));
        		$end_hour = 10 + $recover_hour;
        		$minutes = "00";
        	}
        }
    }else if($day_of_week == 6){
    	date_add($start_date, date_interval_create_from_date_string('2 days'));
    	$end_hour = 10 + $recover_hour;
    	$minutes = "00";
    }else if($day_of_week == 7){
    	$end_hour = 10 + $recover_hour;
    	$minutes = "00";
    }

    if ($end_hour >= 16 && $end_hour < 22){
    	date_add($start_date, date_interval_create_from_date_string('1 days'));
    	$end_hour = $end_hour - 6;
    }else if ($end_hour >= 22 && $end_hour <= 28){
    	date_add($start_date, date_interval_create_from_date_string('2 days'));
    	$end_hour = $end_hour - 12;
    }

    $day_of_week = date_format($start_date, 'N');
	if ($day_of_week == 6){
		date_add($start_date, date_interval_create_from_date_string('2 days'));
	}else if ($day_of_week == 7){
		date_add($start_date, date_interval_create_from_date_string('1 days'));
	}

	//$output = $end_hour;
    $output = date_format($start_date, 'Y-m-d'. ' '.$end_hour.':'.$minutes);

    echo "Input Time: ".date_format($input_date, 'Y-m-d H:i')."<br>";
    echo "Recovery Date: ".$output;
}
?>