# smart-data-import-export
Smart Data Import Export package for Laravel

## Install
Install via composer
```bash
composer require smartwebsource/smart-data-export-import
```

Add Service Provider to `config/app.php` in `providers` section
```php
SmartWebSource\SmartDataExportImport\Providers\PackageServiceProvider::class",
```

Publish `smart-data-export-import.php` configuration file into `/config/` for configuration customization:

```bash
php artisan vendor:publish \
  --provider="SmartWebSource\SmartDataExportImport\Providers\PackageServiceProvider"
``` 

```bash
composer require smartwebsource/smart-data-export-import
```

Go to `http://app-url/smart-data-export-import` or some other route
