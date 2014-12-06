<?php

namespace App\Controllers;

class ProfessorController extends Controller
{
    public function index()
    {
        $this->professores = $this->model->getRepository()->findAll();
        var_dump($this->professores);
    }
    
    public function getTurmasProfessor($professor)
    {
        $html = '';
        foreach($professor->getTurmas() as $turma)
            $html .= "<option value='{$turma->getId()}'>{$turma->getNome()}</option>";
        return $html;
    }
    
    public function cadastrar()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)){
            
            if ($this->model->save($_POST))
                echo '<script>alert("Cadastrado com sucesso!");</script>';
            else
                echo '<script>alert("Erro ao cadastrar.");</script>';
        }
        
        $professor = new $this->entity();
        $this->optionsTurma = $this->model->getOptionsTurma($professor);
    }
    
    public function editar()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)){
            
            if ($this->model->save($_POST)) {
                echo '<script>alert("Editado com sucesso!");</script>';
                echo "<script>window.location = 'index'</script>";
            } else {
                echo '<script>alert("Erro ao editar.");</script>';
                echo "<script>window.location = 'index'</script>";
            }
        }
        
        if ($id = FrontController::getParams('id')) {
            $id = (int) !empty($id) ? $id : 0;
            $professor = $this->model->getRepository()->find($id);
        }
        
        $professor = empty($professor) ? new Professor() : $professor;

        $this->professor = $professor;
        $this->optionsTurma = $this->model->getOptionsTurma($professor);
    }
    
    public function excluir()
    {
        if ($id = FrontController::getParams('id')) {
            
            if ($this->model->remover($id)) {
                echo '<script>alert("Excluído com sucesso!");</script>';
                echo "<script>window.location = '/tcc/aluno'</script>";
            } else {
                echo '<script>alert("Erro ao excluir.");</script>';
                echo "<script>window.location = '/tcc/aluno'</script>";
            }
        }
    }

    public function excluirTurma()
    {
        $idProfessor = $_POST['professor'];
        $idTurma = $_POST['turma'];

        $em = $GLOBALS['em'];

        $professor = $em->find('App\\Entities\\Professor',$idProfessor);
        $turma = $em->find('App\\Entities\\Turma',$idTurma);
        $turma->getProfessores()->removeElement($professor);
        $professor->getTurmas()->removeElement($turma);

        $em->persist($turma);

        $this->mensagem = 'Turma removida';
        try
        {
            $em->flush();
        }
        catch (Exception $e)
        {
            $mensagem = 'Ocorreu um erro: ' . $e->getMessage();
        }
        $this->professor = $professor;
    }
}