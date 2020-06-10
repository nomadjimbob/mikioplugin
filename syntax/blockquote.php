<?php
/**
 * Mikio Syntax Plugin: Blockquote
 *
 * Syntax:  <BLOCKQUOTE [footer=] footer-text-colour footer-small></BLOCKQUOTE>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_blockquote extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'blockquote';
    public $options             = array('footer', 'footer-small', 'footer-text-colour');
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClassString($data);
        
        $renderer->doc .= '<blockquote class="blockquote ' . $classes . '">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $footerSmallPrefix = '';
        $footerSmallPostfix = '';
        $footerStyle = '';

        if(array_key_exists('footer-small', $this->values) && $this->values['footer-small'] != false) {
            $footerSmallPrefix = '<small>';
            $footerSmallPostfix = '</small>';
        }

        if(array_key_exists('footer-text-colour', $this->values) && $this->values['footer-text-colour'] != '') {
            $footerStyle = 'color:' . $this->values['footer-text-colour'] . ';';
        }

        if($footerStyle != '') $footerStyle = 'style="' . $footerStyle . '"';

        if(array_key_exists('footer', $this->values) && $this->values['footer'] != '') {
            $renderer->doc .= '<footer class="blockquote-footer" ' . $footerStyle . '>'. $footerSmallPrefix . $this->values['footer'] . $footerSmallPostfix . '</footer>';
        }

        $renderer->doc .= '</blockquote>'; 
    }
}
?>