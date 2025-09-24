<?php
/**
 * Mikio Syntax Plugin: TabGroup
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */

if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_tabgroup extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'tab-group';
    public $hasEndTag           = true;
    public $options             = array(
        'pills'     => array('type'     => 'boolean',   'default'   => 'false'),
    );
    
    public function getAllowedTypes() {  return array(); }

    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data, array('pills'));

        $renderer->doc .= '<ul class="' . $this->elemClass . ' ' . $this->classPrefix . 'tab-group' . $classes . '">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        
    }


    public function render_lexer_unmatched(Doku_Renderer $renderer, $data) {
        $items = [];
        $bar = '';
        $content = '';
        $first = true;

        $tabOptions = array(
            'title'     => array('type' => 'text',      'default'   => ''),
            'disabled'  => array('type' => 'boolean',   'default'   => 'false'),
        );

        $tabs = $this->findTags($this->tagPrefix . 'tab', $data, $tabOptions);

        foreach($tabs as $tab) {
            $classes = $this->buildClass($tab['options'], array('disabled'));
            
            $bar .= '<li class="' . $this->elemClass . ' ' . $this->classPrefix . 'tab-item' . $classes . '"><a class="' . $this->elemClass . ($first ? ' mikiop-active' : '') . '" data-toggle="tab" href="#">' . $tab['options']['title'] . '</a></li>';
            $content .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'tab-pane' . ($first ? ' mikiop-show' : '') . '"><p>' . $tab['content'] . '</p></div>';

            $first = false;
        }

        $renderer->doc .= $bar . '</ul><div class="' . $this->elemClass . ' ' . $this->classPrefix . 'tab-content">' . $content . '</div>';
    }
}
?>
