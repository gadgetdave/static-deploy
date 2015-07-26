<?php

namespace MyApp\Resource;

interface PersistenceInterface
{
    public function create(array $data);
    public function update($id, array $data);
    public function fetch($id);
    public function fetchAll();
}