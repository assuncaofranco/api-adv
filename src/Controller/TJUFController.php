<?php

namespace App\Controller;

use App\Form\TJType;
use App\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TJUFController extends AbstractController
{
    const API_KEY = 'APIKey cDZHYzlZa0JadVREZDJCendQbXY6SkJlTzNjLV9TRENyQk1RdnFKZGRQdw==';
    const TJ_URL = 'https://api-publica.datajud.cnj.jus.br/api_publica_tjsp/_search';
    
    private ApiClient $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    #[Route(
        path: '/tj-uf',
        name: 'process_tjuf_list',
        requirements: ['domainId' => '\d+', 'id' => '\d+'],
        methods: ['GET']
    )]
    public function getProcessListAction(): JsonResponse
    {
        try {
            $jsonData = $this->apiClient->fetchData(self::TJ_URL, self::API_KEY);

            return $this->json($jsonData);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    #[Route(
        path: '/tj-uf/{id}',
        name: 'process_tjuf',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function getProcessDataAction(): JsonResponse
    {
        try {
            $jsonData = $this->apiClient->fetchData(self::TJ_URL, self::API_KEY);

            return $this->json($jsonData);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    #[Route(
        path: '/tj-uf/{id}',
        name: 'post_process_tjuf',
        requirements: ['id' => '\d+'],
        methods: ['POST']
    )]
    public function postProcessDataAction(Request $request): JsonResponse|FormInterface
    {
        $jsonData = json_decode($request->getContent(), true);

        $form = $this->createForm(TJType::class);
        $form->submit($jsonData);

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[$error->getOrigin()->getName()] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errors], Response::HTTP_BAD_REQUEST);        
        }

        try {
            $response = $this->apiClient->fetchData(self::TJ_URL, self::API_KEY);
            return $this->json($response);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }
}
