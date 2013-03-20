<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 - Dirk Wildt <http://wildt.at.die-netzmacher.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
* Class provides methods for the extension manager.
*
* @author    Dirk Wildt <http://wildt.at.die-netzmacher.de>
* @package    TYPO3
* @subpackage    org
* @version 0.4.4
* @since 0.4.2
*/


  /**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   49: class tx_org_extmanager
 *   67:     function promptQuickstart()
 *
 * TOTAL FUNCTIONS: 2
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */
class tx_orgesab_extmanager
{



/**
 * promptQuickstart(): Displays the quick start message.
 *
 * @return  string    message wrapped in HTML
 * @access  public 
 * @since 0.4.2
 * @version 0.4.4
 */
  public function promptQuickstart()
  {
//.message-notice
//.message-information
//.message-ok
//.message-warning
//.message-error

    $str_prompt = null;

    $confArrRpt = $this->zz_getExtConfiguration( );
    $confArrOrg = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['org']);
    
    if($confArrRpt['store_records'] != $confArrOrg['store_records'])
    {
      $str_phrase = $GLOBALS['LANG']->sL('LLL:EXT:orgesab/lib/locallang.xml:promptStoreRecordWarn');
      $str_phrase = str_replace('###RPT_STORERECORD###', $confArrRpt['store_records'], $str_phrase);
      $str_phrase = str_replace('###ORG_STORERECORD###', $confArrOrg['store_records'], $str_phrase);
      
      $str_prompt = $str_prompt.'
<div class="typo3-message message-information">
  <div class="message-body">
    ' . $str_phrase . '
  </div>
</div>
';
    }
    if($confArrRpt['store_records'] == $confArrOrg['store_records'])
    {
      $str_phrase = $GLOBALS['LANG']->sL('LLL:EXT:orgesab/lib/locallang.xml:promptStoreRecordOk');
      $str_phrase = str_replace('###RPT_STORERECORD###', $confArrRpt['store_records'], $str_phrase);
      
      $str_prompt = $str_prompt.'
<div class="typo3-message message-ok">
  <div class="message-body">
    ' . $str_phrase . '
  </div>
</div>
';
    }
    
    $str_prompt = $str_prompt.'
<div class="typo3-message message-information">
  <div class="message-body">
    ' . $GLOBALS['LANG']->sL('LLL:EXT:orgesab/lib/locallang.xml:promptGeneralInfo'). '
  </div>
</div>
';

    $str_prompt = $str_prompt . var_export( $_POST['data'], true );

    return $str_prompt;
  }

/**
 * zz_getExtConfiguration( ): Displays the quick start message.
 *
 * @return  string    message wrapped in HTML
 * @access  public 
 * @since 0.4.2
 * @version 0.4.4
 */
  public function zz_getExtConfiguration()
  {
//.message-notice
//.message-information
//.message-ok
//.message-warning
//.message-error

    switch( true )
    {
      case( ! empty( $_POST ) ):
        $extConfiguration = $_POST;
        break;
      case( empty( $_POST ) ):
      default:
        $extConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['orgesab']);
        break;
    }
    
    return $extConfiguration;
  }









}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/orgesab/lib/class.tx_orgesab_extmanager.php'])
{
  include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/orgesab/lib/class.tx_orgesab_extmanager.php']);
}

?>
