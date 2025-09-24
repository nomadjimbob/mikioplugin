<?php
/**
 * Mikio Syntax Plugin: Heading
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_heading extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'heading';
    public $hasEndTag           = true;
    public $options             = array(
        'color'             => array('type'    => 'color',    'default' => ''),
        'size'              => array('type'    => 'choice',
                                     'data'    => array('1', '2', '3', '4', '5', '6'),
                                     'default' => '1'),
        'text-decoration'   => array('type'    => 'text',     'default' => '1'),
    );
    // 
    public function getAllowedTypes() { return array('formatting', 'substition', 'disabled'); }
    public function getPType() { return 'normal'; }
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $styles = $this->buildStyle(array(
            'color'             => $data['color'] ?? '',
            'text-decoration'   => $data['text-decoration'] ?? '',
        ), TRUE);

        $renderer->doc .= '<h' . $data['size'] . ' class="' . $this->elemClass. ' ' . $this->classPrefix . 'heading ' . $this->classPrefix . 'heading-' . $data['size'] . '"' . $styles . '>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</h' . $data['size'] . '>';
    }
}

?>