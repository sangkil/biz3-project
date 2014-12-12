<?php

use Composer\Util\Filesystem;

/**
 * Configure
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 3.0
 */
class Configure
{

    public static function apply($event)
    {
        $package = $event->getComposer()->getPackage();
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        static::addPackage($package, $vendorDir);
        // do stuff
    }

    protected static function addPackage($package, $vendorDir)
    {
        $extension = [
            'name' => $package->getName(),
            'version' => $package->getVersion(),
        ];

        $alias = static::generateDefaultAlias($package, $vendorDir);
        if (!empty($alias)) {
            $extension['alias'] = $alias;
        }
        $extra = $package->getExtra();
        if (isset($extra[yii\composer\Installer::EXTRA_BOOTSTRAP])) {
            $extension['bootstrap'] = $extra[yii\composer\Installer::EXTRA_BOOTSTRAP];
        }

        $extensions = static::loadExtensions($vendorDir);
        $extensions[$package->getName()] = $extension;
        static::saveExtensions($extensions, $vendorDir);
    }

    protected static function generateDefaultAlias($package, $vendorDir)
    {
        $fs = new Filesystem;
        $vendorDir = $fs->normalizePath($vendorDir);
        $autoload = $package->getAutoload();

        $aliases = [];

        if (!empty($autoload['psr-0'])) {
            foreach ($autoload['psr-0'] as $name => $path) {
                $name = str_replace('\\', '/', trim($name, '\\'));
                if (!$fs->isAbsolutePath($path)) {
                    $path = $vendorDir . '/' . $package->getPrettyName() . '/' . $path;
                }
                $path = $fs->normalizePath($path);
                if (strpos($path . '/', $vendorDir . '/') === 0) {
                    $aliases["@$name"] = '<vendor-dir>' . substr($path, strlen($vendorDir)) . '/' . $name;
                } else {
                    $aliases["@$name"] = $path . '/' . $name;
                }
            }
        }

        if (!empty($autoload['psr-4'])) {
            foreach ($autoload['psr-4'] as $name => $path) {
                $name = str_replace('\\', '/', trim($name, '\\'));
                if (!$fs->isAbsolutePath($path)) {
                    $path = $vendorDir . '/' . $package->getPrettyName() . '/' . $path;
                }
                $path = $fs->normalizePath($path);
                if (strpos($path . '/', $vendorDir . '/') === 0) {
                    $aliases["@$name"] = '<vendor-dir>' . substr($path, strlen($vendorDir));
                } else {
                    $aliases["@$name"] = $path;
                }
            }
        }

        return $aliases;
    }

    protected static function loadExtensions($vendorDir)
    {
        $file = $vendorDir . '/' . yii\composer\Installer::EXTENSION_FILE;
        if (!is_file($file)) {
            return [];
        }
        // invalidate opcache of extensions.php if exists
        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($file, true);
        }
        $extensions = require($file);

        $vendorDir = str_replace('\\', '/', $vendorDir);
        $n = strlen($vendorDir);

        foreach ($extensions as &$extension) {
            if (isset($extension['alias'])) {
                foreach ($extension['alias'] as $alias => $path) {
                    $path = str_replace('\\', '/', $path);
                    if (strpos($path . '/', $vendorDir . '/') === 0) {
                        $extension['alias'][$alias] = '<vendor-dir>' . substr($path, $n);
                    }
                }
            }
        }

        return $extensions;
    }

    protected static function saveExtensions(array $extensions, $vendorDir)
    {
        $file = $vendorDir . '/' . yii\composer\Installer::EXTENSION_FILE;
        if (!file_exists(dirname($file))) {
            mkdir(dirname($file), 0777, true);
        }
        $array = str_replace("'<vendor-dir>", '$vendorDir . \'', var_export($extensions, true));
        file_put_contents($file, "<?php\n\n\$vendorDir = dirname(__DIR__);\n\nreturn $array;\n");
        // invalidate opcache of extensions.php if exists
        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($file, true);
        }
    }
}