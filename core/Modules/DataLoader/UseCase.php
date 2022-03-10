<?php

declare(strict_types=1);

namespace Core\Modules\DataLoader;

use Core\Modules\DataLoader\Rule\FilterRule;
use Core\Modules\DataLoader\Rule\LoadDataRule;
use Core\Modules\DataLoader\Rule\SaveDataRule;

final class UseCase
{
    public function __construct(
        private LoadDataRule $loadDataRule,
        private FilterRule $filterRule,
        private SaveDataRule $saveDataRule,
    ) {
    }

    public function execute()
    {
        $data = $this->loadDataRule->apply();

        ($this->filterRule)($data);
        $filteredData = $this->filterRule->apply();

        ($this->saveDataRule)($filteredData);

        return $this->saveDataRule->apply();
    }
}
