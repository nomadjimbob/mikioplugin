<?php
/**
 * Mikio Syntax Plugin: Carousel Item
 *
 * Syntax:  <CAROUSEL-ITEM [active] [image=] [title=] [text=]></CAROUSEL-ITEM>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_carouselitem extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'carousel-item';
    public $noEndTag            = true;
    public $options             = array('active', 'image', 'title', 'text');
    
    
    public function render_lexer_special(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClassString($data, array('active'), '');

        $renderer->doc .= '<div class="carousel-item' . $classes . '">';
        if(array_key_exists('image', $data) && $data['image'] != '') $renderer->doc .= '<img src="' . $this->getMediaFile($data['image']) . '" class="d-block w-100">';
        
        if((array_key_exists('title', $data) && $data['title'] != '') || (array_key_exists('title', $data) && $data['title'] != '')) {
            $renderer->doc .= '<div class="carousel-caption d-none d-md-block">';
            if(array_key_exists('title', $data) && $data['title'] != '') $renderer->doc .= '<h5>' . $data['title'] . '</h5>';
            if(array_key_exists('text', $data) && $data['text'] != '') $renderer->doc .= '<p>' . $data['text'] . '</p>';    
            $renderer->doc .= '</div>';
        }        
        
        $renderer->doc .= '</div>';
    }

}
?>