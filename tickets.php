<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/40354d1261.js" crossorigin="anonymous"></script>
	<script>
		var state = 1;
		function toggleAll() {
			if (state == 1) {
				$('.Plus').hide()
				$('.Moins').show()
				$('.Detail').show();
				$('.info').hide();
				$('.close').show();
				state = 0;
				console.log("element shown");
			}else{
				$('.Moins').hide()
				$('.Plus').show()
				$('.Detail').hide();
				$('.info').show();
				$('.close').hide();
				state = 1;
				console.log("element hidded");
			}
		}
		
		function toggleThis(id){
			$(id+"info").toggle();
			$(id+"close").toggle();
			$(id+"Detail").toggle();
			console.log("toggled "+id);
			console.log($(id+"Detail").attr("style"));
		}
		
	$(document).ready(function(){
		$(".zoomed").mouseover(function(){
		  $(this).css("font-size", "30px");
		});
		
		$(".zoomed").mouseleave(function(){
		  $(this).css("font-size", "15px");
		});
	});
	</script>
</head>


<?php
	include_once("./DB_connect.php");
	include_once("./Class/class_produit.php");
	include_once("./Class/class_categorie.php");
	include_once("./Class/class_ticket.php");
	
	$id = $_GET['id'];
	$request_tickets = "SELECT id AS ticket_id, date AS ticket_date FROM tickets WHERE utilisateur_id = $id ORDER BY date";
	$tickets_bdd = $pdo->prepare($request_tickets);
	$tickets_bdd->execute();
	$tickets_bdd->setFetchMode(PDO::FETCH_CLASS, 'ticket');
	
	$request_categories = "SELECT DISTINCT categories.nom AS categorie_nom FROM ticket_entry JOIN produits ON ticket_entry.produit_id = produits.id JOIN categories ON categories.id = produits.categorie_id WHERE ticket_entry.ticket_id=:ticketId GROUP BY categories.nom";
	$categories_bdd = $pdo->prepare($request_categories);
	$categories_bdd->bindParam(':ticketId', $TheId);
	$categories_bdd->setFetchMode(PDO::FETCH_CLASS, 'categorie');
	
	$request_produit = "SELECT produits.id AS produit_id, produits.nom AS produit_nom, ticket_entry.quantite AS produit_quantite, produits.prix AS produit_prix FROM ticket_entry join produits on ticket_entry.produit_id = produits.id join categories on categories.id = produits.categorie_id where ticket_entry.ticket_id=:ticketId and categories.nom=:categorieNom";
	$produits_bdd = $pdo->prepare($request_produit);
	$produits_bdd->bindParam(':ticketId', $TheId);
	$produits_bdd->bindParam(':categorieNom', $TheCatNom);
	$produits_bdd->setFetchMode(PDO::FETCH_CLASS, 'produit');
	
	$tickets = array();
	$i = 0;
	foreach ($tickets_bdd->fetchAll() as $ticket) {
		$tickets[$i] = $ticket;
		$TheId = $ticket->ticket_id;
		$categories_bdd->execute();
		$j = 0;
		foreach ($categories_bdd->fetchAll() as $categorie) {
			$tickets[$i]->ticket_categories[$j] = $categorie;
			$TheCatNom = $categorie->categorie_nom;
			$produits_bdd->execute();
			$k = 0;
			foreach ($produits_bdd->fetchAll() as $produit) {
				$tickets[$i]->ticket_categories[$j]->categorie_produits[$k] = $produit;
				$k += 1;
			}
			$j += 1;
		}
		$i += 1;
	}
?>

	<!-- Second Parallax Image with Portfolio Text -->
	<div class="bgimg-2 w3-display-container w3-opacity-min">
	  <div class="w3-display-middle">
	    <span class="w3-xxlarge w3-text-white w3-wide">Tickets</span>
	  </div>
	</div>
	

	<div class="w3-panel w3-theme-d2 w3-round-xlarge">
	<table class="w3-table w3-light-grey">
		<thead class="w3-theme-d2">
			<tr>
				<th>ID</th>
				<th>Date</th>
				<th class="DetailNNN">Détails<div class="w3-right"><button class="w3-theme-l1 w3-button w3-circle" onclick="toggleAll()"><i class="fas fa-minus Moins" style='display: none'></i><i class="fas fa-plus Plus"></i></button></div></th>
			</tr>
		</thead>
		<?php
			foreach ($tickets as $ticket) {
				echo $ticket;
			}
		?>
	</table>
		