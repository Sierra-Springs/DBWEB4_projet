<?php
	class ticket{
		public $ticket_id = 0;
		public $ticket_date = "";
		public $ticket_categories = array();
		
		public function __toString(){
			try{
				$str = "<tr>\n";
				$str = $str."\t<td>".$this->ticket_id."</td>\n";
				$str = $str."\t<td>".$this->ticket_date."</td>\n";
				$str = $str."<td>\n";
				$str = $str."<i class ='fa fa-info-circle info ".$this->ticket_id."info' onclick=\"toggleThis('.".$this->ticket_id."')\"></i>\n";
				$str = $str."<i class ='far fa-times-circle close ".$this->ticket_id."close' onclick=\"toggleThis('.".$this->ticket_id."')\"  style='display: none;'></i>\n";
				$str = $str."<div class='Detail ".$this->ticket_id."Detail' style='display: none'>\n";
				foreach ($this->ticket_categories as $categorie) {
					$str = $str.$categorie;
				}
				$str = $str."</div>\n";
				$str = $str."</tr>\n";
				return $str;
			}
			
			catch(Exception $exception){
				return "";
			}
		}
	}
?>