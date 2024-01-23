<?php

namespace App\Http\Controllers;

use App\Http\Requests\Todo\StoreTodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;
use App\Http\Resources\Todo\TodoCollection;
use App\Http\Resources\Todo\TodoResource;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Info;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\SecurityScheme;
use OpenApi\Attributes\Server;
use Throwable;

#[Info(version: "0.1", title: "My First API")]
#[Server(url: 'api.todo.loc', description: 'Local')]
#[SecurityScheme(securityScheme: 'bearerAuth', type: 'http', bearerFormat: 'JWT', scheme: 'bearer')]
class TodoController extends Controller
{
    /**
     * @param TodoService $todoService
     */
    public function __construct(public TodoService $todoService) {}


//    #[Info(version: '1.0', title: 'Todo2')]

    /**
     * @return TodoCollection
     */
    #[Get(
        path: '/api/todos',
        security: [['bearerAuth' => []]],
        responses: [
            new Response(response: 200, description: 'AOK', content: new MediaType(mediaType: 'application/json', schema: new Schema(ref: "#/components/schemas/TodoCollection"))),
            new Response(response: 401, description: 'Not allowed'),
        ]
    )]
    public function index(): TodoCollection
    {
        $todos = Todo::query()->get();

        return new TodoCollection($todos);
    }

    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    #[Post(
        path: '/api/todos',
        security: [['bearerAuth' => []]],
        requestBody: new RequestBody(ref: '#/components/requestBodies/StoreTodoRequest'),
        responses: [
            new Response(response: 200, description: 'AOK', content: new MediaType(mediaType: 'application/json', schema: new Schema(ref: "#/components/schemas/TodoResource"))),
            new Response(response: 401, description: 'Not allowed'),
        ]
    )]
    public function store(StoreTodoRequest $request): TodoResource
    {
        $todo = $this->todoService->create($request->toDTO());

        activityLog($todo, 'Пользователь создал todo', 'toto',);


        return new TodoResource($todo);
    }

    /**
     * Display the specified resource.
     */
    #[Get(
        path: '/api/todos/{todo_id}',
        security: [['bearerAuth' => []]],
        parameters: [
            new Parameter(name: 'todo_id', description: 'id of todo', in: 'path', required: true, schema: new Schema(type: 'integer'))
        ],
        responses: [
            new Response(response: 200, description: 'AOK', content: new MediaType(mediaType: 'application/json', schema: new Schema(ref: "#/components/schemas/TodoResource"))),
            new Response(response: 401, description: 'Not allowed'),
        ]
    )]
    public function show(Todo $todo): TodoResource
    {
        return new TodoResource($todo);
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    #[Put(
        path: '/api/todos/{todo_id}',
        security: [['bearerAuth' => []]],
        requestBody: new RequestBody(ref: '#/components/requestBodies/UpdateTodoRequest'),
        parameters: [
            new Parameter(name: 'todo_id', description: 'id of todo', in: 'path', required: true, schema: new Schema(type: 'integer'))
        ],
        responses: [
            new Response(response: 200, description: 'AOK', content: new MediaType(mediaType: 'application/json', schema: new Schema(ref: "#/components/schemas/TodoResource"))),
            new Response(response: 401, description: 'Not allowed'),
        ]
    )]
    public function update(UpdateTodoRequest $request, Todo $todo): TodoResource
    {
        $this->todoService->update($todo, $request->toDTO());

        activityLog($todo, 'Пользователь обновил todo', 'toto',);


        return new TodoResource($todo);
    }

    #[Delete(
        path: '/api/todos/{todo_id}',
        security: [['bearerAuth' => []]],
        parameters: [
            new Parameter(name: 'todo_id', description: 'id of todo', in: 'path', required: true, schema: new Schema(type: 'integer'))
        ],
        responses: [
            new Response(response: 204, description: 'Empty'),
            new Response(response: 401, description: 'Not allowed'),
        ]
    )]
    /**
     * @param Todo $todo
     * @return JsonResponse
     */
    public function destroy(Todo $todo): JsonResponse
    {
        $todo->delete();

        activityLog($todo, 'Пользователь удалил todo', 'toto',);


        return $this->respondEmpty();
    }
}
