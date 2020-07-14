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
 
class action_plugin_mikioplugin extends DokuWiki_Action_Plugin {

	public function register(Doku_Event_Handler $controller) {
		$controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, '_load');
	}

	public function _load(Doku_Event $event, $param) {
		global $conf;
        global $MIKIO_ICONS;

        $baseDir = DOKU_BASE.'lib/plugins' . str_replace(dirname(dirname(__FILE__)), '', dirname(__FILE__)) . '/';
        $stylesheets = [];
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

        foreach ($stylesheets as $style) {
            array_unshift($event->data['link'], array(
                'type' => 'text/css',
                'rel'  => 'stylesheet',
                'href' => $style
            ));
        }

        foreach ($scripts as $script) {
            $event->data['script'][] = array(
                 'type'  => 'text/javascript',
              '_data' => '',
              'src'   => $script
          );
      }
    }
}
