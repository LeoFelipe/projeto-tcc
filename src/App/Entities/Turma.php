<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 * @Entity
 * @Table(name="turmas")
 */
class Turma
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     **/
    private $id;
    /** @Column(type="string") **/
    private $nome;
    /** @OneToMany(targetEntity="Aluno", mappedBy="turma")  **/
    private $alunos;
    /**
     * @ManyToMany(targetEntity="Professor", fetch="EAGER")
     * @JoinTable(name="professores_turma",
     * joinColumns={@JoinColumn(name="id_turma",referencedColumnName="id")},
     * inverseJoinColumns={@JoinColumn(name="id_professor",referencedColumnName="id")}
     * )
     **/
    private $professores;

    public function __construct()
    {
        $this->professores = new ArrayCollection();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setAlunos($alunos)
    {
        $this->alunos = $alunos;
    }

    public function setProfessores($professores)
    {
        $this->professores = $professores;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getAlunos()
    {
        return $this->alunos;
    }

    public function getProfessores()
    {
        return $this->professores;
    }
}