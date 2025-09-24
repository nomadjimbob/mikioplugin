<?php
/**
 * Mikio Syntax Plugin: Accordion Item
 *
 * @link    http://github.com/nomadjimbob/mikioplugin
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author  James Collins <james.collins@outlook.com.au>
 */

if (!defined('DOKU_INC')) { die();
}
if (!defined('DOKU_PLUGIN')) { define('DOKU_PLUGIN', DOKU_INC.'lib/plugins/');
}
require_once __DIR__.'/core.php';
 
class syntax_plugin_mikioplugin_accordionitem extends syntax_plugin_mikioplugin_core
{
    public $tag                 = 'accordion-item';
    public $requires_tag        = 'accordion';
    public $hasEndTag           = true;
    public $options             = array(
        'title'         => array('type'     => 'text',      'default'   => ''),
        'show'          => array('type'     => 'boolean',   'default'   => 'false'),
    );
    
    public function __construct()
    {
        $this->addCommonOptions('type text-align');
    }
    
    public function getAllowedTypes()
    {
        return array('container', 'formatting', 'substition', 'disabled', 'paragraphs', 'protected'); 
    }

    public function render_lexer_enter(Doku_Renderer $renderer, $data)
    {
        $classes = $this->buildClass($data, array('show'));

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'accordian-item' . $classes . '"><a href="#" class="' . $this->elemClass . ' ' . $this->classPrefix . 'accordian-title">' . $data['title'] . '</a><div class="' . $this->elemClass . ' ' . $this->classPrefix . 'accordian-body">';
    }
        

    public function render_lexer_exit(Doku_Renderer $renderer, $data)
    {
        $renderer->doc .= '</div></div>'; 
    }
}
?>