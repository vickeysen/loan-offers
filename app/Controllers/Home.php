<?php

namespace App\Controllers;


use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Dotenv\Dotenv;
class Home extends BaseController
{
    public function index()
    {
        return view('home');
    }
    
    public function personalLoan()
    {
        $mobile = session('user');
        if($mobile !== null){
           // return redirect()->to('/personal-loan/offers');
        }
        return view('personal-loan/personalLoan');
    }

    public function sendOTP()
    {
        helper('form');
        $validationRules = [
            'mobile' => [
                'required',
                'regex_match[/^[6-9]\d{9}$/]', // Regular expression for 10-digit Indian mobile numbers starting with 6, 7, 8, or 9
            ]
        ];

        if (!$this->validate($validationRules)) {
            // Validation failed, display the form with validation errors
            $errors = $this->validator->getErrors();
            return redirect()->to('/personal-loan')->with('errors', $errors);
        }
        // Load the .env file
        $dotenv = Dotenv::createImmutable(ROOTPATH);
        $dotenv->load();
        $mobile = $this->request->getPost('mobile');
        // Generate OTP code
        $otpCode = mt_rand(1000, 9999);
        $otp_expiration = new \DateTime();
        $otp_expiration->add(new \DateInterval('PT10M'));
        $otp_expiration = $otp_expiration->format('Y-m-d H:i:s');
        $authorization = $_ENV['FAST2SMS_AUTHORIZATION_KEY'];
        $url = $_ENV['FAST2SMS_V2_URL'];
        
        // Prepare the parameters for the API request
        $params = [
            'authorization' => $authorization,
            'route' => 'otp',
            'variables_values' => $otpCode,
            'flash' => '0',
            'numbers' => $mobile
        ];
        // Create an instance of the HTTPRequest library
        $httpClient = service('curlrequest');
        // $response = $httpClient->get($url, $params);

        // // Handle the API response
        // if ($response->getStatusCode() === 200) {
        //     // Success
        //     $responseData = $response->getBody();
        //     // Process the response data as needed
        // } else {
        //     // API request failed
        //     $error = $response->getStatusCode() . ' ' . $response->getReason();
        //     // Log the error
        //     log_message('error', 'Fast2SMS API Error: ' . $error);
        //     $errors = [$error];
        //     return redirect()->to('/personal-loan')->with('errors', $errors)->with('mobile', $mobile);
        // }
        // Save or update OTP code in the database
        $UserModel = new UserModel();
        $existingUser = $UserModel->getUserByMobile($mobile);
        if ($existingUser !== null) {
            // Update existing OTP
            $UserModel->updateOtp($mobile, $otpCode, $otp_expiration);
        } else {
            // Create new OTP
            $UserModel->createOtp($mobile, $otpCode, $otp_expiration);
        }
        return redirect()->to('/personal-loan/verify-otp')->with('mobile', $mobile);
    }

    public function verifyOtpProcess(){
        helper('form');
        $validationRules = [
            'mobile' => [
                'required',
                'regex_match[/^[6-9]\d{9}$/]', // Regular expression for 10-digit Indian mobile numbers starting with 6, 7, 8, or 9
            ],
            'otp' => [
                'required',
                'numeric',
                'exact_length[4]'
            ]
        ];
        $mobile = $this->request->getPost('mobile');
        $otp = $this->request->getPost('otp');
        if (!$this->validate($validationRules)) {
            $errors = $this->validator->getErrors();
            return redirect()->to('/personal-loan/verify-otp')->with('errors', $errors)->with('mobile', $mobile);
        }
        $UserModel = new UserModel();
        $existingUser = $UserModel->getUserByMobile($mobile);
        if ($existingUser !== null) {
            $otpCode = $existingUser->otp;
            $otpExpiration = $existingUser->otp_expiration; // 'Y-m-d H:i:s'
            
            // Convert OTP expiration to DateTime object
            $expirationTime = Time::createFromFormat('Y-m-d H:i:s', $otpExpiration);
            
            // Get the current time
            $currentTime = new \DateTime();
            $currentTime->add(new \DateInterval('PT1M'));
            $currentTime = $currentTime->format('Y-m-d H:i:s');            
            $currentTime = Time::createFromFormat('Y-m-d H:i:s', $currentTime);


            if ($currentTime > $expirationTime) {
                // OTP has expired
                $errors = ['OTP is expired'];
                return redirect()->to('/personal-loan')->with('errors', $errors)->with('mobile', $mobile);
            } else {
                // OTP is still valid
                if($otpCode == $otp){
                    $expirationTime = Time::createFromTimestamp(time() + 3600); // Set expiration time to 1 hour from now
                    session()->set('user', $existingUser, $expirationTime);
                    return redirect()->to('/personal-loan/employment-type')->with('mobile', $mobile);
                }else{
                    $errors = ['OTP is not valid'];
                    return redirect()->to('/personal-loan/verify-otp')->with('errors', $errors)->with('mobile', $mobile);
                }
            }
            // Access other fields as needed
        }else{
            $errors = ['Technical error'];
            return redirect()->to('/personal-loan')->with('errors', $errors)->with('mobile', $mobile);
        }
    }

