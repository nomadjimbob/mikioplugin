<?php
/**
 * Mikio Syntax Plugin: Card Footer
 *
 * Syntax:  <CARD-FOOTER></CARD-FOOTER>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_cardfooter extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'card-footer';
    public $options             = array('small');
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClassString($data);
        
        $renderer->doc .= '<div class="card-footer ' . $classes . '">';

        if(array_key_exists('small', $data) && $data['small'] != false) $renderer->doc .= '<small>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        if(array_key_exists('small', $this->values) && $this->values['small'] == true) $renderer->doc .= '</small>';

        $renderer->doc .= '</div>'; 
    }
}
?>