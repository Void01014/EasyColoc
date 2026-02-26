<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        /* Human-made touch: Minimalist, dark-mode focused */
        body {
            background-color: #07091a;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: none;
            text-size-adjust: none;
        }
    </style>
</head>
<body style="background-color: #07091a; font-family: 'Georgia', serif; color: #f0f4ff;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #07091a; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="400" border="0" cellspacing="0" cellpadding="40" style="background: #0d1136; border: 1px solid rgba(107, 130, 255, 0.2); border-radius: 32px; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
                    <tr>
                        <td align="center">
                            <div style="font-size: 32px; color: #6b82ff; margin-bottom: 20px;">✦</div>
                            
                            <p style="text-transform: uppercase; letter-spacing: 0.3em; font-size: 10px; color: #82BDED; font-weight: bold; margin-bottom: 15px; font-family: sans-serif;">
                                Sector Transmission
                            </p>
                            
                            <h1 style="font-style: italic; font-size: 26px; line-height: 1.2; margin: 0 0 20px 0; font-weight: normal; color: #dde5ff;">
                                Join the <span style="color: #6b82ff;">{{ $group_name }}</span> constellation.
                            </h1>

                            <p style="font-family: sans-serif; font-size: 14px; line-height: 1.6; color: #82BDED; margin-bottom: 35px;">
                                You’ve been invited to sync your expenses and manage the ledger for this mission.
                            </p>

                            <a href="{{ route('groups.accept', ['token' => $token]) }}" 
                               style="display: inline-block; background-color: #6b82ff; color: #ffffff; padding: 18px 36px; border-radius: 16px; text-decoration: none; font-weight: bold; font-size: 13px; text-transform: uppercase; letter-spacing: 0.15em; font-family: sans-serif; box-shadow: 0 10px 20px rgba(107, 130, 255, 0.25);">
                                Establish Connection
                            </a>

                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 40px; border-top: 1px solid rgba(107, 130, 255, 0.1); padding-top: 25px;">
                                <tr>
                                    <td align="center">
                                        <p style="font-size: 9px; color: #3d4a7a; font-family: sans-serif; letter-spacing: 0.1em; margin: 0;">
                                            UNIQUE TOKEN: <span style="color: #6b82ff;">{{ $token }}</span>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                
                <p style="margin-top: 30px; font-size: 11px; color: #3d4a7a; font-family: sans-serif;">
                    Stationed in Rabat • SplitStay System ✧
                </p>
            </td>
        </tr>
    </table>
</body>
</html>