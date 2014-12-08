<?php

namespace App\Controllers;

class TurmaController extends Controller
{
    public function index()
    {
        $this->turmas = $this->model->getRepository()->findAll();
    }

    public function cadastrar()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)){
            
            $post['nome'] = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            
            if ($this->model->save($post))
                echo '<script>alert("Cadastrado com sucesso!");</script>';
            else
                echo '<script>alert("Erro ao cadastrar.");</script>';
        }
    }
    
    public function editar()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)){
            
            $post['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $post['nome'] = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            
            if ($this->model->save($post)){
                echo '<script>alert("Editado com sucesso!");</script>';
                echo "<script>window.location = 'index'</script>";
            } else {
                echo '<script>alert("Erro ao editar.");</script>';
                echo "<script>window.location = 'index'</script>";
            }
        }
        
        if ($id = FrontController::getParams('id')) {
            
            $id = (int) !empty($id) ? $id : 0;
            $turma = $this->model->getRepository()->find($id);
            
            $this->turma = empty($turma) ? new $this->entity() : $turma;
        }
    }
    
    public function excluir()
    {
        if ($id = FrontController::getParams('id')) {
            
            if ($this->model->remover($id)) {
                echo '<script>alert("Excluído com sucesso!");</script>';
                echo "<script>window.location = '".PATH_ROOT."/turma'</script>";
            } else {
                echo '<script>alert("Erro ao excluir.");</script>';
                echo "<script>window.location = '".PATH_ROOT."/turma'</script>";
            }
        }
    }
}