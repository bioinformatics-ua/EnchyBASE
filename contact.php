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
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                    <div id="contact" class="white">
                        <h1>Scientific Content</h1>
                        <h2>M&oacute;nica Amorim</h2>
                        <a href="http://www.cesam.ua.pt/monicaamorim" target="_blank">http://www.cesam.ua.pt/monicaamorim</a><br>
                        <a href="mailto:mjamorim@ua.pt">mjamorim@ua.pt</a>
                        <h2>Sara Novais</h2>
                        <a href="http://www.cesam.ua.pt/saranovais" target="_blank">http://www.cesam.ua.pt/saranovais</a><br />
                        <a href="mailto:sara.novais@ua.pt">sara.novais@ua.pt</a>
                        <h2>Address</h2>
                        CESAM- Centro de Estudos do Ambiente e do Mar<br>
                        Departamento de Biologia<br>
                        Universidade de Aveiro<br>
                        3810-193 Aveiro<br>
                        PORTUGAL<br>     
                        <h1>Bioinformatics Development (Web and Database)</h1>
                        <h2>Joel Arrais</h2>
                        <a href="mailto:jpa@ua.pt">jpa@ua.pt</a>
                        <br />
                        <h2>Pedro Lopes</h2>
                        <a href="pedrolopes@ua.pt">pedrolopes@ua.pt</a>
                    </div>

                </div>
            </div>
            <div id="sidebar">
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </body>
</html>
