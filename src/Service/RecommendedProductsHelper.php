<?php

namespace App\Service;

use App\Entity\RecommendedProducts;
use App\Repository\ProductRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;


class RecommendedProductsHelper
{
    private $productRepository;

    private $client;

    public function __construct(ProductRepository $productRepository, HttpClientInterface $client)
    {
        $this->productRepository = $productRepository;
        $this->client = $client;
    }

    public function fetchOne(string $city): ?RecommendedProducts
    {
        $forecast = $this->parseWeatherForecastData($this->fetchWeatherForecast($city));
        $recommendations = [];

        foreach ($forecast as $f) {
            $r = new \stdClass();
            $r->weather_forecast = $f['condition'];
            $r->date = $f['date'];
            $r->products = $this->productRepository->findBy(['weather' => $f['code']], [], 2);
            $recommendations[] = $r;
        }

        return new RecommendedProducts($city, $recommendations);
    }

    private function fetchWeatherForecast(string $city): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.meteo.lt/v1/places/'.$city.'/forecasts/long-term'
        );

        if ($response->getStatusCode() == 404) {
            throw new NotFoundHttpException();
        } elseif ($response->getStatusCode() != 200) {
            throw new ServiceUnavailableHttpException();
        }

        return $response->toArray();
    }

    private function parseWeatherForecastData(array $data): array
    {
        $date = new \DateTime('tomorrow');
        $result = [];

        if (empty($data['forecastTimestamps']) || !is_array($data['forecastTimestamps'])) {
            return $result;
        }

        for ($i=0; $i < 3; $i++) { 
            $dateStr = $date->format('Y-m-d');
            foreach ($data['forecastTimestamps'] as $f) {
                if (empty($f['forecastTimeUtc']) || empty($f['conditionCode']) || !is_string($f['conditionCode'])) {
                    return $result;
                }
                try {
                    $forecastDate = new \DateTimeImmutable($f['forecastTimeUtc']);
                } catch (Exception $e) {
                    return $result;
                }
                if ($dateStr === $forecastDate->format('Y-m-d')) {
                    if (!isset($result[$i])) {
                        $result[$i] = [
                            'condition' => $f['conditionCode'],
                            'date' => $dateStr,
                            'code' => 1
                        ];
                    } elseif (str_contains($f['conditionCode'], 'rain')) {
                        $result[$i]['condition'] = $f['conditionCode'];
                        $result[$i]['code'] = 2;
                    }
                }
            }
            $date->modify('+1 day');
        }

        return $result;
    }
}
