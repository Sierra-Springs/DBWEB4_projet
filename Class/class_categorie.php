<?php
	class categorie{
		public $categorie_nom = "";
		public $categorie_produits = array();
		
		public function __toString(){
			try{
				if(isset($_SESSION['User']) && $_SESSION['User']->user_admin == 1){
					$colspan = 5;
					$colAcheteurs="<th>Acheteurs</th>\n";
					// colspan = 5 pour la colonne "acheteurs" supplémentaire
				}else{
					$colspan = 4;
					$colAcheteurs = "";
				}
				$str = "<table border=1 class='w3-table'>\n";
				$str = $str."<tr class='zoomed'><th colspan=".$colspan.">".$this->categorie_nom."</th></tr>\n";
				$str = $str."<th>Produit</th>";
				$str = $str."<th>quantité</th>";
				$str = $str."<th>Prix unitaire</th>";
				$str = $str."<th>Prix</th>";
				$str = $str.$colAcheteurs;
				$str = $str."</tr>\n";
				foreach ($this->categorie_produits as $produit) {
					$str = $str.$produit;
				}
				$str = $str."</table>\n";
				return $str;
			}
			catch(Exception $exception){
				return "";
			}
		}
	}
?>