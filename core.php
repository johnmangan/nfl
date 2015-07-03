<?php

/******************************************************************
 * This file acts as an abstaction for the database, to be used by
 * the rest of the web-app. Within this file, all queries are to be
 * prepared statements in order to prevent SQL injection.
 * 
 * This file also serves as a utility toolbox for other security
 * concerns, such as enabling anti-Clickjack code and preventing
 * URL injection. All user defined input should pass through the
 * functions provided at the top of this document (getGet/getPost).
 *****************************************************************/

require_once('classes.php');

/**
 * Echo this within every page's <HEAD> tag to avoid click-jacking.
 * Credit: headBust content unceremoniously copied from a past project, which
 *         was provided at the time via a professor (or possibly a TA), whom
 *         likely copied it as well. Code reuse at its worst.
 * /
$headBust = '<style id="antiClickjack">body{display:none !important;}</style>'.
    ' <script type="text/javascript">'.
    ' if (self === top) {'.
    ' var antiClickjack = document.getElementById("antiClickjack");'.
    ' antiClickjack.parentNode.removeChild(antiClickjack);'.
    ' } else {'.
    ' top.location = self.location;'.
    ' }'.
    ' </script>';

function htmlEnt($string) {
    return htmlEntities($string,
            ENT_COMPAT | ENT_HTML401,
            ini_get("default_charset"),
            false);
}

function getPost($var, $default) {
    global $_POST;
    return isset($_POST[$var]) ? htmlEnt($_POST[$var]) : $default;
}

function getGet($var, $default) {
    global $_GET;
    return isset($_GET[$var]) ? htmlEnt($_GET[$var]) : $default;
}

$db = pg_connect("hostaddr=127.0.0.1 port=5432 dbname=nfl user=postgres password=nflPsql");

pg_prepare($db, "getMatchups", 'SELECT hometeam, awayteam, time FROM matchups ORDER BY time ASC');

function getMatchups() {
    global $db;
    $rows = pg_fetch_all( pg_execute($db, "getMatchups", array()) );
    
    $matchups = array();
    
    if (!empty($rows)) {
        foreach($rows as $row) {
            $home = getTeam($row[hometeam]);
            $away = getTeam($row[awayteam]);
//            die($row[time]);
            $time = new DateTime($row[time]);
            if ($home && $away) {
                $matchups[] = new Matchup($home, $away, $time);
            }
        }
    }
    return $matchups;
}

pg_prepare($db, "addMatchup", 'INSERT INTO matchups (hometeam, awayteam, time) VALUES ($1, $2, $3)');

function addMatchup( Matchup $matchup ) {
    global $db;
    pg_execute($db, "addMatchup", array($matchup->hometeam->name, $matchup->awayteam->name, $matchup->when->format('Y-m-d H:i')));
}

pg_prepare($db, "getTeam", 'SELECT name, location, summary FROM teams WHERE name LIKE $1');

function getTeam($name) {
    global $db;
    $team = pg_fetch_object( pg_execute($db, "getTeam", array($name)) );
    if ($team) {
        return new Team($team->name, $team->location, $team->summary);
    }
    else {
        return false;
    }
}

pg_prepare($db, "getTeamNames", 'SELECT name FROM teams');

function getTeamNames() {
    global $db;
    $teams = pg_fetch_all( pg_execute($db, "getTeamNames", array()) );
    $ret = array();
    foreach ($teams as $team) {
        $ret[] = $team[name];
    }
    return $ret;
}

pg_prepare($db, "addTeam", 'INSERT INTO teams (name, location, summary) VALUES ($1, $2, $3)');

function addTeam( Team $team ) {
    global $db;
    pg_execute($db, "addTeam", array($team->name, $team->location, $team->summary));
}

pg_prepare($db, "getPlayerNames", 'SELECT name FROM players');

function getPlayerNames() {
    global $db;
    $players = pg_fetch_all( pg_execute($db, "getPlayerNames", array()) );
    $ret = array();
    if (!empty($players)) {
        foreach ($players as $player) {
            $ret[] = $player[name];
        }
    }
    return $ret;
}

pg_prepare($db, "getPlayersOnTeam", 'SELECT name, position, summary FROM players WHERE team LIKE $1');

function getPlayersOnTeam(Team $team) {
    global $db;
    $rows = pg_fetch_all( pg_execute($db, "getPlayersOnTeam", array($team->name)) );
    
    $players = array();
    
    if (!empty($rows)) {
        foreach($rows as $row) {
            $players[] = new Player($row[name], $row[position], $team, $row[summary]);
        }
    }
    
    return $players;
}

pg_prepare($db, "addPlayer", 'INSERT INTO players (name, position, team, summary) VALUES ($1, $2, $3, $4)');

function addPlayer( Player $player ) {
    global $db;
    pg_execute($db, "addPlayer", array($player->name, $player->position, $player->team->name, $player->summary));
}

?>
