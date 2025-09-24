<?php
/**
 * Mikio Syntax Plugin:Pagination
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
 
class syntax_plugin_mikioplugin_pagination extends syntax_plugin_mikioplugin_core
{
    public $tag                 = 'pagination';
    public $hasEndTag           = true;
    
    public function __construct()
    {
        $this->addCommonOptions('shadow');
    }

    public function getAllowedTypes()
    {
        return array(); 
    }
    public function getPType()
    {
        return 'normal'; 
    }

    public function render_lexer_enter(Doku_Renderer $renderer, $data)
    {
        global $conf;

        $classes = $this->buildClass($data);

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'pagination" data-start="' . $conf['start'] . '">';
        $renderer->doc .= '<ul class="' . $this->elemClass . ' ' . $this->classPrefix . 'pagination-inner'. $classes . '">';
        $renderer->doc .= '<li class="' . $this->elemClass . ' ' . $this->classPrefix . 'pagination-item ' . $this->classPrefix . 'pagination-prev"><a href="#">Prev</a></li>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data)
    {
        $renderer->doc .= '<li class="' . $this->elemClass . ' ' . $this->classPrefix . 'pagination-item ' . $this->classPrefix . 'pagination-next"><a href="#">Next</a></li>';
        $renderer->doc .= '</ul></div>';
    }

    public function render_lexer_unmatched(Doku_Renderer $renderer, $data)
    {
        $i = 1;

        $itemOptions = array(
            'url'     => array('type' => 'url',      'default'   => ''),
            'active'    => array('type' => 'boolean',   'default'=> 'false', 'class' => true),
            'disabled'    => array('type' => 'boolean',   'default'=> 'false', 'class' => true),
        );

        $items = array_merge(
            $this->findTags($this->tagPrefix . 'pagination-item', $data, $itemOptions, false),
            $this->findTags($this->tagPrefix . 'pagenation-item', $data, $itemOptions, false)
        );

        foreach($items as $item) {
            $classes = $this->buildClass($item['options'], null, false, $itemOptions);

            $renderer->doc .= '<li class="' . $this->elemClass . ' ' . $this->classPrefix . 'pagination-item' . $classes . '"><a href="' . $item['options']['url'] . '">' . $i++ . '</a></li>';
        }
    }
}
?>
