<?php

include 'config.php';
include 'opendb.php';

$term = $_GET['id'];

$query = "SELECT * FROM seq WHERE id LIKE '%$term%';";
$dbres = mysql_query($query) or die('Error, term search failed');


while ($row = mysql_fetch_array($dbres)) {
    $id = $row['id'];
    $seq = $row['seq'];
    $seq_dsc = $row['seq_dsc'];
    $seq_w = wordwrap($seq, 70, "\n");
    echo ">$id $seq_dsc\n$seq_w";
}
include 'config.php';
?>
