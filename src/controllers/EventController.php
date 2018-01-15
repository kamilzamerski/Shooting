<?php

namespace App\Controllers;

use App\Models\EventModel;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class EventController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get(Request $req, Response $res, array $args)
    {
        $objEvent = EventModel::getById((int)$args['id']);
        if ($objEvent) {
            return $res->withHeader(
                'Content-Type',
                'application/json'
            )->withJson($objEvent->toArray(), 200);
        }
        $data = ['status' => 'success', 'data' => null];
        return $res->withJson($data);
    }

    public function post(Request $req, Response $res, array $args)
    {
        $objEvent = EventModel::addEvent($req->getParams());
        if ($objEvent) {
            return $res->withHeader(
                'Content-Type',
                'application/json'
            )->withJson(['status' => 'success', 'data' => $objEvent->toArray()], 200);
        }
        return $res->withJson(['status' => 'error', 'type' => 'Unknown error']);
    }

    public function put(Request $req, Response $res, array $args)
    {
        $objEvent = EventModel::updateEvent($args['id'], $req->getParams());
        if ($objEvent) {
            return $res->withHeader(
                'Content-Type',
                'application/json'
            )->withJson(['status' => 'success', 'data' => $objEvent->toArray()], 200);
        }
        return $res->withJson(['status' => 'error', 'type' => 'Unknown error']);
    }
    public function delete(Request $req, Response $res, array $args)
    {
        $objEvent = EventModel::deleteById((int)$args['id']);
        if ($objEvent) {
            return $res->withHeader(
                'Content-Type',
                'application/json'
            )->withJson(['status' => 'success', 'data' => null], 200);
        }
        return $res->withJson(['status' => 'error', 'type' => 'Unknown error']);
    }

}