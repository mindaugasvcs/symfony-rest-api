<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * @ApiResource(
 *     collectionOperations={},
 *     itemOperations={
 *          "get"={"path"="/products/recommended/{city}"},
 *     },
 *     attributes={
 *          "formats"={"json"}
 *     },
 *     cacheHeaders={"max_age"=300, "shared_max_age"=300, "vary"={"Authorization", "Accept-Language"}}
 * )
 */
class RecommendedProducts
{
    /**
     * @ApiProperty(identifier=true)
     */
	public $city;

	public $recommendations;

    public function __construct(string $city, array $recommendations)
    {
        $this->city = $city;
        $this->recommendations = $recommendations;
    }
}
