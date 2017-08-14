<?php
 /**
  * Handles all functions regarding the native user. field type = radio, select or checkbox
  *
  *
  * @author  Bastiaan Blaauw <statuur@gmail.com>
  * @see http://www.w3schools.com/tags/tag_input.asp
  * @author URI: http://metacollections.statuur.nl/
  * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
  * @access Public
  * @package  Collections Wordpress plugin
  * @todo this type of field type classes probably don't need a constructor function
  */
class Related extends Basics{
	
	function __construct($meta=null){
	
	parent::init();
	$this->Field 		= new Field();
	$this->fieldname 	= __("Related post", "_coll");
}
	
	
/**
    * Shows the specific fieldtype in UI::edituserinterface, post(-new).php or edit.php. 
    * @access public
    * @param object $post the post info
    * @param array $element info about the metadata field
    */	
public function showfield($post=null, $element=null){
			
			$element 	= ($element[id]!="") ? $element[args]: $element;
			$name	 	= $this->postmetaprefix.$element[ID];
			$return_value = $element[return_value];
			$values	 	= get_post_meta($post->ID, $name, true); 
			$values	 	= ($values=="" && $element[default_value]!="") ? $element[default_value] : $values;
			$values	 	= (!is_array($values)) ? array($values) : $values;			
			
			
			$html = "";			
			if($element[description]!=""){
			$html.="<span style=\"font-size:10px;font-style:italic\">{$element[description]}</span>";	
			}
			

			$fieldfinfo = $this->Field->getAttributesAndClasses($element);
			$args = array('posts_per_page'   => 900);
			
			if($element[post_type]!="all"){
			$args[post_type] = $element[post_type];
			}
			
			$posts = get_posts( $args);
			
			$i=0;
			foreach ($values as $value){
			$html.="<div class=\"metafield-value\">
					<select name=\"{$name}[]\" class=\"".implode(" ", $fieldfinfo[0])."\" ".implode(" ", $fieldfinfo[1]).">";
		   	$html.= "<option value=\"\">".__("Choose")."</option>";
			
						    
			foreach($posts as $post){
			
			$selected = ($post->ID==$value)? "selected": "";
			$html.= "<option {$selected} value=\"{$post->ID}\">{$post->post_title}</option>";
					}
			$html.= "</select>";
				
				if($element[multiple]==1){
			$visibility = ($i==0) ? "0": "1";
			$html.="<a class=\"delete_metavalue genericon_ genericon-trash\" title=\"".__("delete this", "_coll")."\" href=\"#\" style=\"opacity:{$visibility}\" onclick=\"remove_value_instance(event, $(this).parent('.metafield-value'))\">&nbsp;</a>";
			}
			$html.="</div>";
			$i++;
			}			
			
			echo $this->Field->metafieldBox($html, $element);
			}


/**
    * Shows the specific form for the fieldtype with all the options related to that field. 
    * @access public
    */	
public function fieldOptions($element){

echo"<table class=\"widefat metadata\" cellpadding=\"10\">";
	$statusc = ($element[status]==1)? "checked":"";
	$formID = "#edit_options_{$element[ID]}_{$element[cpt]}";
	$this->Field->getID($element);
	
	echo"
	
	<tr>
	<td>".__("Type").":</td>
	<td>";
	
	 $this->Field->getfieldSelect($element);
	
	echo"</td>
	</tr>";
	
	$this->Field->getBasics($element);
	$this->Field->getValidationOptions($element,1);
	
	

echo"<tr>
	<td valign=\"top\">".__("Post type", "_coll").":</td>
	<td valign=\"top\">";
	
	$post_types = get_post_types( array('public'=>true), 'names'); 


	echo"<select name=\"post_type\">";

	$types = array("post"=>"Post", "page"=>"Select (multiple choice)",  "checkbox"=>"Checkbox (multiple choice)");
	$aselected = ($post_type=="all")? "selected":"";	
	
	echo"<option value=\"all\" {$aselected}>"._("All")."</option>";
	
	
	foreach ( $post_types as $post_type) {
	$selected = ($post_type==$element[post_type])? "selected":"";	
	echo"<option value=\"{$post_type}\" {$selected}>{$post_type}</option>";
	}

	
	echo"</select>
	
	</td>
	</tr>	
	
	<tr>	
	<td colspan=\"2\" style=\"padding:10px\">
	<a href=\"#\" onclick=\"
	if(jQuery('{$formID}').validate().form()){
	save_metafield('{$element[ID]}', '{$element[cpt]}', '".__("Field Options Saved")."...');
	}return false;
	\" class=\"button-primary\" id=\"savemetafield\">".__("Save")."</a>	</td>
	</tr>
	
	
	</table>";
		
	echo"<script>
	 jQuery(document).ready(function(){
	jQuery('{$formID}').validate();
   });
   
   </script>";

//Cancel <a href=\"#\" onclick=\"\" class=\"button\">".__("Cancel")."</a>
}

}
?>