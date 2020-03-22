<?php

namespace Enflow\Svg\Test;

use ReflectionClass;
use Spatie\Snapshots\MatchesSnapshots;

trait Snapshots
{
    use MatchesSnapshots;

    protected function getSnapshotId(): string
    {
        return (new ReflectionClass($this))->getShortName() . '--' .
            $this->getName() . '--' .
            substr(md5(PHP_EOL), 0, 2) . '--' .
            $this->snapshotIncrementor;
    }
}
