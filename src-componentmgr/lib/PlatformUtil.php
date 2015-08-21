<?php

/**
 * Moodle component manager.
 *
 * @author Luke Carrier <luke@carrier.im>
 * @copyright 2015 Luke Carrier
 * @license GPL v3
 */

namespace ComponentManager;

use ComponentManager\Exception\PlatformException;

/**
 * Platform utility methods.
 *
 * Provides functionality for working around platform inconsistencies.
 */
class PlatformUtil {
    /**
     * Temporary file/directory prefix.
     *
     * @var string
     */
    const TEMP_PREFIX = 'componentmgr-';

    /**
     * Create a temporary directory in the system temporary directory.
     *
     * @return string The absolute path to the created directory.
     */
    public static function createTempDirectory() {
        $root      = sys_get_temp_dir();
        $directory = tempnam($root, static::TEMP_PREFIX);

        unlink($directory);
        mkdir($directory);

        return $directory;
    }

    /**
     * Retrieve the platform's directory separator.
     *
     * @return string
     */
    public static function directorySeparator() {
        return DIRECTORY_SEPARATOR;
    }

    /**
     * Retrieve the user's home directory.
     *
     * @return string
     */
    public static function homeDirectory() {
        switch (PHP_OS) {
            case 'Linux': return getenv('HOME');
            case 'WINNT': return getenv('HOMEDRIVE') . getenv('HOMEPATH');
            default:      throw new PlatformException(PHP_OS, PlatformException::CODE_UNKNOWN_PLATFORM);
        }
    }

    /**
     * Retrieve the user's local shared data directory.
     *
     * @return string
     */
    public static function localSharedDirectory() {
        switch (PHP_OS) {
            case 'Linux': return static::homeDirectory() . '/.local/share';
            case 'WINNT': return getenv('APPDATA');
            default:      throw new PlatformException(PHP_OS, PlatformException::CODE_UNKNOWN_PLATFORM);
        }
    }

    /**
     * Get the path to the php executable.
     *
     * @return string
     */
    public static function phpExecutable() {
        global $_SERVER;

        return $_SERVER['_'];
    }

    /**
     * Get the current working directory.
     *
     * @return string
     */
    public static function workingDirectory() {
        return getcwd();
    }
}
