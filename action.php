<?php
/**
 * Mikio Plugin
 * 
 * @version    1.0
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if(!defined('DOKU_INC')) die();

require_once('icons/icons.php');
 
if(!function_exists('glob_recursive')) {
  function glob_recursive($pattern, $flags = 0) {
    $files = glob($pattern, $flags);
    foreach(glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
      $files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));
    }
    return $files;
  }
}

class action_plugin_mikioplugin extends DokuWiki_Action_Plugin {

	public function register(Doku_Event_Handler $controller) {
		$controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, '_load');
	}

	public function _load(Doku_Event $event, $param) {
		global $conf;
    global $MIKIO_ICONS;

    $baseDir = DOKU_BASE.'lib/plugins' . str_replace(dirname(dirname(__FILE__)), '', dirname(__FILE__)) . '/';
    $stylesheets = [];
    $less = [];
    $scripts = [];

    if(is_array($MIKIO_ICONS)) {
        $icons = Array();
        foreach($MIKIO_ICONS as $icon) {
            if(isset($icon['name']) && isset($icon['css']) && isset($icon['insert'])) {
                $icons[] = $icon;

                if($icon['css'] != '') {
                    if(strpos($icon['css'], '//') === FALSE) {
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
        
    $stylesList = glob_recursive('lib/plugins' . str_replace(dirname(dirname(__FILE__)), '', dirname(__FILE__)) . '/styles/*');
    if($stylesList !== FALSE) {
      foreach($stylesList as $value) {
        $filename = strtolower($value);
        if(substr($filename, -5) == '.less' || substr($filename, -5) == '.css') {
          $stylesheets[] = '/' . $filename;
        }
      }
    }
   
    $stylesheets = array_unique($stylesheets);

    // css
    foreach ($stylesheets as $style) {
      if(strtolower(substr($style, -5)) == '.less') {
        $less[] = $style;
      } else {
        array_unshift($event->data['link'], array(
            'type' => 'text/css',
            'rel'  => 'stylesheet',
            'href' => $style
        ));
      }
    }
    
    // less
    array_unshift($less, '/assets/variables.less', '/assets/styles.less');

    $lessSorted = [];
    foreach($less as $key=>$value) {
      if(substr(strtolower($value), -14) == 'variables.less') {
        $lessSorted[] = $value;
        unset($less[$key]);
      }
    }
    
    $lessSorted = array_merge($lessSorted, $less);
    $lessPath = implode(',', $lessSorted);

    array_unshift($event->data['link'], array(
      'type' => 'text/css',
      'rel'  => 'stylesheet',
      'href' => $baseDir . 'css.php?css=' . str_replace($baseDir, '', $lessPath)
    ));

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