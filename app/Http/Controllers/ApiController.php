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


    public function updateTodo() {

    }

    public function deleteTodo() {

    }


}
