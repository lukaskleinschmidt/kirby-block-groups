# Kirby Block Groups

> **Note**  
> This plugin is currently experimental and not ready for production use.  
> The documentation is lacking at best and the API is not stable yet.

## What is it for?

The plugin groups blocks according to given patterns.  
Imagine you are looking for the following pattern:

```php
'media-card' => [
    'media'   => Block::pattern('image|video'),
    'heading' => Block::pattern('heading'),
    'content' => Block::pattern('text')->count('+'),
    'stop'    => Block::pattern('line'),
]
```
The plugin will find the pattern in your `$blocks` and render those with the `blocks/groups/media-card` snippet.

```diff
- heading
- text
- text
- text
+ image
+ heading
+ text
+ text
+ line
- heading
- text
- list
- text
+ video
+ heading
+ text
+ line
- heading
- text
- text
- text
```

## This and that

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
        'content' => Block::pattern('text')->count('+'),
        'stop'    => Block::pattern('line'),

        // Example for a catchall
        'content' => Block::pattern('\w+')->count('+'),
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
            'lines',
            'media-card',
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
