<!-- app/Views/verify_email/otp.php -->
<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification</title>
</head>
<body>
    <h1>OTP Verification</h1>
    <p>An OTP has been sent to <?= $email ?>. Please enter the OTP below:</p>
    
    <form action="<?= base_url('verify-otp') ?>" method="post">
        <input type="text" name="otp" placeholder="Enter OTP" required>
        <input type="hidden" name="email" value="<?= $email ?>">
        <button type="submit">Verify OTP</button>
    </form>
</body>
</html>
