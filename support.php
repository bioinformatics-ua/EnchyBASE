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
                        <li><a href="#support">Support</a></li>
                    </ul>

                    <div id="support" class="white">
                        EnchyBASE development was possible due to support from the following institutions and projects.
                        <br />

                        <h2>University of Aveiro</h2>
                        <h2>Funda&ccedil;&atilde;o para a Ci&ecirc;ncia e Tecnologia</h2>
                        <h2>PhD grant to Sara Novais (SFRH/BD/36253/2007) </h2>
                        <h2>PTDC/BIA-BCM/64745/2006 (REDE)</h2>
                        <h2>PTDC/BIA-BDE/75690/2006 (DisRupTox)</h2>
                        </ul>

                        <div class="supporter">
                            <img src="assets/image/logo-ua.png" alt="UA" /><br />
                            <img src="assets/image/fct.png" alt="FCT" width="480" /><br />
                            <img src="assets/image/compete.png" alt="COMPETE" /><br />
                            <img src="assets/image/ue.png" alt="UE" /><br />

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
