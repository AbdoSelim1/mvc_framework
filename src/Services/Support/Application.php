<?php

namespace Src\Services\Support;



use Dotenv\Dotenv;
use Src\Database\Apis\DB;
use Src\Http\Routes\Route;
use Src\Http\Request\Request;
use Src\Http\Response\Response;
use Src\Database\DatabaseMangers\MYSQLManger;
use Src\Database\DatabaseGerammers\MYSQLGerammer;

class Application
{
    public Request $request;
    public Response $response;
    public Route $route;
    public Dotenv $env;
    public DB $db;

    public function __construct()
    {
        $this->request = new Request;
        $this->response = new Response;
        $this->route = new Route($this->request, $this->response);
        $this->env = Dotenv::createImmutable(base_path(""));
        $this->db = new DB($this->getDatabaseDrivier());
    }

    public function run()
    {
        $this->route->resolve();
        $this->env->safeLoad();
        $this->db->init();
    }

    private function getDatabaseDrivier()
    {
        return match (env('DB_DRIVER')) {
            'mysql' => new MYSQLManger(new MYSQLGerammer),
            default => new MYSQLManger(new MYSQLGerammer)
        };
    }
}
