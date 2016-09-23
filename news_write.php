<?php

if (isset($_POST['id'])) {
	if (is_numeric($_POST['id'])) {
		$newsid = intval($_POST['id']);
	} else {
		$newsid = -1;
	}
} else {
	$newsid = 0;
}

$datas = postToArray($_POST);

if ($datas['datesql'] != "" && $datas['titre'] != "" && $datas['texte'] != "") {
	include('connect.php');
	
	if ($newsid > 0) {
		// Mise à jour d'un article existant
		// Vérification de l'existance de l'article 
		$req = $bdd->prepare("SELECT COUNT(id) FROM actualites WHERE id=?");
		$req->execute(array($newsid));
		$resultat = $req->fetch();
		if ($resultat) {
			$req = $bdd->prepare(
				'UPDATE actualites SET
					news_date = :datesql,
					news_titre = :titre,
					news_texte = :texte,
					news_afficher = :afficher,
					news_afficher_archive = :archive,
					news_lien = :lien,
					news_lien_externe = :externe
				WHERE
					id = ' . $newsid
			);
			$req->execute($datas);
			echo 'ok_maj';
			$req->closeCursor();
		} else {
			echo 'erreur_maj';
		}
	} else if ($newsid == 0) {
		// Nouvel article
		$req = $bdd->prepare(
			'INSERT INTO actualites SET
				news_date = :datesql,
				news_titre = :titre,
				news_texte = :texte,
				news_afficher = :afficher,
				news_afficher_archive = :archive,
				news_lien = :lien,
				news_lien_externe = :externe'
		);
		$req->execute($datas);
		echo 'ok_ajout';
		$req->closeCursor();
	} else {
		echo 'erreur_ajout';
	}
} else {
	echo 'erreur_envoi';
}

function postToArray($post) {
	$retour = [];
	if (isset($post['datefr'])) {
		$retour['datesql'] = date_change_format($post['datefr'], 'd/m/Y', 'Y-m-d');
	} else {
		$retour['datesql'] = "";
	}
	if (isset($post['titre'])) {
		$retour['titre'] = htmlspecialchars($post['titre']);
	} else {
		$retour['titre'] = "";
	}
	if (isset($post['texte'])) {
		$retour['texte'] = htmlspecialchars($post['texte']);
	} else {
		$retour['texte'] = "";
	}
	if (isset($post['afficher'])) {
		$retour['afficher'] = intval($post['afficher']);
	} else {
		$retour['afficher'] = 0;
	}
	if (isset($post['archive'])) {
		$retour['archive'] = intval($post['archive']);
	} else {
		$retour['archive'] = 0;
	}
	if (isset($post['lien'])) {
		$retour['lien'] = htmlspecialchars($post['lien']);
	} else {
		$retour['lien'] = "";
	}
	if (isset($post['externe'])) {
		$retour['externe'] = intval($post['externe']);
	} else {
		$retour['externe'] = 0;
	}
	return $retour;
}

function date_change_format($ladate,$from='Y-m-d', $to='d/m/Y'){ // PHP > 5.3
	if($ladate !=''){
		if ( preg_match ( "!^(0?\d|[12]\d|3[01])(/)(0?\d|1[012])(/)((?:19|20)\d{2})$!" , $ladate ) ) {
			$date = DateTime::createFromFormat($from, $ladate);
			if(!$date){
				return "";
			} else {
				return $date->format($to);	
			}
		} else {
			return "";
		}
	} else {
		return "";
	}
}