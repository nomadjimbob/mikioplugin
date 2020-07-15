<?php
/**
 * Mikio Syntax Plugin: Quiz
  *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_quiz extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'quiz';
    public $hasEndTag           = true;
    public $options             = array(
    );


    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data);

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz ' . $classes . '" data-status="Question $1 of $2" data-result="You got $1 out of $2 correct">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz-result"></div>';
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz-status">';
        $renderer->doc .= '<span class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz-status-text"></span>';
        $renderer->doc .= '<button class="' . $this->elemClass . ' ' . $this->classPrefix . 'button ' . $this->classPrefix . 'quiz-button-prev">&laquo; Prev</button>';
        $renderer->doc .= '<button class="' . $this->elemClass . ' ' . $this->classPrefix . 'button ' . $this->classPrefix . 'quiz-button-submit">Submit</button>';
        $renderer->doc .= '<button class="' . $this->elemClass . ' ' . $this->classPrefix . 'button ' . $this->classPrefix . 'quiz-button-next">Next &raquo;</button>';
        $renderer->doc .= '</div>';
        $renderer->doc .= '</div>'; 
    }
}
?>