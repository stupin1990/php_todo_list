<?php

namespace Src\Core;

use Src\Core\DB;
use Src\Core\Config;

abstract class Model
{
    /**
     * @var string model table name
     */
    protected static string $table_name;

    /**
     * @var array fields that should set single value when updates
     */
    protected static array $default_values;

    /**
     * @var array fields that shouldn't effects on update
     */
    protected static array $not_to_update_fields;

    /**
     * Get defined fields from table for given page
     * @param array $select - fields to select
     * @param int $page - page number
     * @param string $order - order by expression
     * @param int $per_page - items per page
     * 
     * @return array ['data' => [], 'pages' => int, 'current_page' => int, 'next_page' => int, 'prev_page' => int, 'per_page' => int, 'total' => int  ]
     */
    public static function selectPaginate(array $select, int $page = 1, string $order = '', int $per_page = 3): array
    {
        $order = static::getOrder($order);

        $total = DB::getRow("SELECT COUNT(*) AS total FROM `" . static::$table_name . "`");
        $total = $total['total'];

        $pages = ceil($total / $per_page);

        $page = $page > $pages ? $pages : $page;

        $from = $per_page * ($page - 1);

        $data = DB::getRows("SELECT `" . implode('`,`', $select) . "` FROM `" . static::$table_name . "` ORDER BY $order LIMIT $from, $per_page");
        if ($data === false) {
            $data = [];
        }

        $next_page = $page + 1;
        $prev_page = $page - 1;

        return [
            'data' => $data,
            'pages' => $pages,
            'current_page' => $page,
            'next_page' => $next_page > $pages ? $pages : $next_page,
            'prev_page' => $prev_page < 1 ? 1 : $prev_page,
            'per_page' => $per_page,
            'total' => $total
        ];
    }

    /**
     * Get available order by expression for request
     * @param string $order
     * 
     * @return string
     */
    public static function getOrder(string $order): string
    {
        if (!isset(static::$sort_ar[$order])) {
            $order = 'id_desc';
        }
        $order = strtoupper(str_replace('_', ' ', $order));

        return $order;
    }

    /**
     * Save new record to table
     * @param array $fields - fields to select
     * @param array $values - values array
     * 
     * @return bool
     */
    public static function save(array $fields, array $values) : bool
    {
        $query = "INSERT INTO `" . static::$table_name . "` (`" . implode('`,`', $fields) ."`) VALUES (" . implode(",", array_keys($values)) . ")";
        return DB::insertRow($query, $values);
    }

    /**
     * Update existed record in table
     * @param int $id
     * @param array $fields
     * @param array $values
     * 
     * @return bool
     */
    public static function update(int $id, array $fields, array $values) : bool
    {
        $query = "SELECT `" . implode('`,`', $fields) ."` FROM `" . static::$table_name . "` WHERE id = $id";
        $current = DB::getRow($query);
        if (!$current) {
            return false;
        }

        $update_ar = $values_ar = [];
        $updated = false;
        foreach ($fields as $field) {
            if ($current[$field] != $values[':' . $field]) {
                if (!$updated && !in_array($field, static::$not_to_update_fields)) {
                    $updated = true;
                }
                if (!empty(static::$default_values[$field])) {
                    $update_ar[] = "`$field` = " . static::$default_values[$field];
                }
                else {
                    $update_ar[] = "`$field` = :$field";
                    $values_ar[":$field"] = $values[':' . $field];
                }
            }
        }

        if ($updated) {
            $query = "UPDATE `" . static::$table_name . "` SET " . implode(', ', $update_ar) . " WHERE id = $id";
            return DB::updateRow($query, $values_ar);
        }

        return true;
    }

    /**
     * Delete records with given ids from table
     * @param array $ids - array of ids to delete from table
     * 
     * @return bool
     */
    public static function delete(array $ids = []) : bool
    {
        if (!count($ids)) {
            return true;
        }

        $query = "DELETE FROM `" . static::$table_name . "` WHERE id IN (" . implode(',', $ids) . ")";
        return DB::deleteRow($query);
    }
}
