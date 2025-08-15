<?php
/**
 * Index Block - Main template block for Mage module
 * 
 * Provides the main block functionality for rendering the Mage module's
 * frontend interface.
 * 
 * @category   Mage
 * @package    Mage_Block
 * @author     Mage Development Team
 * @copyright  Copyright © All rights reserved.
 * @license    GPL-3.0
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Mage\Block\Index;

/**
 * Index Block Class
 * 
 * Main block class for the Mage module's frontend display.
 * Extends Magento's base template block functionality.
 * 
 * @package Mage\Block\Index
 * @since   1.0.0
 */
class Index extends \Magento\Framework\View\Element\Template
{

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context Template context
     * @param array $data Additional data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
}

