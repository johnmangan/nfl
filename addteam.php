<?php
require_once('core.php');

$name = getPost('NAME', '');
$location = getPost('LOCATION', '');
$summary = getPost('SUMMARY', '');

// See if the team already exists
$exists = getTeam($name);

if ($name != '' &&
  $location != '' &&
  $summary != '' &&
  !$exists) {
    addTeam(new Team($name, $location, $summary));
}

header("Location: team.php?name={$name}");

?>