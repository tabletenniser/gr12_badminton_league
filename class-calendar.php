<?php

/**
 * Calendar contains static methods that are used to generate the calendar.
 */

class Calendar{
	static function getWeekday($year, $month, $day){
		$doomsday=(2+$year+floor($year/4) - floor($year/100) + floor($year/400))%7;
		
		if(year%4==0 && year%100!=0){
			if($month==1){
				$firstDay=($doomsday+4)%7;
			}if($month==2){
				$firstDay=$doomsday;
			}
		}else{
			if($month==1){
				$firstDay=($doomsday+5)%7;
			}if($month==2){
				$firstDay=($doomsday+1)%7;
			}
		}
		if($month==3){
				$firstDay=($doomsday+1)%7;
		}if($month==4){
				$firstDay=($doomsday+4)%7;
		}if($month==5){
				$firstDay=($doomsday+6)%7;
		}if($month==6){
				$firstDay=($doomsday+2)%7;
		}if($month==7){
				$firstDay=($doomsday+4)%7;
		}if($month==8){
			$firstDay=$doomsday;
		}if($month==9){
				$firstDay=($doomsday+3)%7;
		}if($month==10){
				$firstDay=($doomsday+5)%7;
		}if($month==11){
				$firstDay=($doomsday+1)%7;
		}if($month==12){
				$firstDay=($doomsday+3)%7;
		}
		$day=($firstDay+($day-1))%7;
		return $day;
	}
	static function calulate_days_in_month($month, $year){
		switch($month) {
		case 1:
			return 31;
			break;
		case 2:
			return 28;
			break;
		case 3:
			return 31;
			break;
		case 4:
			return 30;
			break;
		case 5:
			return 31;
			break;
		case 6:
			return 30;
			break;
		case 7:
			return 31;
			break;
		case 8:
			return 31;
			break;
		case 9:
			return 30;
			break;
		case 10:
			return 31;
			break;
		case 11:
			return 30;
			break;
		case 12:
			return 31;
			break;
		default:
			return "Wrong month.";
			break;
		}


	}

	
	static function getMonthName($month) {
		switch($month) {
		case 1:
			return "January";
			break;
		case 2:
			return "February";
			break;
		case 3:
			return "March";
			break;
		case 4:
			return "April";
			break;
		case 5:
			return "May";
			break;
		case 6:
			return "June";
			break;
		case 7:
			return "July";
			break;
		case 8:
			return "August";
			break;
		case 9:
			return "September";
			break;
		case 10:
			return "October";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "December";
			break;
		default:
			return "Wrong month.";
			break;
		}
	}
	
}

?>