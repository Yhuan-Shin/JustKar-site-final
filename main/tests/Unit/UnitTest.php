<?php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// for user model
test('username and password', function () {
    $user = new User();
    $user->username = 'John Doe';
    $user->password = Hash::make('12345');
    expect($user->username)->toBe('John Doe');
    expect(Hash::check('12345', $user->password))->toBeTrue();
});
test('role',function(){
    $user = new User();
    $user->role = 'admin';
    expect($user->role)->toBe('admin');
});

