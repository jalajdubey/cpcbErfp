

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>OTP Verification</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f8;
        margin: 0;
        padding: 0;
      }
      .container {
        max-width: 600px;
        margin: 40px auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      }
      .header {
        text-align: center;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
      }
      .otp-box {
        background: #f0f8ff;
        font-size: 24px;
        font-weight: bold;
        color: #333;
        padding: 15px;
        text-align: center;
        margin: 20px 0;
        letter-spacing: 5px;
        border-radius: 6px;
      }
      .content {
        font-size: 16px;
        color: #555;
        line-height: 1.6;
      }
      .footer {
        text-align: center;
        font-size: 12px;
        color: #999;
        margin-top: 30px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="header">
        <h2>OTP Verification</h2>
      </div>
      <div class="content">
      
        <p>We received a request to verify your identity. Please use the One Time Password (OTP) below:</p>
        <div class="otp-box">{{ $otp }}</div>
        <p>This OTP is valid for the next <strong>10 minutes</strong>. Please do not share this code with anyone.</p>
        <p>If you did not request this, please ignore this email or contact our support team immediately.</p>
        <p>Thank you,<br /><strong>CPCB Team</strong></p>
      </div>
      
    </div>
  </body>
</html>
