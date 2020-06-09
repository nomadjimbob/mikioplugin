<?php
/**
 * Mikio Syntax Plugin: Button
 *
 * Syntax:  <BUTTON [primary|secondary|success|danger|warning|info|light|dark] [url] [target] [newtab] [collapse-id]></BUTTON>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_button extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'button';
    public $defaults            = array('type' => 'primary');
    public $options             = array(
        'type' => array('primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark', 'outline-primary', 'outline-secondary', 'outline-success', 'outline-danger', 'outline-warning', 'outline-info', 'outline-light', 'outline-dark'),
        'size' => array('lg', 'sm'),
        'block',
        'active',
        'disabled',
        'url',
        'target',
        'newtab',
        'collapse-id'
    );
    
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClassString($data, array('type', 'size', 'block', 'active', 'disabled'), array('btn-' => array('type', 'size', 'block')));

        $url = '#';
        if(array_key_exists('url', $data) && $data['url'] != '') $url = $this->getLink($data['url']);

        $target = '';
        if(array_key_exists('target', $data) && $data['target'] != '') $target = ' target="' . $data['target'] . '"';
        if(array_key_exists('newtab', $data) && $data['newtab'] != false) $target = ' target="_blank"';

        $collapse = '';
        if(array_key_exists('collapse-id', $data) && $data['collapse-id'] != '') {
            $collapse = ' data-toggle="collapse" data-target="#' . $data['collapse-id'] . '"';
        }

        $renderer->doc .= '<a href="' . $url . '"' . $target . ' class="btn ' . $classes . '" role="button"' . $collapse . '>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</a>'; 
    }
}
?>