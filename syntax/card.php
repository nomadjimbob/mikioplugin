<?php
/**
 * Mikio Syntax Plugin: Card
 *
 * Syntax:  <CARD [width=] [height=] [image=] [title=] [header=] [subtitle=] [listgroup] [nobody]></CARD>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_card extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'card';
    public $options             = array('width', 'height', 'image', 'title', 'subtitle', 'listgroup', 'nobody', 'header');
    
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $styles = [];
        $body = true;

        $this->setAttr($styles, 'width', $data);
        $this->setAttr($styles, 'height', $data);

        $renderer->doc .= '<div class="card"' . $this->listAttr('style', $styles) . '>';
        if(array_key_exists('image', $data) && $data['image'] != '') $renderer->doc .= '<img src="' . $this->getMediaFile($data['image']) . '" class="card-img-top">';

        if((array_key_exists('listgroup', $data) && $data['listgroup'] == true) || (array_key_exists('nobody', $data) && $data['nobody'] == true)) $body = false;

        if(array_key_exists('header', $data) && $data['header'] != '') $this->syntaxRender($renderer, 'syntax_plugin_mikioplugin_cardheader', $data['header']);

        if($body) {
            $renderer->doc .= '<div class="card-body">';
        }
        
        if(array_key_exists('title', $data) && $data['title'] != '') $this->syntaxRender($renderer, 'syntax_plugin_mikioplugin_cardtitle', $data['title']);
        if(array_key_exists('subtitle', $data) && $data['subtitle'] != '') $this->syntaxRender($renderer, 'syntax_plugin_mikioplugin_cardsubtitle', $data['subtitle']);
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        if((!array_key_exists('listgroup', $this->values) || $this->values['listgroup'] == false) && (!array_key_exists('nobody', $this->values) || $this->values['nobody'] == false)) {
            $renderer->doc .= '</div>'; 
        }

        $renderer->doc .= '</div>'; 
    }
}
?>