    public function verifyOTP()
    {
        $mobile = session()->getFlashdata('mobile');
        return view('/personal-loan/verifyMobile', [
            'mobile' => $mobile
        ]);
    }

    public function employmentType(){
        $mobile = session()->getFlashdata('mobile');
        return view('/personal-loan/employment',[
            'mobile' => $mobile
        ]);
    }

    public function employmentTypeProcess(){
        helper('form');
        $validationRules = [
            'mobile' => [
                'required',
                'regex_match[/^[6-9]\d{9}$/]', // Regular expression for 10-digit Indian mobile numbers starting with 6, 7, 8, or 9
            ],
            'employment' => [
                'required',
            ]
        ];
        $expirationTime = Time::createFromTimestamp(time() + 3600);
        $mobile = $this->request->getPost('mobile');
        $employment = $this->request->getPost('employment');
        if (!$this->validate($validationRules)) {
            $errors = $this->validator->getErrors();
            return redirect()->to('/personal-loan/employment-type')->with('errors', $errors)->with('mobile', $mobile);
        }
        $existingUser = session()->get('user');
        if ($existingUser) {
            $existingUser->employment = $employment;
            session()->set('user', $existingUser, $expirationTime);
            if($employment  === 'salaried'){
                return redirect()->to('/personal-loan/employer');
            }else{
                return redirect()->to('/personal-loan/income');
            }
        }else{
            $errors = ['Technical error'];
            return redirect()->to('/personal-loan')->with('errors', $errors)->with('mobile', $mobile);
        }
    }


    public function incomeProcess(){
        helper('form');
        $validationRules = [
            'anual_income' => [
                'required',
            ]
        ];

        $anual_income = $this->request->getPost('anual_income');
        if (!$this->validate($validationRules)) {
            $errors = $this->validator->getErrors();
            return redirect()->to('/personal-loan/income')->with('errors', $errors);
        }
        $expirationTime = Time::createFromTimestamp(time() + 3600);
        $existingUser = session()->get('user');
        if ($existingUser) {
            $existingUser->anual_income = $anual_income;
            session()->set('user', $existingUser, $expirationTime);
            return redirect()->to('/personal-loan/loanAmount');
        }else{
            $errors = ['Technical error'];
            return redirect()->to('/personal-loan')->with('errors', $errors);
        }
    }



    public function loanAmount(){
        return view('/personal-loan/loanAmount');
    }
    
    public function income(){
        return view('/personal-loan/income');
    }


    public function employer(){
        return view('/personal-loan/employer');
    }

    public function primaryBank(){
        return view('/personal-loan/primaryBank');
    }

    public function residence(){
        return view('/personal-loan/residence');
    }

    public function residenceType(){
        return view('/personal-loan/residenceType');
    }

    public function residenceTypeProcess(){
        return view('/personal-loan/residenceType');
    }
    
    public function personalDetails(){
        return view('/personal-loan/personalDetails');
    }
    
    public function offers(){
        return view('/personal-loan/offers');
    }
    
    public function offerApply(){
        return view('/personal-loan/thankYou');
    }

    public function primaryBankProcess(){
        helper('form');
        $validationRules = [
            'primaryBank' => [
                'required',
            ]
        ];

        $primaryBank = $this->request->getPost('primaryBank');
        if (!$this->validate($validationRules)) {
            $errors = $this->validator->getErrors();
            return redirect()->to('/personal-loan/primaryBank')->with('errors', $errors);
        }
        $expirationTime = Time::createFromTimestamp(time() + 3600);
        $existingUser = session()->get('user');
        if ($existingUser) {
            $existingUser->primaryBank = $primaryBank;
            session()->set('user', $existingUser, $expirationTime);
            return redirect()->to('/personal-loan/residence');
        }else{
            $errors = ['Technical error'];
            return redirect()->to('/personal-loan')->with('errors', $errors);
        }
    }
    
