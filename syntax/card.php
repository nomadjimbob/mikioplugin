<?php
/**
 * Mikio Syntax Plugin: Card
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_card extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'card';
    public $hasEndTag           = true;
    public $options             = array(
        'image'         => array('type'     => 'media',      'default'   => ''),
        'overlay'       => array('type'     => 'boolean',   'default'   => 'false'),
        'title'         => array('type'     => 'text',      'default'   => ''),
        'subtitle'      => array('type'     => 'text',      'default'   => ''),
        'no-body'        => array('type'     => 'boolean',   'default'   => 'false'),
        'header'      => array('type'     => 'text',      'default'   => ''),
        'footer'      => array('type'     => 'text',      'default'   => ''),
        'placeholder-text'      => array('type'     => 'text',      'default'   => ''),
        'placeholder-color'      => array('type'     => 'text',      'default'   => ''),
        'placeholder-text-color'      => array('type'     => 'text',      'default'   => ''),
        'footer-image'      => array('type'     => 'media',      'default'   => ''),
        'footer-placeholder-text'      => array('type'     => 'text',      'default'   => ''),
        'footer-placeholder-color'      => array('type'     => 'text',      'default'   => ''),
        'footer-placeholder-text-color'      => array('type'     => 'text',      'default'   => ''),
        'horizontal'            => array('type'     => 'boolean',   'default'   => 'false'),
        'footer-small'        => array('type'     => 'boolean',   'default'   => 'false'),
    );
    

    public function __construct() {
        $this->addCommonOptions('type shadow width height text-align vertical-align text-color');
    }
    
    public function getAllowedTypes() { return array('formatting', 'substition', 'disabled', 'container'); }
    public function getPType() { return 'normal'; }
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data, array('overlay', 'horizontal'));
        $styles = $this->buildStyle(array('height' => $data['height'], 'width' => $data['width']), TRUE);

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'card' . $classes . '"' . $styles . '>';

        if($data['horizontal']) $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'card-horizontal-image">';
        if($data['placeholder-text'] != '') {
            $this->syntaxRender($renderer, 'placeholder', '', $this->arrayRemoveEmpties(array('text' => $data['placeholder-text'], 'color' => $data['placeholder-color'], 'text-color' => $data['placeholder-text-color'])));
        } elseif($data['image'] != '') {
            $renderer->doc .= '<img src="' . $data['image'] . '" class="' . $this->elemClass . ' ' . $this->classPrefix . 'card-image">';
        }
        if($data['horizontal']) $renderer->doc .= '</div><div class="' . $this->elemClass . ' ' . $this->classPrefix . 'card-horizontal-body">';
        
        if($data['header'] != '') $this->syntaxRender($renderer, 'cardheader', $data['header']);

        if($data['no-body'] == FALSE) $this->syntaxRender($renderer, 'cardbody', '', $this->arrayRemoveEmpties(array('vertical-align' => $data['vertical-align'], 'text-color' => $data['text-color'])), MIKIO_LEXER_ENTER);
        
        if($data['title'] != '') $this->syntaxRender($renderer, 'cardtitle', $data['title']);
        if($data['subtitle'] != '') $this->syntaxRender($renderer, 'cardsubtitle', $data['subtitle']);
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        if($data['no-body'] == FALSE) $this->syntaxRender($renderer, 'cardbody', '', null, MIKIO_LEXER_EXIT);

        if($data['footer'] != '') {
            $this->syntaxRender($renderer, 'cardfooter', $data['footer'], $this->arrayRemoveEmpties(array('small' => $data['footer-small'])));
        }

        if($data['footer-placeholder-text'] != '') {
            $this->syntaxRender($renderer, 'placeholder', '', $this->arrayRemoveEmpties(array('text' => $data['footer-placeholder-text'], 'color' => $data['footer-placeholder-color'], 'text-color' => $data['footer-placeholder-text-color'])));
        } elseif($data['footer-image'] != '') {
            $renderer->doc .= '<img src="' . $data['footer-image'] . '" class="' . $this->elemClass . ' ' . $this->classPrefix . 'card-image">';
        }
        
        if($data['horizontal']) $renderer->doc .= '</div>';
        $renderer->doc .= '</div>'; 
    }
}
?>