<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity]
#[ORM\Table(name: 'atualizacao_monetaria')]
class AtualizacaoMonetaria
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected ?int $id = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    protected string $valor;

    #[ORM\Column(type: "datetime")]
    #[Gedmo\Timestampable(on: 'create')]  // Exemplo de uso do Gedmo
    protected DateTime $data;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getData(): DateTime
    {
        return $this->data;
    }

    public function setData(DateTime $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function getValor(): string
    {
        return $this->valor;
    }

    public function setValor(string $valor): self
    {
        $this->valor = $valor;
        return $this;
    }
}
