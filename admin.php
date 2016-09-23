<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <base target="_parent">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/themes/cupertino/jquery-ui.css">
    <link rel="stylesheet" href="css/admin.css" type="text/css">
    <title>Administration des News</title>
</head>
<body>

<p id="entete">Administration des Actualités<br /></p>
<div class="hot-container"><p id="btnnew">Ajouter une News</p></div>

<div class="wrapper">
	<table id="actus">
		<thead>
			<tr class="hors_champ">
				<th class="masque">id</th>
				<th>Actualité</th>
				<th>Date</th>
				<th>Publiée</th>
				<th>Lien</th>
			</tr>
		<thead>
		<tfoot>
			<tr class="hors_champ">
				<td colspan="3" class="pied">Cliquez sur une ligne pour afficher ou modifier une actualité</td>
				<td class="pied" id="aide">Aide</td>
			</tr>
		</tfoot>
		<tbody>
			<tr>
				<?php
					include('connect.php');
					$req = $bdd->query('SET lc_time_names = \'fr_FR\'');
			
					// Requête de lecture des news dans la BDD
					$req = $bdd->query('
						SELECT 
							id,
							DATE_FORMAT(news_date, \'%e %M %Y\') AS date_fr,
							news_titre, 
							news_texte,
							news_afficher,
							news_afficher_archive,
							news_lien,
							news_lien_externe
						FROM 
							actualites
						ORDER BY 
							news_date DESC;
					');
					while ($donnees = $req->fetch()) { ?>
					<td class="masque"><?php echo $donnees['id']; ?></td>
					<td><?php echo $donnees['news_titre']; ?></td>
					<td class="cellc"><?php echo $donnees['date_fr']; ?></td>
					<?php 
						if ($donnees['news_afficher'] == 1) {
							echo '<td class="cellc" id="bleu">Accueil'; }
						elseif ($donnees['news_afficher_archive'] == 1) {
							echo '<td class="cellc" id="rouge">Archives'; }
						else {
							echo '<td class="cellc">Non';
					}?></td>
					<?php
						if ($donnees['news_lien'] != null) {
							if ($donnees['news_lien_externe'] == 1) {
								echo '<td class="cellc" id="bleu">Externe'; }
							else {
								echo '<td class="cellc" id="vert">Interne'; }
							}
						else {
							echo '<td class="cellc">Aucun';
				}?></td>
		</tr><?php } ?>
		</tbody>
	</table>
</div>

<div class="uni-form-wrap">
    <form class="uni-form" method="post">
        <fieldset>
			<input type="hidden" id="id" />
            <div class="ctrl-holder">
                <label for="">Date</label>
                    <input name="date" id="datepicker" data-default-value="" size="35" maxlength="50" type="text" class="input-text small"/>
                </div>
                <div class="ctrl-holder">
                <label for="">Titre</label>
                <input name="titre" id="titre" data-default-value="" size="35" maxlength="50" type="text" class="input-text large"/>
            </div>
            <div class="ctrl-holder">
                <label for="">Contenu</label>
                <textarea class="input-textarea" name="texte" id="texte" rows="15" cols="25"></textarea>
            </div>
            <div class="ctrl-holder">
                <label for="">Lien</label>
                <input name="lien" id="lien" data-default-value="" size="35" maxlength="50" type="text" class="input-text large"/>
                <label for="externe"><input id="externe" name="" type="checkbox"> Externe</label>
            </div>
            <div class="ctrl-holder">
                <label for="">Publiée dans :
                    <label for="accueil" class="noir"><input id="accueil" name="publie" value="a" type="radio" checked="checked"/> Accueil</label>
                    <label for="archive" class="noir"><input id="archive" name="publie" value="b" type="radio"/> Archives</label>
                    <label for="aucun" class="noir"><input id="aucun" name="publie" value="c" type="radio"/> Brouillons</label>
                </label>
            </div>

            <div class="button-holder">
                <button type="reset" class="action-primary" id="btnsave">Enregistrer</button>
                <button type="reset" class="action-primary" id="btndelete">Supprimer</button>
                <button type="reset" class="action-primary" id="btnclose">Fermer</button>
            </div>
        </fieldset>
		<div id="dialog" title="Confirmation">
			<p>Voulez-vous vraiment supprimer cette actualité ?</p>
		</div>
    </form>
</div>

<!-- chargement de jQuery, de jQueryUI, du Calendrier FR et du script de la page -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<script src="js/datepicker-fr.js" type="text/javascript"></script>
<script src="js/admin.js" type="text/javascript"></script>

</body>
</html>
