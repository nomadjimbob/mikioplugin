<?php
/**
 * Mikio Syntax Plugin: Dropdown
 *
 * Syntax:  <DROPDOWN [primary|secondary|success|danger|warning|info|light|dark]></DROPDOWN>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_button extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'dropdown';
    public $defaults            = array('type' => 'primary');
    public $options             = array(
        'type' => array('primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark', 'outline-primary', 'outline-secondary', 'outline-success', 'outline-danger', 'outline-warning', 'outline-info', 'outline-light', 'outline-dark'),
        'size' => array('lg', 'sm'),
        'active',
        'disabled',
    );
    
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClassString($data, array('type', 'size', 'active', 'disabled'), array('btn-' => array('type', 'size')));

        // $renderer->doc .= '<div class="dropdown"><a href="#" class="btn ' . $classes . '" role="button"' . $collapse . '>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        // $renderer->doc .= '</a>'; 
    }
}
?>