<?php
/**
 * Polyfill-CType
 *
 * @link    https://github.com/nomadjimbob/polyfill-ctype
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */

if(!function_exists('array_key_first')) {
    function array_key_first($data)
    {
        foreach ($data as $key => $unused) {
            return $key;
        }    
    }
}
?>