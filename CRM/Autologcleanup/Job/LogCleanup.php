<?php

class CRM_Autologcleanup_Job_LogCleanup {

  /**
   * @var string
   */
  private $maxAge;

  /**
   * Constructs a new LogCleanup object.
   *
   * @param string $maxAge
   *  Maximum log age.
   */
  public function __construct(string $maxAge) {
    $this->maxAge = $maxAge;
  }

  /**
   * Starts the scheduled job for clearing up
   * stale log records.
   *
   * @return True
   *
   * @throws \CRM_Core_Exception
   */
  public function run() {
    $this->pruneLogTables();

    return TRUE;
  }

  /**
   * Tranforms the log age to date ago.
   *
   * @param string $age
   *  The age of the log to be cleared.
   *
   * @throws \CRM_Core_Exception;
   */
  private function transformLogAge(string $age) {
    $timestamp = strtotime("today - $age");
    if (!$timestamp) {
      throw new \CRM_Core_Exception("${age} is an invalid log max age");
    }

    return date('Y-m-d', $timestamp);
  }

  /**
   * Prunes stale records from log tables.
   *
   * Records that have stayed loger than the max age
   * are considered stale.
   */
  private function pruneLogTables() {
    $ageAgo = $this->transformLogAge($this->maxAge);
    $logTables = $this->getLogTables();

    foreach ($logTables as $logTable) {
      $query = "DELETE FROM {$logTable} WHERE log_date < '{$ageAgo}'";
      CRM_Core_DAO::executeQuery($query);
    }
  }

  /**
   * Gets all the log tables
   *
   * @return array
   *   Returns an array of log tables
   */
  private function getLogTables() {
    $logTables = [];
    $loggingSchema = new \CRM_Logging_Schema();
    $nonStandardTableNameString = $loggingSchema->getNonStandardTableNameFilterString();

    $this->db = $this->getDBDSN()['database'];

    $dao = CRM_Core_DAO::executeQuery("
      SELECT TABLE_NAME
      FROM   INFORMATION_SCHEMA.TABLES
      WHERE  TABLE_SCHEMA = '{$this->db}'
      AND    TABLE_TYPE = 'BASE TABLE'
      AND    (TABLE_NAME LIKE 'log_civicrm_%' $nonStandardTableNameString )
    ");

    while ($dao->fetch()) {
      $logTables[] = $dao->TABLE_NAME;
    }

    return $logTables;
  }

  /**
   * Gets the appropraite log DB data source.
   *
   * @return array
   *   List of the log db data source information.
   */
  private function getDBDSN() {
    $logDSN = defined('CIVICRM_LOGGING_DSN') ? CIVICRM_LOGGING_DSN : CIVICRM_DSN;
    $dsn = CRM_Utils_SQL::autoSwitchDSN($logDSN);
    $dsn = DB::parseDSN($dsn);

    return $dsn;
  }

}
