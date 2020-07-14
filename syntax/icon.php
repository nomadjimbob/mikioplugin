<?php
/**
 * Mikio Syntax Plugin: Icon
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_icon extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'icon';
    public $hasEndTag           = false;
    
    // not declaring $options will return all options in the $data variable in lexer functions
    
    public function render_lexer_special(Doku_Renderer $renderer, $data) {
        global $MIKIO_ICONS;

        if(is_array($MIKIO_ICONS) && count($MIKIO_ICONS) > 0) {
            foreach($MIKIO_ICONS as $icon) {
                if(isset($icon['name']) && strcasecmp($icon['name'], $this->getFirstArrayKey($data)) == 0) {
                    if(isset($icon['insert'])) {
                        $insert = $icon['insert'];
                        $keys = array_keys($data);
                        $keys = array_pad($keys, 10, '');

                        for($i = 1; $i < 10; $i++) {
                            $insert = str_replace('$' . $i, $keys[$i], $insert);
                        }

                        $renderer->doc .= $insert;
                    }
                }

                break;
            }
        }
    }
}
?>