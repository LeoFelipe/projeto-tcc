<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 * @Entity
 * @Table(name="professores")
 */
class Professor
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     **/
    private $id;
    /** @Column(type="integer") **/
    private $matricula;
    /** @Column(type="string") **/
    private $nome;
    /**
     * @ManyToMany(targetEntity="Turma", mappedBy="professores", fetch="EAGER")
     **/
    private $turmas;

    public function __construct()
    {
        $this->turmas = new ArrayCollection();
    }

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

    public function setTurmas($turmas)
    {
        $this->turmas = $turmas;
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

    public function getTurmas()
    {
        return $this->turmas;
    }
}