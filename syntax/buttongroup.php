<?php
/**
 * Mikio Syntax Plugin: Button Group
 *
 * Syntax:  <BUTTON-GROUP [lg|sm] [vertical]></BUTTON-GROUP>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_buttongroup extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'button-group';
    public $options             = array('size' => array('lg', 'sm'), 'vertical');
    
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClassString($data, array('size'), 'btn-group-');

        $class = 'btn-group';
        if(array_key_exists('vertical', $data) && $data['vertical'] != false) $class = 'btn-group-vertical';

        $renderer->doc .= '<div class="' . $class . ' ' . $classes . '" role="group">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div>'; 
    }
}
?>