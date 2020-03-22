<?php

namespace Enflow\Svg\Test;

use ReflectionClass;
use Spatie\Snapshots\MatchesSnapshots;

trait Snapshots
{
    use MatchesSnapshots;

    protected function getSnapshotId(): string
    {
        dd( (new ReflectionClass($this))->getShortName().'--'.
            $this->getName().'--'.
            PHP_EOL .
            $this->snapshotIncrementor);

        return (new ReflectionClass($this))->getShortName().'--'.
            $this->getName().'--'.
            PHP_EOL .
            $this->snapshotIncrementor;
    }
}
