<?php
/**
 * WURFL API
 *
 * LICENSE
 *
 * This file is released under the GNU General Public License. Refer to the
 * COPYING file distributed with this package.
 *
 * Copyright (c) 2008-2009, WURFL-Pro S.r.l., Rome, Italy
 *
 *
 *
 * @category   WURFL
 * @package    WURFL_Request_UserAgentNormalizer_Generic
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @author     Fantayeneh Asres Gizaw
 * @version    $id$
 */
class WURFL_Request_UserAgentNormalizer_Generic_LocaleRemover implements WURFL_Request_UserAgentNormalizer_Interface  {

	/**
	 * Removes the locale string from the user-agent
	 *
	 * @param string $userAgent
	 * @return string
	 */
	public function normalize($userAgent) {
        return WURFL_Handlers_Utils::removeLocale($userAgent);
	}

}


