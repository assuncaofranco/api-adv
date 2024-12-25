<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class CalcController extends AbstractController
{
    #[Route(
        path: '/api',
        name: '',
        methods: ['POST']
    )]
    public function atualizacaoTabelaTjspAction(Request $request): array
    {
        
        return [];
    }
}