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

        printf("<title>$term - Annotation Search - EnchyBASE</title>\n");
        ?>

    </head>
    <body>
        <?php
        echo "<h1>Ontology annotation information for <em>&lt;$term&gt;</em></h1>";

        if ($library == "all") {
            $query = "SELECT * FROM normal_ontology AS N WHERE N.seq_desc LIKE '%$term%' UNION SELECT * FROM pesticides_ontology AS N WHERE N.seq_desc LIKE '%$term%' UNION SELECT * FROM metals_ontology AS N WHERE N.seq_desc LIKE '%$term%'";
        } else {
            $query = "SELECT * FROM " . $library . "_ontology AS N WHERE N.seq_desc LIKE '%$term%'";
        }

        $dbres = mysql_query($query) or die('Error, term search failed');
        $result = mysql_num_rows($dbres);

        if ($result == 0) {
            print "<h2>$term was not found in the database!</h2><p>There are no ontology annotation matches for the given <em>$term</em></p>";
            print "<a href=\"search.html\">Search again</a>";
            exit();
        } else {

            while ($row = mysql_fetch_array($dbres)) {
                echo "<div style=\"padding-left:20px;border-bottom:solid 2px #333;\">";
                $sequence = $row['sequence'];
                #$seq = $row['seq'];
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

                echo "<h2>Sequence Information</h2>";
                echo "<p style=\"text-align: left; padding-left:5px;\"><strong>Sequence ID</strong>: <a href=\"sequence.php?id=$sequence\" target=\"_blank\">$sequence</a><br /><strong>Name</strong>: $seq_desc<br /><strong>Length</strong>: $seq_length<br /><strong>Library</strong>: $type</p>";
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
        }
        ?>
    </body>
</html>
<?php
include 'config.php';
?>
