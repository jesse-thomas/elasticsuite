<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Smile ElasticSuite to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\ElasticsuiteCatalog
 * @author    Romain Ruaud <romain.ruaud@smile.fr>
 * @copyright 2020 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */
namespace Smile\ElasticsuiteCatalog\Model\Product\Search\Request\Container\Filter;

use Smile\ElasticsuiteCore\Api\Search\Request\Container\FilterInterface;
use Smile\ElasticsuiteCore\Search\Request\QueryInterface;

/**
 * Product Visibility Default filter.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCatalog
 * @author   Romain Ruaud <romain.ruaud@smile.fr>
 */
class VisibleInSearch implements FilterInterface
{
    /**
     * @var \Smile\ElasticsuiteCore\Search\Request\Query\QueryFactory
     */
    private $queryFactory;

    /**
     * @var Magento\Catalog\Model\Product\VisibilityFactory
     */
    private $visibilityFactory;
    
    /**
     * Search Blacklist filter constructor.
     *
     * @param \Smile\ElasticsuiteCore\Search\Request\Query\QueryFactory $queryFactory Query Factory
     */
    public function __construct(
        \Smile\ElasticsuiteCore\Search\Request\Query\QueryFactory $queryFactory,
        \Magento\Catalog\Model\Product\VisibilityFactory $visibilityFactory
    )
    {
        $this->queryFactory  = $queryFactory;
        $this->visibilityFactory = $visibilityFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilterQuery()
    {
        $query = $this->queryFactory->create(
            QueryInterface::TYPE_TERMS,
            [
                'field' => 'visibility',
                'values' => $visibility->getVisibleInSearchIds(),
            ]
        );

        return $query;
    }
}
