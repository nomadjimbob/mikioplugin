<?php

/**
 * Mikio Plugin
 * 
 * @version 1.0
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author  James Collins <james.collins@outlook.com.au>
 */

if (!defined('DOKU_INC')) { die();
}

require_once 'icons/icons.php';
require_once __DIR__ . '/inc/polyfill-array-key-first.php';

if (!function_exists('glob_recursive')) {
    function glob_recursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
            $subFiles = glob_recursive($dir . '/' . basename($pattern), $flags);
            foreach ($subFiles as $file) {
                $files[] = $file;
            }
        }
        return $files;
    }
}

class action_plugin_mikioplugin extends DokuWiki_Action_Plugin
{
    public function register(Doku_Event_Handler $controller)
    {
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, '_load');
    }

    public function _load(Doku_Event $event, $param)
    {
        global $conf;
        global $MIKIO_ICONS;

        $baseDir = str_replace('\\', '/', DOKU_BASE . 'lib/plugins' . str_replace(dirname(__DIR__), '', __DIR__) . '/');
        $stylesheets = [];
        $less = [];
        $scripts = [];

        if (is_array($MIKIO_ICONS)) {
            $icons = array();
            foreach ($MIKIO_ICONS as $icon) {
                if (isset($icon['name']) && isset($icon['css']) && isset($icon['insert'])) {
                    $icons[] = $icon;

                    if ($icon['css'] != '') {
                        if (strpos($icon['css'], '//') === false) {
                            $stylesheets[] = $baseDir . 'icons/' . $icon['css'];
                        } else {
                            $stylesheets[] = $icon['css'];
                        }
                    }
                }
            }
            $MIKIO_ICONS = $icons;
        } else {
            $MIKIO_ICONS = [];
        }

        $stylesList = glob_recursive(str_replace('\\', '/', 'lib/plugins' . str_replace(dirname(__DIR__), '', __DIR__) . '/styles/*'));
        if ($stylesList !== false) {
            foreach ($stylesList as $value) {
                $filename = strtolower($value);
                if (substr($filename, -5) == '.less' || substr($filename, -4) == '.css') {
                    $stylesheets[] = DOKU_BASE . $filename;
                }
            }
        }

        $stylesheets[] = $baseDir . 'assets/variables.css';

        $stylesheets = array_unique($stylesheets);

        $tpl_supported = false;
        if($conf['template'] === 'mikio' && file_exists(tpl_incdir() . 'template.info.txt')) {
            $tpl_info = [];
            $tpl_data = file_get_contents(tpl_incdir() . 'template.info.txt');
            foreach(preg_split("/(\r\n|\n|\r)/", $tpl_data) as $line){
                if(preg_match("/([a-z]*)\s+(.*)/", $line, $matches)) {
                    $tpl_info[$matches[1]] = $matches[2];
                }
            }
      
            if(array_key_exists('date', $tpl_info)) {
                $date = array_map('intval', explode('-', $tpl_info['date']));
                if(count($date) === 3) {
                    // Date of mikio template is > 2022-10-12
                    if($date[0] > 2022 || ($date[0] == 2022 && ($date[1] > 10 || ($date[1] == 10 && $date[2] > 12)))) {
                        $tpl_supported = true;
                    }
                }
            }      
        }

        if($tpl_supported == false) {
            array_unshift($stylesheets, $baseDir . 'assets/variables.css');
        }

        array_unshift($stylesheets, $baseDir . 'assets/styles.less');

        // css
        foreach ($stylesheets as $style) {
            if (strtolower(substr($style, -5)) == '.less') {
                $less[] = $style;
            } else {
                array_unshift(
                    $event->data['link'], array(
                    'type' => 'text/css',
                    'rel'  => 'stylesheet',
                    'href' => $style
                    )
                );
            }
        }

        $lessPath = implode(',', $less);

        if(strlen($lessPath) > 0) {
            array_unshift(
                $event->data['link'], array(
                'type' => 'text/css',
                'rel'  => 'stylesheet',
                'href' => $baseDir . 'css.php?css=' . str_replace($baseDir, '', $lessPath)
                )
            );
        }

        // js
        foreach ($scripts as $script) {
            $event->data['script'][] = array(
            'type'  => 'text/javascript',
            '_data' => '',
            'src'   => $script
            );
        }
    }
}
