<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
vimport('~~/modules/SMSNotifier/SMSNotifier.php');

class SMSNotifier_Record_Model extends Vtiger_Record_Model {

	public static function SendSMS($message, $toNumbers, $currentUserId, $recordIds, $moduleName) {
		SMSNotifier::sendsms($message, $toNumbers, $currentUserId, $recordIds, $moduleName);
	}

	public function checkStatus() {
		$statusDetails = SMSNotifier::getSMSStatusInfo($this->get('id'));
		foreach ($statusDetails as $statkey => $status_array) {
			$status_array['statuscolor'] = $this->getColorForStatus($status_array['status']);
			$messagedetails [$statkey] = $status_array;
			$this->set('messagedetails', $messagedetails);
		}
		return $this;
	}

	public function getCheckStatusUrl() {
		return "index.php?module=".$this->getModuleName()."&view=Detail&mode=showRecentActivities&record=".$this->getId();
	}

	public function getColorForStatus($smsStatus) {
		if ($smsStatus == 'Processing') {
			$statusColor = '#FFFCDF';
		} 
		elseif ($smsStatus == 'Delivered') {
			$statusColor = '#E8FFCF';
		} 
		elseif ($smsStatus == 'Failed') {
			$statusColor = '#FFE2AF';
		} 
		else {
			$statusColor = '#FFFFFF';
		}
		return $statusColor;
	}
}