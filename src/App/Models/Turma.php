<?php

namespace App\Models;

use App\Entities\Turma as TurmaEntity;

class Turma extends Model
{
    
    public function save(Array $post)
    {
        if (isset($post['id']))
            $id = (int) $post['id'];
        
        $nome = $post['nome'];
        
        $this->em->getConnection()->beginTransaction();        
        try
        {
            $turma = isset($id) ? $this->getRepository()->find($id) : new $this->entity();            
            $turma->setNome($nome);
            
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
    
    public function remover($id)
    {
        $this->em->getConnection()->beginTransaction();        
        try
        {
            $turma = $this->getRepository()->find($id);
            $this->em->remove($turma);
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
