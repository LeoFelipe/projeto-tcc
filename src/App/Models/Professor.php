<?php

namespace App\Models;

use App\Entities\Professor as ProfEntity,
    App\Entities\Turma as Turma;

class Professor extends Model
{
    private $entityTurma = 'App\Entities\Turma';
    
    public function getOptionsTurma(ProfEntity $professor = null)
    {
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
    
    public function save(Array $post)
    {
        if (isset($post['id']))
            $id = (int) $post['id'];
        
        if (!empty($post['turmas']))
            $turmas = $post['turmas'];
        
        $matricula = $post['matricula'];
        $nome = $post['nome'];
        
        $this->em->getConnection()->beginTransaction();        
        try
        {
            $professor = isset($id) ? $this->getRepository()->find($id) : new $this->entity();
            $professor->setMatricula($matricula);
            $professor->setNome($nome);
            
            if ($professor->getTurmas()->count() > 0)
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
    
    public function removerTurma(Array $post)
    {
        $professorId = (int) $post['professorId'];
        $turmaId = (int) $post['turmaId'];
        
        $this->em->getConnection()->beginTransaction();        
        try
        {
            $professor = $this->getRepository()->find($professorId);
            $turma = $this->getRepository($this->entityTurma)->find($turmaId);
            
            $turma->getProfessores()->removeElement($professor);
            $professor->getTurmas()->removeElement($turma);

            $this->em->persist($turma);
            
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
