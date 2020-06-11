<?php
/**
 * Mikio Syntax Plugin: NOSIDEBAR
 *
 * Syntax:  ~~NOSIDEBAR~~
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
 
class syntax_plugin_mikioplugin_nosidebar extends DokuWiki_Syntax_Plugin {
    function getType(){ return 'substition'; }
    function getPType(){ return 'normal'; }
    function getSort(){ return 32; }
 
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('~~NOSIDEBAR~~', $mode, 'plugin_mikioplugin_nosidebar');
    }
 
    function handle($match, $state, $pos, Doku_Handler $handler){
        return true;
    }

    function render($mode, Doku_Renderer $renderer, $data) {
        if($mode == "metadata") {
            $renderer->meta['nosidebar'] = true;
        }

        return true;
    } 
}
?>