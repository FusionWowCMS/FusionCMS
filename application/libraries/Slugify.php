<?php

use App\Config\Database;

class Slugify
{
    private Controller $CI;

    /** @var string */
    protected static string $table;

    /** @var string */
    protected static string $primaryKey;

    /** @var string */
    protected static string $separator;

    /** @var string */
    protected static string $model;

    /** @var Slugify */
    protected static Slugify $onlyInstance;

    /** @var int */
    protected static int $updateTo;

    /** @var array */
    protected static array $latin = ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'ç', 'ü', 'à', 'è', 'ì', 'ò', 'ù', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'Ç', 'Ü', 'À', 'È', 'Ì', 'Ò', 'Ù'];

    /** @var array */
    protected static array $plain = ['a', 'e', 'i', 'o', 'u', 'n', 'c', 'u', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'N', 'C', 'U', 'A', 'E', 'I', 'O', 'U'];

    /**
     * Define our paths and objects
     */
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->helper(['url', 'text']);
    }

    protected static function getSelf(): Slugify
    {
        if (static::$onlyInstance === null) {
            static::$onlyInstance = new Slugify;
        }
        return static::$onlyInstance;
    }

    /**
     * Return the name of the table on the chain.
     *
     * @param string $name Name of the table
     * @param string $primaryKey Primary key of the table
     * @return Slugify
     */
    public static function table(string $name, string $primaryKey = 'id'): Slugify
    {
        static::$table = $name;
        static::$primaryKey = $primaryKey;
        return static::getSelf();
    }

    /**
     * Return an object of the Model
     *
     * @param string $name instance of the model
     * @param string $primaryKey of the model table
     * @return Slugify
     */

    public static function model(string $name, string $primaryKey = 'id'): Slugify
    {
        static::$model = $name;
        static::$primaryKey = $primaryKey;
        return static::getSelf();
    }

    /**
     * Return a final result of generating unique slug
     *
     * @param string $string String value from title or other text
     * @param string $field field name of the given table
     * @return string
     * @throws Exception
     */

    public static function make(string $string, string $field = 'slug'): string
    {
        if (!$string) {
            throw new Exception('Defining string on make() is required');
        }

        if (!$field) {
            throw new Exception('Defining field on make() is required');
        }

        if (!self::$model && !self::$table) {
            throw new Exception(' "table()" or "model()" method on chain is required');
        }

        if (self::$model && self::$table) {
            throw new Exception('Only one function allowed on the chain. Choose "table()" or "model()"');
        }
        $db = Database::connect();
        $_separator = (self::$separator && is_string(self::$separator)) ? self::$separator : '-';
        $slug = self::latinToPlain($string);

        $_table_model = null;
        $slug = strtolower(url_title(convert_accented_characters($slug), $_separator));
        $slug = reduce_multiples($slug, $_separator, true);

        $params = [];
        $params[$field] = $slug;
        $prm_ky = self::$primaryKey;

        if (self::$table) $_table_model = $db->table(self::$table);

        if (self::$model && is_string(self::$model)) $_table_model = new self::$model;

        $sid = (self::$updateTo && is_int(self::$updateTo)) ? self::$updateTo : '';

        return self::check_slug($_table_model, $field, $slug, $params, $_separator, $sid);
    }

    private static function check_slug($model, $field, $slug, $params, $separator, $id, $count = 0)
    {
        $new_slug = ($count > 0) ? $slug . $separator . $count : $slug;
        $pk = self::$primaryKey;
        $query = $model->where($field, $new_slug);

        if ($id != null && is_int($id)) {
            $query->where($pk . '!=', $id);
        }
        if ($query->countAllResults() > 0) {
            return self::check_slug($model, $field, $slug, $params, $separator, $id, ++$count);
        } else {
            return $new_slug;
        }
    }

    /**
     * Defining the separator/divider symbol
     * Example: '-', '_' .The default symbol is '-'.
     *
     * @param string $string
     * @return Slugify
     */
    public static function separator(string $string): Slugify
    {
        static::$separator = $string;
        return static::getSelf();
    }

    /**
     * Change the latin characters to plain characters
     *
     * @param string $string
     * @return string
     */
    private static function latinToPlain(string $string): string
    {
        return str_replace(self::$latin, self::$plain, $string);
    }

    /**
     * id of selected table column
     *
     * @param int $id
     * @return Slugify
     */
    public static function getId(int $id): Slugify
    {
        static::$updateTo = $id;
        return static::getSelf();
    }
}