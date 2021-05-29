<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\RecommendedProducts;
use App\Service\RecommendedProductsHelper;


class RecommendedProductsProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $recommendedProductsHelper;

    public function __construct(RecommendedProductsHelper $recommendedProductsHelper)
    {
        $this->recommendedProductsHelper = $recommendedProductsHelper;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        return $this->recommendedProductsHelper->fetchOne($id);
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === RecommendedProducts::class;
    }
}
