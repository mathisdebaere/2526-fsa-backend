<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welkom bij FijneWijk</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { background: #4a7c59; padding: 32px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 28px; }
        .header p { color: #d4edda; margin: 8px 0 0; font-size: 16px; }
        .body { padding: 32px; color: #333333; font-size: 16px; line-height: 1.6; }
        .body h2 { color: #4a7c59; font-size: 20px; }
        .info-box { background: #f0f7f2; border-left: 4px solid #4a7c59; padding: 16px; border-radius: 4px; margin: 20px 0; }
        .next-steps { margin: 24px 0; }
        .next-steps li { margin-bottom: 8px; }
        .footer { background: #f5f5f5; padding: 20px 32px; text-align: center; font-size: 13px; color: #888888; }
        .footer a { color: #4a7c59; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Welkom bij FijneWijk!</h1>
        <p>Het buurtnetwerk dat verbindt</p>
    </div>

    <div class="body">
        <h2>Hallo {{ $user->first_name }},</h2>

        <p>
            Fijn dat je deel wil uitmaken van <strong>FijneWijk</strong>!
            Jouw account is succesvol aangemaakt.
        </p>

        <div class="info-box">
            <strong>Jouw gegevens:</strong><br>
            Naam: {{ $user->first_name }} {{ $user->last_name }}<br>
            E-mail: {{ $user->email }}<br>
            Rol: {{ $user->role === 'client' ? 'Dienstvrager' : 'Vrijwilliger' }}
        </div>

        <div class="next-steps">
            <strong>Wat zijn de volgende stappen?</strong>
            <ul>
                <li>Een persoonlijk adviseur neemt binnenkort contact met je op.</li>
                <li>Er wordt een kennismakingsgesprek ingepland om jouw account te bekijken en aan te vullen.</li>
                @if($user->role === 'client')
                <li>Na verificatie kun je hulpvragen plaatsen en in contact komen met vrijwilligers.</li>
                @else
                <li>Na verificatie word je zichtbaar voor mensen in jouw buurt die hulp zoeken.</li>
                @endif
            </ul>
        </div>

        <p>Heb je vragen? Neem gerust contact op via <a href="mailto:info@zilverenschakel.be">info@zilverenschakel.be</a>.</p>

        <p>Met vriendelijke groeten,<br><strong>Het ZilverenSchakel-team</strong></p>
    </div>

    <div class="footer">
        &copy; 2026 FijneWijk &nbsp;|&nbsp;
        <a href="#">Privacybeleid</a> &nbsp;|&nbsp;
    </div>
</div>
</body>
</html>
