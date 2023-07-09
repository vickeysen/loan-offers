<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['mobile', 'otp', 'otp_expiration'];

    public function getUserByMobile($mobile)
    {
        return $this->where('mobile', $mobile)
                ->getWhere(null, 1)
                ->getRow();
    }

    public function updateOtp($mobile, $otpCode, $otp_expiration)
    {
        $data = [
            'otp' => $otpCode,
            'otp_expiration' => $otp_expiration
        ];
        
        $this->where('mobile', $mobile)
             ->set($data)
             ->update();
    }

    public function createOtp($mobile, $otpCode, $otp_expiration)
    {
        $data = [
            'mobile' => $mobile,
            'otp' => $otpCode,
            'otp_expiration' => $otp_expiration
        ];

        $this->insert($data);
    }

}
