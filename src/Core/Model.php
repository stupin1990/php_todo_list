<?php

namespace Src\Core;

use Src\Core\DB;
use Src\Core\Config;

class Model
{
    protected static string $table_name;

    public static function selectPaginate(array $select = [], int $page = 1, string $order = '', int $per_page = 3): array
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

    public static function getOrder(string $order): string
    {
        if (!isset(static::$sort_ar[$order])) {
            $order = 'id_desc';
        }
        $order = strtoupper(str_replace('_', ' ', $order));

        return $order;
    }

    public static function save(array $fields, array $values, int $id = 0) : bool
    {
        if ($id) {
            $query = "SELECT `" . implode('`,`', $fields) ."` FROM `" . static::$table_name . "` WHERE id = $id";
            $current = DB::getRow($query);
            if (!$current) {
                return true;
            }

            $update_ar = $values_ar = [];
            $updated = false;
            foreach ($fields as $field) {
                if (isset($current[$field]) && $current[$field] != $values[':' . $field]) {
                    if ($field != 'updated_by') {
                        $updated = true;
                    }
                    $update_ar[] = "`$field` = :$field";
                    $values_ar[":$field"] = $values[':' . $field];
                }
            }
            $update_ar[] = '`updated_at` = NOW()';

            if ($updated) {
                $query = "UPDATE `" . static::$table_name . "` SET " . implode(', ', $update_ar) . " WHERE id = $id";
                return DB::updateRow($query, $values_ar);
            }

            return true;
        }

        $query = "INSERT INTO `" . static::$table_name . "` (`" . implode('`,`', $fields) ."`) VALUES (" . implode(",", array_keys($values)) . ")";
        return DB::insertRow($query, $values);
    }

    public static function delete(array $ids) : bool
    {
        $query = "DELETE FROM `" . static::$table_name . "` WHERE id IN (" . implode(',', $ids) . ")";
        return DB::deleteRow($query);
    }
}
