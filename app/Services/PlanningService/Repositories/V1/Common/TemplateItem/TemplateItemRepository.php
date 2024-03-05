<?php

namespace App\Services\PlanningService\Repositories\V1\Common\TemplateItem;

use App\Services\PlanningService\Models\Template;
use Celysium\Base\Repository\BaseRepository;

class TemplateItemRepository extends BaseRepository implements TemplateItemInterface
{
    public function __construct(Template $model)
    {
        return parent::__construct($model);
    }
}
