# Kirby Block Groups

> **Note**  
> This plugin is currently experimental and not ready for production use.
> The documentation is very much lacking and the API is not stable yet.

```php

use LukasKleinschmidt\BlockGroups\Block;
use LukasKleinschmidt\BlockGroups\BlockGroups;
use LukasKleinschmidt\BlockGroups\Group;
use LukasKleinschmidt\BlockGroups\GroupBlock;

// Regex quantifiers
// a?      Zero or one of a
// a*      Zero or more of a
// a+      One or more of a
// a{3}    Exactly 3 of a
// a{3,}   3 or more of a
// a{3,6}  Between 3 and 6 of a

BlockGroups::define([

    // Basic group definition:
    // The block will render the blocks/groups/media-card snippet
    'media-card' => [
        'media'   => Block::pattern('image|video'),
        'heading' => Block::pattern('heading'),
        'content' => Block::pattern('\w+')->count('+'),

        // Or maybe more specific
        'content' => Block::pattern('text|list')->count('?'),
    ],

    // Extended group defintion:
    // The block will use the render function to render the group
    // When render is omitted the blocks/groups/lines snippet will be used
    // When render is set to a string, the snippet with that name will be used
    'lines' => Group::make(
        pattern: [
            'lines' => Block::pattern('line')->count('{2,}'),
        ],
        render: function (GroupBlock $block) {
            return '<hr><!-- Only one line for you -->';
        },
    ),

]);

foreach ($page->article()->toLayouts() as $layout) {
    foreach ($layout->columns() as $column) {
        echo $column->blocks()->insertGroups([
            'media-card',
            'lines',
        ]);
    }
}

```

```php

// blocks/groups/media-card.php

<div class="bg-gray p-8 rounded">
  <?= $media ?>
  <?= $heading ?>
  <?= $content ?>
</div>

```
