<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::first();
$user->update(['phone' => '123456789']);
echo "User phone updated to: " . $user->phone . "\n";
