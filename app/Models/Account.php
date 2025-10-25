<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // dùng Authenticatable
use Illuminate\Notifications\Notifiable;

class Account extends Authenticatable
{
    use Notifiable;

    protected $table = 'Accounts';
    protected $primaryKey = 'UserId';

    // Nếu bảng có timestamps khác tên mặc định
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $fillable = [
        'UserName',
        'UserPassword',
        'UserEmail',
        'UserAvatar',
        'UserRole'
    ];

    protected $hidden = ['UserPassword'];

    // Laravel sẽ dùng hàm này để lấy password
    public function getAuthPassword()
    {
        return $this->UserPassword;
    }
}
