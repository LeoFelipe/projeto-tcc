<?php

namespace App\Controllers;

class ProfessorController extends Controller
{
    public function index()
    {
        $this->professores = $this->model->getRepository()->findAll();
    }
    
    public function cadastrar()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)){
            
            $post['matricula'] = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_NUMBER_INT);
            $post['nome'] = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $post['turmas'] = filter_input(INPUT_POST, 'turmas', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);

            if ($this->model->save($post))
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
            
            $post['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $post['matricula'] = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_NUMBER_INT);
            $post['nome'] = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $post['turmas'] = filter_input(INPUT_POST, 'turmas', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
            
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
        if ($id = (int) FrontController::getParams('id')) {
            
            if ($this->model->remover($id)) {
                echo '<script>alert("Excluído com sucesso!");</script>';
                echo "<script>window.location = '".PATH_ROOT."professor'</script>";
            } else {
                echo "<script>window.location = '".PATH_ROOT."professor'</script>";
            }
        }
    }

    public function excluirTurma()
    {
        $post['professorId'] = filter_input(INPUT_POST, 'professorId', FILTER_SANITIZE_NUMBER_INT);
        $post['turmaId'] = filter_input(INPUT_POST, 'turmaId', FILTER_SANITIZE_NUMBER_INT);

        if ($this->model->removerTurma($post)) {
            echo '<script>alert("Turma Excluída com sucesso!");</script>';
            echo "<script>window.location = '".PATH_ROOT."professor'</script>";
        } else {
            echo "<script>window.location = '".PATH_ROOT."professor'</script>";
        }
    }
}