<?php

namespace App\Repositories;

use App\EmailTemplate;

/**
 * Class EmailTemplateRepository.
 */
class EmailTemplateRepository extends AbstractRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EmailTemplate::class;
    }

    /**
     * @param string $name
     *
     * @return EmailTemplate
     */
    public function findByName($name)
    {
        return $this->model->where('name', $name)->first();
    }
}
