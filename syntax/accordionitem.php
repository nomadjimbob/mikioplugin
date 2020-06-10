<?php
/**
 * Mikio Syntax Plugin: Accordion Item
 *
 * Syntax:  <ACCORDION-ITEM></ACCORDION-ITEM>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_accordionitem extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'accordion-item';
    public $options             = array('title', 'id', 'parent', 'show');
    
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $id = '';
        $parent = '';
        $title = '';
        $heading = 'heading_' . rand(0, 32767);
        $collapse = 'collapse_' . rand(0, 32767);
        $show = '';

        if(array_key_exists('id', $data) && $data['id'] != '') {
            $id = $data['id'];
        } else {
            $id = 'accordion_item_' . rand(0, 32767);
            $this->values['id'] = $id;
        }

        if(array_key_exists('parent', $data) && $data['parent'] != '') $parent = $data['parent'];
        if(array_key_exists('title', $data) && $data['title'] != '') $title = $data['title'];
        if(array_key_exists('show', $data) && $data['show'] != false) $show = 'show';

        $renderer->doc .= '<div class="card"><div class="card-header" id="' . $heading . '"><h5 class="mb-0"><button class="btn btn-link" data-toggle="collapse" data-target="#' . $collapse . '" aria-expanded="true" aria-controls="' . $collapse . '">' . $title . '</button></h5></div><div id="' . $collapse . '" class="collapse ' . $show . '" aria-labelledby="' . $heading . '" data-parent="#' . $parent . '"><div class="card-body">';
    }
        

    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div></div></div>'; 
    }
}
?>