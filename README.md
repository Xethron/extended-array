PHP Extended Arrays
===================

Install
-------

Edit your composer.json file to require `xethron/extended-array` and run `composer update`
```json
"require": {
    "xethron/extended-array": "dev-master"
}
```

Usage
-----

```php
// Create a blank extended array
$array = new Xethron\ExtendedArray;

// Create a new extended array from an existing array
$array = new Xethron\ExtendedArray($array);

// Accessing Data
$value = $array['key'];
$value = $array->key;
$value = $array->get('key', 'Default Value');

// Setting Data
$array['key'] = 'value';
$array->key = 'value';
$array->set('key', 'value');

// Checking if a key exists
$bool = isset($array['key']);
$bool = isset($array->key);
$bool = $array->has('key');

// Unset a value
unset($array['key']);
unset($array->key);
$array->forget('key');

// Get the actual array
$value = $array->getArray();

// Check if the array contains a list of keys
$bool = $array->hasAll(['key1', 'key2', 'key3']);

// Check if the array contains one of the following keys
$bool = $array->hasOne(['key1', 'key2', 'key3']);

// Add a key only if it doesn't exist
$array->add('key', 'value');

// Split an array into two arrays. One with keys and the other with values.
list($keys, $values) = $array->split();
```

Contributors
------------

Bernhard Breytenbach ([@BBreyten](https://twitter.com/BBreyten))

License
----------

Extended Array is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)