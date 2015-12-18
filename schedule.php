<?php
require_once("common.php");
require_once("class-calendar.php");
protect();

date_default_timezone_set("America/New_York");

if(isset($_GET['print_view'])) {
	if($_GET['print_view'] == "true") {
		$_SESSION['print_view'] = true;
	} else {
		$_SESSION['print_view'] = false;
	}
}

//set print view
if($_SESSION['print_view'] == true) {
	$printView = true;
} else {
	$printView = false;
}

showHeader(true);

//Add meet
if(isset($_POST['meet']) && isset($_POST['date'])) {
	$meet = mysql_real_escape_string($_POST['meet']);
	$date = mysql_real_escape_string($_POST['date']);
	mysql_query("UPDATE meet SET date='$date' WHERE id=$meet");
}
//get month and year from $_GET, otherwise get current month and year
if(isset($_GET['month'])) {
	$month = $_GET['month'];
} else {
	$month = date('n');
}
if(isset($_GET['year'])) {
	$year = $_GET['year'];
} else {
	$year = date('Y');
}

?>
<?php
if(Auth::schoolID() == 0) {
?>
<form method="post">
<?php
}
?>

<table id="<?php echo ($printView ? "schedule_print" : "schedule") ?>">
<?php

//create an array to store schools and the number of meets they host
$schoolNumHost = array();

if(Auth::schoolID() == 0 && !$printView) {
?>
<tr>
	<td colspan="7">
	<b>Select a meet: </b>
	<?php

	$i = 1;
	echo "<select name='meet'>";
	$rs1 = mysql_query("SELECT * FROM meet");
	$current = 0;
	while($meet = mysql_fetch_object($rs1)) {

		if($meet->home_school_id != 0) {
			if(!isset($schoolNumHost[$meet->home_school_id])) {
				$schoolNumHost[$meet->home_school_id] = 1;
			} else {
				$schoolNumHost[$meet->home_school_id]++;
			}
		}

		$rs2 = mysql_query("SELECT * FROM meet_school JOIN school ON school.id=school_id WHERE meet_id = $meet->id");
		$schools = array();
		while($school = mysql_fetch_object($rs2)) {
			if($school->id == $meet->home_school_id)
				$schools[] = "@$school->name";
			else
				$schools[] = "$school->name";
		}

		echo "<option value='$meet->id'" . ($meet->date == "0000-00-00" ? "" : " class='used'") . ">$i. " . implode(", ", $schools) . " ($meet->type)</option>";
		$i++;
	}
	echo "</select>";
	echo "</select>";
	?>
	<br />
	<b>Select a date: </b>
	</td>
</tr>
<?php
} else if (!$printView) {
?>
<tr>
	<td colspan="7">To enter scores, select a meet from the calendar below.</td>
</tr>
<?php
}
?>
<tr>
	<td>
	<?php
	if($month == 1) {
		echo "<a href='?month=12&year=", ($year - 1), "'><<</a>";
	} else {
		echo "<a href='?month=", ($month - 1), "&year=$year'><<</a>";
	}
	?>
	</td>
	<td colspan="5">
	<div>
	<?php
	if($printView)
		echo Calendar::getMonthName($month) . " " . $year;
	else
		echo "<h1>" . Calendar::getMonthName($month) . " " . $year . "<h1>";
	?>
	</div>
	</td>
	<td align="right">
	<?php
	if($month == 12) {
		echo "<a href='?month=1&&year=", ($year + 1), "'>>></a>";
	} else {
		echo "<a href='?month=", ($month + 1), "&&year=$year'>>></a>";
	}
	?></td>
</tr>
<tr>
	<th>SUN</th>
	<th>MON</th>
	<th>TUE</th>
	<th>WED</th>
	<th>THU</th>
	<th>FRI</th>
	<th>SAT</th>
</tr>
<?php

$weekday = Calendar::getWeekday($year, $month, 1);

if($weekday == 7) {
	$weekday = 1;
} else {
	$weekday++;
}

$numDays = Calendar::calulate_days_in_month($month, $year);
$i = 1;
$j = 8;

//display calendar.
while($i <= $numDays) {
	echo "<tr>";
	for($j = 1; $j <= 7; $j++) {
		if($i > $numDays || $i == 1 && $j != $weekday) {
			echo "<td class='blocked'></td>";
		} else {
			echo "<td>$i";
			if(Auth::schoolID() == 0) {
				echo "<input type='radio' name='date' value='$year-$month-$i' />";
			}
			$rs1 = mysql_query("SELECT * FROM meet WHERE date='$year-$month-$i'");
			while($meet = mysql_fetch_object($rs1)) {

				$rs2 = mysql_query("SELECT * FROM meet_school JOIN school ON school.id=school_id WHERE meet_id = $meet->id");
				$schools = array();
				while($school = mysql_fetch_object($rs2)) {
					$name = $school->name;
					if($school->id == $meet->home_school_id)
						$name = "@" . $name;
					if(Auth::schoolID() == 0) {
						$name .= "(" . (isset($schoolNumHost[$school->id]) ? $schoolNumHost[$school->id] : 0) . ")";
					}
					$schools[] = $name;
				}

				echo "<div class='meet'>";
				echo implode(", ", $schools);

				$options = array();

				if(Auth::schoolID() == 0) {
					$options[] = "<a href='set_home_school.php?meet_id=$meet->id'>set home school</a>";
				}
				if($meet->home_school_id == Auth::schoolID() && $meet->home_school_id!=0) {
					$options[] = "<a href='enter_scores.php?meet_id=$meet->id'>edit</a>";
				}
				$options[] = "<a href='view_scores.php?meet_id=$meet->id'>view</a>";
				if(!$printView) {
					echo " [" . implode("/", $options) . "]";
				}
				echo "</div>";
			}
			echo "</td>";
			$i++;
		}
	}
	echo "</tr>";
}

?>
<tr>
	<td colspan="7" align="right">
	<input type="button" value="Toggle Print View" onClick="location.href='?print_view=<?php echo ($printView ? "false" : "true") ?>'" />
	<?php
	if(Auth::schoolID() == 0) {
	?>
	<input type="submit" value="Add/Change Meet" />
	<?php
	}
	?>
	</td>
</tr>
</table>
<?php
if(Auth::schoolID() == 0 && !$printView) {
?>
</form>
<?php
}

showFooter(true);
?>
