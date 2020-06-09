<?php
/**
 * Mikio Plugin
 * 
 * @version    0.1
 * @copyright  Copyright 2020 James Collins
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if(!defined('DOKU_INC')) die();
 
class action_plugin_mikioplugin extends DokuWiki_Action_Plugin {

	public function register(Doku_Event_Handler $controller) {
		$controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, '_load');
		// $controller->register_hook('DOKUWIKI_DONE', 'BEFORE', $this, 'dw_done');
	}

	public function _load(Doku_Event $event, $param) {

		global $conf;
	}
}


