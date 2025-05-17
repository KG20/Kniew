<?php

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

return function (RectorConfig $rectorConfig) {
    $rectorConfig->sets([
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
    ]);
};
