## 1.0.2 @17.Oct.2016

- Fixed path for enqueuing `/assets/js/responsive-menu.js`

## 1.0.1

Changed autoload.php to move Customizer loading into the nonadmin files.  Why?  The customizer action occurs before `admin_init`.  It wants to be loaded at the start independent of the admin area.

## 1.0.0

Initial release.