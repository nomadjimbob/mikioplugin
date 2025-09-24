<?php
/**
 * Mikio Syntax Plugin: List Group
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_listgroup extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'listgroup';
    public $hasEndTag           = true;
    public $options             = array(
        'flush'         => array('type' => 'boolean',   'default'   => 'false'),
        'horizontal'    => array('type' => 'boolean',   'default'   => 'false'),
    );
    
    public function getAllowedTypes() { return array('formatting', 'substition', 'disabled'); }
    public function getPType() { return 'normal'; }
    
    public function __construct() {
        $this->addCommonOptions('shadow width');
    }

    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data, array('flush', 'horizontal'));
        $styles = $this->buildStyle(array('width' => $data['width'] ?? ''), TRUE);

        $renderer->doc .= '<ul class="' . $this->elemClass . ' ' . $this->classPrefix . 'list-group ' . $classes . '"' . $styles . '>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</ul>'; 
    }
}
?>