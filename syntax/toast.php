<?php
/**
 * Mikio Syntax Plugin: Toast
 *
 * Syntax:  <TOAST [title=] [status=]></TOAST>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_toast extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'toast';
    public $options             = array('title', 'status');
    
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '<div class="toast" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><strong class="mr-auto">' . (array_key_exists('title', $data) && $data['title'] != '' ? $data['title'] : '') . '</strong><small>' . (array_key_exists('status', $data) && $data['status'] != '' ? $data['status'] : '') . '</small><button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="toast-body">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div></div>'; 
    }
}
?>