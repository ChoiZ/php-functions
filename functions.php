<?php
/**
 * @version 2014-07-22
 * @author François LASSERRE <choiz@me.com>
 * @license GNU GPL {@link http://www.gnu.org/licenses/gpl.html}
 */

/**
 * print_array Easiest for debugging
 *
 * @param array $array Array to display.
 * @access public
 * @return string
 */
function print_array($array) {
    echo '<pre>',print_r($array,true),'</pre>';
}

/**
 * makedir
 *
 * @param string $folder Folder's name.
 * @access public
 * @return void
 */
function makedir($folder) {
    $path = pathinfo($folder);
    if(is_writable($path['dirname'])) {
        if(is_executable($path['dirname'])) {
            if(!@mkdir($folder)) {
                throw new exception("Error: Creating '$folder'", 1);
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
 * @param string $s String to update.
 * @param string $c Charset (utf-8 by default).
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
 * @param string $s String to update.
 * @param string $c Charset (utf-8 by default).
 * @access public
 * @return string
 */
function mb_ucfirst($s, $c='utf-8') {
    if (function_exists('mb_strtoupper') && function_exists('mb_substr') && !empty($s)) {
        $fc = mb_strtoupper(mb_substr($s, 0, 1, $e), $e);
        return $fc.mb_substr($s, 1, mb_strlen($s, $e), $e);
    }
    return ucfirst($s);
}

/**
 * mb_ucwords
 *
 * @param string $s String to update.
 * @param string $c Charset (utf-8 by default).
 * @access public
 * @return string
 */
function mb_ucwords($s, $c ='utf-8') {
    if (function_exists('mb_convert_case') && !empty($s)) {
        return mb_convert_case($s, MB_CASE_TITLE, $c);
    }
    return ucwords($s);
}

/**
 * cut Cut the string $s after $c caracter(s) if it's space or before the current word.
 *
 * @param string $s String to cut.
 * @param int $c Cut after this caracter(s) if it's space.
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

/**
 * get_url_params
 *
 * @param string|null $url Get params in url, or NULL.
 * @param array $array_default Set default params (or add new one).
 * @access public
 * @return array
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

/**
 * set_url_params
 *
 * @param array $array Define the params to change as key => value.
 * @param bool $get_params True to get all the params through get_url_params, false to ignore the params.
 * @access public
 * @return string
 */
function set_url_params($array = array(), $get_params = false) {
    if ($get_params != false) {
        $out = array_merge(get_url_params(),$array);
    } else {
        $out = $array;
    }
    return '?'.http_build_query($out);
}

/**
 * getRealIP Get client ip address behind proxy.
 *
 * @access public
 * @return string Ip address.
 */
function getRealIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
