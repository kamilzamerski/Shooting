<?php

namespace App\Controllers;

use App\Models\ShooterModel;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class ShooterController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get(Request $req, Response $res, array $args)
    {
        $objShooter = ShooterModel::getById((int)$args['id']);
        if ($objShooter) {
            return $res->withHeader(
                'Content-Type',
                'application/json'
            )->withJson($objShooter->toArray(), 200);
        }
        $data = ['status' => 'success', 'data' => null];
        return $res->withJson($data);
    }

    public function post(Request $req, Response $res, array $args)
    {
        $objShooter = ShooterModel::addShooter($req->getParams());
        if ($objShooter) {
            return $res->withHeader(
                'Content-Type',
                'application/json'
            )->withJson(['status' => 'success', 'data' => $objShooter->toArray()], 200);
        }
        return $res->withJson(['status' => 'error', 'type' => 'Unknown error']);
    }

    public function put(Request $req, Response $res, array $args)
    {
        $objShooter = ShooterModel::updateShooter($args['id'], $req->getParams());
        if ($objShooter) {
            return $res->withHeader(
                'Content-Type',
                'application/json'
            )->withJson(['status' => 'success', 'data' => $objShooter->toArray()], 200);
        }
        return $res->withJson(['status' => 'error', 'type' => 'Unknown error']);
    }
    public function delete(Request $req, Response $res, array $args)
    {
        $objShooter = ShooterModel::deleteById((int)$args['id']);
        if ($objShooter) {
            return $res->withHeader(
                'Content-Type',
                'application/json'
            )->withJson(['status' => 'success', 'data' => null], 200);
        }
        return $res->withJson(['status' => 'error', 'type' => 'Unknown error']);
    }

}