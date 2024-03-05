<?php

namespace App\Services\PlanningService\Repositories\V1\Common\Template;

use App\Services\PlanningService\Models\Template;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class TemplateRepository extends BaseRepository implements TemplateInterface
{
    public function __construct(Template $model)
    {
        return parent::__construct($model);
    }

    public function store(array $parameters): Model
    {
        /** @var Template $template */
        $template = parent::store($parameters);

        foreach ($parameters['items'] as $item) {
            $template->items()->create($item);
        }

        return $template;
    }
}
