<?php
require_once('core.php');

$home = getPost('HOMETEAM', '');
$away = getPost('AWAYTEAM', '');
$year = getPost('YEAR', 0);
$month = getPost('MONTH', 0);
$day = getPost('DAY', 0);
$hour = getPost('HOUR', 24);
$minute = getPost('MINUTE', 60);

// Get Team objects via the user defined names
$hometeam = getTeam($home);
$awayteam = getTeam($away);

// Cleaner DateTime construction than the non-default ctor offers
$when  = new DateTime();
$when->setDate($year, $month, $day);
$when->setTime($hour, $minute);

// TODO - More sophisticated validation is necessary, such as avoiding February 31st
if ($hometeam &&
  $awayteam &&
  $home != $away &&
  $year >= 2015 &&
  $year <= 2115 &&
  $month > 0 &&
  $month <= 12 &&
  $day > 0 &&
  $day <= 31 &&
  $hour >= 0 &&
  $hour < 24 &&
  $minute >= 0 &&
  $minute < 60) {
    addMatchup(new Matchup($hometeam, $awayteam, $when));
}

header("Location: index.php");

?>