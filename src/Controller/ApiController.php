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
        private readonly AuthKeyRepository $authKeyRepository
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

        //TODO create relations in DB

        //TODO post to database

        //TODO send emails

        $responseContent = $serializer->serialize($calculation, 'json');

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
