<?php

if (isset($_POST['id'])) {
		if (is_numeric($_POST['id'])) {
		$newsid = intval($_POST['id']);
	} else {
		$newsid = 0;
	}
} else {
	$newsid = 0;
}

include('connect.php');

// Vérification de l'existance de l'article 
if ($newsid>0) {
	$req = $bdd->prepare("SELECT COUNT(id) FROM actualites WHERE id=?");
	$req->execute(array($newsid));
	$resultat = $req->fetch();
	var_dump($resultat);
	if ($resultat[0] != "0") {
		$req = $bdd->query("DELETE FROM actualites WHERE id=" . $newsid);
	} else {
		echo('erreur_suppression');
	}
}