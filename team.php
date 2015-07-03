<?php
require_once('core.php');
require_once('utility.php');
$name = getGet('name', '');
$team = getTeam("$name");
?>

<HEAD>
<TITLE>
<?php
  if ($team)  {
    echo "NFL Team: $name";
  } else {
    echo "NFL Team Lookup";
  }
?>
</TITLE>
<?php echo $headBust ?>
</HEAD>
<BODY BGCOLOR=WHITE>
<DIV ALIGN="CENTER">
<?php
  if ($team)
  {
?>

<TABLE ALIGN="CENTER">
<TR><H1><?php echo $name; ?></H1></TR>
<TR><i><?php echo $team->summary; ?></i><br><br></TR>
<?php
    $players = getPlayersOnTeam($team);
  
    if (empty($players)) {
      echo "<TR><TD>No players listed on this roster.</TD></TR>";
    } else { // !empty($players)
      echo "<TR><TD><b>Player</b></TD><TD><b>Position</b></TD><TD><b>Summary</b></TD></TR>";

      foreach ($players as $player) {
        $pName     = $player->name;
        $position = $player->position;
        $summary  = $player->summary;
        
        echo "<TR><TD>$pName</TD><TD>$position</TD><TD>$summary</TD></TR>";
      }
    }
?>

</TABLE>
<HR>

<FORM ACTION="addplayer.php" METHOD="POST">
<TABLE CELLPADDING=5>
<TR><TD>Add a new player:</TD></TR>
<TR><TD>Name:</TD><TD><INPUT TYPE="TEXT" NAME="NAME"></TD></TR>
<TR><TD>Position:</TD><TD><INPUT TYPE="TEXT" NAME="POSITION"></TD></TR>
<INPUT TYPE="HIDDEN" NAME="TEAM" VALUE="<?php echo $name; ?>">
<TR><TD>Summary:</TD><TD><INPUT TYPE="TEXT" NAME="SUMMARY"></TD></TR>
<TR><TD><INPUT TYPE="SUBMIT" VALUE="Add Player"></TD></TR>
</TABLE>
</FORM>
<HR>

<?php // Following example derived from: http://php.net/manual/en/curl.examples.php
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "https://en.wikipedia.org/w/api.php?action=query&prop=extracts&format=json&exintro=&explaintext=&titles=".urlencode($team->location." ".$team->name));

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);
        
        
        $pages = json_decode($output)->query->pages;
        foreach($pages as $page) {
          echo "<b>Wikipedia: </b>".$page->title."<br>";
          
          if ($page->extract) {
            echo "<div align=\"justify\">".$page->extract."</div><br><br>";
          } else { // !$page->extract
            echo "Page not found.<br><br>";
          }
        }
?>

<?php
  }  else { //!$exists
?>

Which team would you like to view?<br>
<FORM ACTION="team.php" METHOD="GET">
<TABLE CELLPADDING=5>
<TR><TD>Team:</TD><TD>
<?php echo selectTeamName("name"); ?>
</TD></TR>
<TR><TD><INPUT TYPE="SUBMIT" VALUE="View Team"></TD></TR>
</TABLE>
</FORM>
<?php
  }
?>
<br><br>
<a href="/">Back to the Matchups</a>
</DIV>
</BODY>