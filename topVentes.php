<?php
	include_once("./DB_connect.php");
	include_once("./Class/class_produit.php");
		
	$request_topProduit = "SELECT produits.id AS produit_id, produits.nom AS produit_nom, sum(ticket_entry.quantite) AS produit_quantite, produits.prix AS produit_prix FROM ticket_entry join produits on ticket_entry.produit_id = produits.id join categories on categories.id = produits.categorie_id group by produits.id order by produit_quantite DESC";
	$topProduit_bdd = $pdo->prepare($request_topProduit);
	$topProduit_bdd->execute();
	$topProduit_bdd->setFetchMode(PDO::FETCH_CLASS, 'produit');
?>

	<!-- Second Parallax Image with Portfolio Text -->
	<div class="bgimg-2 w3-display-container w3-opacity-min">
	  <div class="w3-display-middle">
	    <span class="w3-xxlarge w3-text-white w3-wide">Top Ventes</span>
	  </div>
	</div>

	<div class="w3-panel w3-theme-d2 w3-round-xlarge">
	<table class="w3-table w3-striped w3-grey">
		<thead class="w3-theme-d2">
			<tr>
				<th>Produit</th>
				<th>quantité</th>
				<th>Prix unitaire</th>
				<th>Prix</th>
				<?php
					if(isset($_SESSION['User']) && $_SESSION['User']->user_admin == 1){
						echo "<th>Acheteurs</th>";
					}
				?>
			</tr>
		</thead>
		<?php
			foreach ($topProduit_bdd->fetchAll() as $topProduit) {
				echo $topProduit;
			}
		?>
	</table>
	</div>