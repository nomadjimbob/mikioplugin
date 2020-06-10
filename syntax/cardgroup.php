<?php
/**
 * Mikio Syntax Plugin: Card Group
 *
 * Syntax:  <CARD-GROUP></CARD-GROUP>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_cardgroup extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'card-group';
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClassString($data);
        
        $renderer->doc .= '<div class="card-group ' . $classes . '">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div>'; 
    }
}
?>