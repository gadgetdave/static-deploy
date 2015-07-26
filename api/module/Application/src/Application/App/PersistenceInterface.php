<?php

namespace MyApp\App;

interface PersistenceInterface
{
    public function save(array $data);
    public function fetch($id);
    public function fetchAll();
}