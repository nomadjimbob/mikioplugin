<?php
/**
 * Mikio Syntax Plugin: Box
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_box extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'box';
    public $requires_tag        = 'grid';
    public $hasEndTag           = true;
    public $options             = array(
        'attr'          => array('type'     => 'text'),
        'round'         => array('type'     => 'size',  'default'   => '0'),
        'border-color'  => array('type'     => 'color', 'default'   => ''),
        'border-width'  => array('type'     => 'multisize',  'default'   => ''),
        'reveal'        => array('type'     => 'boolean', 'default' => 'false'),
        'reveal-text'   => array('type'     => 'text',  'default'   => 'Reveal'),
        'url'           => array('type'     => 'url',       'default'   => ''),
        'color'         => array('type'    => 'color',    'default' => ''),
        'padding'       => array('type'     => 'multisize',  'default'   => ''),
        'margin'       => array('type'     => 'multisize',  'default'   => ''),
        'grid-row'          => array('type' => 'text',    'default' => ''),
        'grid-row-start'    => array('type' => 'number',    'default' => ''),
        'grid-row-end'      => array('type' => 'number',    'default' => ''),
        'grid-row-span'     => array('type' => 'number',    'default' => ''),
        'grid-col'          => array('type' => 'text',    'default' => ''),
        'grid-col-start'    => array('type' => 'number',    'default' => ''),
        'grid-col-end'      => array('type' => 'number',    'default' => ''),
        'grid-col-span'     => array('type' => 'number',    'default' => ''),
    );

    public function __construct() {
        $this->addCommonOptions('width height type shadow text-align links-match vertical-align');
    }
    
    public function getPType() { return 'normal'; }

    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        if(!empty($data['attr'])) {
            $data = array_merge($data, $this->callMikioTag('setattr', $data['attr']));
        }

        $tag = 'div';
        if(!empty($data['url'])) $tag = 'a';

        if(!empty($data['grid-row-span'])) $data['grid-row-end'] = 'span ' . $data['grid-row-span'];
        if(!empty($data['grid-col-span'])) $data['grid-col-end'] = 'span ' . $data['grid-col-span'];

        if(!empty($data['grid-row'])) {
            $parts = explode(' ', $data['grid-row']);
            $i = count($parts);
            if($i == 2 || $i == 3) {
                $data['grid-row-start'] = filter_var($parts[0], FILTER_VALIDATE_INT);
            }

            if($i == 2) {
                $data['grid-row-end'] = filter_var($parts[1], FILTER_VALIDATE_INT);
            } else {
                $data['grid-row-end'] = strtolower($parts[1]) . ' ' . filter_var($parts[2], FILTER_VALIDATE_INT);
            }
        }

        if(!empty($data['grid-col'])) {
            $parts = explode(' ', $data['grid-col']);
            $i = count($parts);
            if($i == 2 || $i == 3) {
                $data['grid-col-start'] = filter_var($parts[0], FILTER_VALIDATE_INT);
            }

            if($i == 2) {
                $data['grid-col-end'] = filter_var($parts[1], FILTER_VALIDATE_INT);
            } else {
                $data['grid-col-end'] = strtolower($parts[1]) . ' ' . filter_var($parts[2], FILTER_VALIDATE_INT);
            }
        }

        $classes = $this->buildClass($data);
        $styles = $this->buildStyle(array(
            'width'         => $data['width'] ?? '',
            'height'        => $data['height'] ?? '',
            'border-radius' => $data['round'] ?? '',
            'border-color'  => $data['border-color'] ?? '',
            'border-width'  => $data['border-width'] ?? '',
            'color'         => $data['color'] ?? '',
            'padding'       => $data['padding'] ?? '',
            'margin'        => $data['margin'] ?? '',
            'grid-row-start'    => $data['grid-row-start'] ?? '',
            'grid-row-end'      => $data['grid-row-end'] ?? '',
            'grid-column-start'    => $data['grid-col-start'] ?? '',
            'grid-column-end'      => $data['grid-col-end'] ?? '',
            
        ), TRUE);

        $renderer->doc .= '<' . $tag . ($data['url'] != '' ? ' href="' . $data['url'] . '"' : '') . ' class="' . $this->elemClass . ' ' . $this->classPrefix . 'box'. $classes .'"' . $styles. '>';
        if($data['reveal']) $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'reveal">' . $data['reveal-text'] . '</div>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $tag = 'div';
        if(!empty($data['url'])) $tag = 'a';

        $renderer->doc .= '</' . $tag . '>'; 
    }
}
?>