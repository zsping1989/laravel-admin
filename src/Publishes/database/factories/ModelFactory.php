<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/



/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10)
    ];
});

//后台用户
$factory->define(App\Models\Admin::class, function (Faker\Generator $faker) {
    return [];
});

//后台角色
$factory->define(App\Models\Role::class, function (Faker\Generator $faker) {
    return [
        'name'=>$faker->word,
        'description'=>$faker->word
    ];
});

//后台权限
$factory->define(App\Models\Menu::class, function (Faker\Generator $faker) {
    return [
        'name'=>$faker->word,
        'description'=>$faker->word,
        'method'=>1,
        'url'=>'/',
        'status'=>2 //不显示
    ];
});


//配置
$factory->define(App\Models\Config::class, function (Faker\Generator $faker) {
    return [
        'key'=>$faker->word,
        'value'=>$faker->word,
        'name'=>''
    ];
});

