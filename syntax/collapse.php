<?php
/**
 * Mikio Syntax Plugin: Collapse
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_collapse extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'collapse';
    public $hasEndTag           = true;
    public $options             = array(
        'id'            => array('type' => 'text',  'default'   => ''),
    );
    
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'collapse" id="' . $data['id'] . '">';
    }

    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div>';
    }
}
?>