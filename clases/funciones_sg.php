<?php 
/*****************************************************************
creado: 20/06/2007
modificado: 11/07/2007
por: Yanny Nu�ez
*****************************************************************/

$patron = '{
		(\w++)\s*+:((?:(?:\\\(?:;|")|[^;"])++)
		|
        # Entre Comillas doble
        " # Abre Comillas
        (?:  [^"]*+ (?: (?<=\\\)" [^"]*+ )*+ )
        " # Cierra Comillas
    	
)}x';
$q = 'color:rojo;propiedad:"coloR:azul;letRA\"s:tahoma;";columnas:163px;filas:144pt;agua:sucia;comilla:sdsd\"x';
//===========================================================
function extraer_sec($q){
	$aux = array();
	$patron = '{
			(\w++)\s*+:((?:(?:\\\(?:;|")|[^;"])++)
			|
			# Entre Comillas doble
			" # Abre Comillas
			(?:  [^"]*+ (?: (?<=\\\)" [^"]*+ )*+ )
			" # Cierra Comillas
			
			)}x';
	if(preg_match_all($patron,$q,$c)){
		$aux[0]=$c[1]; 
		$aux[1]=$c[2]; 
	}// end if	
	return $aux;
}// end function
//===========================================================
function inner_html($diagrama,$id,$filas){
	$patron = "{((<(\w++)[^<>]+(?=id=([\"']?)".$id."[\\4]?)[^<>]*>)
		(
			(?: <(\w++) [^>]*+ (?<!/)> (?5) </\\6> 			# matched pair of tags
			| [^<>]++                                       # non-tag stuff
			| <\w[^>]*/>                                	# self-closing tag
			| <!--.*?-->                                    # comment
			| <script\b[^>]*>.*?</script>          			# script block
			| <hr[^>]*>| <input[^>]*><br[^>]*>
			| <\w[^>]*>
		   )*+
		 )(<\/\\3>))
		}isx";
	$diagrama = preg_replace($patron,"$2$filas$7", $diagrama);
	return $diagrama;
}// end function

//===========================================================
function extraer_patron($diagrama,$id,$etiqueta="tr"){
	$linea = "";
	$patron = "{(<(\w++)[^<>]+(?=id=([\"']?)".$id."[\\3]?)[^<>]*>
		(
			(?: <(\w++) [^>]*+ (?<!/)> (?4) </\\5> 			# matched pair of tags
			| [^<>]++                                       # non-tag stuff
			| <\w[^>]*/>                                	# self-closing tag
			| <!--.*?-->                                    # comment
			| <script\b[^>]*>.*?</script>          			# script block
			| <hr[^>]*>| <input[^>]*><br[^>]*>
			| <\w[^>]*>
		   )*+
		 )<\/(\\2)>)
		}isx";
	if (preg_match_all($patron, $diagrama,$c)){
		$linea = $c[1][0];
	}// end if
	return $linea;	
}// end function
//===========================================================
function formar_diagrama($diagrama,$id,$filas){
	$patron = "{(<(\w++)[^<>]+(?=id=([\"']?)".$id."[\\3]?)[^<>]*>
		(
			(?: <(\w++) [^>]*+ (?<!/)> (?4) </\\5> 			# matched pair of tags
			| [^<>]++                                       # non-tag stuff
			| <\w[^>]*/>                                	# self-closing tag
			| <!--.*?-->                                    # comment
			| <script\b[^>]*>.*?</script>          			# script block
			| <hr[^>]*>| <input[^>]*><br[^>]*>
			| <\w[^>]*>
		   )*+
		 )<\/(\\2)>)
		}isx";
	$diagrama = preg_replace($patron,$filas, $diagrama);
	return $diagrama;
}// end function
//===========================================================
function eval_exp_x($c){
	
	$x = "";
	try{
		eval("@\$x=".$c[1].";");
	} catch (Exception $e) {
		
	}
    
	return $x;
}// end function
//===========================================================
function eval_expresion($q=""){
	if ($q=="" or $q==null){
		return "";
	}// end if
	$q =  preg_replace_callback("|{exp=([^}]+)}|","eval_exp_x",$q);
	return $q;
}// end function
//===========================================================
function hhr($msg_x,$color_x="green"){
	echo "<hr><span style=\"color:$color_x;font-family:tahoma;font-size:9pt;font-weight:bold;\">".htmlentities($msg_x)."</span><hr>";
}// end function
//===========================================================
function reg_explode($simb,$q=""){
	if($q==""){
		return false;
	}// end if

	$q = preg_replace("|(?<!\\\)".$simb."|","sGsimBolo",$q);
	$q = preg_replace("|(\\\\".$simb.")|",$simb,$q);
	$q = preg_split("|(?<!\\\)"."sGsimBolo"."|",$q);
    return $q;
}// end function
//===========================================================
function extraer_variables($q=""){
	if($q==""){
		return false;
	}// end if
	$vector_x = explode(C_SEP_L,$q);
	for($i=0;$i<count($vector_x);$i++){
		$vector_y = explode(C_SEP_E,$vector_x[$i]);
		$vector[$vector_y[0]] = $vector_y[1];
	}// next
	return $vector;
}// end function	
//===========================================================
function extraer_variables_v($q="",$valor="0"){
	if($q==""){
		return false;
	}// end if
	$vector_x = explode(C_SEP_L,$q);
	for($i=0;$i<count($vector_x);$i++){
		$vector[$vector_y[0]] = $valor;
	}// next
	return $vector;
}// end function	
//===========================================================
function extraer_bandera($q="",$valor_x=true){
	if($q==""){
		return false;
	}// end if
	$vector_x = explode(C_SEP_L,$q);
	for($i=0;$i<count($vector_x);$i++){
		$band[$vector_x[$i]] = $valor_x;
	}// next
	return $band;
}// end function	
//===========================================================
function reparar_query($q){
	if (preg_match("/([^;]+)/i",$q, $c)){
		$q = $c[1];
	}// end if
	return $q;
}// end function	
//===========================================================
?>