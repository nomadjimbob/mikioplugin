<?php
/**
 * Mikio CSS/LESS Engine
 *
 * @link  http://dokuwiki.org/template:mikio
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html)
 */

require(dirname(__FILE__) . '/inc/polyfill-ctype.php');

if(!class_exists('lessc')) {
    require(dirname(__FILE__) . '/inc/stemmechanics/lesserphp/lessc.inc.php');
}

if(!function_exists('getallheaders')) {
    function getallheaders() {
        $headers = [];
        foreach($_SERVER as $name => $value) {
            if(substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}

if(!function_exists('platformSlashes')) {
    function platformSlashes($path) {
        return str_replace('/', DIRECTORY_SEPARATOR, $path);
    }
}

try {
    if(isset($_GET['css'])) {
        $failed = false;
        $cssFileList = platformSlashes(explode(',', $_GET['css']));
        $baseDir = platformSlashes(dirname(__FILE__) . '/');
        $css = '';

        foreach($cssFileList as $cssFileItem) {
            $cssFile = platformSlashes(realpath($baseDir . $cssFileItem));

            if(strpos($cssFile, $baseDir) === 0 && file_exists($cssFile)) {
                $css .= file_get_contents($cssFile);
            } else {
                $failed = true;
            }
        }

        if(!$failed) {
            $rawVars = Array();

            header('Content-Type: text/css; charset=utf-8');

            $less = new lessc();
            $less->setPreserveComments(false);

            $vars = Array();
            if(isset($rawVars['replacements'])) {
                foreach($rawVars['replacements'] as $key=>$val) {
                    if(substr($key, 0, 2) == '__' && substr($key, -2) == '__') {
                        $vars['ini_' . substr($key, 2, -2)] = $val;
                    }
                }
            }

            if(count($vars) > 0) {
                $less->setVariables($vars);
            }

            $css = $less->compile($css);
            echo $css;
        } else {
            header('HTTP/1.1 404 Not Found');
            echo "The requested file could not be found";
        }
    } else {
        header('HTTP/1.1 404 Not Found');
        echo "The requested file could not be found";
    }
}
catch(Exception $e) {
    header('Content-Type: text/css; charset=utf-8');
    echo ".error_in_mikio_plugin_with_less_file {
/**
" . $e . "
**/
}";
}
