<?php
/**
 * Mikio Syntax Plugin: Placeholder
 *
 * Syntax:  <PLACEHOLDER [colour=] [text=] [text-colour=] [width=] [height=] [classes=]></PLACEHOLDER>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_placeholder extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'placeholder';
    public $noEndTag            = true;
    public $options             = array('width', 'height', 'text', 'colour', 'text-colour', 'classes');
    
    
    public function render_lexer_special(Doku_Renderer $renderer, $data) {
        $colour = '#868e96';
        $textcolour = '#dee2e6';
        $classes = '';

        if(array_key_exists('colour', $data) && $data['colour'] != '') {
            $colour = $data['colour'];
        }

        if(array_key_exists('text-colour', $data) && $data['text-colour'] != '') {
            $colour = $data['text-colour'];
        }

        if(array_key_exists('classes', $data) && $data['classes'] != '') {
            $classes = 'classes="' . $data['classes'] . '" ';
        }

        $renderer->doc .= '<svg ' . $classes . (array_key_exists('width', $data) && $data['width'] != '' ? ' width="' . $data['width'] . '" ' : '') . (array_key_exists('height', $data) && $data['height'] != '' ? ' height="' . $data['height'] . '" ' : '') . ' xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">';
        $renderer->doc .= '<rect width="100%" height="100%" fill="' . $colour . '"></rect>';

        if(array_key_exists('text', $data) && $data['text'] != '') $renderer->doc .= '<text x="50%" y="50%" fill="' .$textcolour . '" dominant-baseline="middle" text-anchor="middle">' . $data['text'] . '</text>';

        $renderer->doc .= '</svg>'; 
    }
}
?>