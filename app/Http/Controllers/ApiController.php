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
     * @author Pierri Alexander Vidmar
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
     * @author Pierri Alexander Vidmar
     */
    public function readAllTodos() {
        $array = ['error' => ''];

        // PAGINAÇÃO: Buscamos os itens com limite de 2 itens por página
        $todos = Todo::simplePaginate(2);

        // Se quiser uma condição na paginação
        // $todos = Todo::where('done', 1)->simplePaginate(2);

        // Armazenamos em list os itens
        $array['list'] = $todos->items();

        // Mostra a página atual
        $array['current_page'] = $todos->currentPage();

        return $array;
    }


    /**
     * Retorna uma única tarefa
     * @param $id
     * @return string[]
     * @author Pierri Alexander Vidmar
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


    /**
     * Realiza a atualização de uma única tarefa.
     * @param $id
     * @param Request $request
     * @return string[]
     * @author Pierri Alexander Vidmar
     */
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
            if($done !== NULL) {
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


    /**
     * Realiza a exclusão de uma única tarefa.
     * @param $id
     * @return string[]
     * @author Pierri Alexander Vidmar
     */
    public function deleteTodo($id) {
        $array = ['error' => ''];

        $todo = Todo::find($id);
        $todo->delete();

        return $array;
    }


}
