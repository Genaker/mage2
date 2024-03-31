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
        echo "Setup Sript->\n";
        echo shell_exec("pwd");
        echo shell_exec("cp -n vendor/mage/mage/.psysh.php .");
        echo shell_exec("cp -n vendor/bin/psysh ./bin/");
    }

}