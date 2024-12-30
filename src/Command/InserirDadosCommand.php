<?php

// src/Command/InserirDadosCommand.php

namespace App\Command;

use App\Entity\Indice;
use App\Utils\Dados;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InserirDadosCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    // Remova ou modifique a constante estática para o nome do comando
    protected static $defaultName = null; // Deixe vazio aqui se estiver com problemas.

    protected function configure(): void
    {
        $this
            ->setName('app:inserir-dados')  // Defina explicitamente o nome do comando aqui
            ->setDescription('Insere dados de índices históricos no banco de dados.')
            ->setHelp('Este comando insere dados históricos de índices a partir da constante definida na classe Dados.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dados = Dados::DADOS;

        foreach ($dados as $dado) {
            $indice = new Indice();
            $indice->setData(new \DateTime($dado['data'] ?? null)); // Convertendo string para objeto DateTime
            $indice->setIndice($dado['indice'] ?? null);

            $this->entityManager->persist($indice);
        }

        $this->entityManager->flush();

        $output->writeln('Dados inseridos com sucesso!');

        return Command::SUCCESS;
    }
}
