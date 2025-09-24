<?php
/**
 * Mikio Syntax Plugin: Button Group
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_buttongroup extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'button-group';
    public $requires_tag        = 'button';
    public $hasEndTag           = true;
    public $options             = array(
        'size'          => array('type'     => 'choice',
                                 'data'     => array('large'=> array('large', 'lg'), 'small' => array('small', 'sm')),
                                 'default'  => ''),
        'vertical'      => array('type'     => 'boolean',   'default'   => 'false'));
    
    public function __construct() {
        $this->addCommonOptions('align shadow');
    }

    public function getAllowedTypes() { return array('formatting', 'substition', 'disabled'); }
    public function getPType() { return 'normal'; }
        
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data, array('size', 'vertical'));

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'button-group' . $classes . '" role="group">';
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'button-group-inner" role="group">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div></div>'; 
    }
}
?>