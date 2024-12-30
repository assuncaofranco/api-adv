<?php


namespace App\Controller;

use App\Entity\Indice;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class CalcController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route(
        path: '/api/atualizacao-monetaria',
        name: 'atualizacao_monetaria',
        methods: ['POST']
    )]
    public function atualizacaoMonetariaAction(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        $valor = str_replace(',', '.', $data['valor'] ?? null);
        $valor = (float) $valor;
    
        $inicio = \DateTime::createFromFormat('d/m/Y', $data['inicio'] ?? null);
        $inicio->setTime(0, 0, 0);
        $fim = clone $inicio;
        $fim->setTime(23, 59, 59);
    
        $indiceInicio = $this->entityManager->getRepository(Indice::class)->findOneBy([
            'data' => $inicio
        ]);
    
        if (!$indiceInicio) {
            return $this->json(['error' => 'Índice não encontrado para a data inicial']);
        }
    
        $indiceFinal = $this->entityManager->getRepository(Indice::class)->findOneBy([], ['data' => 'DESC']);
    
        if (!$indiceFinal) {
            return $this->json(['error' => 'Índice mais recente não encontrado']);
        }
    
        $valorAtualizado = $valor / $indiceInicio->getIndice() * $indiceFinal->getIndice();

        $response = [
            'valor_inicial' => $valor,
            'valor_atualizado' => number_format($valorAtualizado, 2, ',', '.'),
            'inicio' => $inicio->format('d/m/Y'),
            'final' => $indiceFinal->getData()->format('d/m/Y')
        ];
    
        return $this->json($response);
    }
}

