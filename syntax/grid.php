<?php
/**
 * Mikio Syntax Plugin: Grid
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_grid extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'grid';
    public $hasEndTag           = true;
    public $options             = array(
        'rows'          => array('type'     => 'multisize'),
        'cols'           => array('type'     => 'multisize'),
    );

    public function getPType() { return 'normal'; }
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $styles = $this->buildStyle(array(
            'grid-template-rows'  => $data['rows'] ?? '',
            'grid-template-columns'  => $data['cols'] ?? '',
        ), TRUE);

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'grid"' . $styles . '>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div>'; 
    }
}
?>