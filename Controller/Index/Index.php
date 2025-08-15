<?php
/**
 * Index Controller - Main frontend controller for Mage module
 * 
 * Handles the main frontend route for the Mage module, providing
 * the entry point for module demonstration and testing.
 * 
 * @category   Mage
 * @package    Mage_Controller
 * @author     Mage Development Team
 * @copyright  Copyright © All rights reserved.
 * @license    GPL-3.0
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Mage\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Index Controller Class
 * 
 * Main controller for handling frontend requests to the Mage module.
 * Implements HttpGetActionInterface for proper HTTP GET handling.
 * 
 * @package Mage\Controller\Index
 * @since   1.0.0
 */
class Index implements HttpGetActionInterface
{

    /**
     * Page factory for creating result pages
     * 
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param PageFactory $resultPageFactory
     */
    public function __construct(PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute view action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}

