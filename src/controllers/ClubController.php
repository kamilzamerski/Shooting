<?php

namespace App\Controllers;

use App\Models\ClubModel;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class ClubController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get(Request $req, Response $res, array $args)
    {
        $objClub = ClubModel::getById((int)$args['id']);
        if ($objClub) {
            return $res->withHeader(
                'Content-Type',
                'application/json'
            )->withJson($objClub->toArray(), 200);
        }
        $data = ['status' => 'success', 'data' => null];
        return $res->withJson($data);
    }

    public function post(Request $req, Response $res, array $args)
    {
        $objClub = ClubModel::addClub($req->getParams());
        if ($objClub) {
            return $res->withHeader(
                'Content-Type',
                'application/json'
            )->withJson(['status' => 'success', 'data' => $objClub->toArray()], 200);
        }
        return $res->withJson(['status' => 'error', 'type' => 'Unknown error']);
    }

    public function put(Request $req, Response $res, array $args)
    {
        $objClub = ClubModel::updateClub($args['id'], $req->getParams());
        if ($objClub) {
            return $res->withHeader(
                'Content-Type',
                'application/json'
            )->withJson(['status' => 'success', 'data' => $objClub->toArray()], 200);
        }
        return $res->withJson(['status' => 'error', 'type' => 'Unknown error']);
    }
    public function delete(Request $req, Response $res, array $args)
    {
        $objClub = ClubModel::deleteById((int)$args['id']);
        if ($objClub) {
            return $res->withHeader(
                'Content-Type',
                'application/json'
            )->withJson(['status' => 'success', 'data' => null], 200);
        }
        return $res->withJson(['status' => 'error', 'type' => 'Unknown error']);
    }

}