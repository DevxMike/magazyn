<?php
	class Formularz{
		function __destruct(){}
		function __construct(){
		}
		public function labelka($id,$tekst){
			printf("<label for='%s'>%s</label>",$id,$tekst);
		}
		public function poleTekstowe($klasa,$nazwa,$typ,$placeholder,$value, $br,$label){
			$this->labelka($nazwa,$label);
			if($br)$br='<br />';
			else $br='';
			if($value!=null)
			printf("<input name='%s' class='%s' id='%s' type='%s' value='%s' placeholder='%s'/>%s",
			$nazwa,$klasa,$nazwa,$typ,$value,$placeholder,$br);
			else
				printf("<input name='%s' class='%s' id='%s' type='%s' placeholder='%s'/>%s",
			$nazwa,$klasa,$nazwa,$typ,$placeholder,$br);
		}
		public function submit($nazwa, $label, $klasa){
			printf("<input type='submit' name='%s' value='%s' class='%s'/>",$nazwa,$label,$klasa);
		}
		public function baton($nazwa, $label, $klasa, $onclick){
			printf("<button type='button' class='%s' name='%s' onclick='%s'>%s</button>",$klasa,$nazwa,$onclick,$label);
		}
		public function textArea($nazwa,$klasa,$value,$placeholder,$maxlenght,$label){
			$this->labelka($nazwa,$label);
			if($value==null)
				printf("<textarea name='%s' id='%s' placeholder='%s' maxlenght='%u' class='%s'></textarea>",
				$nazwa,$nazwa,$placeholder,$maxlenght,$klasa);
			else 
				printf("<textarea name='%s' id='%s' maxlenght='%u' class='%s'>'%s'</textarea>",
				$nazwa,$nazwa,$maxlenght,$klasa,$value);
		}
		public function radio($nazwa,$id ,$value,$label,$checked){
			if($checked)
			printf("<input type='radio' value='%s' name='%s' id='%s' checked/>&nbsp;&nbsp;",$value,$nazwa,$id);
			else
				printf("<input type='radio' value='%s' name='%s' id='%s'/>&nbsp;&nbsp;",$value,$nazwa,$id);
			$this->labelka($id,$label);
		}
		public function select($name,$label,$numrows,$value,$klasa,$stOP,$lsOP,$event,$id,$active,$isset){
			$this->labelka($id,$label);
			if($event!=null)
				printf("<select name='%s' id='%s' %s class='%s'>",$name,$id,$event,$klasa);
			else
				printf("<select name='%s' id='%s'  class='%s'>",$name,$id,$klasa);
			if($stOP!=null)
				printf("%s",$stOP);
			for($i=0;$i<$numrows;$i++){
				$row=$value->fetch_row();
				if($active==$row[0]&&$active!=null&&isset($isset))
				printf("<option selected value='%s'>%s</option>",$row[0],$row[1]);
				else
					printf("<option value='%s'>%s</option>",$row[0],$row[1]);
			}
			if($lsOP!=null)
				printf("%s",$lsOP);
			printf("</select>");
		}
	}
	?>