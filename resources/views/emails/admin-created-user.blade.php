<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your CRM account</title>
</head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:Figtree,Arial,sans-serif;color:#0f172a;">
    <div style="display:none;max-height:0;overflow:hidden;">Your CRM account is ready.</div>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f8fafc;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:620px;background:#ffffff;border:1px solid rgba(15,23,42,.10);border-radius:14px;overflow:hidden;box-shadow:0 20px 45px rgba(15,23,42,.08);">
                    <tr>
                        <td style="background:#111111;padding:24px 28px;">
                            <div style="font-size:22px;font-weight:800;letter-spacing:.04em;color:#ffffff;">CRM<span style="color:#ef4444;">.</span></div>
                            <div style="margin-top:8px;color:#a3a3a3;font-size:14px;">Your workspace account has been created</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px 28px;">
                            <h1 style="margin:0 0 12px;font-size:24px;line-height:1.25;color:#0f172a;">Welcome, {{ $name }}</h1>
                            <p style="margin:0 0 22px;color:#64748b;font-size:15px;line-height:1.7;">An administrator created a CRM account for you. Use the credentials below to sign in.</p>

                            <div style="background:#f1f5f9;border:1px solid rgba(15,23,42,.10);border-radius:10px;padding:18px 20px;margin-bottom:24px;">
                                <p style="margin:0 0 10px;font-size:13px;color:#64748b;text-transform:uppercase;font-weight:700;">Login details</p>
                                <p style="margin:0 0 8px;font-size:15px;"><strong>Email:</strong> {{ $email }}</p>
                                <p style="margin:0;font-size:15px;"><strong>Temporary password:</strong> {{ $password }}</p>
                            </div>

                            <a href="{{ $loginUrl }}" style="display:inline-block;background:#ef4444;color:#ffffff;text-decoration:none;border-radius:10px;padding:12px 20px;font-size:14px;font-weight:800;box-shadow:0 10px 20px rgba(239,68,68,.24);">Log in to CRM</a>

                            <p style="margin:24px 0 0;color:#64748b;font-size:14px;line-height:1.7;">For security, please change your password after your first login.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px 28px;background:#f1f5f9;color:#64748b;font-size:12px;line-height:1.6;">
                            If the button does not work, copy this link into your browser:<br>
                            <span style="color:#0f172a;word-break:break-all;">{{ $loginUrl }}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
