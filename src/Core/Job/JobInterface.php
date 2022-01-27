<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Job;

use Dealroadshow\K8S\API\Batch\Job;
use Dealroadshow\K8S\Framework\Core\LabelSelector\SelectorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Pod\PodTemplateSpecInterface;

interface JobInterface extends PodTemplateSpecInterface, ManifestInterface
{
    public function selector(SelectorConfigurator $selector): void;
    public function backoffLimit(): ?int;
    public function activeDeadlineSeconds(): ?int;
    public function ttlSecondsAfterFinished(): ?int;
    public function completions(): ?int;
    public function manualSelector(): ?bool;
    public function parallelism(): ?int;
    public function configureJob(Job  $job): void;
}
