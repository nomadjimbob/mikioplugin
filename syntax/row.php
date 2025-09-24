<?php
/**
 * Mikio Syntax Plugin: Row
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_row extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'row';
    public $hasEndTag           = true;
    public $options             = array(
            'border-color'  => array('type'     => 'color', 'default'   => ''),
            'border-width'  => array('type'     => 'multisize',  'default'   => ''),
            'padding'       => array('type'     => 'multisize',  'default'   => ''),
            'margin'       => array('type'     => 'multisize',  'default'   => ''),
    );

    public function getPType() { return 'normal'; }

    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $styles = $this->buildStyle(array(
            'border-color'  => $data['border-color'] ?? '',
            'border-width'  => $data['border-width'] ?? '',
            'padding'       => $data['padding'] ?? '',
            'margin'        => $data['margin'] ?? '',
        ), TRUE);

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'row"' . $styles . '>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div>';
    }
}
?>