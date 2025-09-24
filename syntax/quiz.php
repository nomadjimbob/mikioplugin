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
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_quiz extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'quiz';
    public $hasEndTag           = true;
    public $options             = array(
        'resettable'   => array('type'     => 'boolean',          'default'   => 'false'),
        'full'   => array('type'     => 'boolean',          'default'   => 'false'),
        'reset-text'   => array('type'     => 'text',          'default'   => 'Retry'),
        'submit-text'   => array('type'     => 'text',          'default'   => 'Submit'),
        'submit-type'   => array('type' => 'text', 'default' => ''),
        'prev-text'   => array('type'     => 'text',          'default'   => 'Prev'),
        'next-text'   => array('type'     => 'text',          'default'   => 'Next'),
        'correct-text'   => array('type'     => 'text',          'default'   => 'Correct'),
        'incorrect-text'   => array('type'     => 'text',          'default'   => 'Incorrect'),
        'status-text'   => array('type'     => 'text',          'default'   => 'Question $1 of $2'),
        'result-correct-text'   => array('type'     => 'text',          'default'   => 'You got $1 out of $2 correct'),
        'result-score-text'   => array('type'     => 'text',          'default'   => 'Score: $1'),
        'result-score-total-text'   => array('type'     => 'text',          'default'   => 'Total score: $1'),
    );

    public function __construct() {
        $this->addCommonOptions('type');
        $this->options['type']['default'] = 'secondary';
    }

    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data);
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz ' . $classes . '" data-status="' . $this->applyMarkdownEffects($data['status-text']) . '" data-result-correct="' . $this->applyMarkdownEffects($data['result-correct-text']) . '" data-result-score="' . $this->applyMarkdownEffects($data['result-score-text']) . '" data-result-score-total="' . $this->applyMarkdownEffects($data['result-score-total-text']) . '" data-correct="' . $this->applyMarkdownEffects($data['correct-text']) . '" data-incorrect="' . $this->applyMarkdownEffects($data['incorrect-text']) . '"' . ($data['full'] == true ? ' data-full="true"' : '') . '>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data);
        
        if($data['submit-type'] == '') {
            if(substr($data['type'], 0, 8) == 'outline-') {
                $data['type'] = substr($data['type'], 8);
            } else {
                $data['type'] = 'outline-'.$data['type'];
            }
        } else {
            $data['type'] = $data['submit-type'];
        }

        $oppositeClasses = $this->buildClass($data);
        /*
        ['type']
        outline-
        */

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz-result"></div>';
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz-status">';
        if($data['full'] == false) {
            $renderer->doc .= '<span class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz-status-text"></span>';
            $renderer->doc .= '<button class="' . $this->elemClass . ' ' . $this->classPrefix . 'button ' . $this->classPrefix . 'quiz-button-prev ' . $classes . '">&laquo; ' . $data['prev-text'] . '</button>';
        }
        $renderer->doc .= '<button class="' . $this->elemClass . ' ' . $this->classPrefix . 'button ' . $this->classPrefix . 'quiz-button-submit ' . $oppositeClasses . '">' . $data['submit-text'] . '</button>';
        if($data['resettable'] == true) {
            $renderer->doc .= '<button class="' . $this->elemClass . ' ' . $this->classPrefix . 'button ' . $this->classPrefix . 'quiz-button-reset ' . $oppositeClasses . '">' . $data['reset-text'] . '</button>';
        }
        if($data['full'] == false) {
            $renderer->doc .= '<button class="' . $this->elemClass . ' ' . $this->classPrefix . 'button ' . $this->classPrefix . 'quiz-button-next ' . $classes . '">' . $data['next-text'] . ' &raquo;</button>';
        }
        $renderer->doc .= '</div>';
        $renderer->doc .= '</div>'; 
    }
}
?>