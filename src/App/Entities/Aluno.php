<?php

namespace App\Entities;

use \App\Entities\Turma as Turma;

/**
 * @Entity
 * @Table(name="alunos")
 */
class Aluno
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     **/
    private $id;
    /** @Column(type="integer")  **/
    private $matricula;
    /** @Column(type="string") **/
    private $nome;
    /** @Column(name="data_de_nascimento", type="date") **/
    private $dataDeNascimento;
    /**
    * @OnetoOne(targetEntity="HistoricoEscolar", orphanRemoval=true)
    * @JoinColumn(name="id_historico", referencedColumnName="id")
    **/
    private $historico;
    /**
     * @ManyToOne(targetEntity="Turma")
     * @JoinColumn(name="id_turma", referencedColumnName="id")
     */
    private $turma;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setDataDeNascimento($dataDeNascimento)
    {
        $this->dataDeNascimento = \DateTime::createFromFormat('d/m/Y', $dataDeNascimento);
    }

    public function setHistorico(HistoricoEscolar $historico)
    {
        $this->historico = $historico;
    }

    public function setTurma(Turma $turma)
    {
        $this->turma = $turma;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMatricula()
    {
        return $this->matricula;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getDataDeNascimento()
    {
        return $this->dataDeNascimento->format('d/m/Y');
    }

    public function getTurma()
    {
        return $this->turma;
    }
    
    public function getHistorico()
    {
        return $this->historico;
    }
}