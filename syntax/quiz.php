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
        'resettable'   => array('type'     => 'boolean',          'default'   => 'false'),
        'reset-text'   => array('type'     => 'text',          'default'   => 'Retry'),
        'submit-text'   => array('type'     => 'text',          'default'   => 'Submit'),
        'prev-text'   => array('type'     => 'text',          'default'   => 'Prev'),
        'next-text'   => array('type'     => 'text',          'default'   => 'Next'),
        'correct-text'   => array('type'     => 'text',          'default'   => 'Correct'),
        'incorrect-text'   => array('type'     => 'text',          'default'   => 'Incorrect'),
        'status-text'   => array('type'     => 'text',          'default'   => 'Question $1 of $2'),
        'result-correct-text'   => array('type'     => 'text',          'default'   => 'You got $1 out of $2 correct'),
        'result-score-text'   => array('type'     => 'text',          'default'   => 'Score: $1'),
        'result-score-total-text'   => array('type'     => 'text',          'default'   => 'Total score: $1'),
    );


    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data);
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz ' . $classes . '" data-status="' . $data['status-text'] . '" data-result-correct="' . $data['result-correct-text'] . '" data-result-score="' . $data['result-score-text'] . '" data-result-score-total="' . $data['result-score-total-text'] . '" data-correct="' . $data['correct-text'] . '" data-incorrect="' . $data['incorrect-text'] . '">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz-result"></div>';
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz-status">';
        $renderer->doc .= '<span class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz-status-text"></span>';
        $renderer->doc .= '<button class="' . $this->elemClass . ' ' . $this->classPrefix . 'button ' . $this->classPrefix . 'quiz-button-prev">&laquo; ' . $data['prev-text'] . '</button>';
        $renderer->doc .= '<button class="' . $this->elemClass . ' ' . $this->classPrefix . 'button ' . $this->classPrefix . 'quiz-button-submit">' . $data['submit-text'] . '</button>';
        if($data['resettable'] == true) {
            $renderer->doc .= '<button class="' . $this->elemClass . ' ' . $this->classPrefix . 'button ' . $this->classPrefix . 'quiz-button-reset">' . $data['reset-text'] . '</button>';
        }
        $renderer->doc .= '<button class="' . $this->elemClass . ' ' . $this->classPrefix . 'button ' . $this->classPrefix . 'quiz-button-next">' . $data['next-text'] . ' &raquo;</button>';
        $renderer->doc .= '</div>';
        $renderer->doc .= '</div>'; 
    }
}
?>