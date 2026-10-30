<?php

return [
    // Types allowed on changelog
    'path' => 'CHANGELOG.md',
    'types' => [],
    'ignoreTypes' => [],
    // Do not write "version" into composer.json: Packagist takes it over the tag name and drops a tag that differs
    'packageBump' => false,
];
