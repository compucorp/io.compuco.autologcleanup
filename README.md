# io.compuco.autologcleanup

This extension automates clean up of CiviCRM log tables i.e. the tables that start with `log_civicrm`.

## Usage
This extension adds a job API called `autologcleanup.Cleanup` that is scheduled to run daily. When it runs it clears old records from the CiviCRM log tables.
![Image](https://user-images.githubusercontent.com/85277674/200783685-05d0e055-dab0-4b3d-8349-74a34373b556.png)
The API takes two parameters
- `maxAge`: Using this parameter, you can define the maximum age for log records, for example, `maxAge=6 months`, its default value is `2 years`.
- `ignoreTables`: By specifying this parameter, you can specify which log tables should not be cleared when the job runs. E.g. `ignoreTables=log_civicrm_acl,log_civicrm_user`. By default, no CiviCRM log table is ignored.

## Requirements

* PHP v7.4+
* CiviCRM (5.39.1)

## Installation (Web UI)

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl io.compuco.autologcleanup@https://github.com/compucorp/io.compuco.autologcleanup/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/compucorp/io.compuco.autologcleanup.git
cv en autologcleanup
```
