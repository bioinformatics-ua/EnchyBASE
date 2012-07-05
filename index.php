<!DOCTYPE html>
<html>
    <head>
        <title>EnchyBASE</title>
        <link rel="stylesheet" href="assets/style/reset.css" />
        <link type="text/css" href="assets/style/Aristo/jquery-ui-1.8.7.custom.css" rel="stylesheet" />
        <script src="assets/script/jquery.min.js"></script>
        <script src="assets/script/jquery-ui.min.js"></script>
        <script src="assets/script/jquery.nivo.slider.pack.js"></script>     
        <link rel="stylesheet" href="assets/style/style.css" />
        <link rel="stylesheet" href="assets/style/nivo-slider.css" />
        <script>
            $(document).ready(function(){
                $('#tabs').tabs();
                $(".accordion").accordion({ header: "h3" , active : 0});                
                $('#imageSlider').nivoSlider({
                    effect:'random',
                    prevText: '', // Prev directionNav text
                    nextText: '',
                    animSpeed:500, // Slide transition speed
                    pauseTime:3000, // How long each slide will show
                    controlNav:false, // 1,2,3... navigation
                    controlNavThumbs:false, // Use thumbnails for Control Nav
                    controlNavThumbsFromRel:false, // Use image rel for thumbs
                    pauseOnHover:true, // Stop animation while hovering
                    manualAdvance:false, // Force manual transitions
                });

                $('#enchyinfo').click(function(){
                    $('#enchyinfobox').slideToggle('slow');
                });
            });
        </script>

    </head>
    <body>
        <div id="top">
            <div id="head"><a href="index.php" title="EnchyBASE">  Home</a>  |  <a href="about.php" title="About EnchyBASE">About</a> |  <a href="support.php" title="Support Information">Support</a> |  <a href="contact.php" title="Contact Us">Contact</a></div>
        </div>
        <div id="container">
            <div id="content">
                <a href="index.php" title="EnchyBASE" target="_top"><img src="assets/image/enchy_logo.png" alt="EnchyBASE" /></a>
                <div id="tabs">
                    <ul>
                        <li><a href="#background">Background</a></li>
                        <li><a href="#search">Search</a></li>
                        <li><a href="#blast">BLAST</a></li>
                        <li><a href="#microarray">Microarray Data</a></li>
                        <li><a href="#publications">Publications</a></li>
                    </ul>
                    <div id="background" class="white">
                        <div id="slideContainer">
                            <div id="imageSlider">
                                <img src="assets/image/enchy1.png" alt="enchy1" width="480" height="360"/>
                                <img src="assets/image/enchy2.jpg" alt="enchy1" width="480" height="360"/>
                                <img src="assets/image/enchy3.jpg" alt="enchy1" width="480" height="360"/>
                                <img src="assets/image/enchy4.jpg" alt="enchy1" width="480" height="360"/>
                                <img src="assets/image/enchy5.jpg" alt="enchy1" width="480" height="360"/>
                                <img src="assets/image/enchy6.jpg" alt="enchy1" width="480" height="360"/>
                                <img src="assets/image/enchy7.jpg" alt="enchy1" width="480" height="360"/>
                                <img src="assets/image/enchy8.jpg" alt="enchy1" width="480" height="360"/>
                            </div></div>
                        <a href="#" id="enchyinfo">Enchytraeids (Oligochaeta)</a>, small soil invertebrates, are sensitive to chemicals and other stress factors. They are used as test organisms for environmental risk assessment using standardized guidelines where effects on reproduction and survival are assessed (ISO no 16387, 2004; OECD no 220, 2004). <br/>
                        Information at the gene level, as provided by transcriptomic studies, can elucidate the underlying mechanisms of response occurring in organisms. A series of experiments were performed with <em>Enchytraeus albidus</em> and different genomic libraries developed. Expressed Sequence Tags (EST) were generated and a microarray developed (Agilent platform). EnchyBASE provides all the genomic data which has been generated for enchytraeids and contributes for toxicogenomic effect assessment.
                        <div id="enchyinfobox">
                            The family Enchytraeidae belongs to the Phylum Annelida, class Clitellata, order Oligochaeta. They are are dominant members of the soil biocenosis in many temperate biotopes and are distributed in soils worldwide. Enchytraeidsbelong to the saprophagous mesofauna of the litter layer and the upper mineral soil and contribute to vital processes of this environmental compartment. Indirectly they are involved in regulating the degradation of organic matter, as well as improving the pore structure of the soil.<br />
                            <em>Enchytraeus albidus</em> is the best-known and one of the largest species of the genus Enchytraeus. It has an average size of about 20 mm. Worldwide it occurs in places where a large amount of organic material is present. 

                        </div> 
                    </div>
                    <div id="search">
                        <div id="partigene" class="white">
                            <iframe src="search.html" width="100%" height="800px">
                            <p>Your browser does not support iframes.</p>
                            </iframe>

                        </div>
                    </div>
                    <div id="blast" class="white">
                        <iframe src="viroblast/viroblast.php" width="100%" height="800px">
                        <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
                            <br /><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .7em;"></span>
                                Your browser does not support iframes.</p><br />
                        </div>
                        </iframe>


                    </div>
                    <div id="microarray" class="white">
                        <h1>GEO</h1>
                        <br />
                        <br />
                        <p><strong>Effects of soil properties and time of exposure on gene expression of <em>Enchytraeus albidus</em></strong><br />
                            <a href="http://www.ncbi.nlm.nih.gov/geo/query/acc.cgi?acc=GSE27700" target="_blank">GEO series GSE27700</a>
                        </p>
                        <br />
                        <br />
                        <p><strong>Differential gene expression analysis in <em>Enchytraeus albidus</em> exposed to natural and chemical stressors at different exposure periods</strong><br />
                            <a href="http://www.ncbi.nlm.nih.gov/geo/query/acc.cgi?acc=GSE26896" target="_blank">GEO Series GSE26896</a>
                        </p>
                        <br />
                        <br />
                        <p><strong>Development of a microarray for <em>Enchytraeus albidus (Oligochaeta)</em>: Preliminary tool with diverse applications</strong><br />
                            <a href="http://www.ncbi.nlm.nih.gov/geo/query/acc.cgi?acc=GSE18569" target="_blank">GEO Series GSE18569</a>
                        </p>
                        <br />
                        <br />
                        <p><strong>Effect of Cu-Nanoparticles versus Cu-salt in <em>Enchytraeus albidus (Oligochaeta)</em>: differential gene expression through microarray analysis.</strong><br />
                            <a href="http://www.ncbi.nlm.nih.gov/geo/query/acc.cgi?acc=GSE26331" target="_blank">GEO Series GSE26331</a>
                        </p>
                    </div>
                    <div id="publications" class="white">
                        <h2>Publications with the EST information present in EnchyBASE</h2>
                        <p class="article">
                            Gomes, S.I.L., Novais, S.C., Scott-Fordsmand, J.J., de Coen, W., Soares, A.M.V.M., Amorim, M.J.B., 2011. <em>Effect of Cu-Nanoparticles versus Cu-salt in Enchytraeus albidus (Oligochaeta): differential gene expression through microarray analysis</em>. <strong>Comparative Biochemistry and Physiology - Part C: Toxicology & Pharmacology</strong>, in press. <br />
                            <a href="http://www.sciencedirect.com/science/article/pii/S1532045611001785" target="_blank">DOI: 10.1016/j.cbpc.2011.08.008</a>
                        </p>
                        <p><strong>Abstract</strong><br/>
                            Despite increased utilization of copper (Cu) nano particles, their behaviour and effect in the environment is largely unknown. Enchytraeidsare extensively used in studies of soil ecotoxicology. Ecotoxicogenomic tools have shown to be valuable in nanotoxicity interpretation. A cDNA microarray for <em>Enchytraeus albidus</em> has recently been developed, which was used in this study.  We compared the gene expression profiles of <em>E. albidus</em> when exposed to Cu-salt (CuCl2) and Cu nano particles (Cu-NP) spiked soil. Exposure time was 48 hours with a concentration range of 400 to 1000 mg Cu/kg. There were more down-regulated than up-regulated genes. The number of differently expressed genes (DEG) decreased with increasing concentration for CuCl2 exposure, whereas for Cu-NP, the number did not change. The number of common DEG decreased with increasing concentration. Differences were mainly related to transcripts involved in energy metabolism (e.g. monosaccharide transporting ATPase, NADH dehydrogenase subunit 1, cytochrome c). Overall, our results indicated that Cu-salt and Cu-NP exposure induced different gene responses. Indirect estimates of Cu-NP related ion-release indicated little or no free Cu2+ activity in soil solutions. Hence, it was concluded that the Cu-NP effects were probably caused by the nano particles themselves and not by released ions.
                        </p>
                        <br />
                        <p class="article">
                            Novais, S.C., Howcroft-Ferreira, C., Carreto, L., Pereira, P.M., Santos, M.A.S., De Coen, W., Soares, A.M.V.M., Amorim, M.J.B., 2011. <em>Differential gene expression analysis in Enchytraeus albidus exposed to natural and chemical stressors at different exposure periods</em>. <strong>Ecotoxicology</strong>, in press. <br />
                            <a href="http://www.springerlink.com/content/jgh8178x671u0493/" target="_blank">DOI: 10.1007/s10646-011-0780-4</a>
                        </p>
                        <p><strong>Abstract</strong><br/>
                            The soil oligochaete <em>Enchytraeus albidus</em> is a standard test organism used in biological testing for Environmental Risk Assessment (ERA). Although effects are known at acute and chronic level through survival, reproduction and avoidance behaviour endpoints, very little is known at the sub-cellular and molecular levels. In this study, the effects of soil properties (clay, organic matter and pH) and of the chemicals copper and phenmedipham were studied on E. albidus gene expression during exposure periods of 2, 4 and 21 days, using DNA microarrays based on a normalised cDNA library for this test species (Amorim et al., 2011) The main objectives of this study were: 1) to assess changes in gene expression of E. albidus over time, and 2) to identify molecular markers for natural and chemical exposures. Results showed an influence of exposure time on gene expression. Transcriptional responses to phenmedipham were seen at 2 days while the responses to copper and the different soils were more pronounced at 4 days of exposure. Some genes were differentially expressed in a stress specific manner and, in general, the responses were related with effects in the energy metabolism and cell growth.
                        </p>
                        <br />

                        <p class="article">
                            Amorim, M.J.B., Novais, S.C., Van der Ven, K., Vandenbrouck, T., Soares, A.M.V.M., De Coen, W., 2011. <em>Development of a Microarray for Enchytraeus albidus (Oligochaeta): Preliminary Tool with Diverse Applications</em>. <strong>Environmental Toxicology and Chemistry</strong> 30, 1395-1402. <br />
                            <a href="http://onlinelibrary.wiley.com/doi/10.1002/etc.512/abstract" target="_blank">DOI: 10.1002/etc.512</a>
                        </p>
                        <p><strong>Abstract</strong><br/>
                            Standard bioassays allow hazard assessment at the population level, but much remains to be learned about the molecular level
                            response of organisms to stressors. The main aim of this study was the development of a DNA microarray for <em>Enchytraeus albidus</em>, a
                            common soil worm species. Further, this microarray was tested using worms exposed to Cu, phenmedipham, and different soil types.
                            Hybridization onto the developed microarray revealed several genes with homology to known sequences. Genes of interest were
                            confirmed through real-time polymerase chain reaction. It was possible to discriminate between natural and chemical stressors and
                            chemical concentrations. Gene responses were detected under conditions known to have effects in the reproduction of individuals. It was
                            confirmed that the integration of different endpoints improves the assessment process and enhances the understanding of the modes of
                            action of stressors. The chemical stress-induced genes were related to factors such as immune response, stress response, metabolic
                            processes, and/or signal transduction. The present study represents the first step of a gene-level study in the ecologically relevant and
                            standard test species E. albidus. It demonstrates the usefulness of cDNA normalization in the production of cDNA libraries of
                            ecotoxicological standard organisms that are not genome models like E. albidus.
                        </p>
                        <br />
                        <br />
                        <p class="article">Gomes S.I.L., Novais S.C., Soares A.M.V.M., Amorim M.J.B., 2011.<em>Effects of soil properties and time of exposure on gene expression of Enchytraeus albidus</em>. <strong>Soil Biology & Biochemistry</strong> 43, 2078-2084.<br />
                            <a href="http://www.sciencedirect.com/science/article/pii/S0038071711002355" target="_blank">DOI: 10.1016/j.soilbio.2011.06.006</a></p>
                        <p><strong>Abstract</strong><br/>
                            Changes in soil properties (e.g. pH, organic matter content, granulometry) can influence chemical toxicity
                            to organisms and act alone as stressors. Previous studies on <em>Enchytraeus albidus</em> showed that changes in
                            soil properties caused effects on reproduction and avoidance behavior and also oxidative stress. In
                            addition, results at the transcritptomic level indicated changes in gene expression profile due to soil
                            properties changes. In this study, E. albidus was exposed to modified versions of the artificial standard
                            OECD soil (higher clay and lower sand proportion, lower pH, and lower organic matter content) in
                            different exposure times (2, 4 and 8 days). The gene expression profile was characterized using a class
                            comparison statistical analysis. Results indicated that the transcriptional response was time dependent,
                            with different genes being affected at different time points. Results also showed some genes (and biological
                            functions) being affected in a soil specific way. The unknown gene function in the data-set makes
                            further discrimination difficult.
                        </p>
                    </div>
                </div>
            </div>
            <div id="sidebar">                
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </body>
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-12230872-6']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>
</html>
