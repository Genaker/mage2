<?php
/**
 * Debug Dump Trait - Variable dumping functionality
 * 
 * Provides simple variable dumping capabilities using Symfony VarDumper.
 * 
 * @category   Mage
 * @package    Mage_Debug
 * @author     Mage Development Team
 * @copyright  Copyright © All rights reserved.
 * @license    GPL-3.0
 * @since      1.0.0
 */

namespace Mage\Debug;

/**
 * Dump Trait
 * 
 * Simple wrapper around Symfony VarDumper functions for
 * convenient variable debugging.
 * 
 * @package Mage\Debug
 * @since   1.0.0
 */
trait Dump
{
    /**
     * Dump and die using Symfony VarDumper
     * 
     * Outputs the variable content and terminates script execution.
     * 
     * @param mixed $var Variable to dump
     * 
     * @return void This method terminates execution
     * 
     * @example
     * ```php
     * Mage::dd($user); // Dumps user object and stops execution
     * ```
     */
    static function dd($var)
    {
        dd($var);
    }

    /**
     * Dump variable using Symfony VarDumper
     * 
     * Outputs the variable content without stopping execution.
     * 
     * @param mixed $var Variable to dump
     * 
     * @return void
     * 
     * @example
     * ```php
     * Mage::dump($array); // Dumps array content
     * // Script continues execution...
     * ```
     */
    public static function dump($var)
    {
        dump($var);
    }
}