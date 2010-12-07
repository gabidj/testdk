<?php
/**
* DotBoost Technologies Inc.
* DotKernel Application Framework
*
* @category   DotKernel
* @package    Admin 
* @copyright  Copyright (c) 2009-2010 DotBoost Technologies Inc. Canada (http://www.dotboost.com)
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
* @version    $Id$
*/

/**
* System View Class
* class that prepare output related to User controller 
* @category   DotKernel
* @package    Admin 
* @author     DotKernel Team <team@dotkernel.com>
*/

class System_View extends View
{
	/**
	 * Constructor
	 * @access public
	 * @param Dot_Template $tpl
	 */
	public function __construct($tpl)
	{
		$this->tpl = $tpl;
	}
	/**
	 * Display dashboard
	 * @access public
	 * @param string $templateFile
	 * @param string $mysqlVersion
	 * @param array $geoIpVersion
	 * @return void
	 */
	public function dashboard($templateFile, $mysqlVersion, $geoIpVersion)
	{
		$this->tpl->setFile('tpl_main', 'system/' . $templateFile . '.tpl');
		// system overview
		$this->tpl->setVar('HOSTNAME' , System::getHostname());
		$this->tpl->setVar('MYSQL',$mysqlVersion);
		$this->tpl->setVar('PHP',phpversion());
		$this->tpl->setVar('PHPAPI',php_sapi_name());
		$this->tpl->setVar('ZFVERSION', Zend_Version::VERSION);
		
		// GeoIP section
		$this->tpl->setVar('GEOIP_COUNTRY_LOCAL', $geoIpVersion['local']);
		
		$this->tpl->setBlock('tpl_main', 'is_geoip', 'is_geoip_row');
		if(function_exists('geoip_database_info'))
		{
			$this->tpl->setVar('GEOIP_CITY_VERSION', $geoIpVersion['city']);
			$this->tpl->setVar('GEOIP_COUNTRY_VERSION', $geoIpVersion['country']);
			$this->tpl->parse('is_geoip_row', 'is_geoip', true);
		}
	  
			
	}
	/**
	 * Display settings
	 * @access public
	 * @param string $templateFile
	 * @param array $data
	 * @return void
	 */
	public function displaySettings($templateFile, $data)
	{
		$this->tpl->setFile('tpl_main', 'system/' . $templateFile . '.tpl');
		$this->tpl->setBlock('tpl_main', 'textarea', 'textarea_row');
		$this->tpl->setBlock('tpl_main', 'options', 'options_row');
		$this->tpl->setBlock('tpl_main', 'option', 'option_row');
		$this->tpl->setBlock('tpl_main', 'radios', 'radios_row');
		$this->tpl->setBlock('tpl_main', 'radio', 'radio_row');
		foreach ($data as $v)
		{			
			$this->tpl->setVar('NAME', $v['title']);
			$this->tpl->setVar('VARIABLE', $v['key']);
			$this->tpl->setVar('DEFAULT', $v['possibleValues']);
			$this->tpl->setVar('EXPLANATION', $v['comment']);
			switch ($v['type']) 
			{
				case 'textarea':	
					$this->tpl->setVar('CURRENT_VALUE', $v['value']);
					$this->tpl->parse('textarea_row', 'textarea', true);
				break;
				case 'option':
					$this->tpl->parse('options_row', '');
					$options = explode(';', $v['possibleValues']);
					foreach ($options as $opt)
					{
						$this->tpl->setVar('LIST_OPTION', $opt);
						$optionSelect = ($v['value'] == $opt) ? 'selected' : '';
						$this->tpl->setVar('SELECTED_OPTION', $optionSelect);
						$this->tpl->parse('options_row', 'options', true);
					}
					$this->tpl->parse('option_row', 'option', true);
				break;
				case 'radio':
					$this->tpl->parse('radios_row', '');
					$radios = explode(';', $v['possibleValues']);
					foreach ($radios as $val)
					{
						$this->tpl->setVar('POSIBLE_VALUE', $val);
						$radioTxt = ($val == 1) ? 'Yes' : 'No';
						$this->tpl->setVar('POSIBLE_VALUE_TXT', $radioTxt);
						$radioCheck = ($v['value'] == $val) ? 'checked' : '';
						$this->tpl->setVar('CHECKED_OPTION', $radioCheck);
						$this->tpl->parse('radios_row', 'radios', true);
					}
					$this->tpl->parse('radio_row', 'radio', true);
				break;
			}
		}
	}
	/**
	 * Display phpinfo values
	 * @access public
	 * @param string $templateFile
	 * @return void
	 */
	public function showPHPInfo($templateFile)
	{
		$this->tpl->setFile('tpl_main', 'system/' . $templateFile . '.tpl');
		ob_start();
		phpinfo();
		$parsed = ob_get_contents();
		ob_end_clean();
		preg_match( "#<body>(.*)</body>#is" , $parsed, $match1 );
		
		$phpBody  = $match1[1];
		// PREVENT WRAP: Most cookies	
		$phpBody  = str_replace( "; " , ";<br />"   , $phpBody );
		// PREVENT WRAP: Very long string cookies
		$phpBody  = str_replace( "%3B", "<br />"    , $phpBody );
		// PREVENT WRAP: Serialized array string cookies
		$phpBody  = str_replace( ";i:", ";<br />i:" , $phpBody );
		$phpBody  = str_replace( ":", ";<br>" , $phpBody );
		$phpBody = preg_replace('#<table#', '<table class="big_table" align="center"', $phpBody);
		$phpBody = preg_replace('#<th#', '<th  class="bgmain"', $phpBody);
		$phpBody = preg_replace('#(\w),(\w)#', '\1, \2', $phpBody);
		$phpBody = preg_replace('#border="0" cellpadding="3" width="600"#', 'border="0" cellspacing="1" cellpadding="1" width="100%"', 		$phpBody);
		$phpBody = preg_replace('#<hr />#', '', $phpBody);
		$this->tpl->setVar("PHPINFO", $phpBody);
	}
	/**
	 * List the email transporter
	 * @param string $templateFile
	 * @param array $list
	 * @param int $page
	 * @param bool $ajax [optional] - Using ajax, parse only the list content
	 * @return void
	 */
	public function listEmailTransporter($templateFile, $list, $page, $ajax=false)
	{
		$this->tpl->setFile('tpl_main', 'system/' . $templateFile . '.tpl');
		$this->tpl->setBlock('tpl_main', 'list', 'list_block');
		$this->tpl->paginator($list['pages']);
		$this->tpl->setVar('PAGE', $page);
		$this->tpl->setVar('ACTIVE_URL', '/admin/system/transporter-activate');
		$this->tpl->setVar('ACTIVE_1', 'checked');
		$this->tpl->setVar('SSL_TLS', 'checked');
		$this->tpl->displayMessage($ajax);
		
		foreach ($list["data"] as $k => $v)
		{
			$this->tpl->setVar('BG', $k%2+1);
			$this->tpl->setVar('ID', $v["id"]);
			$this->tpl->setVar('USER', $v['user']);
			$this->tpl->setVar('SERVER', $v['server']);
			$this->tpl->setVar('PORT', $v['port']);
			$this->tpl->setVar('SSL', $v['ssl']);
			$this->tpl->setVar('CAPACITY', $v['capacity']);
			$this->tpl->setVar('COUNTER', $v['counter']);
			$this->tpl->setVar('DATE_CREATED', Dot_Kernel::timeFormat($v['date']));
			$this->tpl->setVar('ACTIVE_IMG', $v['isActive'] == 1 ? 'active' : 'inactive');
			$this->tpl->setVar('ISACTIVE', $v['isActive']*(-1)+1);
			$this->tpl->parse('list_block', 'list', true);
		}
		// if we are showing the form after an error, fill the form with the previous values
		if (isset($list['form']))
		{
			$this->tpl->setVar('USER', $list['form']['user']);
			$this->tpl->setVar('PASS', $list['form']['pass']);
			$this->tpl->setVar('SERVER', $list['form']['server']);
			$this->tpl->setVar('PORT', $list['form']['port']);
			$this->tpl->setVar('CAPACITY', $list['form']['capacity']);
			
			$this->tpl->setVar('SSL_SSL', $list['form']['ssl']=='ssl'?'checked':'');
			$this->tpl->setVar('SSL_TLS', $list['form']['ssl']=='tls'?'checked':'');
			
			$this->tpl->setVar('ACTIVE_YES', $list['form']['isActive']==1?'checked':'');
			$this->tpl->setVar('ACTIVE_NO', $list['form']['isActive']==0?'checked':'');
		}else{
			$this->tpl->setVar('USER', '');
			$this->tpl->setVar('PASS', '');
			$this->tpl->setVar('SERVER', '');
			$this->tpl->setVar('PORT', '');
			$this->tpl->setVar('CAPACITY', '');
			
			$this->tpl->setVar('SSL_SSL', '');
			$this->tpl->setVar('SSL_TLS', 'checked');
			
			$this->tpl->setVar('ACTIVE_YES', 'checked');
			$this->tpl->setVar('ACTIVE_NO', '');
		}
		
		if($ajax)
		{
			$this->tpl->pparse('AJAX', 'tpl_main');
			exit;
		}
	}
	/**
	 * Display email transporter details. It is used for update actions
	 * @param object $templateFile
	 * @param object $data [optional]
	 * @return void
	 */
	public function details($templateFile, $data=array())
	{
		$this->tpl->setFile('tpl_main', 'system/' . $templateFile . '.tpl');
		$this->tpl->setVar('ACTIVE_1', 'checked');
		$this->tpl->setVar('SSL_TLS', 'checked'); $this->tpl->setVar('SSL_SSL', '');
		foreach ($data as $k=>$v)
		{
			$this->tpl->setVar(strtoupper($k), $v);
			if('isActive' == $k)
			{
				$this->tpl->setVar('ACTIVE_'.$v, 'checked');
				$this->tpl->setVar('ACTIVE_'.$v*(-1)+1, '');
			}
			if('ssl' == $k)
			{
				if ($v == 'ssl')
				{
					$this->tpl->setVar('SSL_SSL', 'checked');
					$this->tpl->setVar('SSL_TLS', '');
				}
			else{
					$this->tpl->setVar('SSL_TLS', 'checked');
					$this->tpl->setVar('SSL_SSL', '');
				}
			}
		}
	}
}
