<!DOCTYPE html>
<html lang=nl>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>afbollen moatje</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }

            body {
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                text-align: center;
                padding: 1.5rem;
                background: #0a0a0a;
                color: #EDEDEC;
                overflow: hidden;
                position: relative;
                cursor: not-allowed;
            }

            .zwaai {
                font-size: clamp(4rem, 18vw, 11rem);
                line-height: 1;
                margin-bottom: 1.5rem;
                animation: zwaai 0.6s ease-in-out infinite;
                transform-origin: 50% 80%;
                user-select: none;
            }

            @keyframes zwaai {
                0%, 100% { transform: rotate(-22deg); }
                50%      { transform: rotate(22deg); }
            }

            h1 {
                font-size: clamp(1.75rem, 6vw, 3.5rem);
                font-weight: 700;
                margin-bottom: 0.75rem;
                color: #FF4433;
                letter-spacing: -0.02em;
            }

            p {
                font-size: clamp(1rem, 3.5vw, 1.4rem);
                color: #A1A09A;
                max-width: 36rem;
                line-height: 1.5;
                margin-bottom: 0.4rem;
            }

            .ksst {
                margin-top: 1.5rem;
                font-size: clamp(1.5rem, 5vw, 2.5rem);
                font-weight: 600;
                color: #F8B803;
                letter-spacing: 0.15em;
                animation: pulse 1.1s ease-in-out infinite;
            }

            @keyframes pulse {
                0%, 100% { opacity: 1; transform: scale(1); }
                50%      { opacity: 0.55; transform: scale(0.94); }
            }

        </style>
    </head>
    <body>
        <div class="zwaai">👋</div>

        <h1>elaba, wa doede gij ier?</h1>
        <p>gij moedier eigenlijk <strong>helemaal nie</strong> zijn e maotje</p>
        <p>das ier privé, allez hop, voetjes vegen en buiten.</p>

        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="ksst">klikt ier om em af te bollen 👋</a>

    </body>
</html>