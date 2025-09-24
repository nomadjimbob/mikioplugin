<?php
/**
 * Mikio Syntax Plugin: Text
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_text extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'text';
    public $hasEndTag           = true;
    public $options             = array(
        'color'                 => array('type'    => 'color',    'default' => ''),
        'size'                  => array('type'    => 'size',     'default' => ''),
        'weight'                => array('type'    => 'choice',
                                         'data'    => array('normal', 'bold', 'bolder', 'lighter', '100', '200', '300', '400', '500', '600', '700', '800', '900', 'initial', 'inherit'),
                                         'default' => 'normal'),
        'style'                 => array('type'    => 'text',     'default' => ''),
        'background-color'      => array('type'    => 'color',    'default' => ''),
        'line-height'           => array('type'    => 'float',    'default' => ''),
        'text-decoration'       => array('type'    => 'text',     'default' => ''),
        'block'                 => array('type'    => 'boolean',    'default' => 'false'),
    );

    public function getAllowedTypes() { return array('formatting', 'substition', 'disabled'); }
    public function getPType() { return 'normal'; }
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {

        $styles = $this->buildStyle(array(
            'color'             => $data['color'] ?? '',
            'font-size'         => $data['size'] ?? '',
            'font-weight'       => $data['weight'] ?? '',
            'font-style'        => $data['style'] ?? '',
            'background-color'  => $data['background-color'] ?? '',
            'line-height'       => $data['line-height'] ?? '',
            'text-decoration'   => $data['text-decoration'] ?? '',
            'display'           => ($data['block'] ? 'block' : 'inline-block'),
        ), TRUE);
        
        $renderer->doc .= '<span' . $styles . '>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</span>';
    }
}

?>