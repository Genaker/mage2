<?php
/**
 * Setup Class - Composer script handler
 * 
 * Handles post-install and post-update composer scripts for the Mage package.
 * Copies necessary files and sets up the development environment.
 * 
 * @category   Mage
 * @package    Mage_Core
 * @author     Mage Development Team
 * @copyright  Copyright © All rights reserved.
 * @license    GPL-3.0
 * @since      1.0.0
 */

namespace Mage\Core;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;

/**
 * Setup Class
 * 
 * Composer script handler for package installation and updates.
 * Copies PsySH shell and configuration files to the project root.
 * 
 * @package Mage\Core
 * @since   1.0.0
 */
class Setup
{
    
    /**
     * Setup script execution
     * 
     * Copies PsySH shell binary and configuration file to the project root
     * for easy access to the interactive development shell.
     * 
     * @param Event $event Composer event object
     * 
     * @return void
     * 
     * @throws \Exception If file operations fail
     */
    public static function setup(Event $event)
    {
        echo "Setup Script->\n";
        echo shell_exec("pwd");
        echo shell_exec("cp vendor/mage/mage/.psysh.php .");
        echo shell_exec("cp vendor/bin/psysh ./bin/");
    }

}