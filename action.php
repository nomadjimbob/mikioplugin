<?php
/**
 * Mikio Plugin
 * 
 * @version    1.0
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if(!defined('DOKU_INC')) die();
 
class action_plugin_mikioplugin extends DokuWiki_Action_Plugin {

	public function register(Doku_Event_Handler $controller) {
		$controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, '_load');
	}

	public function _load(Doku_Event $event, $param) {
		global $conf;

        $baseDir = DOKU_BASE.'lib/plugins' . str_replace(dirname(dirname(__FILE__)), '', dirname(__FILE__)) . '/';
        $stylesheets = [];
        $scripts = [];

        if($conf['template'] !== 'mikio') {
            if($this->getConf('loadBootstrap')) {
                $stylesheets[]  = $baseDir . 'css/bootstrap.min.css';
                $scripts[]      = $baseDir . 'js/bootstrap.min.css';
                $scripts[]      = $baseDir . 'js/popper.min.css';
            }

            if($this->getConf('loadFontAwesome')) {
                $stylesheets[]  = $baseDir . 'css/fontawesome.min.css';
            }
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
