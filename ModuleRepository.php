<?php

namespace App\Twill\Capsules\Base;

use A17\CDN\Behaviours\HasCDNTags;
use A17\Twill\Models\Behaviors\HasMedias;
use App\Twill\Capsules\Base\Behaviors\Finder;
use A17\TwillTransformers\RepositoryTrait;
use A17\Twill\Repositories\ModuleRepository as TwillModuleRepository;

abstract class ModuleRepository extends TwillModuleRepository
{
    use RepositoryTrait, Finder, HasCDNTags;

    /**
     * @param \A17\Twill\Models\Model $object
     * @param array $fields
     * @return void
     */
    public function afterSave($object, $fields)
    {
        parent::afterSave($object, $fields);

        $this->invalidateCDNTags($object);
    }

    protected function makeBrowserData($object, $module, $prefix = null): array
    {
        $titleColumnKey = repository($module)->getModel()->titleColumnKey;

        return [
            'id' => $object->id,

            'name' => $object->$titleColumnKey,

            'edit' => moduleRoute($module, $prefix, 'edit', $object->id),
        ] +
            (classHasTrait($object, HasMedias::class)
                ? [
                    'thumbnail' => $object->defaultCmsImage([
                        'w' => 100,
                        'h' => 100,
                    ]),
                ]
                : []);
    }

    protected function getManyToManyBrowserField($model, array $fields, $relation, $prefix): array
    {
        if (blank($models = $model->{$relation})) {
            return $fields;
        }

        $fields['browsers'][$relation] = $models
            ->map(fn($model) => $this->makeBrowserData($model, $relation, $prefix))
            ->toArray();

        return $fields;
    }

    public function afterSaveUpdateManyToOneBrowser($page, $fields, $key)
    {
        $object = $fields['browsers'][$key][0] ?? null;

        $page->{$key} = filled($object) ? $object['id'] : null;

        $page->save();
    }

    protected function getManyToOneBrowserField($object, $fields, $key, $module, $relation, $prefix = null): array
    {
        if (filled($object = $object->{$relation})) {
            $fields['browsers'][$key] = collect([$object])
                ->map(fn($country) => $this->makeBrowserData($object, $module, $prefix))
                ->toArray();
        }

        return $fields;
    }

    public function findByCode($code)
    {
        return $this->model->where('code', $code)->first();
    }

    public function updateHasManyBrowser($object, $fields, $formField, $field, $hasManyClass)
    {
        $items = $fields['browsers'][$formField] ?? null;

        if (blank($items)) {
            $object->$formField()->delete();

            return;
        }

        foreach ($items as $position => $record) {
            $hasMany = app($hasManyClass)->find($record['id']);

            if (filled($hasMany)) {
                $hasMany->$field = $object->id;

                $hasMany->position = $position;

                $hasMany->save();
            }
        }

        foreach ($object->$formField as $city) {
            if (
                collect($items)
                    ->where('id', $city->id)
                    ->isEmpty()
            ) {
                $city->$field = null;

                $city->save();
            }
        }
    }
}
