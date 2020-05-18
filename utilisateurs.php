<?php
	include_once("./DB_connect.php");
	include_once("./Class/class_user.php");
	
	if(isset($_POST['User_modif_request_id']) && !empty($_POST['User_modif_request_nom'])){
		$request_UserExist = "SELECT count(id) as cpt, nom , prenom, admin from utilisateurs where utilisateurs.id =".$_POST['User_modif_request_id']."GROUP BY admin, prenom, nom";
		$UserExist_bdd = $pdo->prepare($request_UserExist);
		$UserExist_bdd->execute();
		$UserExist = $UserExist_bdd->fetch();
		if($UserExist['cpt'] < 1){
			$request_create_user = "INSERT INTO utilisateurs(id, prenom, nom, admin) VALUES (:TheId, :ThePrenom, :TheNom, :TheAdminStatut)";
			$create_bdd = $pdo->prepare($request_create_user);
			$create_bdd->bindParam(':TheId', $TheId);
			$create_bdd->bindParam(':ThePrenom', $ThePrenom);
			$create_bdd->bindParam(':TheNom', $TheNom);
			$create_bdd->bindParam(':TheAdminStatut', $TheAdminStatut);
			
			$TheId = $_POST['User_modif_request_id'];
			$ThePrenom = $_POST['User_modif_request_prenom'];
			$TheNom = $_POST['User_modif_request_nom'];
			if($_POST['User_modif_request_admin'] == "setAdmin"){
				$TheAdminStatut = "TRUE";
			}else{
				$TheAdminStatut = "FALSE";
			}
			
			$create_bdd->execute();
		}else{
			if($UserExist['admin'] == 1){
				echo "<script>window.alert('OPÉRATION NON PERMISE\\nVous avez tenté d\'altérer les informations d\'un Administrateur.')</script>\n";
			}else{
				if($UserExist['nom'] == $_POST['User_modif_request_nom'] && $UserExist['prenom'] == $_POST['User_modif_request_prenom'] && $UserExist['admin'] != 1 && empty($_POST['User_modif_request_admin'])){
// 					$request_DeleteUser = "DELETE FROM utilisateurs WHERE id =:TheId";
// 					$request_DeleteUser
// 					$DeleteUser = $pdo->prepare($request_DeleteUser);
// 					$DeleteUser->bindParam(':TheId', $TheId);
// 					$TheId = $_POST['User_modif_request_id'];
// 					$DeleteUser->execute();
					$request_UpdateUser = "UPDATE utilisateurs SET id=:TheId, prenom=:ThePrenom, nom=:TheNom, admin=:TheAdmin WHERE id=:TheId;";
					$UpdateUser = $pdo->prepare($request_UpdateUser);
					$UpdateUser->bindParam(':ThePrenom', $ThePrenom);
					$UpdateUser->bindParam(':TheNom', $TheNom);
					$UpdateUser->bindParam(':TheAdmin', $TheAdmin);
					$UpdateUser->bindParam(':TheId', $TheId);
					$UpdateUser->setFetchMode(PDO::FETCH_CLASS, 'categorie');
					$ThePrenom = $_POST['User_modif_request_prenom']."DELETE";
					$TheNom = $_POST['User_modif_request_nom']."DELETE";
					$TheAdmin = "FALSE";
					$TheId = $_POST['User_modif_request_id'];
					$UpdateUser->execute();
				}else{
					$request_UpdateUser = "UPDATE utilisateurs SET prenom=:ThePrenom, nom=:TheNom, admin=:TheAdmin WHERE id=:TheId;";
					$UpdateUser = $pdo->prepare($request_UpdateUser);
					$UpdateUser->bindParam(':ThePrenom', $ThePrenom);
					$UpdateUser->bindParam(':TheNom', $TheNom);
					$UpdateUser->bindParam(':TheAdmin', $TheAdmin);
					$UpdateUser->bindParam(':TheId', $TheId);
					$UpdateUser->setFetchMode(PDO::FETCH_CLASS, 'categorie');
					$ThePrenom = $_POST['User_modif_request_prenom'];
					$TheNom = $_POST['User_modif_request_nom'];
					if(empty($_POST['User_modif_request_admin'])){
						$TheAdmin = "FALSE";
					}else{
						$TheAdmin = "TRUE";
					}
					$TheId = $_POST['User_modif_request_id'];
					$UpdateUser->execute();
				}
			}
		}
	}
		
	$request = "SELECT id as user_id, prenom as user_prenom, nom as user_nom, admin as user_admin FROM utilisateurs";
	$result = $pdo->prepare($request);
	$result->execute();
	$result->setFetchMode(PDO::FETCH_CLASS, 'user');
	
	$Users = array();
	$i = 0;
	foreach ($result->fetchAll() as $user) {
		$Users[$i] = $user;
		$i = $i+1;
	}
	
	echo "<script>\n";
	echo "var Users = [];\n";
	foreach ($Users as $user) {
		echo "Users['".$user->user_id."'] = [];\n";
		echo "Users['".$user->user_id."']['prenom'] = '".$user->user_prenom."';\n";
		echo "Users['".$user->user_id."']['nom'] = '".$user->user_nom."';\n";
		echo "Users['".$user->user_id."']['admin'] = '".$user->user_admin."';\n";
	}
	echo "</script>\n";
