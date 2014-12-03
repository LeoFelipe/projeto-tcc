<?php

namespace App\Models;

use App\Entities\Aluno as AlunoEntity,
    App\Entities\HistoricoEscolar as HistoricoEscolar;

class Aluno extends Model
{
    private $entityTurma = 'App\Entities\Turma';
    
    public function getOptionsTurma(AlunoEntity $aluno)
    {
        $turmas = $this->getRepository($this->entityTurma)->findAll();

        $html = '';
        foreach($turmas as $turma)
        {
            $id = ($aluno->getTurma() == null) ? 0 : $aluno->getTurma()->getId();
            $selected = ($turma->getId() == $id) ? 'selected' : '';
            $html .= "<option value='{$turma->getId()}' {$selected}>{$turma->getNome()}</option>";
        }
        return $html;
    }
    
    public function save(Array $request)
    {
        if (isset($request['id']))
            $id = (int) $request['id'];
        
        $matricula = $request['matricula'];
        $nome = $request['nome'];
        $dataDeNascimento = $request['data_de_nascimento'];
        $idTurma = (int) $request['turma'];
        
        $this->em->getConnection()->beginTransaction();        
        try
        {
            $turma = $this->getRepository($this->entityTurma)->find($idTurma);
            
            $aluno = isset($id) ? $this->getRepository()->find($id) : new $this->entity();
            
            $aluno->setMatricula($matricula);
            $aluno->setNome($nome);
            $aluno->setDataDeNascimento($dataDeNascimento);
            $aluno->setTurma($turma);
            
            if (empty($id))
            {
                $historico = new HistoricoEscolar();
                $historico->setObservacoes('');
                $this->em->persist($historico);
                $aluno->setHistorico($historico);
            }
            
            $this->em->persist($aluno);
            $this->em->flush();
            $this->em->getConnection()->commit();
            return true;
        }
        catch (Exception $e)
        {
            $this->em-->getConnection()->rollback();
            $this->em-->close();
            return false;
        }
    }
    
    public function remover($id)
    {
        $this->em->getConnection()->beginTransaction();        
        try
        {
            $aluno = $this->getRepository()->find($id);
            $this->em->remove($aluno);
            $this->em->flush();
            $this->em->getConnection()->commit();
            return true;
        }
        catch (Exception $e)
        {
            $this->em-->getConnection()->rollback();
            $this->em-->close();
            return false;
        }
    }
}
