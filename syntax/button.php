<?php
/**
 * Mikio Syntax Plugin: Button
  *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_button extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'button';
    public $hasEndTag           = true;
    public $options             = array(
        'type'          => array('type'     => 'choice',
                                 'data'     => array('primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'),
                                 'default'  => 'primary'),
        'size'          => array('type'     => 'choice',
                                 'data'     => array('large'=> array('large', 'lg'), 'small' => array('small', 'sm')),
                                 'default'  => ''),
        'block'         => array('type'     => 'boolean',   'default'   => 'false'),
        'active'        => array('type'     => 'boolean',   'default'   => 'false'),
        'disabled'      => array('type'     => 'boolean',   'default'   => 'false'),    // also supports prefix => ''
        'url'           => array('type'     => 'text',      'default'   => ''),
        'target'        => array('type'     => 'text',      'default'   => ''),
        'newtab'        => array('type'     => 'set',       'option'    => 'target',    'data'  => '_blank'),
        'collapse-id'   => array('type'     => 'text',      'default'   => ''),
        'nowrap'        => array('type'     => 'boolean',   'default'   => 'false'),
    );

    public function __construct() {
        $this->addCommonOptions('type shadow width align text-align');
        $this->options['type']['data'] = array_merge($this->options['type']['data'], array('link', 'outline-primary', 'outline-secondary', 'outline-success', 'outline-danger', 'outline-warning', 'outline-info', 'outline-light', 'outline-dark'));
        $this->options['type']['default'] = 'primary';
    }

    public function getAllowedTypes() { return array('formatting', 'substition', 'disabled'); }
    public function getPType() { return 'normal'; }

    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data, array('size', 'block', 'active', 'disabled', 'nowrap'));
        $styles = $this->buildStyle(array('width' => $data['width']), TRUE);

        $url = ($data['url'] != '' ? $this->buildLink($data['url']) : '#');
        $target = $data['target'];
        $collapse = $data['collapse-id'];

        $renderer->doc .= '<a href="' . $url . '"' . ($target != '' ? ' target="'.$target.'"' : '') . ' class="' . $this->elemClass . ' ' . $this->classPrefix . 'button ' . $classes . '" role="button"' . ($collapse != '' ? ' data-toggle="collapse" data-target="#' . $data['collapse-id'] . '"' : '') . ' ' . ($data['disabled'] ? 'disabled' : '') . $styles . '>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</a>'; 
    }
}
?>