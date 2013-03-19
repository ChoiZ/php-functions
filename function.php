<?php
/**
 * vim: set foldmethod=marker:
 *
 * @version 2013-02-25T10:46:22Z (ISO-8601)
 * @author François LASSERRE <choiz@me.com>
 * @license GNU GPL {@link http://www.gnu.org/licenses/gpl.html}
 */

/* public print_array($array) {{{ */
/**
 * print_array
 *
 * @param array $array
 * @access public
 * @return void
 */
function print_array($array) {
    echo '<pre>',print_r($array,true),'</pre>';
}
/* }}} */

/* public makedir($rep) {{{ */
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
/* }}} */

/* public rm_accent($s, $c='utf-8') {{{ */
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
/* }}} */

/* public mb_ucfirst($s, $c='utf-8') {{{ */
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
/* }}} */

/* public mb_ucwords($s, $c ='utf-8') {{{ */
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
/* }}} */

/* public cut($s, $m) {{{ */
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
/* }}} */

/* public get_url_params($url=NULL, $array_default=array()) {{{ */
/**
 * get_url_params
 *
 * @param mixed $url get params in url, or NULL
 * @param array $array_default set default params (or add new one)
 * @access public
 * @return void
 */
function get_url_params($url=NULL, $array_default=array()) {
    if ($url == NULL) {
        $params = $_SERVER['QUERY_STRING'];
    } else {
        $params = parse_url($url, PHP_URL_QUERY);
    }
    parse_str($params, $out);
    return array_merge($array_default, $out);
}
/* }}} */

/* public set_url_params($array = array(), $get_params = false) {{{ */
/**
 * set_url_params
 *
 * @param array $array define the params to change as key => value
 * @param mixed $get_params true to get all the params through get_url_params, false to ignore the params
 * @access public
 * @return void
 */
function set_url_params($array = array(), $get_params = false) {
    if ($get_params != false) {
        $out = array_merge(get_url_params(),$array);
    } else {
        $out = $array;
    }
    return '?'.http_build_query($out);
}
/* }}} */
?>
