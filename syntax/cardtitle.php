<?php
/**
 * Mikio Syntax Plugin: Card Title
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_cardtitle extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'card-title';
    public $requires_tag        = 'card';
    public $hasEndTag           = true;
    
    public function __construct() {
        $this->addCommonOptions('text-align text-color');
    }

    public function getPType() { return 'normal'; }
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data);
        $styles = $this->buildStyle(array(
            'color'             => $data['text-color'] ?? '',
        ), true);

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'card-title' . $classes . '"' . $styles . '>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div>'; 
    }
}
?>