<?php
include 'config.php';
include 'opendb.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="assets/style/reset.css" />
        <link type="text/css" href="assets/style/Aristo/jquery-ui-1.8.7.custom.css" rel="stylesheet" />
        <script src="assets/script/jquery.min.js"></script>
        <script src="assets/script/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="assets/style/parti.css" />
        <script>
            $(document).ready(function(){
                $("#submit,#reset,#go,#search,#download").button();
            });
        </script>
        <?php
        $term = $_POST['term'];
        $library = $_POST['library'];

        printf("<title>$term - Cluster Search - EnchyBASE</title>\n");
        ?>

    </head>
    <body>
        <?php
        /*  if ($library == "all") {
          $query = "SELECT * FROM normal_ontology AS N INNER JOIN normal_sequences AS S ON N.sequence = S.id WHERE N.gos LIKE '%$term%' UNION SELECT * FROM pesticides_ontology AS N INNER JOIN pesticides_sequences AS S ON N.sequence = S.id WHERE N.gos LIKE '%$term%' UNION SELECT * FROM metals_ontology AS N INNER JOIN metals_sequences AS S ON N.sequence = S.id WHERE N.gos LIKE '%$term%'";
          } else {
          $query = "SELECT * FROM " . $library . "_ontology AS N INNER JOIN normal_sequences AS S ON N.sequence = S.id WHERE N.gos LIKE '%$term%'";
          } */


        $query = "SELECT * FROM cluster WHERE id LIKE '$term'";
        $dbres = mysql_query($query) or die('Error, term search failed');
        $result = mysql_num_rows($dbres);

        if ($result == 0) {
            print "<h2>$term was not found in the database!</h2><p>There are no cluster matches for <em>$term</em></p>";
            print "<a href=\"search.html\">Search again</a>";
            exit();
        } else {
            while ($rrow = mysql_fetch_array($dbres)) {
                $contig = $rrow['contig'];
                $id = $rrow['id'];
                $sequences = $rrow['sequences'];
                ## CONTIGS
                #echo $contig;
                $contig_query = "SELECT * FROM contigs_ontology WHERE contig LIKE '$contig'";
                $contig_dbres = mysql_query($contig_query) or die('Error, term search failed');
                while ($contig_row = mysql_fetch_array($contig_dbres)) {
                    echo "<h1>Contig information for <em>&lt;$contig&gt;</em></h1>";
                    echo "<div style=\"padding-left:20px;border-bottom:solid 2px #333;\">";

                    ## PROCESS CONTIG ONTOLOGY;
                    $contig = $contig_row['contig'];
                    $seq_dsc = $contig_row['seq_dsc'];
                    $seq_length = $contig_row['seq_length'];
                    $hits = $contig_row['hits'];
                    $evalue = $contig_row['evalue'];
                    $sim = $contig_row['sim'];
                    $n_gos = $contig_row['n_gos'];
                    $gos = $contig_row['gos'];
                    $gos = str_replace("P:", "", $gos);
                    $gos = str_replace("F:", "", $gos);
                    $gos = str_replace("C:", "", $gos);
                    $go_list = split("; ", $gos);
                    echo "<p style=\"text-align: left; padding-left:5px;\"><strong>ID</strong>: $contig<br /><strong>Description</strong> $seq_dsc<br /><strong>Length</strong>: $seq_length</p>";
                    echo "<h2>Sequences</h2>";
                    $sequences = str_replace("|", ";", $sequences);
                    $list = split(";", $sequences);
                    foreach ($list as $sequence) {
                        $items = split("_", $sequence);
                        $item = $items[2] . "_" . $items[3];
                        $seq_query = "SELECT * FROM seq WHERE seq_dsc LIKE '%$item%';";
                        $seq_dbres = mysql_query($seq_query) or die('Error, term search failed');

                        while ($seq_row = mysql_fetch_array($seq_dbres)) {
                            $id = $seq_row['id'];
                            $seq_dsc = $seq_row['seq_dsc'];
                            $id = str_replace("|", ";", $id);
                            $ids = split(";", $id);

                            echo "<p style=\"text-align: left; padding-left:5px;\"><strong>GenBank</strong> ($seq_dsc)<ul> ";
                            foreach ($ids as $s) {
                                if (!($s == 'gb' || $s == 'gi')) {
                                    echo "<li><a href=\"http://www.ncbi.nlm.nih.gov/nucest/$s\" target=\"_blank\">$s</a></li>";
                                }
                            }
                            echo "</ul></p><br /><br />";
                        }
                    }

                    echo "<h2>Gene Ontology information</h2>";
                    echo "<p><strong>Hits</strong>: $hits<br /><strong>eValue</strong>: $evalue<br /><strong>Similarity</strong>: $sim<br /><strong># GOs</strong>: $n_gos</p>";
                    echo "<p style=\"text-align: left; padding-left:15px;\">";
                    foreach ($go_list as $go) {
                        $go_query = "SELECT * FROM ontology WHERE id LIKE '$go'";
                        $go_res = mysql_query($go_query);
                        while ($go_row = mysql_fetch_array($go_res)) {
                            $go_id = $go_row['id'];
                            $go_family = $go_row['family'];
                            $go_term = $go_row['term'];
                            echo "<strong><a href=\"http://amigo.geneontology.org/cgi-bin/amigo/term_details?term=$go_id\" target=\"_blank\">$go_id</a></strong> [<em>$go_family</em>] <span>$go_term</span><br />";
                        }
                    }
                    echo"</p>";
                    echo "</div>";
                }


                ## SEQUENCES
                /* $sequences = str_replace("|", ";", $sequences);
                  $list = split(";", $sequences);
                  foreach ($list as $sequence) {
                  $items = split("_", $sequence);
                  $item = $items[2] . "_" . $items[3];
                  $seq_query = "SELECT * FROM seq WHERE seq_dsc LIKE '%$item%';";
                  $seq_dbres = mysql_query($seq_query) or die('Error, term search failed');

                  while ($seq_row = mysql_fetch_array($seq_dbres)) {
                  $id = $seq_row['id'];
                  $seq_dsc = $seq_row['seq_dsc'];
                  echo "<h1>Sequence information for <em>&lt;$id&gt;</em></h1>";
                  echo "<div style=\"padding-left:20px;border-bottom:solid 2px #333;\">";
                  echo "<h2>Sequence Information</h2>";
                  echo "<p style=\"text-align: left; padding-left:5px;\"><strong>Sequence ID</strong>: <a href=\"sequence.php?id=$id\" target=\"_blank\">$id</a><br /><strong>Description</strong> $seq_desc";


                  ## ONTOLOGY
                  if ($library == "all") {
                  $onto_query = "SELECT * FROM normal_ontology WHERE sequence LIKE '%$id%' UNION SELECT * FROM metals_ontology WHERE sequence LIKE '%$id%' UNION SELECT * FROM pesticides_ontology WHERE sequence LIKE '%$id%'";
                  } else {
                  $onto_query = "SELECT * FROM " . $library . "_ontology WHERE sequence LIKE '%$id%'";
                  }
                  $onto_dbres = mysql_query($onto_query) or die('Error, term search failed');
                  $onto_result = mysql_num_rows($onto_dbres);
                  if ($onto_result == 0) {
                  echo "</p>";
                  echo "<p style=\"padding: 5px;\"><br />There is <strong>no</strong> ontology information for sequence <em>$id</em> in the selected library.</p><br />";
                  } else {

                  while ($row = mysql_fetch_array($onto_dbres)) {
                  $seq_desc = $row['seq_desc'];
                  $type = $row['type'];
                  $seq_length = $row['sql_length'];
                  $hits = $row['hits'];
                  $evalue = $row['eValue'];
                  $sim = $row['sim'];
                  $n_gos = $row['n_gos'];
                  $gos = $row['gos'];
                  $gos = str_replace("P:", "", $gos);
                  $gos = str_replace("F:", "", $gos);
                  $gos = str_replace("C:", "", $gos);
                  $go_list = split("; ", $gos);

                  echo "<br /><strong>Name</strong>: $seq_desc<br/>Length</strong>: $seq_length<br /><strong>Library</strong>: $type</p>";
                  echo "<h2>Gene Ontology information</h2>";
                  echo "<p><strong>Hits</strong>: $hits<br /><strong>eValue</strong>: $evalue<br /><strong>Similarity</strong>: $sim<br /><strong># GOs</strong>: $n_gos</p>";
                  echo "<p style=\"text-align: left; padding-left:15px;\">";
                  foreach ($go_list as $go) {
                  $go_query = "SELECT * FROM ontology WHERE id LIKE '$go'";
                  $go_res = mysql_query($go_query);
                  while ($go_row = mysql_fetch_array($go_res)) {
                  $go_id = $go_row['id'];
                  $go_family = $go_row['family'];
                  $go_term = $go_row['term'];
                  echo "<strong><a href=\"http://amigo.geneontology.org/cgi-bin/amigo/term_details?term=$go_id\" target=\"_blank\">$go_id</a></strong> [<em>$go_family</em>] <span>$go_term</span><br />";
                  }
                  }
                  echo"</p>";
                  }
                  }
                  echo "</div>";
                  }
                  } */
            }
        }
        ?>
    </body>
</html>
<?php
include 'config.php';
?>
