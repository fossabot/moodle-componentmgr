<?php

/**
 * Moodle component manager.
 *
 * @author Luke Carrier <luke@carrier.im>
 * @copyright 2016 Luke Carrier
 * @license GPL-3.0+
 */

namespace ComponentManager\PackageRepository;

use Psr\Log\LoggerInterface;

/**
 * Caching package repository interface.
 */
interface CachingPackageRepository {
    /**
     * Retrieve the time of the last cache update time.
     *
     * @return \DateTime|null
     */
    public function metadataCacheLastRefreshed();

    /**
     * Update the metadata cache.
     *
     * @return void
     */
    public function refreshMetadataCache(LoggerInterface $logger);
}