    public function loanAmountProcess(){
        helper('form');
        $validationRules = [
            'loanAmount' => [
                'required',
            ]
        ];

        $loanAmount = $this->request->getPost('loanAmount');
        if (!$this->validate($validationRules)) {
            $errors = $this->validator->getErrors();
            return redirect()->to('/personal-loan/loanAmount')->with('errors', $errors);
        }
        $expirationTime = Time::createFromTimestamp(time() + 3600);
        $existingUser = session()->get('user');
        if ($existingUser) {
            $existingUser->loanAmount = $loanAmount;
            session()->set('user', $existingUser, $expirationTime);
            return redirect()->to('/personal-loan/primary-bank');
        }else{
            $errors = ['Technical error'];
            return redirect()->to('/personal-loan')->with('errors', $errors);
        }
    }
    
    public function personalDetailsProcess(){
        helper('form');
        $validationRules = [
            'firstName' => [
                'required',
            ],
            'middleName' => [
                'required',
            ],
            'lastName' => [
                'required',
            ],
            'panNo' => [
                'required',
                'regex_match[/^[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}$/]',
            ],
            'emailAddress' => [
                'required',
                'valid_email',
            ],
            'dob' => [
                'required',
                'valid_date'
            ],
        ];
        $personalDetails = [
            'firstName' => $this->request->getPost('firstName'),
            'middleName' => $this->request->getPost('middleName'),
            'lastName' => $this->request->getPost('lastName'),
            'panNo' => $this->request->getPost('panNo'),
            'emailAddress' => $this->request->getPost('emailAddress'),
            'dob' => $this->request->getPost('dob'),
        ];
        if (!$this->validate($validationRules)) {
            $errors = $this->validator->getErrors();
            return redirect()->to('/personal-loan/personal-details')->with('errors', $errors);
        }
        $expirationTime = Time::createFromTimestamp(time() + 3600);
        $existingUser = session()->get('user');
        if ($existingUser) {
            $existingUser->residence = $residence;
            session()->set('user', $existingUser, $expirationTime);
            return redirect()->to('/personal-loan/offers');
        }else{
            $errors = ['Technical error'];
            return redirect()->to('/personal-loan')->with('errors', $errors);
        }
    }

    public function residenceProcess(){
        helper('form');
        $validationRules = [
            'houseNo' => [
                'required',
            ],
            'street' => [
                'required',
            ],
            'landMark' => [
                'required',
            ],
            'city' => [
                'required',
            ],
            'state' => [
                'required',
            ],
            'pinCode' => [
                'required',
                'numeric',
                'exact_length[6]'
            ],
        ];
        //die($this->request->getPost('houseNo'));
        $residence = [
            'houseNo' => $this->request->getPost('houseNo'),
            'street' => $this->request->getPost('street'),
            'landMark' => $this->request->getPost('landMark'),
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'pinCode' => $this->request->getPost('pinCode'),
        ];
        if (!$this->validate($validationRules)) {
            $errors = $this->validator->getErrors();
            return redirect()->to('/personal-loan/residence')->with('errors', $errors);
        }
        $expirationTime = Time::createFromTimestamp(time() + 3600);
        $existingUser = session()->get('user');
        if ($existingUser) {
            $existingUser->residence = $residence;
            session()->set('user', $existingUser, $expirationTime);
            return redirect()->to('/personal-loan/residenceType');
        }else{
            $errors = ['Technical error'];
            return redirect()->to('/personal-loan')->with('errors', $errors);
        }
    }

    public function employerProcess(){
        helper('form');
        $validationRules = [
            'employer' => [
                'required',
            ]
        ];

        $employer = $this->request->getPost('employer');
        if (!$this->validate($validationRules)) {
            $errors = $this->validator->getErrors();
            return redirect()->to('/personal-loan/employer')->with('errors', $errors);
        }
        $expirationTime = Time::createFromTimestamp(time() + 3600);
        $existingUser = session()->get('user');
        if ($existingUser) {
            $existingUser->employer = $employer;
            session()->set('user', $existingUser, $expirationTime);
            return redirect()->to('/personal-loan/income');
        }else{
            $errors = ['Technical error'];
            return redirect()->to('/personal-loan')->with('errors', $errors);
        }
    }


    /*
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


    */
}
