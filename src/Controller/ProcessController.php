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

class ProcessController extends AbstractController
{    
    private ApiClient $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    #[Route(
        path: '/apiadv/tj-uf/list',
        name: 'process_tjuf_list',
        methods: ['POST']
    )]
    public function getProcessListAction(Request $request): JsonResponse
    {
        try {
            $jsonData = json_decode($request->getContent(), true);
            //TODO: validar Request
            $response = $this->apiClient->getProcessList($jsonData['tribunal'] ?? null);

            return $this->json($response);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    #[Route(
        path: '/apiadv/tj-uf',
        name: 'process_tjuf',
        requirements: ['id' => '\d+'],
        methods: ['POST']
    )]
    public function getProcessByAction(Request $request): JsonResponse
    {
        try {
            //TODO: validar request e implementar paginação https://datajud-wiki.cnj.jus.br/api-publica/exemplos/exemplo3
            $jsonData = json_decode($request->getContent(), true);

            $tribunal = $jsonData['tribunal'];

            $query = $jsonData;
            unset($query['tribunal']);

            $response = $this->apiClient->getProcess($tribunal, $query);

            return $this->json($response);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }  
}
