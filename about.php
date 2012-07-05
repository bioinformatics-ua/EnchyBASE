<!DOCTYPE html>
<html>
    <head>
        <title>EnchyBASE</title>
        <link rel="stylesheet" href="assets/style/reset.css" />
        <link type="text/css" href="assets/style/Aristo/jquery-ui-1.8.7.custom.css" rel="stylesheet" />
        <script src="assets/script/jquery.min.js"></script>
        <script src="assets/script/jquery-ui.min.js"></script>   
        <link rel="stylesheet" href="assets/style/style.css" />
        <script>
            $(document).ready(function(){
                $('#tabs').tabs();
                $(".accordion").accordion({ header: "h3" , active : 0});
            });
        </script>

    </head>
    <body>
        <div id="top">
            <div id="head"><a href="index.php" title="EnchyBASE">  Home</a>  |  <a href="about.php" title="About EnchyBASE">About</a> |  <a href="support.php" title="Support Information">Support</a> |  <a href="contact.php" title="Contact Us">Contact</a></div>
        </div>
        <div id="container">
            <div id="content">
                <a href="index.php" title="EnchyBASE"><img src="assets/image/enchy_logo.png" alt="EnchyBASE" /></a>
                <div id="tabs">
                    <ul>
                        <li><a href="#development">Development</a></li>
                    </ul>
                    <div id="development" class="white">
                        <h1>Software</h1>
                        <p>
                            EnchyBASE is supported by two sequence analysis frameworks, PartiGene and ViroBlast. 
                        </p>
                        <h2>PartiGene</h2>
                        <p>
                            PartiGene is part of the Edinburgh-EGTDC developed EST-software pipeline at the moment consisting of trace2dbEST, PartiGene, wwwPartiGene, port4EST and annot8r. PartiGene is a menu-driven, multi-step software tool which takes sequences (usually ESTs) and creates a dataabase of a non-redundant set of sequence objects (putative genes) which we term a partial genome.
                        </p>
                        <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
                            <br /><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .7em;"></span>
                                PartiGene is publicly available at <a href="http://www.nematodes.org/bioinformatics/PartiGene/" title="PartiGene">http://www.nematodes.org/bioinformatics/PartiGene/</a></p><br />
                        </div>
                        <h2>ViroBlast</h2>
                        <p>
                            ViroBLAST in Dr. Mullins Lab at University of Washington was established to provide sequence comparison and contamination checking on viral research. ViroBLAST is readily useful for all research areas that require BLAST functions and is available as a downloadable archive for independent installation (current version: viroblast-2.2+). ViroBLAST implements the NCBI C++ Toolkit BLAST command line applications referred as the BLAST+ applications.
                        </p>
                        <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
                            <br /><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .7em;"></span>
                                ViroBLAST is publicly available at <a href="http://indra.mullins.microbiol.washington.edu/viroblast/viroblast.php" title="ViroBLAST">http://indra.mullins.microbiol.washington.edu/viroblast/viroblast.php</a></p><br />
                        </div>
                    </div>
                </div>
            </div>
            <div id="sidebar">                
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </body>
</html>
