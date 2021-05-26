<?php

namespace App\Twill\Capsules\Base;

use Illuminate\Database\Migrations\Migration as IlluminateMigration;

abstract class Migration extends IlluminateMigration
{
    public function createSeoFields($table)
    {
        if ($this->capsule()['config']['seo']['enabled'] ?? false) {
            create_seo_fields($table);
        }
    }

    public function capsule(): array
    {
        $reflection = new \ReflectionClass(get_class($this));

        return capsules()->capsule($reflection->getFileName());
    }
}
