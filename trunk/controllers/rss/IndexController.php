<?php
/**
* DotBoost Technologies Inc.
* DotKernel Application Framework
*
* @category   DotKernel
* @package    Rss
* @copyright  Copyright (c) 2009-2010 DotBoost Technologies Inc. Canada (http://www.dotboost.com)
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
* @version    $Id$
*/

/**
* Rss Module - Index Controller
* Is doing all the job for specific rss control stuff 
* @author     DotKernel Team <team@dotkernel.com>
*/   

// set Module default value
$defaultController = $resource->route->controller->$requestModule;
$requestController = isset($requestController) && $requestController !='Index' ? $requestController : $defaultController;

/**
 * start the template object,
 * NOTE: the output of this module is XML not HTML
 * This View class does not inherit from Dpt_Template class
 */   
require(DOTKERNEL_PATH . '/' . $requestModule . '/' . 'View.php');
$view = new View();
/** 
 * each Controller  must load its own specific models and views
 */
Dot_Settings :: loadControllerFiles($requestModule);

$option = Dot_Settings::getOptionVariables($requestModule,$requestController);
$registry->option = $option;
/**
 * From this point , the control is taken by the Action specific controller
 * call the Action specific file, but check first if exists 
 */
$actionControllerPath = CONTROLLERS_PATH . '/' . $requestModule . '/' . $requestController . 'Controller.php';
!file_exists($actionControllerPath) ?  $dotKernel->pageNotFound() :  require($actionControllerPath);
//output the rss content
$view->output();
