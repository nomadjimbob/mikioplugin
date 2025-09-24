<?php
/**
 * Mikio Syntax Plugin: Small
*
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_small extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'small';
    public $hasEndTag           = true;

    public function getPType() { return 'normal'; }
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '<small class="' . $this->elemClass . ' ' . $this->classPrefix . 'small">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</small>'; 
    }
}
?>