?>

	<script>
		function isset(variable){
		  try{
		    return typeof(variable) !== 'undefined';
		  }catch(e){
		    return false;
		  }
		}
	
		function actualiseModifFormId() {
    		var x = document.getElementById('inputId').value;
    		if(isset(Users[x])){
	    		document.getElementById('inputPrenom').value = Users[x]['prenom'];
	    		document.getElementById('inputNom').value = Users[x]['nom'];
	    		if (Users[x]['admin'] == 1) {
	    			document.getElementById('inputAdmin').setAttribute("checked","checked");
				}else{
	    			document.getElementById('inputAdmin').removeAttribute("checked");
				}
				document.getElementById('inputSubmit').setAttribute("value","Supprimer");
			}else{
				document.getElementById('inputPrenom').value = "";
	    		document.getElementById('inputNom').value = "";
	    		document.getElementById('inputAdmin').removeAttribute("checked");
	    		document.getElementById('inputSubmit').setAttribute("value","Ajouter");
			}
			if (Users[x]['admin'] == 1) {
    			document.getElementById('inputSubmit').setAttribute("value","Unauthorized");
			}
		}
		
		function actualiseModifForm(){
			var x = document.getElementById('inputId').value;
			if(isset(Users[x]) && Users[x]['admin'] != 1){
				if(document.getElementById('inputPrenom').value == Users[x]['prenom'] && document.getElementById('inputNom').value == Users[x]['nom'] && document.getElementById('inputAdmin').checked == ""){
					document.getElementById('inputSubmit').setAttribute("value","Supprimer");
				}else{
					document.getElementById('inputSubmit').setAttribute("value","Modifier");
				}
			}
		}
		
		$(document).ready(function(){
		$(".colored").mouseover(function(){
		  $(this).css("color", "red");
		});
		
		$(".colored").mouseleave(function(){
		  $(this).css("color", "grey");
		});
	});
	</script>

	<!-- Second Parallax Image with Portfolio Text -->
	<div class="bgimg-2 w3-display-container w3-opacity-min">
	  <div class="w3-display-middle">
	    <span class="w3-xxlarge w3-text-white w3-wide">UTILISATEURS</span>
	  </div>
	</div>
	
	<button class="w3-button w3-theme-l1" onclick="OpenModal('modif_user')">Modifier</button>
	
	<!-- modal for user modification -->
	<div class="w3-modal" id="modif_user">
	<div class="w3-modal-content w3-animate-zoom w3-container" style="width:50%">
		<form action="index.php?page=utilisateurs.php" method="post">
        	<div class="w3-row">
        		<div class="w3-col l12 m12 s12">
	        		<input id="inputId" class="w3-input w3-border" style="margin-top:20px" type="text" placeholder="Id" onkeyup="actualiseModifFormId()" required name="User_modif_request_id">
	        	</div>
	        	<div class="w3-col l6 m6 s12">
	        		<input id="inputPrenom" class="w3-input w3-border" style="margin-top:20px" type="text" placeholder="Prénom" onkeyup="actualiseModifForm()" required name="User_modif_request_prenom">
	        	</div>
	        	<div class="w3-col l6 m6 s12">
	        		<input id="inputNom" class="w3-input w3-border" style="margin-top:20px" type="text" placeholder="Nom" onkeyup="actualiseModifForm()" required name="User_modif_request_nom">
	        	</div>
	        </div>
        	<input id="inputAdmin" class="w3-input w3-border w3-check" style="margin-top:5px" onmouseout="actualiseModifForm()" type="checkbox" name="User_modif_request_admin" value="setAdmin">
        	<label>Admin</label>
        	<input id="inputSubmit" type="submit" value="Ajouter" class="w3-button w3-theme w3-right w3-section"></input>
        </form>
	</div>
</div>

	
	<div class="w3-panel w3-theme-d2 w3-round-xlarge">
	<table class="w3-table w3-striped w3-grey">
		<thead class="w3-theme-d2">
			<tr>
				<th>ID</th>
				<th>Prénom</th>
				<th>Nom</th>
				<th>Tickets</th>
			</tr>
		<!-- </tr> generated by php for code alignement in safari inspector -->
		<?php
			echo "</thead>\n";  // here and not above just for visual code alignement in safari inspector (there was a bug)
			foreach($Users as $user){
				echo $user;
			}
		?>
	</table>
	</div>