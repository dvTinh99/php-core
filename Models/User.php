<?php 

class User extends Model {

    protected $table = 'user';
    protected $fillable = [
        'user_fullname',
        'user_email',
    ];

}