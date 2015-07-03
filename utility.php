<?php 
require_once('core.php');

// Creates a team selection (dropdown menu) for forms
// $name - Refers to the name to be passed via the FORM submission
function selectTeamName($name) {
    $ret = "<select NAME=\"{$name}\">";
    foreach (getTeamNames() as $team) {
        $ret .= "<option value=\"{$team}\">{$team}</option>";
    }
    $ret .= '</select>';
    return $ret;
}