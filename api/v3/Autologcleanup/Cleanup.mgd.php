<?php
// This file declares a managed database record of type "Job".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
return [
  [
    'name' => 'Cron:Autologcleanup.Cleanup',
    'entity' => 'Job',
    'params' => [
      'version' => 3,
      'name' => 'Call Autologcleanup.Cleanup API',
      'description' => 'Clear records from the log tables',
      'run_frequency' => 'Daily',
      'api_entity' => 'Autologcleanup',
      'api_action' => 'Cleanup',
      'parameters' => "maxAge=2 years \nignoreTables=",
      'is_active' => 0,
    ],
  ],
];
