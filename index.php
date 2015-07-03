<?php
    require_once('core.php');
    require_once('utility.php');
?>
<HEAD>
<TITLE>NFL Listings</TITLE>
<?php echo $headBust ?>
</HEAD>
<BODY BGCOLOR=WHITE>
<TABLE ALIGN="CENTER">
<TR><TD>
<H1>Matchups</H1>
</TD></TR>
<TR><TD>Home Team</TD><TD>Away Team</TD><TD>When</TD></TR>
<?php
  $matchups = getMatchups();
  foreach ($matchups as $matchup) {
      $home = $matchup->hometeam->name;
      $away = $matchup->awayteam->name;
?>
<TR>
    <TD><?php echo "<a href=\"team.php?name={$home}\">$home</a>" ?></TD>
    <TD><?php echo "<a href=\"team.php?name={$away}\">$away</a>" ?></TD>
    <TD><?php echo $matchup->when->format('Y-m-d H:i');
        ?></TD>
</TR>
<?php
    }
    
    $teams = getTeamNames();
?>
</TABLE>
<HR>
<TABLE ALIGN="CENTER">
<TR><TD>
<FORM ACTION="addteam.php" METHOD="POST">
<TABLE CELLPADDING=5>
<TR><TD>Add a New Team:</TD></TR>
<TR><TD>Team Name:</TD><TD><INPUT TYPE="TEXT" NAME="NAME"></TD></TR>
<TR><TD>Location:</TD><TD><INPUT TYPE="TEXT" NAME="LOCATION"></TD></TR>
<TR><TD>Summary:</TD><TD><INPUT TYPE="TEXT" NAME="SUMMARY"></TD></TR>
<TR><TD><INPUT TYPE="SUBMIT" VALUE="Add Team"></TD></TR>
</TABLE>
</FORM>
</TD></TR>
</TABLE>
<HR>
    <TABLE ALIGN="CENTER">
<TR><TD>
<FORM ACTION="addmatchup.php" METHOD="POST">
<TABLE CELLPADDING=5>
<TR><TD>Add a new matchup:</TD></TR>
<TR><TD>Home Team:</TD><TD>
<?php echo selectTeamName("HOMETEAM"); ?>
</TD></TR>
<TR><TD>Away Team:</TD><TD>
<?php echo selectTeamName("AWAYTEAM"); ?>
</TD></TR>
<TR><TD>When (Year, Month, Day, Hour, Minute):</TD><TD>
    <INPUT TYPE="number" NAME="YEAR" MIN="2015" MAX="2115" STEP="1" VALUE="2015">
    <INPUT TYPE="number" NAME="MONTH" MIN="1" MAX="12" STEP="1" VALUE="1">
    <INPUT TYPE="number" NAME="DAY" MIN="1" MAX="31" STEP="1" VALUE="1">
    <INPUT TYPE="number" NAME="HOUR" MIN="0" MAX="23" STEP="1" VALUE="0">
    <INPUT TYPE="number" NAME="MINUTE" MIN="0" MAX="59" STEP="15" VALUE="0">
</TD></TR>
<TR><TD><INPUT TYPE="SUBMIT" VALUE="Add Matchup"></TD></TR>
</TABLE>
</FORM>
</TD></TR>
</TABLE>
<HR>
<DIV align="center">
Which team would you like to view?<br>
<FORM ACTION="team.php" METHOD="GET">
<TABLE CELLPADDING=5>
<TR><TD>Team:</TD><TD>
<?php echo selectTeamName("name"); ?>
</TD></TR>
<TR><TD><INPUT TYPE="SUBMIT" VALUE="View Team"></TD></TR>
</TABLE>
</FORM>
</DIV>
</BODY>
