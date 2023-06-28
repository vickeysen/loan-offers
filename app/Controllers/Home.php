<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('home');
    }
    public function personalLoan()
    {
        return view('personalLoan');
    }
    public function VerifyEmail()
    {
        return view('VerifyEmail');
    }
    public function VerifyEmailProcess()
    {
        $email = $this->request->getVar('email');
        $otp = $this->generateOTP(); // Generate a random OTP
    
        // Send the OTP to the user's email
        $status = $this->sendOTP($email, $otp);
    
        // Load the view for OTP entry and pass the email and status
        return view('verify_email/otp', [
            'email' => $email,
            'status' => '$status'
        ]);
    }
    

    public function verifyOTP()
    {
        $otp = $this->request->getPost('otp');
        $email = $this->request->getPost('email');
        $userModel = new \App\Models\UserModel();

        // Retrieve the user record from the database
        $user = $userModel->where('email', $email)
                        ->where('otp', $otp)
                        ->where('otp_expiration >', date('Y-m-d H:i:s'))
                        ->first();
        if ($user) {
            // OTP is valid
            // Perform further actions (e.g., mark the email as verified)
            // ...
            return 'OTP verified successfully';
        } else {
            // OTP is invalid or expired
            return 'Invalid or expired OTP';
        }
    }


    private function getGeneratedOTP($email)
    {
        // Retrieve the generated OTP associated with the email address from your database or any other storage
        // This is just a placeholder method, you need to implement your own logic
        return '123456'; // Replace with your implementation
    }
    private function generateOTP()
    {
        // Generate a random 6-digit OTP
        return mt_rand(100000, 999999);
    }
    private function sendOTP($emailAddress, $otp)
    {
        $email = \Config\Services::email();
        $userModel = new \App\Models\UserModel();

        $email->setTo($emailAddress);
        $email->setFrom('temp@todayblog.org', 'Your Name');
        $email->setSubject('OTP Verification');
        $email->setMessage('Your OTP is: ' . $otp);

        // Save the OTP, email, and expiration time in the database
        $expiration = date('Y-m-d H:i:s', strtotime('+5 minutes')); // Example: OTP expires after 5 minutes
        $data = [
            'email' => $emailAddress,
            'otp' => $otp,
            'otp_expiration' => $expiration
        ];
        $userModel->insert($data);

        // if ($email->send()) {
        //     return true; // Email sent successfully
        // } else {
        //     return false; // Email sending failed
        // }
    }


    
}
