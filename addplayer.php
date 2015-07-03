<?php
require_once('core.php');

$name     = getPost('NAME', '');
$position = getPost('POSITION', '');
$teamname = getPost('TEAM', '');
$team     = getTeam($teamname);
$summary  = getPost('SUMMARY', '');

if ($name != '' &&
  $position != '' &&
  $team &&
  $summary != '' &&
  !in_array($name, getPlayerNames())) {
    addPlayer(new Player($name, $position, $team, $summary));
}

header("Location: team.php?name={$team->name}");

?>