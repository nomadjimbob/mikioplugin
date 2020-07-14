<?php
/**
 * Mikio Syntax Plugin: Color
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_color extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'color';
    public $hasEndTag           = true;
    public $options             = array(
        'color'  =>  array('type'    => 'color',    'default' => ''),
    );

    public function getAllowedTypes() { return array('formatting', 'substition', 'disabled'); }
    public function getPType() { return 'normal'; }
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $styles = $this->buildStyle(array('color' => $data['color']), TRUE);
        $renderer->doc .= '<span' . $styles . '>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</span>';
    }
}

?>