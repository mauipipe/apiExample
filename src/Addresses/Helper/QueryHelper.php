<?php

namespace Addresses\Helper;

/**
 * @author davidcontavalli
 */
class QueryHelper
{
    /**
     * @param array $data
     * @param array $optionalParams
     *
     * @return array
     */
    public static function getMappedParams(array $data, array $optionalParams = [])
    {
        $mappedParams = [];
        foreach (array_keys($data) as $key) {
            $mappedParams[':'.$key] = $data[$key];
        }

        return array_merge($mappedParams, $optionalParams);
    }

    /**
     * @param $boundParams
     *
     * @return null|string
     */
    public static function createWhereQuery($boundParams)
    {
        $whereQuery = null;
        if (!empty($boundParams)) {
            $whereQueryParts = [];
            foreach ($boundParams as $key => $value) {
                $whereQueryParts[] = sprintf('%s=:%s', $key, $key);
            }
            $whereQuery = ' WHERE '.implode(' AND ', $whereQueryParts);
        }

        return $whereQuery;
    }

    /**
     * @param array $data
     *
     * @return string
     */
    public static function createSetQuery(array $data)
    {
        $setQueryPart = [];
        foreach ($data as $key => $value) {
            $setQueryPart[] = sprintf('%s = :%s', $key, $key);
        }

        return implode(', ', $setQueryPart);
    }
}
