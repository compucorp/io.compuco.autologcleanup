<?php

/**
 * Autologcleanup.Cleanup API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_autologcleanup_Cleanup_spec(&$spec) {
  $spec['maxAge']['api.required'] = 1;
  $spec['ignoreTables']['api.required'] = 0;
}

/**
 * Autologcleanup.Cleanup API
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @see civicrm_api3_create_success
 *
 * @throws API_Exception
 */
function civicrm_api3_autologcleanup_Cleanup($params) {
  $ignoreTables = empty($params['ignoreTables']) ? [] : explode(',', $params['ignoreTables']);
  $logCleanup = new CRM_Autologcleanup_Job_LogCleanup($params['maxAge'], $ignoreTables);
  return civicrm_api3_create_success($logCleanup->run(), $params, 'Autologcleanup', 'Cleanup');

}
