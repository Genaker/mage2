<?php
namespace Mage\Mage\Core;


class Setup
{
    
    public static function setup()
    {
        echo "Setup Sript->\n";
        echo shell_exec("pwd");
        echo shell_exec("cp vendor/mage/mage/.psysh.php .");
        echo shell_exec("cp vendor/bin/psysh ./bin/");
    }

}