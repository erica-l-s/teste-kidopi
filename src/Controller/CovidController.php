<?php

namespace App\Controller;

use App\Repository\AccessUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Service\AccessService;


class CovidController extends AbstractController
{
  public function __construct(
    private HttpClientInterface $client,
    private AccessService $service,
  ) {

  }

  #[Route('/covid', name: 'app_covid')]
  public function index(): Response
  {
    return $this->render('covid/index.html.twig', []);
  }

  #[Route('/api/save/{country}', methods: ['GET'], name: 'api_covid_save')]
  public function save($country): Response
  {
    try {
      if (empty($country)) {
        throw new \InvalidArgumentException('country not found.');
      }

      $result = $this->client->request('GET', 'https://dev.kidopilabs.com.br/exercicio/covid.php?pais=' . $country);
      $data = json_decode($result->getContent());

      $this->service->saveAccess($country);

      return $this->json($data);
    } catch (\Throwable $th) {
      return $this->json('Error ' . $th->getMessage(), 500);
    }
  }

  #[Route('/api/last-access', methods: ['GET'], name: 'api_covid_last_access')]
  public function lastAccess(): Response
  {
    try {
      $lastAccess = $this->service->getLastAccess();
      $accessResult = [
        'country'=>$lastAccess->getCountry(),
        'date'=>$lastAccess->getDate()->format('d/m/Y H:m'),
        
      ];
      return $this->json($accessResult);
    }catch (\Throwable $th) {
      return $this->json('Error ' . $th->getMessage(), 500);
    }
  }
}