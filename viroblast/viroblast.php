<html>
    <head> 
        <title>EnchyBASE - ViroBlast</title>  
        <link type="text/css" href="assets/style/Aristo/jquery-ui-1.8.7.custom.css" rel="stylesheet" />
        <link href="../assets/style/reset.css"  rel="Stylesheet" type="text/css" />
        <link href="stylesheets/viroblast.css"  rel="Stylesheet" type="text/css" />        
        <link href="../assets/style/parti.css"  rel="Stylesheet" type="text/css" />
        <script type="text/javascript" src='javascripts/viroblast.js'></script>
        <script src="../assets/script/jquery.min.js"></script>
        <script src="../assets/script/jquery-ui.min.js"></script>
        <script>
            $(document).ready(function(){
                $('#bblast,#breset,#ablast,#areset').button();                
            });
        </script>
    </head>
    <body>

        <div class="spacer">&nbsp;</div>

        <div id="indent">

            <form enctype='multipart/form-data' name='blastForm' action = 'blastresult.php' method='post'>
                <div class='box'>
                    <h1>Basic Search</h1>
                    <p>Default BLAST parameter settings</p>
                    <br><br>

                    <p>Enter query sequences here in <a href='docs/parameters.html#format'>Fasta format</a></p> 

                    <p><textarea name='querySeq' rows='6' cols='66'></textarea></p>
                    <p>Or upload sequence fasta file for querying: <input type='file' name='queryfile'></p>

                    <p><table border=0 style='font-size: 12px'>
                        <tr><td valign=top>
                                <a href=docs/blast_program.html>Program</a> <select id="programList" name='program' onchange="changeDBList(this.value, this.form.dbList, dblib[programNode.value]); changeParameters(this.value, 'adv_parameters');">
                                    <option value='blastn' selected>blastn
                                        <!--<option value='blastp'>blastp
                                        <option value='blastx'>blastx
                                        <option value='tblastn'>tblastn
                                        <option value='tblastx'>tblastx -->
                                </select></td>

                            <td valign=top>&nbsp;&nbsp;&nbsp;
                                Libraries
                            </td><td>
                                <?php
                                $fp = fopen("./viroblast.ini", "r");
                                if (!$fp) {
                                    echo "<p><strong> Error: Couldn't open file viroblast.ini </strong></p></body></html>";
                                    exit;
                                }
                                while (!feof($fp)) {
                                    $blastdbstring = rtrim(fgets($fp));
                                    if (!$blastdbstring) {
                                        continue;
                                    }
                                    if (!preg_match("/^\s*#/", $blastdbstring)) {
                                        $blastdbArray = split(":", $blastdbstring);
                                        $blastProgram = $blastdbArray[0];
                                        $dbString = $blastdbArray[1];

                                        if ($blastProgram == "blast+") {
                                            echo "<input type='hidden' name= 'blastpath' value='$dbString'>";
                                        } else {
                                            if (preg_match("/^\s*(.*?)\s*$/", $blastProgram, $match)) {
                                                $blastProgram = $match[1];
                                            }
                                            if (preg_match("/^\s*(.*?)(\s*|\s*,\s*)$/", $dbString, $match)) {
                                                $dbString = $match[1];
                                            }
                                            $dbString = preg_replace("/\s*=>\s*/", "=>", $dbString);
                                            if (preg_match("/,/", $dbString, $match)) {
                                                $dbString = preg_replace("/\s*,\s*/", ",", $dbString);
                                            }
                                            echo "<input id='$blastProgram' type='hidden' name='blastdb[]' value='$dbString'>";
                                        }
                                    }
                                }
                                fclose($fp);
                                ?>
                                <select id="dbList" size=4 multiple="multiple" name ="patientIDarray[]">
                                    <script type="text/javascript">
                                        var dblib = Array();
                                        var programNode = document.getElementById("programList");
                                        var blastndbNode = document.getElementById("blastn");
                                        var blastpdbNode = document.getElementById("blastp");
                                        var blastxdbNode = document.getElementById("blastx");
                                        dblib["blastn"] = blastndbNode.value;
                                        dblib["blastp"] = blastpdbNode.value;
                                        dblib["blastx"] = blastxdbNode.value;
                                        changeDBList(programNode.value, document.getElementById("dbList"), dblib[programNode.value]);
                                    </script>

                                </select>
                            </td></tr></table></p>

                    <input type='hidden' name='blast_flag' value=1>

                    <p><input type='button' id="bblast" name="bblast" value='Basic search' onclick="checkform(this.form, this.value)">&nbsp;&nbsp;<input id="breset" type='reset' value='Reset' onclick="window.location.reload();"></p>

                    <h1>Advanced Search</h1>
                    <p>Set your favourite parameters below</p>
                    <br><br>
                    <div id="adv_parameters">

                        <script type="text/javascript">
                            var programNode = document.getElementById("programList");
                            changeParameters(programNode.value, 'adv_parameters');
                        </script>

                    </div>
                    <p><input type='button' name="ablast" id="ablast" value='Advanced search' onclick="checkform(this.form, this.value)">&nbsp;&nbsp;<input type='reset' id="areset" value='Reset' onclick="window.location.reload();"></p>
            </form>

        </div>
    </div>
</body>
</html>
