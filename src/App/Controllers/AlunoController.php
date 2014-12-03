<?php

namespace App\Controllers;

class AlunoController extends Controller
{
    
    public function index()
    {
        $this->alunos = $this->model->getRepository()->findAll();
    }

    public function cadastrar()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)){
            
            if ($this->model->save($_POST))
                echo '<script>alert("Cadastrado com sucesso!");</script>';
            else
                echo '<script>alert("Erro ao cadastrar.");</script>';
        }
        
        $aluno = new $this->entity();
        $this->optionsTurma = $this->model->getOptionsTurma($aluno);
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
            $aluno = $this->model->getRepository()->find($id);
        }
        
        $aluno = empty($aluno) ? new $this->entity() : $aluno;
        
        $this->aluno = $aluno;
        $this->optionsTurma = $this->model->getOptionsTurma($aluno);
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
}