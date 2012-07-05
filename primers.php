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
        printf("<title>$term - Primers search - EnchyBASE</title>\n");
        ?>

    </head>
    <body>
        <?php
        echo "<h1>Primer information for Accession Number <em>&lt;$term&gt;</em></h1>";
        $query = "select distinct * from primers where acc like '%$term%';";
        $dbres = mysql_query($query) or die('Error, term search failed');
        $result = mysql_num_rows($dbres);

        if ($result == 0) {
            print "<h2>$term was not found in the database!</h2><p>There are no primer matches for the given Accession Number</p>";
            print "<a href=\"wwwPartiGene.html\">";
            print "try again</a>";
            exit();
        } else {

            while ($row = mysql_fetch_array($dbres)) {
                echo "<div style=\"padding:20px;border-bottom:solid 1px #AAA;\">";
                $seq = $row['seq'];
                $acc = $row['acc'];
                $forward = $row['forward'];
                $reverse = $row['reverse'];

                echo "<p style=\"text-align: left; padding:5px;\"><strong>Sequence ID</strong>: $seq</p><p style=\"text-align: left; padding:5px;\"><strong>Acc Number</strong>: $acc</p><p style=\"text-align: left; padding:5px;\"><strong>Forward</strong>: $forward</p><p style=\"text-align: left; padding:5px;\"><strong>Reverse</strong>: $reverse</p>";
                echo "</div>";
            }
        }
        ?>
    </body>
</html>
<?php
include 'config.php';
?>
