<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Todo;

class ApiController extends Controller
{
    /**
     * Cria uma nova tarefa
     * @param Request $request
     * @return string[]
     */
    public function createTodo(Request $request) {
        $array = ['error' => ''];

        // Validações
        $rules = [
            'title' => 'required|min:3'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            $array['error'] = $validator->messages();
            return $array;
        }

        $title = $request->input('title');

        // Criando o registro no Banco de dados
        $todo = new Todo();
        $todo->title = $title;
        $todo->save();

        return $array;
    }

    /**
     * Retorna todos os dados das tarefas do servidor
     * @return string[]
     */
    public function readAllTodos() {
        $array = ['error' => ''];

        $array['list'] = Todo::all();

        return $array;
    }

    /**
     * Retorna uma única tarefa
     * @param $id
     * @return string[]
     */
    public function readTodo($id) {
        $array = ['error' => ''];

        $todo = Todo::find($id);

        if($todo) {
            $array['todo'] = $todo;
        }
        else {
            $array['error'] = "A tarefa $id não foi localizada!";
        }

        return $array;
    }


    public function updateTodo($id, Request $request) {
        $array = ['error' => ''];

        // Validando os dados
        $rules = [
            'title' => 'min:3',
            'done'  => 'boolean'
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $array['error'] = $validator->messages();
            return $array;
        }

        // Recebe os dados da requisição e armazena nas variáveis
        $title = $request->input('title');
        $done = $request->input('done');

        // Atualizando o item

        // Busca se existe uma tarefa pelo ID.
        $todo = Todo::find($id);

        if($todo) {

            if($title) {
                $todo->title = $title;
            }
            if($done) {
                $todo->done = $done;
            }
            // Salva.
            $todo->save();
        }
        else {
            $array['error'] = "Tarefa $id não existe, logo, não pode ser atualizada!";
        }

        return $array;
    }

    public function deleteTodo() {

    }


}
