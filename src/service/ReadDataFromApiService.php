<?php


namespace App\service;


use App\Entity\Ad;
use App\Entity\AdTags;
use App\Entity\AdUrls;
use App\Repository\AdRepository;
use App\Repository\AdTagsRepository;
use App\Repository\AdUrlsRepository;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ReadDataFromApiService
{
    private $adRepository;
    private $adUrlsRepository;
    private $adTagsRepository;

    private $key = "";
    private $date = "";
    private $output = "json";

    /**
     * @param AdRepository $adRepository
     * @param AdUrlsRepository $adUrlsRepository
     * @param AdTagsRepository $adTagsRepository
     */
    public function __construct(AdRepository $adRepository,
                                AdUrlsRepository $adUrlsRepository,
                                AdTagsRepository $adTagsRepository)
    {
        $this->adRepository = $adRepository;
        $this->adUrlsRepository = $adUrlsRepository;
        $this->adTagsRepository = $adTagsRepository;
    }

    public function getApiConnection(): ResponseInterface
    {
            return HttpClient::create()->request('GET',
                "https://api.URLAPI.com/get?key=" .
                $this->key .
                "Date=" .
                $this->date .
                "&endDate=" .
                $this->date .
                "&output=" .
                $this->output);
    }

    public function saveDataToDatabase(array $apiData)
    {
        foreach ($apiData["data"] as $data) {

            $url = $this->getUrl($data[0]);

            $tag = $this->getTag($data[1]);

            $ad = new Ad();
            $ad->setCurrency($apiData["settings"]["currency"]);
            $ad->setUrl($url);
            $ad->setTag($tag);
            $ad->setDate(new \DateTime($data[2]));
            $ad->setEstimatedRevenue($data[3]);
            $ad->setAdImpressions($data[4]);
            $ad->setAdEcpm($data[5]);
            $ad->setClicks($data[6]);
            $ad->setAdCTR($data[7]);

            $this->adRepository->saveOrUpdate($ad);
        }
    }

    private function getUrl(string $urlAddress)
    {
        $url = $this->adUrlsRepository->findByUrlAddress($urlAddress);

        if (count($url) === 0) {
            return new AdUrls($urlAddress);
        } elseif (count($url) === 1) {
            return  $url[0];
        } else {
            throw new \RuntimeException("Database Error: duplicate url address", 500);
        }
    }

    private function getTag(string $tagName)
    {
        $tag = $this->adTagsRepository->findByUrlAddress($tagName);

        if (count($tag) === 0) {
            return new AdTags($tagName);
        } elseif (count($tag) === 1) {
            return $tag[0];
        } else {
            throw new \RuntimeException("Database Error: duplicate tag name", 500);
        }
    }
}