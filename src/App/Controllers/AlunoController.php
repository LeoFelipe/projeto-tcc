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
            
            $post['turma'] = filter_input(INPUT_POST, 'turma', FILTER_SANITIZE_NUMBER_INT);
            $post['matricula'] = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_NUMBER_INT);
            $post['nome'] = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $post['data_de_nascimento'] = filter_input(INPUT_POST, 'data_de_nascimento', FILTER_SANITIZE_STRING);
            
            if ($this->model->save($post))
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
            
            $post['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $post['turma'] = filter_input(INPUT_POST, 'turma', FILTER_SANITIZE_NUMBER_INT);
            $post['matricula'] = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_NUMBER_INT);
            $post['nome'] = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $post['data_de_nascimento'] = filter_input(INPUT_POST, 'data_de_nascimento', FILTER_SANITIZE_STRING);
            
            if ($this->model->save($post)) {
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
                echo "<script>window.location = '".PATH_ROOT."/aluno'</script>";
            } else {
                echo '<script>alert("Erro ao excluir.");</script>';
                echo "<script>window.location = '".PATH_ROOT."/aluno'</script>";
            }
        }
    }
}