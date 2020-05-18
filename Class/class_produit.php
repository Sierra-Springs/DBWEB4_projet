<?php
	class produit{
		public $produit_id = 0;
		public $produit_nom = "";
		public $produit_quantite = 0;
		public $produit_prix = 0;
		
		public function __toString(){
			try{
				$str = "<tr class='zoomed'>\n";
				$str = $str."<td>".$this->produit_nom."</td>\n";
				$str = $str."<td>".$this->produit_quantite."</td>\n";
				$str = $str."<td>".$this->produit_prix."</td>\n";
				$str = $str."<td>".$this->produit_quantite * $this->produit_prix."</td>\n";
				if(isset($_SESSION['User']) && !empty($_SESSION['User']->user_nom)){
					$str = $str."<td><a href='http://inertie-nas.synology.me/DBWEB4/DBWEB4_PROJET/?page=utilisateursProduit.php&ProductId=".$this->produit_id."'><i class='fa fa-user'></i></a></td>\n";
				}
				$str = $str."</tr>\n";
				return $str;
			}
			catch(Exception $exception){
				return "";
			}
		}
	}
?>