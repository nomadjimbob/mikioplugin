<?php
/**
 * Mikio Syntax Plugin: Badge
 *
 * Syntax:  <BADGE [primary|secondary|success|danger|warning|info|light|dark] [pill] [url=] [target=] [newtab] [collapse-id=]></BADGE>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_badge extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'badge';
    public $defaults            = array('type' => 'primary');
    public $options             = array(
        'type' => array('primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'),
        'pill',
        'url',
        'target',
        'newtab',
        'collapse-id'
    );
    
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClassString($data, array('type', 'pill'), 'badge-');

        $tag = 'span';
        $href = '';
        if(array_key_exists('url', $data) && $data['url'] != '') {
            $tag = 'a';
            $href = ' href="' . $this->getLink($data['url']) . '"';
        }

        $target = '';
        if(array_key_exists('target', $data) && $data['target'] != '') $target = ' target="' . $data['target'] . '"';
        if(array_key_exists('newtab', $data) && $data['newtab'] != false) $target = ' target="_blank"';

        $collapse = '';
        if(array_key_exists('collapse-id', $data) && $data['collapse-id'] != '') {
            $collapse = ' data-toggle="collapse" data-target="#' . $data['collapse-id'] . '"';
        }

        $renderer->doc .= '<' . $tag . $href . ' class="badge ' . $classes . '"' . $target . $collapse . '>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $tag = 'span';
        if(array_key_exists('url', $this->values) && $this->values['url'] != '') {
            $tag = 'a';
        }

        $renderer->doc .= '</' . $tag . '>'; 
    }
}
?>