<?php
/**
 * Mikio Syntax Plugin: Box
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_box extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'box';
    public $hasEndTag           = true;
    public $options             = array(
        'round'         => array('type'     => 'size',  'default'   => '0'),
        'border-color'  => array('type'     => 'color', 'default'   => ''),
        'border-width'  => array('type'     => 'size',  'default'   => ''),
        'reveal'        => array('type'     => 'boolean', 'default' => 'false'),
        'reveal-text'   => array('type'     => 'text',  'default'   => 'Reveal'),
    );

    public function __construct() {
        $this->addCommonOptions('width height type shadow text-align');
    }
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data);
        $styles = $this->buildStyle(array('width' => $data['width'], 'height' => $data['height'], 'border-radius' => $data['round'], 'border-color' => $data['border-color'], 'border-width' => $data['border-width']), TRUE);

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'box'. $classes .'"' . $styles. '>';
        if($data['reveal']) $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'reveal">' . $data['reveal-text'] . '</div>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div>'; 
    }
}
?>