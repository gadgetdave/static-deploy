<?php

namespace StaticDeploy\Resource;

interface PersistenceInterface
{
    /**
     * @param array $data
     */
    public function create(array $data);

    /**
     * @param string | int $id
     * @param array $data
     */
    public function update($id, array $data);

    /**
     * @param string | int $id
     */
    public function fetch($id);

    /**
     * @return array
     */
    public function fetchAll();

    /**
     * @param string | int $id
     * @throws \Exception
     *
     * @return boolean
     */
    public function delete($id);
}