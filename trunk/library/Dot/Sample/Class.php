<?php
/**
 * DotKernel (1.7) Coding Standard Sample File
 *
 * NOTES:
 * File level and class level docblock required
 * Indent = 1 tab (required)
 * Closing PHP Tag Prohibited
 * 80 characters per line recommended, at most 120 characters
 * Short tags not allowed
 * FILENAME: Dot/Sample/Class.php
 *
 * http://www.dotkernel.com/dotkernel/dotkernel-coding-standard/
 *
 * @category   DotKernel
 * @package    DotLibrary
 * @copyright  Copyright (c) 2009-2013 DotBoost Technologies Inc. (http://www.dotboost.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version    $Id: $
 */

/**
 * Description of Class
 *
 * @category   DotKernel
 * @package    DotLibrary
 * @subpackage DotSample
 * @author     DotKernel Team <team@dotkernel.com>
 */

class Dot_Sample_Class  extends Dot_Other_Class
{
	/**
	* Constants use an underscore to separate words
	*/
	const CONSTANT_NAME = 'Must be all uppercase';

	/**
	 * Description of property
	 *
	 * @var type
	 */
	public $sampleClassProperty;

	/**
	* Function name should be verbose and descriptive and  must be written in camelCase
	* Private and Protected function names must begin with an underscore
	* Class methods must always declare visibility
	* Methods must have a docblock with the function description,
	* all of the arguments, and all possible return values
	* @param type $arg1
	* @param type $arg2
	* @return type
	*/
	public function thisIsADescriptiveFunctionName($arg1, $arg2)
	{
		//variable names should be verbose and descriptive
		$variableName = 'Must be in camelCase';
		return $variableName;
	}

	/**
	 * Description of method
	 *
	 */
	protected function _thisMethodBeginsWithUnderscore()
	{
		$string = 'Use single quotes unless substituting variables';

		//Control structure
		if ($string == true)
		{
			echo 'String is set';
		}
		else
		{
			echo 'String is not set';
		}
	}
}