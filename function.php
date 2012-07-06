<?php
/**
 * @version 2012-07-06T22:12:20Z (ISO-8601)
 * @author François LASSERRE <choiz@me.com> 
 * @license GNU GPL {@link http://www.gnu.org/licenses/gpl.html}
 */

/**
 * makedir 
 * 
 * @param string $rep 
 * @access public
 * @return void 
 */
function makedir($rep) {
	$path = pathinfo($rep);
	if(is_writable($path['dirname'])) { 
		if(is_executable($path['dirname'])) {
			if(!@mkdir($rep)) {
				throw new exception("Error: Creating '$rep'", 1);
			}
		} else {
			throw new exception("Folder: '".$path['dirname']."' isn't executable!", 2);
		}
	} else {
		throw new exception("Folder: '".$path['dirname']."' isn't writable!", 3);
	}
}

/**
 * rm_accent 
 * 
 * @param string $s 
 * @param string $c 
 * @access public
 * @return string 
 */
function rm_accent($s, $c='utf-8') {
	$s = htmlentities($s, ENT_NOQUOTES, $charset);
	$s = preg_replace('#&([A-Za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $s);
	$s = preg_replace('#&([A-Za-z]{2})(?:lig);#', '\1', $s);
	return preg_replace('#&[^;]+;#', '', $s);
}

/**
 * mb_ucfirst 
 * 
 * @param string $s 
 * @param string $c 
 * @access public 
 * @return string 
 */
function mb_ucfirst($s, $c='utf-8') {
	if (function_exists('mb_strtoupper') && function_exists('mb_substr') && !empty($s)) {
		$s = mb_strtolower($s, $c);
		$up = mb_strtoupper($s, $c);
		preg_match('#(.)#us', $up, $match);
		$s = $match[1] . mb_substr($s, 1, mb_strlen($s, $c), $c);
	} else {
		$s = ucfirst($s);
	}
	return $s;
}

/**
 * mb_ucwords 
 * 
 * @param string $s 
 * @param string $c 
 * @access public
 * @return string
 */
function mb_ucwords($s, $c ='utf-8') {
	if (function_exists('mb_convert_case') && !empty($s)) {
		$s=mb_convert_case($s, MB_CASE_TITLE, $c);
	} else {
		$s=ucwords($s);
	}
	return $s;
}

/**
 * cut 
 * 
 * @param string $s 
 * @param string $m 
 * @access public 
 * @return string 
 */
function cut($s, $m) {
	if (strlen($s)>$m) {
		$s = substr($s, 0, $m);
		$sp = strrpos($s, " ");
		$s = substr($s, 0, $sp)."...";
	}
	return $s;
}
?>