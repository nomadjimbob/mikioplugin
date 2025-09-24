<?php
/**
 * Mikio Syntax Plugin: List Group Item
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_listgroupitem extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'listgroup-item';
    public $requires_tag        = 'listgroup';
    public $hasEndTag           = true;
    public $options             = array(
        'active'            => array('type' => 'boolean',   'default'   => 'false'),
        'disabled'          => array('type' => 'boolean',   'default'   => 'false'),
        'url'               => array('type' => 'url',       'default'   => ''),
        'content-vertical'  => array('type' => 'boolean',   'default'   => 'false'),
    );

    public function __construct() {
        $this->addCommonOptions('type text-align');
    }
    
    public function getAllowedTypes() { return array('formatting', 'substition', 'disabled'); }
    public function getPType() { return 'normal'; }
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data, array('active', 'disabled', 'content-vertical'));

        $renderer->doc .= '<li class="' . $this->elemClass . ' ' . $this->classPrefix . 'list-group-item' . $classes . '">';
        if(!empty($data['url'])) $renderer->doc .= '<a href="' . $data['url'] . '" class="' . $this->elemClass . ' ' . $this->classPrefix . 'list-group-item-link">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        if(!empty($data['url'])) $renderer->doc .= '</a>';
        $renderer->doc .= '</li>'; 
    }
}
?>