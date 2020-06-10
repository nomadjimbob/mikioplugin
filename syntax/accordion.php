<?php
/**
 * Mikio Syntax Plugin: Accordion
 *
 * Syntax:  <ACCORDION [id=]></ACCORDION>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_accordion extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'accordion';
    public $options             = array('id');
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '<div' . (array_key_exists('id', $data) && $data['id'] != '' ? ' id="' . $data['id'] . '"' : '') . '>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div>'; 
    }
}
?>