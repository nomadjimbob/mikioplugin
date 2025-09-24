<?php
/**
 * Mikio Syntax Plugin: Badge
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_badge extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'badge';
    public $hasEndTag           = true;
    public $options             = array(
        'pill'          => array('type'     => 'boolean',   'default'   => 'false',     'prefix'    => 'badge-'),
        'url'           => array('type'     => 'url',       'default'   => ''),
        'target'        => array('type'     => 'text',      'default'   => ''),
        'newtab'        => array('type'     => 'set',       'option'    => 'target',    'data'      => '_blank'),
        'collapse-id'   => array('type'     => 'text',      'default'   => ''),
    );
    
    public function __construct() {
        $this->addCommonOptions('type shadow width text-align');
        $this->options['type']['default'] = 'primary';
    }

    public function getAllowedTypes() { return array('formatting', 'substition', 'disabled'); }
    public function getPType() { return 'normal'; }
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data, array('type', 'pill'));
        $styles = $this->buildStyle(array('width' => $data['width'] ?? ''), TRUE);

        $tag = 'span';
        $href = '';
        if(!empty($data['url'])) {
            $tag = 'a';
            $href = ' href="' . $data['url'] . '"' . ($data['target'] != '' ? ' target="'.$data['target'].'"' : '');
        }

        $renderer->doc .= '<' . $tag . $href . ' class="' . $this->elemClass . ' ' . $this->classPrefix . 'badge' . $classes . '"' . $styles . '>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        if($data['url'] == '') {
            $renderer->doc .= '</span>';
        } else {
            $renderer->doc .= '</a>';
        }
    }
}
?>