<?php
/**
 * Mikio Syntax Plugin: Heading
 *
 * Syntax:  ---- or <HR> will be replaced with the horizontal line element
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_heading extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'heading';
    public $defaults            = array('size' => '1');
    public $options             = array(
        'size' => array('1', '2', '3', '4', '5')
    );
    
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '<h' . $data['size'] . '>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</h' . $this->values['size'] . '>'; 
    }
}

?>