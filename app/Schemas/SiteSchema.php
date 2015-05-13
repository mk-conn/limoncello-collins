<?php namespace App\Schemas;

use \App\Models\Site;
use \Neomerx\JsonApi\Schema\SchemaProvider;

class SiteSchema extends SchemaProvider
{
    /**
     * @inheritdoc
     */
    protected $resourceType = 'sites';

    /**
     * @inheritdoc
     */
    protected $baseSelfUrl = '/sites';

    /**
     * @inheritdoc
     */
    public function getId($site)
    {
        /** @var Site $site */
        return $site->id;
    }

    /**
     * @inheritdoc
     */
    public function getAttributes($site)
    {
        /** @var Site $site */
        return [
            'name' => $site->name,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getLinks($site)
    {
        /** @var Site $site */
        return [
            'posts' => [self::DATA => $site->posts->all(), self::INCLUDED => true],
        ];
    }
}
