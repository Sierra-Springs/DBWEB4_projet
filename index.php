<?php
include_once("./DB_connect.php");
include_once("./Class/class_user.php");
session_start();

if(isset($_POST['disconnect']) && $_POST['disconnect']==1){
	session_unset();
	session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">
<title>Carrouf</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-red.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-2019.css">
<script src="https://kit.fontawesome.com/f4ec772bb1.js" crossorigin="anonymous"></script>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>
</head>

<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif;}
body, html {
  height: 100%;
  color: #777;
  line-height: 1.8;
}

/* Create a Parallax Effect */
.bgimg-1, .bgimg-2, .bgimg-3 {
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

/* First image (Logo. Full height) */
.bgimg-1 {
  background-image: url('./images/Glacier_NL_1920_1080.jpg');
  min-height: 100%;
}

/* Second image (Portfolio) */
.bgimg-2 {
  background-image: url("./images/Cirques.jpg");
  min-height: 400px;
}

/* Third image (Contact) */
.bgimg-3 {
  background-image: url("./images/Aerial05.jpg");
  min-height: 400px;
}

/* Turn off parallax scrolling for tablets and phones */
@media only screen and (max-device-width: 1600px) {
  .bgimg-1, .bgimg-2, .bgimg-3 {
    background-attachment: scroll;
    min-height: 400px;
  }
}

</style>

<!-- Gestion de Session -->
<?php
	if(isset($_POST['User_log_request_name']) && isset($_POST['User_log_request_id']) && !empty($_POST['User_log_request_name'])){
		$request_User = "SELECT id AS user_id, prenom AS user_prenom, nom AS user_nom, admin as user_admin FROM utilisateurs WHERE nom = :User_log_nom AND id = :User_log_id";
		$User_bdd = $pdo->prepare($request_User);
		$User_bdd->bindParam(':User_log_nom', $TheUserNom);
		$User_bdd->bindParam(':User_log_id', $TheUserId);
		$User_bdd->setFetchMode(PDO::FETCH_CLASS, 'user');
		
		$TheUserNom = $_POST['User_log_request_name'];
		$TheUserId = $_POST['User_log_request_id'];
		$User_bdd->execute();
		if($User_bdd->rowCount() == 0){
			echo "Utilisateur inexistant";
		}else{
			$_SESSION['User'] = $User_bdd->fetch();
		}
		
	}
?>

<script>

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  var modal = document.getElementById('formulaireConnexion');
	  if (event.target == modal) {
	    modal.style.display = "none";
	  }
	}

	function OpenModal(modalName){
    	document.getElementById(modalName).style.display='block';
	};

	function CloseModal(modalName){
        document.getElementById(modalName).style.display='none';
    };
    
    function ToggleModal(modalName) {
    	if (document.getElementById(modalName).style.display=='none') {
    		OpenModal(modalName);
		}else {
    		CloseModal(modalName);
		}
	};
	
	function sendForm(formName) {
		document.forms[formName].submit();
	};
	
	function disconnect(){
		document.forms['disconnect'].submit();
	}
</script>

<body>

<!-- Top -->
<?php
	if(isset($_SESSION['User']) && !empty($_SESSION['User']->user_prenom)){
		$onclick_action = "onclick='disconnect()'";
		$user_icon = "fas fa-user-slash";
	}else{
		$onclick_action = "onclick=\"OpenModal('formulaireConnexion')\"";
		$user_icon = "fa fa-user";
	}
?>
<div class="w3-top">
	<div class="w3-theme w3-large" style="margin:auto">
		<div class="w3-theme w3-padding-10 w3-left w3-hide-large w3-hover-white" onclick="w3_open()"><i class="fa fa-bars" style="margin:10px; padding:3px;padding-bottom:2px"></i></div>
		<div class="w3-theme w3-padding-10 w3-right w3-hover-white" <?php echo $onclick_action ?>><i class="<?php echo $user_icon ?>" style="margin:10px; padding:3px;padding-bottom:2px"></i></div>
		<div class="w3-theme w3-padding-10 w3-right" style="margin:6px;margin-right:0px">
			<?php
				if(isset($_SESSION['User']) && !empty($_SESSION['User']->user_prenom)){
					echo $_SESSION['User']->user_prenom." ".$_SESSION['User']->user_nom;
				}
			?>
		</div>
		<div class="w3-theme w3-padding-10 w3-center w3-xlarge">Carrouf</div>
	</div>
</div>

<!-- Sidebar -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar" style="margin-top:43px">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
    <i class="fa fa-remove"></i>
  </a>
  <h4 class="w3-bar-item"><b>Menu</b></h4>
  <a class="w3-bar-item w3-button w3-hover-black" href="http://inertie-nas.synology.me/DBWEB4/DBWEB4_PROJET/?page=utilisateurs.php">Utilisateurs</a>
  <?php
  	if(isset($_SESSION['User']) && !empty($_SESSION['User']->user_nom)){
  		echo '<a class="w3-bar-item w3-button w3-hover-black" href="http://inertie-nas.synology.me/DBWEB4/DBWEB4_PROJET/?page=topVentes.php">Top Ventes</a>';
  	}
  ?>
  <a class="w3-bar-item w3-button w3-hover-black" href="#">Link</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="#">Link</a>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Formulaire de connexion (modal) -->
