<?php
/**
 * Mikio Syntax Plugin: BR
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_tags extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'tags';
    public $hasEndTag           = false;
    
    public function getPType() { return 'normal'; }

    public function render_lexer_special(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '<div class="mikio-tags"></div>';
    }
}
?>