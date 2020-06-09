<?php
/**
 * Mikio Syntax Plugin: HR
 *
 * Syntax:  ---- or <HR> will be replaced with the horizontal line element
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

 
class syntax_plugin_mikioplugin_hr extends DokuWiki_Syntax_Plugin {
    public function getType(){ return 'substition'; }
    public function getAllowedTypes() { return array('formatting', 'substition', 'disabled'); }   
    public function getSort(){ return 238; }
    
    
    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('----', $mode, 'plugin_mikioplugin_'.$this->getPluginComponent());
        $this->Lexer->addSpecialPattern('<hr>', $mode, 'plugin_mikioplugin_'.$this->getPluginComponent());
    }


    public function handle($match, $state, $pos, Doku_Handler $handler){
        return array($match, $state, $pos);
    }


    public function render($mode, Doku_Renderer $renderer, $data) {
        if($mode == 'xhtml') {
            $renderer->doc .= '<hr>';
            return true;
        }

        return false;
    }   
}