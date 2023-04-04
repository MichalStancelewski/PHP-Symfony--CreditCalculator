<?php

namespace App\Controller;

use App\DTO\CalculateRequestDTO;
use App\Entity\Clients;
use App\Entity\CreditData;
use App\Filter\CalculationsFilterInterface;
use App\Repository\AuthKeyRepository;
use App\Repository\CreditDataRepository;
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
        private AuthKeyRepository      $authKeyRepository,
        private DTOSerializer          $serializer,
        private EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('/api/calculate', name: 'api_calculate', methods: 'POST')]
    public function calculate(Request $request, CalculationsFilterInterface $creditCalculation): JsonResponse
    {
        $this->validateRequest($request, "public");

        $calculateRequest = new CalculateRequestDTO();
        $JsonArray = json_decode($request->getContent(), true);
        $serializer = $this->serializer;

        $calculateRequest->setClient(
            $serializer->deserialize($serializer->serialize($JsonArray['clients'], 'json'), Clients::class, 'json')
        );
        $calculateRequest->setCreditData(
            $serializer->deserialize($serializer->serialize($JsonArray['credit_data'], 'json'), CreditData::class, 'json')
        );

        $calculation = $creditCalculation->apply($calculateRequest);

        //TODO post to database (refactor this) / add unit test?
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
        return new JsonResponse(data: $responseContent, status: Response::HTTP_CREATED, json: true);
    }

    #[Route('/api/find/all', name: 'api_find_all', methods: 'POST')]
    public function findAll(Request $request, CreditDataRepository $creditDataRepository): JsonResponse
    {
        $this->validateRequest($request, "restricted");

        $calculations = $creditDataRepository->findAll();
        $serializer = $this->serializer;

        $responseContent = $serializer->serialize($calculations, 'json', ['groups' => ['client', 'calculation_results', 'credit_data']]);
        return new JsonResponse(data: $responseContent, status: Response::HTTP_OK, json: true);
    }

    #[Route('/api/find/single/{id}', name: 'api_find_single', methods: 'POST')]
    public function findSingle(Request $request, int $id, CreditDataRepository $creditDataRepository): JsonResponse
    {
        $this->validateRequest($request, "restricted");

        $calculation = $creditDataRepository->findOrFail($id);
        $serializer = $this->serializer;

        $responseContent = $serializer->serialize($calculation, 'json', ['groups' => ['client', 'calculation_results', 'credit_data']]);
        return new JsonResponse(data: $responseContent, status: Response::HTTP_OK, json: true);
    }

    #[Route('/api/find/by-currency/{currency}', name: 'api_find_by_currency', methods: 'POST')]
    public function findByCurrency(Request $request, string $currency, CreditDataRepository $creditDataRepository): JsonResponse
    {
        $this->validateRequest($request, "restricted");
        $currency = strtoupper($currency);

        $calculations = $creditDataRepository->findByCurrency($currency);
        $serializer = $this->serializer;

        $responseContent = $serializer->serialize($calculations, 'json', ['groups' => ['client', 'calculation_results', 'credit_data']]);
        return new JsonResponse(data: $responseContent, status: Response::HTTP_OK, json: true);
    }

    private function validateRequest(Request $request, string $type)
    {
        $authorizationValidation = new AuthorizationValidation($this->authKeyRepository);
        $authorizationValidation->validate($request->headers->get('Authorization'), $type);
    }
}
