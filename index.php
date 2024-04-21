<?php
	session_start();
	$time = time();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>||| PBOT - Path of Bravure or Torment |||</title>
    <link rel="shortcut icon" href="img/favicon.ico" />
    <link href="css/stile.css" type="text/css" rel="stylesheet" />
    <link href="css/query.css" type="text/css" rel="stylesheet" />
    <link href="css/accordeon.css" type="text/css" rel="stylesheet" />    
    <link href="css/grid-rank.css" type="text/css" rel="stylesheet">
    <link href="css/jquery-ui.min.css" type="text/css" rel="stylesheet" />
    
    <link href='https://fonts.googleapis.com/css?family=Comfortaa|Tangerine|Poiret+One|Righteous|Fredericka+the+Great|Baumans|Iceland|UnifrakturMaguntia' rel='stylesheet' type='text/css' />
    <link href='https://fonts.googleapis.com/css?family=Varela+Round|Josefin+Sans|Indie+Flower|Lovers+Quarrel|New+Rocker|Fredericka+the+Great' rel='stylesheet' type='text/css' />
    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
    <script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.cycle.all.2.74.js"></script>
    <script type="text/javascript" src="js/scripts.js?_=<?php echo $time; ?>"></script>
    <script type="text/javascript" src="js/language/pt.js?_=<?php echo $time; ?>"></script>
    <script type="text/javascript" src="js/language/en.js?_=<?php echo $time; ?>"></script>
</head>
<body oncontextmenu="return false">
    <div id="slideshow">
        <img src="bg/11.jpg" class="bgM"/>
        <img src="bg/22.jpg" class="bgM"/>
        <img src="bg/33.jpg" class="bgM"/>
        <img src="bg/44.jpg" class="bgM"/>
        <img src="bg/55.jpg" class="bgM"/>
        <img src="bg/66.jpg" class="bgM"/>
        <img src="bg/77.jpg" class="bgM"/>
        <img src="bg/88.jpg" class="bgM"/>
        <img src="bg/99.jpg" class="bgM"/>
    </div>
    <div class="bg">
        <!-- <a href="#" class="wiki">Wiki-PBOT</a> -->
        <div class="menu hide-mobile">
            <ul>
                <li><img class="" src="img/logo-menu.png" /></li>
                <li><a href="#" ajax="index.html" translate="yes">Principal</a></li>
                <li><a href="#" ajax="account.html" translate="yes">Conta</a></li>
                <li><a href="#" ajax="eventos.html" translate="yes">Eventos</a></li>
                <li><a href="#" ajax="ranking.html" translate="yes">Classificações</a></li>
                <li><a href="forum/index.php" target="_blank" translate="yes">Forum</a></li>
                <li><a href="#" ajax="donate.html" translate="yes">Doações</a></li>
                <li><a href="#" ajax="staff.html" translate="yes">Equipe</a></li>
                <li><a href="wiki/" target="_blank" class="wiki" translate="yes">Informações do Servidor</a></li>
            </ul>
        </div>
        <div class="logo">
            <img class="logo-img" src="img/logo.png" />
        </div>
        <div class="online">
            <a href="online.html"><span><strong>Online: </strong><?php include 'scripts/countPlayersOnline.php';?></span></a>
            <img src="img/online.png" />
            <a class="language" href="#" lang="en">
                <img class="flags" src="img/usa.png">
            </a>
            <a class="language" href="#" lang="pt">
                <img class="flags flag2" src="img/bra.png">
            </a>
        </div>
        <div class="menu-body">
            <ul>
                <li><a href="#" ajax="index.html" translate="yes">Principal</a></li>
                <li><a href="#" ajax="account.html" translate="yes">Conta</a></li>
                <li><a href="#" ajax="eventos.html" translate="yes">Eventos</a></li>
                <li><a href="#" ajax="ranking.html" translate="yes">Classificações</a></li>
                <li><a href="forum/index.php" target="_blank" translate="yes">Forum</a></li>
                <li><a href="#" ajax="donate.html" translate="yes">Doações</a></li>
                <li><a href="#" ajax="staff.html" translate="yes">Equipe</a></li>
                <li><a href="wiki/" target="_blank" class="wiki" translate="yes">Informações do Servidor</a></li>
            </ul>
            <a href="downloads/pbot.exe"><span class="span-download" translate="yes">Download</span><img class="img-download" src="img/download.png" /></a>
        </div>
        <div class="pesquisar"><span class="pesquisar-btn"><labe translate="yes">Personagem</labe>:</span><input class="txt-pesquisar" id="personagemField" type="text" /><input class="btn-pesquisar-personagem" type="button" ></input></div>
        <div class="content">
            <div class="content-main">
            	<?php
					if(!@include('contents/'.$_REQUEST['url'])) {
						include('contents/index.html');
					}			
				?>
            </div>
        </div>
		<div id="googleSecurity" style="display: none;">
			<div class="g-recaptcha lblAccRegAutentic" data-sitekey="6LdY3icTAAAAAETaYh0OShriQsJFVf0D1yhmGf4T"></div>
		</div>
        <div class="social">
            <img src="img/social.png" />
            <a href="https://www.facebook.com/pbotoficial" target="_blank"><img class="social-f" src="img/face.png" /></a>
            <a href="https://www.youtube.com/channel/UCLb8C4lP5Yu1o73zMx5hd2A" target="_blank"><img class="social-y" src="img/yt.png" /></a>
            <a href="https://twitter.com/pbotoficial" target="_blank"><img class="social-t" src="img/twt.png" /></a>
        </div>
    </div>
    <div id="ajaxLoader">
    	<div id="centerImg"></div>
    	<div id="centerTxt"></div>
		<div id="modal"></div>
	</div>
</body>
</html>