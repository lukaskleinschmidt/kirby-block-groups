<?php

namespace LukasKleinschmidt\BlockGroups;

use Kirby\Cms\App;

@include_once __DIR__ . '/vendor/autoload.php';
@include_once __DIR__ . '/helpers.php';

App::plugin('lukaskleinschmidt/block-groups', [
    'blocksMethods' => [
        'insertGroup' => function (string $group): BlockGroups {
            return $this->insertGroups([
                $group
            ]);
        },
        'insertGroups' => function (array $groups): BlockGroups {
            return $this->blockGroups()->insert($groups);
        },
        'blockGroups' => function (): BlockGroups {
            return new BlockGroups($this);
        }
    ],
]);
