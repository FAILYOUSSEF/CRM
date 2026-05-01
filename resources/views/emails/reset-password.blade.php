<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset your CRM password</title>
</head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:Figtree,Arial,sans-serif;color:#0f172a;">
    <div style="display:none;max-height:0;overflow:hidden;">Reset your CRM password.</div>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f8fafc;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:620px;background:#ffffff;border:1px solid rgba(15,23,42,.10);border-radius:14px;overflow:hidden;box-shadow:0 20px 45px rgba(15,23,42,.08);">
                    <tr>
                        <td style="background:#111111;padding:24px 28px;">
                            <div style="font-size:22px;font-weight:800;letter-spacing:.04em;color:#ffffff;">CRM<span style="color:#ef4444;">.</span></div>
                            <div style="margin-top:8px;color:#a3a3a3;font-size:14px;">Password recovery</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px 28px;">
                            <h1 style="margin:0 0 12px;font-size:24px;line-height:1.25;color:#0f172a;">Reset your password</h1>
                            <p style="margin:0 0 22px;color:#64748b;font-size:15px;line-height:1.7;">Hello {{ $name }}, we received a request to reset the password for your CRM account.</p>

                            <div style="background:#f1f5f9;border:1px solid rgba(15,23,42,.10);border-radius:10px;padding:18px 20px;margin-bottom:24px;">
                                <p style="margin:0 0 8px;font-size:15px;"><strong>Account:</strong> {{ $email }}</p>
                                <p style="margin:0;color:#64748b;font-size:14px;line-height:1.6;">This reset link expires in {{ $expireMinutes }} minutes.</p>
                            </div>

                            <a href="{{ $resetUrl }}" style="display:inline-block;background:#ef4444;color:#ffffff;text-decoration:none;border-radius:10px;padding:12px 20px;font-size:14px;font-weight:800;box-shadow:0 10px 20px rgba(239,68,68,.24);">Reset password</a>

                            <p style="margin:24px 0 0;color:#64748b;font-size:14px;line-height:1.7;">If you did not request a password reset, no action is required.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px 28px;background:#f1f5f9;color:#64748b;font-size:12px;line-height:1.6;">
                            If the button does not work, copy this link into your browser:<br>
                            <span style="color:#0f172a;word-break:break-all;">{{ $resetUrl }}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
