<?php

namespace App\Controller;

use App\DTO\CalculateRequestDTO;
use App\Service\Serializer\DTOSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{


    #[Route('/api/calculate', name: 'api_calculate', methods: 'POST')]
    public function calculate(Request $request, DTOSerializer $serializer): JsonResponse
    {


        /** @var CalculateRequestDTO $calculateRequest */
        $calculateRequest = $serializer->deserialize(
            $request->getContent(), CalculateRequestDTO::class, 'json'
        );


        $responseContent = 'OK';

        return new JsonResponse(data: $responseContent, status: Response::HTTP_OK, json: true);
    }

    #[Route('/api/find/all', name: 'api_find_all', methods: 'POST')]
    public function findAll(Request $request): JsonResponse
    {
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
