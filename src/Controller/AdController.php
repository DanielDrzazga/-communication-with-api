<?php

namespace App\Controller;

use App\Form\AdType;
use App\Repository\AdRepository;
use App\service\ReadDataFromApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;


/**
 * @Route(path="/")
 * Class AdController
 * @package App\Controller
 */
class AdController extends AbstractController
{
    private $adRepository;
    private $apiService;

    /**
     * @param ReadDataFromApiService $apiService
     * @param AdRepository $adRepository
     */
    public function __construct(ReadDataFromApiService $apiService,
                                AdRepository $adRepository)
    {
        $this->adRepository = $adRepository;
        $this->apiService = $apiService;
    }

    /**
     * @Route(path="/", name="displayAllAdFromDatabase", methods={"GET"})
     * @return Response
     */
    public function showAllAd(): Response
    {
        $ad = $this->adRepository->findAllAd();

        return $this->render(
            'ad/index.html.twig',
            [
                'AdList' => $ad,
            ]
        );
    }

    /**
     * @Route(path="/{id}", name="deleteAdById", methods={"DELETE"})
     * @param string $id
     * @return Response
     */
    public function deleteAdById(string $id): Response
    {
        $ad = $this->adRepository->find($id);

        if ($ad)
            $this->adRepository->removeAd($ad);

        return $this->showAllAd();
    }

    /**
     * @Route(path="/{id}", name="displayAdById", methods={"GET"})
     * @param string $id
     * @return Response
     */
    public function displayAdById(string $id): Response
    {
        $ad = $this->adRepository->find($id);

        $form = $this->createForm(AdType::class, $ad,[
            'method' => "GET",
        ]);

        return $this->render('ad/edit.html.twig', [
            'adForm' => $form->createView(),
        ]);
    }

    /**
     * @Route(path="/read/api", name="readDataFromApi", methods={"GET"})
     * @return Response
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws \Exception
     */
    public function readDataFromApi(): Response
    {
        $response = $this->apiService->getApiConnection();

        if ($response->getStatusCode() !== 200) {
            throw new NotFoundHttpException('Unable to connect to the api');
        }

        $this->apiService->saveDataToDatabase($response->toArray());

        return $this->redirectToRoute('displayAllAdFromDatabase');
    }
}