# Smart Data Export Import
A Laravel Package for exporting data graphically.
 
## Install
Add Path in project's composer.json file after the script block.
```bash
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/SmartWebSource/smart-data-import-export.git"
    }
],
```

Install via composer
```bash
composer require smartwebsource/smart-data-export-import
```

Add Service Provider to `config/app.php` in `providers` section
```php
SmartWebSource\SmartDataExportImport\PackageServiceProvider::class,
```

Publish `smart-data-export-import.php` configuration file into `/config/` for configuration customization:

```bash
php artisan vendor:publish \
  --provider="SmartWebSource\SmartDataExportImport\PackageServiceProvider"
``` 

Go to `http://app-url/smart-data-export-import` or some other route
