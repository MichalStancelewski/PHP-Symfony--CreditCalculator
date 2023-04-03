<?php

namespace App\Controller;

use App\DTO\CalculateRequestDTO;
use App\Entity\Clients;
use App\Entity\CreditData;
use App\Filter\CalculationsFilterInterface;
use App\Repository\AuthKeyRepository;
use App\Repository\ChfCalculationResultsRepository;
use App\Repository\ClientsRepository;
use App\Repository\CreditDataRepository;
use App\Repository\PlnCalculationResultsRepository;
use App\Service\Authorization\AuthorizationValidation;
use App\Service\Serializer\DTOSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    public function __construct(
        private readonly CreditDataRepository      $creditDataRepository,
        private readonly ClientsRepository $clientsRepository,
        private readonly PlnCalculationResultsRepository $plnCalculationResultsRepository,
        private readonly ChfCalculationResultsRepository $chfCalculationResultsRepository,
        private readonly AuthKeyRepository $authKeyRepository,
        private EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('/api/calculate', name: 'api_calculate', methods: 'POST')]
    public function calculate(Request $request, DTOSerializer $serializer, CalculationsFilterInterface $creditCalculation): JsonResponse
    {
        $calculateRequest = new CalculateRequestDTO();
        $JsonArray = json_decode($request->getContent(), true);

        $calculateRequest->setClient(
            $serializer->deserialize($serializer->serialize($JsonArray['clients'], 'json'), Clients::class, 'json')
        );
        $calculateRequest->setCreditData(
            $serializer->deserialize($serializer->serialize($JsonArray['credit_data'], 'json'), CreditData::class, 'json')
        );

        $calculation = $creditCalculation->apply($calculateRequest);

        //TODO post to database (refactor this)
        $entityManager = $this->entityManager;

        $client = $calculation->getClient();
        $calculationResults = $calculation->getCalculationResults();
        $creditData = $calculation->getCreditData();
        $creditData->setClients($client);
        $creditData->setCalculationResults($calculationResults);

        $entityManager->persist($client);
        $entityManager->persist($calculationResults);
        $entityManager->persist($creditData);

        $entityManager->flush();

        //TODO send emails

        $responseContent = $serializer->serialize($creditData, 'json');
        return new JsonResponse(data: $responseContent, status: Response::HTTP_OK, json: true);
    }

    #[Route('/api/find/all', name: 'api_find_all', methods: 'POST')]
    public function findAll(Request $request): JsonResponse
    {
        $authorizationValidation = new AuthorizationValidation($this->authKeyRepository);
        $authorizationValidation->validate($request->headers->get('Authorization'));

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiController.php',
        ]);
    }

    #[Route('/api/find/single/{id}', name: 'api_find_single', methods: 'POST')]
    public function findSingle(Request $request, int $id): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiController.php',
        ]);
    }
}
