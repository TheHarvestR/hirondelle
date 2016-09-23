<?php

if (isset($_GET['id'])) {
	if (is_numeric($_GET['id'])) {
		include('connect.php');
		$req = $bdd->query('SET lc_time_names = \'fr_FR\'');

		$req = $bdd->query('
			SELECT 
				id,
				DATE_FORMAT(news_date, \'%d/%m/%Y\') AS date_fr,
				news_titre, 
				news_texte,
				news_afficher,
				news_afficher_archive,
				news_lien,
				news_lien_externe
			FROM 
				actualites
			WHERE
				id = ' . $_GET['id'] . ';
		');
		while ($donnees = $req->fetch()) {
			$reponse = $donnees['id'] . '|';
			$reponse .= $donnees['date_fr'] . '|';
			$reponse .= $donnees['news_titre'] . '|';
			$reponse .= $donnees['news_texte'] . '|';
			$reponse .= $donnees['news_lien'] . '|';
			$reponse .= $donnees['news_lien_externe'] . '|';
			$reponse .= $donnees['news_afficher'] . '|';
			$reponse .= $donnees['news_afficher_archive'];
		}
		$req->closeCursor();
		if (isset($reponse)) { 
			echo $reponse; 
		} else {
			echo 'vide';
		}
	}

} else {
	echo 'noindex';
}