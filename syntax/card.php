<?php
/**
 * Mikio Syntax Plugin: Card
 *
 * Syntax:  <CARD [width=] [height=] [image=] [image-overlay=] [footer-image=] [title=] [header=] [footer=] [subtitle=] [listgroup] [nobody] [placeholder-text=] [placeholder-colour=] [placeholder-text-colour=] [footer-placeholder-text=] [footer-placeholder-colour=] [footer-placeholder-text-colour=] [horizontal] [footer-small]></CARD>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_card extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'card';
    public $options             = array('width', 'height', 'image', 'overlay', 'title', 'subtitle', 'listgroup', 'nobody', 'header', 'footer', 'placeholder-text', 'placeholder-colour', 'placeholder-text-colour', 'footer-image', 'footer-placeholder-text', 'footer-placeholder-colour', 'footer-placeholder-text-colour', 'horizontal', 'footer-small');
    
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $styles = [];
        $body = true;
        $overlay = false;
        $horizontal = false;
        $classes = $this->buildClassString($data);

        $this->setAttr($styles, 'width', $data);
        $this->setAttr($styles, 'height', $data);

        if(array_key_exists('overlay', $data) && $data['overlay'] != false) $overlay = true;
        if(array_key_exists('horizontal', $data) && $data['horizontal'] != false) $horizontal = true;

        $renderer->doc .= '<div class="card ' . $classes . '"' . $this->listAttr('style', $styles) . '>';

        if($horizontal) $renderer->doc .= '<div class="row no-gutters"><div class="col-md-4">';

        if((array_key_exists('placeholder-text', $data) && $data['placeholder-text'] != '') || (array_key_exists('placeholder-colour', $data) && $data['placeholder-colour'] != '') || (array_key_exists('placeholder-text-colour', $data) && $data['placeholder-text-colour'] != '')) {
            $placeholderData = array('classes' => ($overlay ? 'card-img' : 'card-img-top'));
            if(array_key_exists('placeholder-text', $data) && $data['placeholder-text'] != '') $placeholderData['text'] = $data['placeholder-text'];
            if(array_key_exists('placeholder-colour', $data) && $data['placeholder-colour'] != '') $placeholderData['colour'] = $data['placeholder-colour'];
            if(array_key_exists('placeholder-text-colour', $data) && $data['placeholder-text-colour'] != '') $placeholderData['text-colour'] = $data['placeholder-text-colour'];

            $this->syntaxRender($renderer, 'syntax_plugin_mikioplugin_placeholder', '', $placeholderData);

        } else {
            if(array_key_exists('image', $data) && $data['image'] != '') $renderer->doc .= '<img src="' . $this->getMediaFile($data['image']) . '" class="card-img-top">';
        }

        if($horizontal) $renderer->doc .= '</div><div class="col-md-8">';
        
        if((array_key_exists('listgroup', $data) && $data['listgroup'] == true) || (array_key_exists('nobody', $data) && $data['nobody'] == true)) $body = false;

        if(array_key_exists('header', $data) && $data['header'] != '') $this->syntaxRender($renderer, 'syntax_plugin_mikioplugin_cardheader', $data['header']);

        if($body) {
            if($overlay) {
                $renderer->doc .= '<div class="card-img-overlay">';
            } else {
                $renderer->doc .= '<div class="card-body">';
            }
        }
        
        if(array_key_exists('title', $data) && $data['title'] != '') $this->syntaxRender($renderer, 'syntax_plugin_mikioplugin_cardtitle', $data['title']);
        if(array_key_exists('subtitle', $data) && $data['subtitle'] != '') $this->syntaxRender($renderer, 'syntax_plugin_mikioplugin_cardsubtitle', $data['subtitle']);
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        if((!array_key_exists('listgroup', $this->values) || $this->values['listgroup'] == false) && (!array_key_exists('nobody', $this->values) || $this->values['nobody'] == false)) {
            $renderer->doc .= '</div>'; 
        }

        if(array_key_exists('horizontal', $this->values) && $this->values['horizontal'] != false) {
            $renderer->doc .= '</div></div>';
        }

        $footerOptions = array();
        if(array_key_exists('footer-small', $this->values) && $this->values['footer-small'] != false) $footerOptions['small'] = true;

        if(array_key_exists('footer', $this->values) && $this->values['footer'] != '') {
            $this->syntaxRender($renderer, 'syntax_plugin_mikioplugin_cardfooter', $this->values['footer'], $footerOptions);
        }

        if((array_key_exists('footer-placeholder-text', $this->values) && $this->values['footer-placeholder-text'] != '') || (array_key_exists('footer-placeholder-colour', $this->values) && $this->values['footer-placeholder-colour'] != '') || (array_key_exists('footer-placeholder-text-colour', $this->values) && $this->values['footer-placeholder-text-colour'] != '')) {
            $placeholderData = array('classes' => 'card-img-top');
            if(array_key_exists('footer-placeholder-text', $this->values) && $this->values['footer-placeholder-text'] != '') $placeholderData['text'] = $this->values['footer-placeholder-text'];
            if(array_key_exists('footer-placeholder-colour', $this->values) && $this->values['footer-placeholder-colour'] != '') $placeholderData['colour'] = $this->values['footer-placeholder-colour'];
            if(array_key_exists('footer-placeholder-text-colour', $this->values) && $this->values['footer-placeholder-text-colour'] != '') $placeholderData['text-colour'] = $this->values['footer-placeholder-text-colour'];

            $this->syntaxRender($renderer, 'syntax_plugin_mikioplugin_placeholder', '', $placeholderData);

        } else {
            if(array_key_exists('footer-image', $this->values) && $this->values['footer-image'] != '') $renderer->doc .= '<img src="' . $this->getMediaFile($this->values['footer-image']) . '" class="card-img-top">';
        }

        $renderer->doc .= '</div>'; 
    }
}
?>