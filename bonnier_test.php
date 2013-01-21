<?php
/*
 * This script expects these parameters:
 * - article_id
 * - score
 *
 * Example bonnier_test.php?article_id=1&vote_value=1
 */

mysql_connect('localhost', 'mbreland', 'goldie');
mysql_select_db('bonnier');

function db_result($result) {
  if ($result && mysql_num_rows($result) > 0) {
    $array = mysql_fetch_row($result);
    return $array[0];
  }
  return FALSE;
}

$article_id = $_REQUEST['article_id'];
$vote_value = $_REQUEST['vote_value'];

$current_score = db_result(mysql_query("SELECT score FROM vote WHERE article_id = $article_id"));

if ($current_score) {
	$new_score = $current_score + $vote_value;
	mysql_query("UPDATE vote SET score = $new_score WHERE article_id = $article_id");
}
else {
	mysql_query("INSERT INTO vote (article_id, score) VALUES ($article_id, $vote_value)");
}

$article_score = db_result(mysql_query("SELECT score FROM vote WHERE article_id = $article_id"));

$widget  = '<div class="voting_widget">';
$widget .= '<a href="bonnier_test.php?article_id='.$article_id.'&vote_value=1">Vote Up</a>';
$widget .= ' ';
$widget .= '<a href="bonnier_test.php?article_id='.$article_id.'&vote_value=-1">Vote Down</a>';
$widget .= ' ';
$widget .= 'Score: '. $article_id;
$widget .= '</div>';

print $widget;