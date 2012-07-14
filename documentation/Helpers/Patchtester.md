## Patchtester

Patchtester is a Joomla! CMS component for testing patches (aka pull requests) made to the Joomla! CMS repository hosted on [Github](https://github.com/joomla/joomla-cms).

### Usage

To install the patchtester component you may use the symlinker script:

* Copy or symlink the file ```~/repos/elkuku-lilhelpers/symlinker/symlinker.php``` to the webroot of your Joomla! CMS installation.
* Copy the file ```~/repos/patchtester/patchtester.symlinks``` to the webroot of your Joomla! CMS installation and rename it to ```symlinks```. In case the file already exists, just merge the contents.
* Adjust the paths. Modify the variable ```basePath=``` to ```basePath=/home/jtester/repos/patchtester```
* Open the file ```symlinker.php``` in your browser and click the links to create the symlinks.
* Head on to your Joomla! Backend and install the extension using the "Discover" feature of the Joomla! core instaler.

Happy testing.
