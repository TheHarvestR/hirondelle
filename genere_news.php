<?php

include('connect.php');
$req = $bdd->query('SET lc_time_names = \'fr_FR\'');

$req = $bdd->query('
	SELECT 
		DATE_FORMAT(news_date, \'%e %M %Y\') AS date_fr,
		news_titre, 
		news_texte,
		news_afficher,
		news_lien,
		news_lien_externe
	FROM 
		actualites
	ORDER BY 
		news_date DESC;
');

// Début de la page html générée
$page = '<!DOCTYPE html>' . PHP_EOL . '<html lang="fr">' . PHP_EOL .'<head>' . PHP_EOL . '    <meta charset="utf-8" />' . PHP_EOL . '    <base target="_parent">' . PHP_EOL . '    <link rel="stylesheet" href="css/news_scroll.css" type="text/css">'.PHP_EOL.'    <title>News</title></head>'.PHP_EOL;
$page .= '<body class="news-scroll" onMouseover="scrollspeed=0" onMouseout="scrollspeed=current" OnLoad="NewsScrollStart();">'.PHP_EOL;
$page .= '<div id="NewsDiv">' . PHP_EOL . '<div class="scroll-text-if">' . PHP_EOL;

// Ajout des news depuis la BDD
while ($donnees = $req->fetch())
{
    if ($donnees['news_afficher']==1) {
		$texte = '<span class="scroll-title-if">'. PHP_EOL . $donnees['news_titre'] . '<br />' .PHP_EOL. '</span>' . PHP_EOL  . $donnees['news_texte'] . PHP_EOL;
		if ($donnees['news_lien'] != "") {
			$texte .= ' <a href="' . $donnees['news_lien'] . '"';
			if ($donnees['news_lien_externe']==1) {
				$texte .= ' target="_blank"';
			}
			$texte .= '>Plus...</a>' . PHP_EOL;
		}
		$texte .= '<br />' . PHP_EOL . '<span style="text-align: right;font-size: 15px;font-style: italic;color: #505050">Publié le ' . $donnees['date_fr'] . '</span>' . PHP_EOL;
		$texte .= '<br /><br />' . PHP_EOL . PHP_EOL;
		$page .= $texte;
	}
}
$req->closeCursor();

// Suite de la page html générée
$page .= '</div></div>' . PHP_EOL . PHP_EOL;
$page .= '<script type="text/javascript">' . PHP_EOL . 'var startdelay = 0;' . PHP_EOL . 'var scrollspeed	= 1.1;' . PHP_EOL . 'var scrollwind = 1;' . PHP_EOL . 'var speedjump = 30;' . PHP_EOL;
$page .= 'var nextdelay = 0;' . PHP_EOL . 'var topspace = "2px";' . PHP_EOL . 'var frameheight = 292;' . PHP_EOL . 'current = (scrollspeed);' . PHP_EOL;
$page .= 'function HeightData(){' . PHP_EOL . 'AreaHeight=dataobj.offsetHeight' . PHP_EOL . 'if (AreaHeight===0){' . PHP_EOL . 'setTimeout("HeightData()",( startdelay * 1000 ))' . PHP_EOL . '}' . PHP_EOL . 'else {' . PHP_EOL . 'ScrollNewsDiv()' . PHP_EOL . '}}' . PHP_EOL;
$page .= 'function NewsScrollStart(){' . PHP_EOL . 'dataobj=document.all? document.all.NewsDiv : document.getElementById("NewsDiv")' . PHP_EOL . 'dataobj.style.top=topspace' . PHP_EOL . 'setTimeout("HeightData()",( startdelay * 1000))' . PHP_EOL . '}' . PHP_EOL;
$page .= 'function ScrollNewsDiv(){' . PHP_EOL . 'dataobj.style.top=scrollwind+\'px\';' . PHP_EOL . 'scrollwind-=scrollspeed;' . PHP_EOL . 'if (parseInt(dataobj.style.top)<AreaHeight*(-1)) {' . PHP_EOL . 'dataobj.style.top=frameheight+\'px\';' . PHP_EOL . 'scrollwind=frameheight;' . PHP_EOL . 'setTimeout("ScrollNewsDiv()",( nextdelay * 1000 ))' . PHP_EOL . '}' . PHP_EOL . 'else {' . PHP_EOL . 'setTimeout("ScrollNewsDiv()",speedjump)' . PHP_EOL . '}}' . PHP_EOL . '</script></body></html>';

// Enregistrement du fichier news.html
$fichiernews = fopen('../news.html', 'w+');
fputs($fichiernews, $page);
fclose($fichiernews);