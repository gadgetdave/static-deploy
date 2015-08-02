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
     * @param array $data
     *
     * @return array
     */
    public function fetchAll(array $data);

    /**
     * @param string | int $id
     * @throws \Exception
     *
     * @return boolean
     */
    public function delete($id);
}