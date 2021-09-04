<?php

use Illuminate\Support\Str;

if (!function_exists('is_running_on_frontend')) {
    function is_running_on_frontend(): bool
    {
        return Str::startsWith(optional(request()->route())->getName(), ['front.', 'api.']);
    }
}

if (!function_exists('repository')) {
    function repository($moduleName)
    {
        $repository = 'App\\Repositories\\' . ucfirst(Str::singular($moduleName)) . 'Repository';

        if (class_exists($repository)) {
            return app($repository);
        }

        $repository =
            'App\\Twill\\Capsules\\' .
            ucfirst(Str::plural($moduleName)) .
            '\Repositories\\' .
            ucfirst(Str::singular($moduleName)) .
            'Repository';

        return app($repository);
    }
}

if (!function_exists('create_seo_fields')) {
    function create_seo_fields($table)
    {
        $table->string('seo_title')->nullable();

        $table->string('seo_description')->nullable();
    }
}
