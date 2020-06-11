<?php
/**
 * Mikio Syntax Plugin: Small
 *
 * Syntax:  <SMALL></SMALL>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_tabgroup extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'tabgroup';

    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClassString($data);

        $renderer->doc .= '<ul class="nav nav-tabs ' . $classes . '">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        // $renderer->doc .= '</div>';
    }


    public function render_lexer_unmatched(Doku_Renderer $renderer, $data) {
        $items = [];
        $bar = '';
        $content = '';
        $first = true;

        if(preg_match_all('/<(?:TAB|tab)(.*?)>(.*?)<\/(?:TAB|tab)>/s', $data, $match)) {
            if(count($match) >= 2 && count($match[1]) == count($match[2])) {
                for($i = 0; $i < count($match[1]); $i++) {
                    if(preg_match('/title=("\w[\w\s]*(?=")|\w+|"[\w\s]*")/is', $match[1][$i], $titleMatch)) {
                        if(count($titleMatch) >= 1) {
                            $title = str_replace("\"", "", $titleMatch[1]);
                            $items[] = array('title' => $title, 'id' => 'tab_' . rand(0, 32767), 'content' => $this->render_text($match[2][$i]));
                        }
                    }
                }
            }
        }

        foreach($items as $item) {
            $bar .= '<li class="nav-item"><a class="nav-item nav-link' . ($first ? ' active' : '') . '" data-toggle="tab" href="#' . $item['id'] . '">' . $item['title'] . '</a></li>';
            $content .= '<div id="' . $item['id'] . '" class="tab-pane ' . ($first ? ' show active' : '') . '"><p>' . $item['content'] . '</p></div>';

            $first = false;
        }

        $renderer->doc .= $bar . '</ul><div class="container-fluid"><div class="tab-content">' . $content . '</div></div>';
    }
}
?>
