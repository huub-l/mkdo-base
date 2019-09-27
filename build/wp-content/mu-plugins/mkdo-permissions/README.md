# MKDO Permissions

This plugin should be added into non mkdo-core sites or legacy sites. Its purpose is to dynamically set the value of `DISALLOW_FILE_MODS` based on the users email address and/or username.

A customizer field exists to allow users to enter comma separated email address'. Those email address' will then set `DISALLOW_FILE_MODS` to false. All `@makedo.net` email address' or usernames with values such as `mkdo`, `makedo` etc will be auto set to false. The customizer field will only be accessable to users with `makedo` in their email address. This was to work around the fact that only multi site installs have Super Admins.

On local installs (.test domains), all users by default will be allowed to edit.

**IMPORTANT**: The sites `wp-config.php` musn't have `DISALLOW_FILE_MODS` defined. If for any reason this does exist in `wp-config.php` please comment it out or remove it. (_May need assistance from WPE in some instances_)
