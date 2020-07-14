<?php
/**
 * Mikio Syntax Plugin: Column
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_column extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'col';
    public $options             = array(
        'size'          =>  array('type'    => 'choice',
                                  'data'    => array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'),
                                  'default' => ''),
    );
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'col ' . ($data['size'] != '' ? $this->classPrefix . 'col-' . $data['size'] : '') . '">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div>'; 
    }
}
?>