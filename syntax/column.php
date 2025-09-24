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
require_once(__DIR__.'/core.php');

class syntax_plugin_mikioplugin_column extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'col';
    public $requires_tag        = 'row';
    public $options             = array(
        'size'          => array('type'     => 'choice',
                                 'data'     => array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'),
                                 'default'  => ''),
        'border-color'  => array('type'     => 'color',     'default'   => ''),
        'border-width'  => array('type'     => 'multisize', 'default'   => ''),
        'padding'       => array('type'     => 'multisize', 'default'   => ''),
        'margin'        => array('type'     => 'multisize', 'default'   => ''),
    );
    
    public function __construct() {
        $this->addCommonOptions('vertical-align');
    }

    public function getAllowedTypes()
    {
        return array('container', 'formatting', 'substition', 'protected', 'disabled', 'paragraphs');
    }

    public function getPType() { return 'normal'; }
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data);
        $styles = $this->buildStyle(array(
            'border-color'  => $data['border-color'] ?? '',
            'border-width'  => $data['border-width'] ?? '',
            'padding'       => $data['padding'] ?? '',
            'margin'        => $data['margin'] ?? '',
        ), TRUE);

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'col ' . ($data['size'] != '' ? $this->classPrefix . 'col-' . $data['size'] : '') . $classes . '"' . $styles . '>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div>'; 
    }
}
?>