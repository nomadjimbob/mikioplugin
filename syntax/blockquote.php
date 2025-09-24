<?php
/**
 * Mikio Syntax Plugin: Blockquote
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
 
class syntax_plugin_mikioplugin_blockquote extends syntax_plugin_mikioplugin_core
{
    public $tag                 = 'blockquote';
    public $hasEndTag           = true;
    public $options             = array(
        'footer'                => array('type' => 'text',      'default'   => ''),
        'cite'                  => array('type' => 'text',      'default'   => ''),
    );

    public function __construct()
    {
        $this->addCommonOptions('text-align');
    }

    public function getAllowedTypes()
    {
        return array('formatting', 'substition', 'disabled', 'container', 'protected'); 
    }
    public function getPType()
    {
        return 'normal'; 
    }    
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data)
    {
        $classes = $this->buildClass($data);

        $renderer->doc .= '<blockquote class="' . $this->elemClass . ' ' . $this->classPrefix . 'blockquote' . $classes . '"><p>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data)
    {
        $renderer->doc .= '</p>';

        if(!empty($data['footer'])) {
            $footer = $data['footer'];

            if(!empty($data['cite'])) {
                $i = strripos($footer, $data['cite']);
                if($i !== false) {
                    $cite = substr($footer, $i, strlen($data['cite']));
                    $footer = substr($footer, 0, $i) . '<cite class="' . $this->elemClass . ' ' . $this->classPrefix . 'cite" title="' . $cite . '">' . substr($footer, $i, strlen($cite)) . '</cite>' . substr($footer, $i + strlen($cite));
                }
            }

            $renderer->doc .= '<footer class="' . $this->elemClass . ' ' . $this->classPrefix . 'blockquote-footer">';
            $renderer->doc .= $footer;
            $renderer->doc .= '</footer>';
        }

        $renderer->doc .= '</blockquote>'; 
    }
}
?>