#!/usr/bin/env bash

. 'test/travis/lib.sh'

strict_enable

travis_fold start logs.kitchen
    travis_section '$ cat .kitchen/logs/kitchen.log'

    cat '.kitchen/logs/kitchen.log'
travis_fold end logs.kitchen

travis_fold start versions.docker
    travis_section '$ docker version'

    docker version
travis_fold end versions.docker