<div class="w3-modal" id="formulaireConnexion">
	<div class="w3-modal-content w3-animate-zoom w3-container" style="width:50%">
      <form action="index.php" method="post">
        	
          <input class="w3-input w3-border" style="margin-top:20px" type="text" placeholder="Nom" required name="User_log_request_name">
          <input class="w3-input w3-border" style="margin-top:5px" type="text" placeholder="Mot de Passe" required name="User_log_request_id">
        
        <button class="w3-button w3-theme w3-right w3-section" onclickNNN="sendForm('formulaireConnexion')">
        	<div class='my-fancy-container'>
        		<span>Connexion</span>
				<span class='fa fa-2x fa-arrow-circle-o-right my-icon'></span>
			</div>
		</button>
		
      </form>
      <form action="index.php" method="post" id="disconnect">
          <input type="hidden" name="disconnect" value=1>
      </form>
   </div>
</div>

<!-- Main content: shift it to the right by 200 pixels when the sidebar is visible -->
<div class="w3-main" style="margin-left:200px">

	<div class="w3-row w3-padding-64">
    	<div class="w3-container">
    		<?php
				if(isset($_GET['page'])){
					if(in_array($_GET['page'], array("utilisateurs.php"))){
						if((isset($_SESSION['User'])) && ($_SESSION['User']->user_admin == 1)){
							include($_GET['page']);
						}else{
							echo "vous n'avez pas l'autorisation d'acceder à cette page";
						}
					}else{
						include($_GET['page']);
					}
				}
			?>
		</div>
	</div>



  <div class="w3-row">
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-theme">Heading</h1>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum
        dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div class="w3-third w3-container">
      <p class="w3-border w3-padding-large w3-padding-32 w3-center">AD</p>
      <p class="w3-border w3-padding-large w3-padding-64 w3-center">AD</p>
    </div>
  </div>

  <div class="w3-row w3-padding-64">
  	<div class="w3-third w3-container">
      <p class="w3-border w3-padding-large w3-padding-32 w3-center">AD</p>
      <p class="w3-border w3-padding-large w3-padding-64 w3-center">AD</p>
    </div>
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-theme">Heading</h1>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum
        dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
  </div>

	<!-- Third Parallax Image with Portfolio Text -->
	<div class="bgimg-3 w3-display-container w3-opacity-min">
	  <div class="w3-display-middle">
	     <span class="w3-xxlarge w3-text-white w3-wide">CONTACT</span>
	  </div>
	</div>

	<!-- Container (Contact Section) -->
	<div class="w3-content w3-container w3-padding-64" id="contact">
	  <h3 class="w3-center">Carrouf</h3>
	  <p class="w3-center"><em>La fin des produits dispendieux, Tarbernac !</em></p>
	
	  <div class="w3-row w3-padding-32 w3-section">
	    <div class="w3-col m4 w3-container">
	      <img src="./images/Minimotorway.jpeg" class="w3-image w3-round" style="width:100%">
	    </div>
	    <div class="w3-col m8 w3-panel">
	      <div class="w3-large w3-margin-bottom">
	        <div class="w3-text-theme"><i class="fa fa-map-marker fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i> Montréal, CA<br></div>
	        <div class="w3-text-theme"><i class="fa fa-phone fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i> Téléphone: +00 151515<br></div>
	        <div class="w3-text-theme"><i class="fa fa-envelope fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i> Email: mail@mail.com<br></div>
	      </div>
	      <p>Contactez-nous</p>
	      <form action="/action_page.php" target="_blank">
	        <div class="w3-row-padding" style="margin:0 -16px 8px -16px">
	          <div class="w3-half">
	            <input class="w3-input w3-border" type="text" placeholder="Name" required name="Name">
	          </div>
	          <div class="w3-half">
	            <input class="w3-input w3-border" type="text" placeholder="Email" required name="Email">
	          </div>
	        </div>
	        <input class="w3-input w3-border" type="text" placeholder="Message" required name="Message">
	        <button class="w3-button w3-theme w3-right w3-section" type="submit">
	          <i class="fa fa-paper-plane"></i> SEND MESSAGE
	        </button>
	      </form>
	    </div>
	  </div>
	</div>

	<!-- Footer -->
	<footer class="w3-center w3-theme w3-padding-64 w3-hover-opacity-off">
	  <div class="w3-xlarge w3-section">
	    <i class="fa fa-facebook-official w3-hover-opacity"></i>
	    <i class="fa fa-instagram w3-hover-opacity"></i>
	    <i class="fa fa-snapchat w3-hover-opacity"></i>
	    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
	    <i class="fa fa-twitter w3-hover-opacity"></i>
	</footer>
</div>	
	
<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}
</script>

</body>
</html>

