<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your PeerHive login code</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
    .wrapper { max-width: 520px; margin: 40px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
    .header { background: #0d6efd; padding: 28px 32px; }
    .header h1 { margin: 0; color: #fff; font-size: 22px; font-weight: 700; letter-spacing: -0.3px; }
    .body { padding: 32px; }
    .body p { margin: 0 0 16px; color: #333; font-size: 15px; line-height: 1.6; }
    .code-box { margin: 28px 0; text-align: center; }
    .code { display: inline-block; font-size: 40px; font-weight: 700; letter-spacing: 12px; color: #0d6efd; background: #f0f6ff; border: 2px dashed #b8d4ff; border-radius: 8px; padding: 16px 32px; }
    .note { font-size: 13px; color: #888; }
    .footer { padding: 20px 32px; border-top: 1px solid #eee; font-size: 12px; color: #aaa; }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="header">
      <h1>PeerHive</h1>
    </div>
    <div class="body">
      <p>Hi {{ $firstName }},</p>
      <p>Use the code below to complete your login. It expires in <strong>10 minutes</strong>.</p>

      <div class="code-box">
        <span class="code">{{ $code }}</span>
      </div>

      <p class="note">If you didn't request this, you can safely ignore this email. Someone may have typed your email address by mistake.</p>
    </div>
    <div class="footer">
      &copy; {{ date('Y') }} PeerHive. This is an automated message, please do not reply.
    </div>
  </div>
</body>
</html>
