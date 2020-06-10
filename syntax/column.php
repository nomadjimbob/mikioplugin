<?php
/**
 * Mikio Syntax Plugin: COLUMN
 *
 * Syntax:  <COLUMN></COLUMN>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_column extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'col';
    public $options             = array(
        'size' => array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12')
    );
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClassString($data, array('size', 'smsize', 'mdsize', 'lgsize'), array('col-' => array('size', 'smsize', 'mdsize', 'lgsize')));
        
        $renderer->doc .= '<div class="col ' . $classes . '">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div>'; 
    }
}
?>