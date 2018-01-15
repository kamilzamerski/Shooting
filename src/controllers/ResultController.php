<?php

namespace App\Controllers;

use App\Models\Results\Abstracts\BaseResultModel;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class ResultController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get(Request $req, Response $res, array $args)
    {
        $objResult = BaseResultModel::getById((int)$args['id']);
        if ($objResult) {
            return $res->withHeader(
                'Content-Type',
                'application/json'
            )->withJson($objResult->toArray(), 200);
        }
        $data = ['status' => 'success', 'data' => null];
        return $res->withJson($data);
    }

    public function post(Request $req, Response $res, array $args)
    {
        $objResult = BaseResultModel::addResult($req->getParams());
        if ($objResult) {
            return $res->withHeader(
                'Content-Type',
                'application/json'
            )->withJson(['status' => 'success', 'data' => $objResult->toArray()], 200);
        }
        return $res->withJson(['status' => 'error', 'type' => 'Unknown error']);
    }

    public function put(Request $req, Response $res, array $args)
    {
        $objResult = BaseResultModel::updateResult($args['id'], $req->getParams());
        if ($objResult) {
            return $res->withHeader(
                'Content-Type',
                'application/json'
            )->withJson(['status' => 'success', 'data' => $objResult->toArray()], 200);
        }
        return $res->withJson(['status' => 'error', 'type' => 'Unknown error']);
    }
    public function delete(Request $req, Response $res, array $args)
    {
        $objResult = BaseResultModel::deleteById((int)$args['id']);
        if ($objResult) {
            return $res->withHeader(
                'Content-Type',
                'application/json'
            )->withJson(['status' => 'success', 'data' => null], 200);
        }
        return $res->withJson(['status' => 'error', 'type' => 'Unknown error']);
    }

}