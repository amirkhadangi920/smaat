<?php

namespace App\Helpers;

use Illuminate\Database\Schema\Blueprint as BaseBlueprint;
use Illuminate\Support\Str;
use Illuminate\Database\Schema\Builder;


class Blueprint extends BaseBlueprint
{
    private $default_types = [
        'description'           => 'mediumText',
        'note'                  => 'mediumText',
        'body'                  => 'text',
    ];

    public function __call($method, $parameters)
    {
        if ( Str::startsWith($method, 'relto') )
        {
            $table = strtolower( Str::plural( Str::replaceFirst('relto', '', $method) ) );
            
            if ( in_array($table, [
                'users', 'products', 'variations', 'orders', 'banks', 'accounts', 'persons', 'articles'
            ])) $feild_type = 'uuid';
            
            $this->add_foreign($table, $parameters[0] ?? false, $feild_type ?? 'unsignedInteger');
        }
        else
        {
            $column = strtolower( $method );
            $length = $parameters[0] ?? Builder::$defaultStringLength;
            $type = $this->default_types[$column] ?? 'string';

            return $this->$type($column, $length);
        }
    }

    /**
     * Add id primary key to the table, both unsignedInteger & uuid types
     *
     * @param string $type can be int or uuid
     * @return void
     */
    public function id($type = 'int')
    {
        if ( $type == 'int' )
            $this->increments('id');
        elseif ( $type == 'uuid' )
            $this->uuid('id')->primary();
    }

    /**
     * Add two columns for both title & description feilds on the table.
     *
     * @param  string|title          $title
     * @param  string|description    $description
     * @param  integer|50            $title_length
     * @param  integer|300           $description_length
     * @return void
     */
    public function info($title = 'title', $description = 'description', $title_length = 50, $description_length = 300)
    {
        $this->string($title, $title_length);
        $this->string($description, $description_length);
    }

    /**
     * Add three columns for slug, title & description feilds on the table
     *
     * @param string $title
     * @return void
     */
    public function sluggable_info($title = 'title')
    {
        $this->string('slug', 150);
        $this->info($title);
    }

    /**
     * Add both the forign key column and it's relation to the defined table
     *
     * @param string|null               $table
     * @param boolean|false             $nullable
     * @param string|unsignedInteger    $feild_type
     * @param string|null               $column
     * @param string|cascade            $on_change e.g cascade, set null etc...
     * @return void
     */
    public function add_foreign($table = null, $nullable = false, $feild_type = 'unsignedInteger', $column = null, $on_change = 'cascade')
    {
        if (!$table)
        {
            $table = $this->table;
            $column = 'parent_id';
            $nullable = true;
        } else {
            if (!$column)
                $column = Str::singular($table) . '_id';
        }


        if ($nullable)
            $this->$feild_type($column)->nullable();
        else
            $this->$feild_type($column);

        $this->foreign($column)->references('id')->on($table)
            ->onDelete($on_change)->onUpdate($on_change);
    }

    public function interface($first_table, $second_table)
    {
        $this->{'relto'.$first_table}();
        $this->{'relto'.$second_table}();

        $this->primary([
            Str::singular($first_table) . '_id',
            Str::singular($second_table) . '_id'
        ]);
    }

    /**
     * Add all the deleted_at, created_at & updated_at timestamp feilds to the table
     *
     * @return void
     */
    public function full_timestamps(Array $other_times = [])
    {
        if ( $other_times )
        {
            foreach ( $other_times as $item )
                $this->timestamp($item)->nullable();
        }
        $this->softDeletes();
        $this->timestamps();
    }

    /**
     * Add an mediumtext fieild to the table that represents an json array
     *
     * @param string        $column
     * @param string|null   $comment
     * @param boolean|true  $nullable
     * @return void
     */
    public function array($column, $comment = null, $nullable = true)
    {
        if (!$comment)
        {
            $table = Str::singular( $this->table );
            $comment = "Array of the {$table} {$column}";
        }

        if ( $nullable )
            return $this->mediumText($column)->nullable()->comment($comment);
        else
            return $this->mediumText($column)->comment($comment);
    }

    /**
     * Add all the relation foreign keys on the table
     *
     * @param Array $relations
     * @return void
     */
    public function relations(Array $relations)
    {
        foreach ( $relations as $table => $nullable )
        {
            if ( $nullable === 'self' )
                $this->add_foreign();
            else
            {
                if ( is_int( $table ) )
                {
                    $table = $nullable;
                    $nullable = false;
                }
                $this->{'relto'.$table}($nullable);
            }
        }
    }

    public function table($feilds, $relations = [], $id_type = 'int', $time_feilds = [])
    {
        if ( $id_type )
            $this->id( $id_type );
        
        $this->relations( $relations );
        $this->feilds($feilds);

        if ( $time_feilds === false ) return;

        $this->full_timestamps( $time_feilds );
    }

    /**
     * Add all the feilds of the table base on the array options of each kyes
     *
     * @param Array $feilds
     * @return void
     */
    public function feilds(Array $feilds)
    {
        $methods = ['nullable', 'unique', 'index'];

        foreach ( $feilds as $feild => $options )
        {
            if ( is_string($options) && !is_int($feild) )
                $options = $this->get_array_from_string($options);

            $method = is_int($feild) ? $options : $options['type'] ?? $feild;
            $param = !is_array($options) ? $options : $options['param'] ?? $options[0] ?? null;

            if ( in_array( $param, $methods) || $param === $method ) $param = null;
            if ( isset($options['type']) ) $param = $feild;

            if ( $param )
                $feild = $this->$method($param);
            else
                $feild = $this->$method();

            foreach ( $methods as $method )
            {
                if ( is_array($options) && in_array($method, $options) )
                    $feild->$method();
            }

            foreach ( ['comment', 'default'] as $method )
            {
                if( isset($options[ $method ]) )
                    $feild->$method( $options[ $method ] );
            }
        }
    }

    public function get_array_from_string ( $string )
    {
        $result = [];
        
        foreach ( explode('|', $string) as $key => $item )
        {
            if ( $pos = strpos($item, ':') )
                $result[ substr($item, 0, $pos) ] = substr($item, $pos + 1);
            else
                $result[ $key ] = $item;
        }

        return $this->get_type( $result );
    }

    public function get_type ( $array )
    {
        $all_types = [
            'mediumText', 'text',        
            'tinyInteger', 'smallInteger', 'integer', 'bigInteger',
            'unsignedInteger', 'unsignedBigInteger',
            'boolean', 'array', 'json', 'timestamp',
        ];
    
        foreach ( $all_types as $type )
        {
            $pos = array_search($type, $array);
            if ( $pos !== false )
            {
                $array['type'] = $array[ $pos ];
                unset( $array[ $pos ] );
            }
        }
        return $array;
    }
}
