<?php
namespace app\models;

class Movie extends Item
{

    public static function tableName()
    {
        return 'movie';
    }
}