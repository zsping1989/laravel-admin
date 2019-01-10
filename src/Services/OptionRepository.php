<?php

namespace LaravelAdmin\Services;

use App\Models\Config;
use \Illuminate\Support\Facades\DB;
use ArrayAccess;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Config\Repository as ConfigContract;

class OptionRepository implements ArrayAccess, ConfigContract
{
    /**
     * All of the option items.
     *
     * @var array
     */
    protected $items = [];

    protected $items_modified = [];

    /**
     * Create a new option repository.
     *
     * @return void
     */
    public function __construct()
    {
        try{
            if(class_exists('\App\Models\Config')){
                $options = \App\Models\Config::get();
            }else{
                $options = [];
            }
        }catch (\Exception $e){
            $options = [];
        }

        foreach ($options as $option) {
            $this->items[$option->key] = $option->value;
        }

    }

    /**
     * Determine if the given option value exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function has($key)
    {
        return Arr::has($this->items, $key);
    }

    /**
     * Get the specified option value.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return Arr::get($this->items, $key, $default);
    }

    /**
     * Set a given option value.
     *
     * @param  array|string  $key
     * @param  mixed   $value
     * @return void
     */
    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $innerKey => $innerValue) {
                Arr::set($this->items, $innerKey, $innerValue);
                $this->items_modified[] = $innerKey;
            }
        } else {
            Arr::set($this->items, $key, $value);
            $this->items_modified[] = $key;
        }
    }

    public function save()
    {
        $this->items_modified = array_unique($this->items_modified);

        foreach ($this->items_modified as $key) {
            if (!$item = Config::where('key', $key)->first()) {
                Config::insert(['key' => $key, 'value' => $this[$key]]);
            } else {
                $item->value = $this[$key];
                $item->save();
            }
        }
    }

    /**
     * Prepend a value onto an array option value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function prepend($key, $value)
    {
        $array = $this->get($key);

        array_unshift($array, $value);

        $this->set($key, $array);
    }

    /**
     * Push a value onto an array option value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function push($key, $value)
    {
        $array = $this->get($key);

        $array[] = $value;

        $this->set($key, $array);
    }

    /**
     * Get all of the option items for the application.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Determine if the given option option exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * Get a option option.
     *
     * @param  string  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Set a option option.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Unset a option option.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        $this->set($key, null);
    }

    /**
     * Save all modified options into database
     */
    public function __destruct()
    {
        $this->save();
    }

}