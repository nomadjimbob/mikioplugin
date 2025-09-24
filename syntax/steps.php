<?php
/**
 * Mikio Syntax Plugin: Steps
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_steps extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'steps';
    public $requires_tag        = 'step';
    public $hasEndTag           = true;
    
    public function __construct() {
        $this->addCommonOptions('shadow');
    }

    // public function getAllowedTypes() {  return array(); }

    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data);

        $renderer->doc .= '<ul class="' . $this->elemClass . ' ' . $this->classPrefix . 'steps'. $classes . '">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</ul>';
    }


    // public function render_lexer_unmatched(Doku_Renderer $renderer, $data) {
    //     $items = [];
    //     $bar = '';

    //     if(preg_match_all('/<(?i:' . $this->tagPrefix . 'step)(.*?)>/s', $data, $match)) {
    //         if(count($match) >= 1) {
    //             for($i = 0; $i < count($match[1]); $i++) {
    //                 $title = '';
    //                 $text = '';
    //                 $complete = false;

    //                 if(preg_match('/title=("\w[\w\s]*(?=")|\w+|"[\w\s]*")/is', $match[1][$i], $titleMatch)) {
    //                     if(count($titleMatch) >= 1) {
    //                         $title = str_replace("\"", "", $titleMatch[1]);
    //                     }
    //                 }

    //                 if(preg_match('/text=("\w[\w\s]*(?=")|\w+|"[\w\s]*")/is', $match[1][$i], $titleMatch)) {
    //                     if(count($titleMatch) >= 1) {
    //                         $text = str_replace("\"", "", $titleMatch[1]);
    //                     }
    //                 }

    //                 if(preg_match('/ complete /is', $match[1][$i], $titleMatch)) {
    //                     if(count($titleMatch) >= 1) {
    //                         $complete = true;
    //                     }
    //                 }

    //                 $items[] = array('title' => $title, 'text' => $text, 'complete' => $complete);
    //             }
    //         }
    //     }

    //     foreach($items as $item) {
    //         $bar .= '<li class="' . $this->elemClass . ' ' . $this->classPrefix . 'step' . ($item['complete'] ? ' ' . $this->classPrefix . 'complete' : '' ) . '"><b>' . $item['title'] .'</b>' . $item['text'] . '</li>';
    //     }

    //     $renderer->doc .= $bar . '</ul>';
    // }
}
?>
