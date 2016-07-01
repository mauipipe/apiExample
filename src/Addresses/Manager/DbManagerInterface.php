<?php

namespace Addresses\Manager;

/**
 * @author davidcontavalli
 */
interface DbManagerInterface
{
    /**
     * @param string $table
     * @param array  $data
     */
    public function prepareSelect($table, $data = []);

    /**
     * @param string $table
     * @param array  $data
     */
    public function executeInsert($table, $data);

    /**
     * @param string $table
     * @param int    $id
     * @param array  $data
     */
    public function executeUpdate($table, $id, array $data);

    /**
     * @param string $table
     * @param int    $id
     */
    public function executeDelete($table, $id);

    /**
     * @return array
     */
    public function fetchAll();

    /**
     * @return array
     */
    public function fetch();
}
