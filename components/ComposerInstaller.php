<?php
/**
 * ComposerInstaller class
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2022 OMMU (www.ommu.id)
 * @created date 18 August 2022, 01:59 WIB
 * @link https://github.com/ommu/ommu
 * 
 */

namespace ommu\core\components;

use yii\composer\Installer;

class ComposerInstaller extends Installer
{
    /**
     * Generates a cookie validation key for every app config listed in "config" in extra section.
     * You can provide one or multiple parameters as the configuration files which need to have validation key inserted.
     */
    public static function generateCookieValidationKey()
    {
        $configs = func_get_args();
        $key = self::generateRandomString();
        foreach ($configs as $config) {
            if (is_file($config)) {
                echo "cookieValidationKey in config file $config - ";
                $content = preg_replace('/(("|\')cookieValidationKey("|\')\s*=>\s*)(""|\'\')/', "\\1'$key'", file_get_contents($config), -1, $count);
                if ($count > 0) {
                    file_put_contents($config, $content);
                } else {
                    echo "raedy - skip.\n";
                }
            } else {
                echo "Config file $config not found.\n";
            }
        }
        echo '111';
    }
}