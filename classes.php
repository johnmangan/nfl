<?php

class Team {
    public $name = "";
    public $location = "";
    public $summary = "";

    function __construct($name = "", $location = "", $summary = "") {
        $this->name = $name;
        $this->location = $location;
        $this->summary = $summary;
    }
}

class Matchup {
    public $hometeam = null;
    public $awayteam = null;
    public $when = null;

    function __construct(Team $hometeam, Team $awayteam, DateTime $when) {
        $this->hometeam = $hometeam;
        $this->awayteam = $awayteam;
        $this->when = $when;
    }
}

class Player {
    public $name = "";
    public $position = "";
    public $team = null;
    public $summary = "";

    function __construct($name = "", $position = "", Team $team, $summary = "") {
        $this->name = $name;
        $this->position = $position;
        $this->team = $team;
        $this->summary = $summary;
    }
}

?>