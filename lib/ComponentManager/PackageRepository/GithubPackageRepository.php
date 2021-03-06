<?php

/**
 * Moodle component manager.
 *
 * @author Luke Carrier <luke@carrier.im>
 * @copyright 2016 Luke Carrier
 * @license GPL-3.0+
 */

namespace ComponentManager\PackageRepository;

use ComponentManager\Component;
use ComponentManager\ComponentSource\GitComponentSource;
use ComponentManager\ComponentSpecification;
use ComponentManager\ComponentVersion;
use Github\Client;
use Github\HttpClient\CachedHttpClient;

/**
 * GitHub package repository.
 */
class GithubPackageRepository extends AbstractCachingPackageRepository
        implements PackageRepository {
    /**
     * Cache directory.
     *
     * Path to the Gaufrette response cache for the GitHub API client.
     *
     * @var string
     */
    const CACHE_DIRECTORY = '%s%sGithub';

    /**
     * GitHub client instance.
     *
     * Lazily loaded -- use {@link getClient()} to ensure it's initialised.
     *
     * @var \Github\Client;
     */
    protected $client;

    /**
     * @override \ComponentManager\PackageRepository\PackageRepository
     */
    public function getId() {
        return 'Github';
    }

    /**
     * @override \ComponentManager\PackageRepository\PackageRepository
     */
    public function getName() {
        return 'GitHub package repository';
    }

    /**
     * Get the GitHub client.
     *
     * @return \Github\Client
     */
    protected function getClient() {
        if ($this->client === null) {
            $this->client = new Client(new CachedHttpClient([
                'cache_dir' => $this->getMetadataCacheDirectory(),
            ]));
        }

        return $this->client;
    }

    /**
     * @override \ComponentManager\PackageRepository\PackageRepository
     */
    public function getComponent(ComponentSpecification $componentSpecification) {
        /** @var \Github\Api\Repo $api */
        $api = $this->getClient()->api('repo');

        list($user, $repositoryName) = explode(
                '/', $componentSpecification->getExtra('repository'));

        $repository = $api->show($user, $repositoryName);

        $refs = array_merge(
                $api->tags($user, $repositoryName),
                $api->branches($user, $repositoryName));

        $versions = [];

        foreach ($refs as $ref) {
            $versions[] = new ComponentVersion(null, $ref['name'], null, [
                new GitComponentSource($repository['clone_url'], $ref['name']),
            ]);
        }

        return new Component($componentSpecification->getName(), $versions,
                             $this);
    }

    /**
     * @override \ComponentManager\PackageRepository\PackageRepository
     */
    public function satisfiesVersion($versionSpecification, ComponentVersion $version) {
        return $versionSpecification === $version->getRelease();
    }
}
