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
    private string $apiKey;
    private string $tjUrl;
    private ApiClient $apiClient;

    public function __construct(ApiClient $apiClient, string $apiKey, string $tjUrl)
    {
        $this->apiClient = $apiClient;
        $this->apiKey = $apiKey;
        $this->tjUrl = $tjUrl;
    }

    #[Route(
        path: '/apiadv/tj-uf',
        name: 'process_tjuf_list',
        requirements: ['domainId' => '\d+', 'id' => '\d+'],
        methods: ['GET']
    )]
    public function getProcessListAction(): JsonResponse
    {
        try {
            $jsonData = $this->apiClient->fetchData($this->tjUrl, $this->apiKey);

            return $this->json($jsonData);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    #[Route(
        path: '/apiadv/tj-uf/{id}',
        name: 'process_tjuf',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function getProcessDataAction(): JsonResponse
    {
        try {
            $jsonData = $this->apiClient->fetchData($this->tjUrl, $this->apiKey);

            return $this->json($jsonData);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    #[Route(
        path: '/apiadv/tj-uf/{id}',
        name: 'post_process_tjuf',
        requirements: ['id' => '\d+'],
        methods: ['POST']
    )]
    public function postProcessDataAction(Request $request): JsonResponse|FormInterface
    {
        var_dump($request->request->all());
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
            $response = $this->apiClient->fetchData($this->tjUrl, $this->apiKey);
            return $this->json($response);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }
}
