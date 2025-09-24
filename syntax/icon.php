<?php
/**
 * Mikio Syntax Plugin: Icon
 *
 * @link    http://github.com/nomadjimbob/mikioplugin
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author  James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) { die();
}
if (!defined('DOKU_PLUGIN')) { define('DOKU_PLUGIN', DOKU_INC.'lib/plugins/');
}

require_once __DIR__ .'/core.php';

class syntax_plugin_mikioplugin_icon extends syntax_plugin_mikioplugin_core
{
    public $tag                 = 'icon';
    public $hasEndTag           = false;
    
    // not declaring $options will return all options in the $data variable in lexer functions
    public function getType()
    {
        return 'substition'; 
    }
    public function getPType()
    {
        return 'normal'; 
    }

    public function render_lexer_special(Doku_Renderer $renderer, $data)
    {
        global $MIKIO_ICONS;

        if(is_array($MIKIO_ICONS) && count($MIKIO_ICONS) > 0) {
            foreach($MIKIO_ICONS as $icon) {
                if(isset($icon['name']) && strcasecmp($icon['name'], array_key_first($data)) == 0) {
                    if(isset($icon['insert'])) {
                        $insert = $icon['insert'];
                        $keys = array_keys($data);
                        $keys = array_pad($keys, 10, '');

                        for($i = 1; $i < 10; $i++) {
                            $dollarIndex = '$' . $i;
                            if (empty($keys[$i]) === false) {
                                $insert = str_replace($dollarIndex, $keys[$i], $insert);
                            } else if(empty($icon[$dollarIndex]) === false) {
                                $insert = str_replace($dollarIndex, $icon[$dollarIndex], $insert);
                            }
                        }

                        $dir = '';
                        if (isset($icon['dir']) === true) {
                            $dir = DOKU_BASE . 'lib/plugins/' . basename(dirname(__DIR__)) . '/icons/' . $icon['dir'] . '/';
                        }

                        $insert = str_replace('$0', $dir, $insert);
                        $renderer->doc .= $insert;
                    }

                    break;
                }
            }
        }
    }
}
?>