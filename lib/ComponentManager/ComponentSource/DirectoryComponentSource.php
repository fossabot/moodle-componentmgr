<?php

/**
 * Moodle component manager.
 *
 * @author Luke Carrier <luke@carrier.im>
 * @copyright 2016 Luke Carrier
 * @license GPL-3.0+
 */

namespace ComponentManager\ComponentSource;

/**
 * Directory component source.
 */
class DirectoryComponentSource extends AbstractComponentSource
        implements ComponentSource {
    /**
     * Path to the directory.
     *
     * @var string
     */
    protected $directory;

    /**
     * Initialiser.
     *
     * @param string $directory
     */
    public function __construct($directory) {
        $this->directory = $directory;
    }

    /**
     * @override \ComponentManager\ComponentSource\ComponentSource
     */
    public function getName() {
        return 'Directory';
    }

    /**
     * @override \ComponentManager\ComponentSource\ComponentSource
     */
    public function getType() {
        return 'DirectoryComponentSource';
    }

    /**
     * Get the path to the directory.
     *
     * @return string
     */
    public function getDirectory() {
        return $this->directory;
    }
}
