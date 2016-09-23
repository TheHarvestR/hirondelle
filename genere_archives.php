<?php

include('connect.php');
$req = $bdd->query('SET lc_time_names = \'fr_FR\'');

// Début de la page html générée
$page = '<!DOCTYPE html>' . PHP_EOL . '<html lang="fr">' . PHP_EOL .'<head>' . PHP_EOL . '    <meta charset="utf-8" />' . PHP_EOL . '    <base target="_parent">' . PHP_EOL . '    <link rel="stylesheet" href="css/archive_news.css" type="text/css">'. PHP_EOL .'    <title>Archives</title>'. PHP_EOL .'</head>'.PHP_EOL;
$page .= '<body>' . PHP_EOL . '<table>' . PHP_EOL;
$page .= '    <th>'. PHP_EOL .'        <span class="titre-table">Actualités archivées</span>'. PHP_EOL .'    <th>'. PHP_EOL;

// Requête de lecture des news dans la BDD
$req = $bdd->query('
	SELECT 
		DATE_FORMAT(news_date, \'%e %M %Y\') AS date_fr,
		news_titre, 
		news_texte,
		news_afficher,
		news_afficher_archive,
		news_lien,
		news_lien_externe
	FROM 
		actualites
	WHERE
		news_afficher_archive=1;
	ORDER BY 
		news_date DESC;
');

// Ajout des news archivées depuis la BDD
while ($donnees = $req->fetch())
{
    if ($donnees['news_afficher_archive']==1) {
		$texte = '    <tr>'. PHP_EOL . '        <td>'. PHP_EOL . '            <span class="titre-archive">'. $donnees['news_titre'] . '<br /></span>' . PHP_EOL;
		$texte .= '            <span class="texte-archive">' . $donnees['news_texte'];
		// Ajoute la balise <a href> s'il y a un lien, et la balise target="_blank" si c'est un lien externe au site
		if ($donnees['news_lien'] != "") {
			$texte .= ' <a href="' . str_replace('&', '&amp', $donnees['news_lien']) . '"';
			if ($donnees['news_lien_externe']==1) {
				$texte .= ' target="_blank"';
			}
			$texte .= '>Plus...</a>';
		}
		$texte .= '<br /></span>' . PHP_EOL . '            <span class="date-archive">Publié le ' . $donnees['date_fr'] . '</span>' . PHP_EOL;
		$texte .= '        </td>' . PHP_EOL . '    </tr>' . PHP_EOL;
		$page .= $texte;
	}
}
$req->closeCursor();

// Suite du code HTML de la page html générée
$page .='</table>' . PHP_EOL . '</div>' . PHP_EOL . '</body>' . PHP_EOL . '</html>';

// Enregistrement du fichier archive_news.html
$fichiernews = fopen('../archive_news.html', 'w+');
fputs($fichiernews, $page);
fclose($fichiernews);