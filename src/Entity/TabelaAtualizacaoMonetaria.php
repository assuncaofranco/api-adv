<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class TabelaAtualizacaoMonetaria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "integer")]
    private int $ano;

    #[ORM\Column(type: "integer")]
    private int $mes;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private string $valor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAno(): int
    {
        return $this->ano;
    }

    public function setAno(int $ano): self
    {
        $this->ano = $ano;
        return $this;
    }

    public function getMes(): int
    {
        return $this->mes;
    }

    public function setMes(int $mes): self
    {
        $this->mes = $mes;
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

    public function __toString(): string
    {
        return sprintf('%d-%02d', $this->ano, $this->mes);
    }
}
