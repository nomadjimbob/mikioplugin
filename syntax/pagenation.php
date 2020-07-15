<?php
/**
 * Mikio Syntax Plugin: Pagenation
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_pagenation extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'pagenation';
    public $hasEndTag           = true;
    
    public function __construct() {
        $this->addCommonOptions('shadow');
    }

    public function getAllowedTypes() {  return array(); }
    public function getPType() { return 'normal'; }

    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data);

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'pagenation">';
        $renderer->doc .= '<ul class="' . $this->elemClass . ' ' . $this->classPrefix . 'pagenation-inner'. $classes . '">';
        $renderer->doc .= '<li class="' . $this->elemClass . ' ' . $this->classPrefix . 'pagenation-item ' . $this->classPrefix . 'pagenation-prev"><a href="#">Prev</a></li>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '<li class="' . $this->elemClass . ' ' . $this->classPrefix . 'pagenation-item ' . $this->classPrefix . 'pagenation-next"><a href="#">Next</a></li>';
        $renderer->doc .= '</ul></div>';
    }

    public function render_lexer_unmatched(Doku_Renderer $renderer, $data) {
        $i = 1;

        $itemOptions = array(
            'url'     => array('type' => 'url',      'default'   => ''),
            'active'    => array('type' => 'boolean',   'default'=> 'false', 'class' => true),
            'disabled'    => array('type' => 'boolean',   'default'=> 'false', 'class' => true),
        );

        $items = $this->findTags($this->tagPrefix . 'pagenation-item', $data, $itemOptions, false);

        foreach($items as $item) {
            $classes = $this->buildClass($item['options'], null, false, $itemOptions);

            $renderer->doc .= '<li class="' . $this->elemClass . ' ' . $this->classPrefix . 'pagenation-item' . $classes . '"><a href="' . $item['options']['url'] . '">' . $i++ . '</a></li>';
        }
    }
}
?>
