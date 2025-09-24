<?php
/**
 * Mikio Syntax Plugin: Quiz Item
 *
 * @author  James Collins <james.collins@outlook.com.au>
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @link    http://github.com/nomadjimbob/mikioplugin
 */

if (!defined('DOKU_INC')) {
    die(); 
}
if (!defined('DOKU_PLUGIN')) {
    define('DOKU_PLUGIN', DOKU_INC.'lib/plugins/');
}
require_once __DIR__.'/core.php';
 
class syntax_plugin_mikioplugin_quizitem extends syntax_plugin_mikioplugin_core
{
    public $tag                 = 'quiz-item';
    public $requires_tag        = 'quiz';
    public $hasEndTag           = false;
    public $options             = array(
        'type'          => array('type'     => 'choice',
                                 'data'     => array('choice', 'multiple'),
                                 'default'  => 'choice'),
        'question'      => array('type'     => 'text',          'default'   => ''),
        'options'       => array('type'     => 'text',          'default'   => ''),
        'answer'        => array('type'     => 'text',          'default'   => ''),
        'scores'        => array('type'     => 'text',          'default'   => ''),
        'text'          => array('type'     => 'text',          'default'   => ''),
    );
    
    public function render_lexer_special(Doku_Renderer $renderer, $data)
    {
        $classes = $this->buildClass($data);

        $data['question'] = $this->applyMarkdownEffects($data['question']);
        $data['text'] = $this->applyMarkdownEffects($data['text']);

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz-item' . $classes . '" data-question="' . $data['question'] . '" ' . ($data['answer'] != '' ? 'data-answer="' . $data['answer'] . '"' : '') . '>';
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz-question">' . $data['question'] . '</div>';
        if(!empty($data['text'])) { $renderer->doc .= '<p>' . $data['text'] . '</p>';
        }
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz-options">';

        switch(strtolower($data['type'])) {
        case 'choice':
            $name = rand(10000, 99999);

            $options = explode('|', $data['options']);
            $scores = explode('|', $data['scores']);
            foreach($options as $key => $option) {
                $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz-option"><label><input type="radio" name="' . $name . '" value="' . $option . '" ' . (isset($scores[$key]) && $scores[$key] != "" ? 'data-score="' . $scores[$key] . '" ' : '') . '/>' . $this->applyMarkdownEffects($option) . '</label></div>';
            }
            break;
        case 'multiple':
            $name = rand(10000, 99999);

            $options = explode('|', $data['options']);
            $scores = explode('|', $data['scores']);
            $inGroup = false;
            $groupKey = 0;

            foreach($options as $key => $option) {
                $endGroup = false;

                if($inGroup === false && substr($option, 0, 1) === '[') {
                    $inGroup = true;
                    $option = substr($option, 1);
                } else if($inGroup === true && substr($option, -1) === ']') {
                    $endGroup = true;
                    $option = substr($option, 0, -1);
                }

                if($inGroup === true) {
                    $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz-option"><label><input type="radio" name="' . $name . '-group-' . $groupKey . '" value="' . $option . '" ' . (isset($scores[$key]) && $scores[$key] != "" ? 'data-score="' . $scores[$key] . '" ' : '') . '/>' . $this->applyMarkdownEffects($option) . '</label></div>';
                } else {
                    $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'quiz-option"><label><input type="checkbox" name="' . $name . '-' . $key . '" value="' . $option . '" ' . (isset($scores[$key]) && $scores[$key] != "" ? 'data-score="' . $scores[$key] . '" ' : '') . '/>' . $this->applyMarkdownEffects($option) . '</label></div>';
                }

                if($endGroup === true) {
                    $inGroup = false;
                    $groupKey++;
                }
            }
            break;
        }
        
        $renderer->doc .= '</div>';
        $renderer->doc .= '</div>';
    }
}
?>
