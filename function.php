<?php
/**
 * @version 2012-07-06T20:45:13Z
 * @author François LASSERRE <choiz@me.com> 
 * @license GNU GPL {@link http://www.gnu.org/licenses/gpl.html}
 */

/**
 * makedir 
 * 
 * @param mixed $rep 
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
?>