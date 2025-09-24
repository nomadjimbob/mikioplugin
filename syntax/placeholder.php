<?php
/**
 * Mikio Syntax Plugin: Placeholder
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_placeholder extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'placeholder';
    public $hasEndTag           = false;
    public $options             = array(
        'width'         => array('type'     => 'size',  'default'      => ''),
        'height'        => array('type'     => 'size',  'default'      => ''),
        'text'          => array('type'     => 'text',  'default'      => ''),
        'color'         => array('type'     => 'text',  'default'      => 'var(--mikiop-border-color)'),
        'text-color'    => array('type'     => 'text',  'default'      => 'currentColor'),
    );
    
    public function render_lexer_special(Doku_Renderer $renderer, $data) {
        $styles = $this->buildStyle(array('width' => $data['width'] ?? '', 'height' => $data['height'] ?? ''), TRUE);

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'placeholder"' . $styles . '>';
        $renderer->doc .= '<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">';
        $renderer->doc .= '<rect width="100%" height="100%" fill="' . $data['color'] . '"></rect>';
        $renderer->doc .= '<text x="50%" y="50%" fill="' .$data['text-color'] . '" dominant-baseline="middle" text-anchor="middle">' . $data['text'] . '</text>';
        $renderer->doc .= '</svg>';
        $renderer->doc .= '</div>';
    }
}
?>