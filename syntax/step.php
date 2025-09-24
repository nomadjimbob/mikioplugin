<?php
/**
 * Mikio Syntax Plugin: Step
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_step extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'step';
    public $hasEndTag           = true;
    public $options             = array(
        'title'         => array('type'     => 'text',      'default'   => ''),
        'complete'      => array('type'     => 'boolean',   'default'   => 'false'),
        'url'           => array('type'     => 'url',       'default'   => ''),
        'icon'          => array('type'     => 'text',      'default'   => ''),
    );
    
    public function __construct() {
        $this->addCommonOptions('type');
    }

    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data, array('complete'));

        $renderer->doc .= '<li class="' . $this->elemClass . ' ' . $this->classPrefix . 'step' . $classes . '">';
        if($data['url']) $renderer->doc .= '<a href="' . $data['url'] . '" class="' . $this->elemClass . ' ' . $this->classPrefix . 'step-link">';
        if(!empty($data['icon'])) {
            $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'step-icon">';
            $this->syntaxRender($renderer, 'icon', '', array_flip(explode(' ', $data['icon'])), MIKIO_LEXER_SPECIAL);
            $renderer->doc .= '</div>';
        }
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'step-text">';
        if(!empty($data['title'])) $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'step-title">' . $data['title'] . '</div>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        if($data['url']) $renderer->doc .= '</a>';
        $renderer->doc .= '</div>';
        $renderer->doc .= '</li>';
    }
}
?>
