<?php
/**
 * Mikio Syntax Plugin: Carousel
 *
 * Syntax:  <CAROUSEL [slide] [fade] [indicators=]></CAROUSEL>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_carousel extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'carousel';
    public $options             = array('slide', 'fade', 'indicators', 'indicator-active');
    
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClassString($data, array('slide', 'fade'), array('carousel-' => 'fade'));

        $renderer->doc .= '<div class="carousel' . $classes . '" data-ride="carousel">';
        
        
        if(array_key_exists('indicators', $data) && $data['indicators'] > 0) {
            $indicatorActive = 0;
            if(array_key_exists('indicator-active', $data)) $indicatorActive = intval($data['indicator-active']);

            $renderer->doc .= '<ol class="carousel-indicators">';
            for($i = 0; $i < intval($data['indicators']); $i++) {
                $renderer->doc .= '<li data-target="#carouselExampleIndicators" data-slide-to="' . $i . '"' . ($i == $indicatorActive ? ' class="active"' : ''). '></li>';
            }
            $renderer->doc .= '</ol>';
        }

        $renderer->doc .= '<div class="carousel-inner">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div></div>'; 
    }
}
?>