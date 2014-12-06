<?php

namespace App\Models;

use App\Entities\Professor as ProfEntity,
    App\Entities\Turma as Turma;

class Professor extends Model
{
    private $entityTurma = 'App\Entities\Turma';
    
    public function getOptionsTurma(ProfEntity $professor)
    {
        $html = '';
        foreach($turmas as $turma)
        {
            $id = ($professor->getTurma() == null) ? 0 : $professor->getTurma()->getId();
            $selected = ($turma->getId() == $id) ? 'selected' : '';
            $html .= "<option value='{$turma->getId()}' {$selected}>{$turma->getNome()}</option>";
        }
        return $html;
    }
    
    private function _getOptionsTurma(ProfEntity $professor)
    {
//        $em = $GLOBALS['em'];
//        $query = $em->createQuery("select t from App\Entities\Turma t");
//        $turmas = $query->getResult();
        $turmas = $this->getRepository($this->entityTurma)->findAll();

        $turmasProfessor = $professor->getTurmas();
        $turmasProfessor = empty($turmasProfessor) ? array() : $turmasProfessor;
        
        $html = '';
        foreach($turmas as $turma){
            $selected = '';
            foreach($turmasProfessor as $turmaProfessor){
                if ($turmaProfessor->getId() == $turma->getId())
                {
                    $selected = ' selected ';
                    break;
                }
            }
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
        $turmas = (int) $request['turmas'];
        
        $this->em->getConnection()->beginTransaction();        
        try
        {
            $professor = isset($id) ? $this->getRepository()->find($id) : new $this->entity();
            $professor->setMatricula($matricula);
            $professor->setNome($nome);
            
            foreach($turmas as $index => $idTurma) {
                
                $turma = $this->getRepository($this->entityTurma)->find($idTurma);
                if (!$professor->getTurmas()->contains($turma))
                    $professor->getTurmas()->add($turma);

                if (!$turma->getProfessores()->contains($professor))
                    $turma->getProfessores()->add($professor);
            }
                        
            $this->em->persist($professor);
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
    
    public function gravar()
    {
        $professor = $em->find('App\\Entities\\Professor',$id);
        $professor = empty($professor) ? new professor() : $professor;
        $professor->setMatricula($matricula);
        $professor->setNome($nome);

        foreach($turmas as $index => $turma)
        {
            $turma = $em->find('App\\Entities\\Turma',$turma);
            if (!$professor->getTurmas()->contains($turma))
                $professor->getTurmas()->add($turma);
            
            if (!$turma->getProfessores()->contains($professor))
                $turma->getProfessores()->add($professor);
        }

        $em->persist($professor);

        $mensagem = 'Professor gravado com sucesso!';
        try
        {
            $em->flush();
        }
        catch(Exception $e)
        {
            $mensagem = 'Ocorreu um erro: ' . $e->getMessage();
        }
        $this->mensagem = $mensagem;
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
