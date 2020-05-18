<?php
	class user{
			public $user_id = 0;
			public $user_prenom = "";
			public $user_nom = "";
			public $user_admin;
			
			public function __toString(){
				try{
					if($this->user_admin == "1"){
						$str = "\t\t<tr class='colored'>\n";
					}else{
						$str = "\t\t<tr>\n";
					}
					
					$str = $str."\t\t\t<td>".$this->user_id."</td>\n";
					if($this->user_admin == "1"){
						$str = $str."\t\t\t<td>".$this->user_prenom." <i class='fas fa-user-shield'></i></td>\n";
					}else{
						$str = $str."\t\t\t<td>".$this->user_prenom."</td>\n";
					}
					$str = $str."\t\t\t<td>".$this->user_nom."</td>\n";
					$str = $str."\t\t\t<td>"."<a href=http://Inertie-NAS.synology.me/DBWEB4/DBWEB4_PROJET/?page=tickets.php&id=".$this->user_id."><i class='fas fa-receipt'></i></a></td>\n";
					$str = $str."\t\t</tr>\n";
					return $str;
				}
				
				catch(Exception $exception){
					return "";
				}
			}
		}
?>