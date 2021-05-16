<?php

namespace App\Twill\Base\Behaviors;

use Illuminate\Support\Str;

trait Finder
{
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (Str::startsWith($name, 'findBy')) {
            return $this->findByAnyColumnName($name, $arguments);
        }

        return parent::__call($name, $arguments);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public static function __callStatic($name, $arguments)
    {
        return app(static::class)->__call($name, $arguments);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    protected function findByAnyColumnName($name, $arguments)
    {
        return $this->makeQueryByAnyColumnName(
            'findBy',
            $name,
            $arguments,
        )->first();
    }

    protected function makeQueryByAnyColumnName(
        $type,
        $name,
        $arguments,
        $query = null
    ) {
        $query ??= $this->new();

        $column = Str::snake(Str::after($name, $type));

        return $query->where($this->qualifyColumn($column), $arguments);
    }

    protected function qualifyColumn($name)
    {
        return $this->new()->qualifyColumn($name);
    }

    /**
     * @return mixed
     */
    public function new()
    {
        return $this->model->newQuery();
    }
}
