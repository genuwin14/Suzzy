<!DOCTYPE html>
<html lang="en">
<head>
    <title>Loader</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            justify-content: center;
            align-items: center;
            background-color: #f3f4f6;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .loaderRectangle {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0 3px;
        }

        .loaderRectangle div {
            width: 10px;
            height: 16px;
            animation: .9s ease-in-out infinite;
            background: #183153;
            box-shadow: 0 0 20px rgba(18, 31, 53, 0.3);
        }

        .loaderRectangle div:nth-child(1) { animation-name: rectangleOneAnim; animation-delay: 1s; }
        .loaderRectangle div:nth-child(2) { animation-name: rectangleTwoAnim; animation-delay: 1.1s; }
        .loaderRectangle div:nth-child(3) { animation-name: rectangleThreeAnim; animation-delay: 1.2s; }
        .loaderRectangle div:nth-child(4) { animation-name: rectangleFourAnim; animation-delay: 1.3s; }
        .loaderRectangle div:nth-child(5) { animation-name: rectangleFiveAnim; animation-delay: 1.4s; }

        @keyframes rectangleOneAnim { 0% { height: 15px; } 40% { height: 30px; } 100% { height: 15px; } }
        @keyframes rectangleTwoAnim { 0% { height: 15px; } 40% { height: 40px; } 100% { height: 15px; } }
        @keyframes rectangleThreeAnim { 0% { height: 15px; } 40% { height: 50px; } 100% { height: 15px; } }
        @keyframes rectangleFourAnim { 0% { height: 15px; } 40% { height: 40px; } 100% { height: 15px; } }
        @keyframes rectangleFiveAnim { 0% { height: 15px; } 40% { height: 30px; } 100% { height: 15px; } }

        .redirecting-text {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #183153;
        }
    </style>
</head>
<body>
    <div class="loaderRectangle">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
    
    <div class="redirecting-text" id="redirectingText">Redirecting</div>

    <script>
        let count = 0;
        setInterval(() => {
            count = (count % 3) + 1; // Cycles between 1, 2, 3
            document.getElementById("redirectingText").innerText = "Redirecting" + ".".repeat(count);
        }, 500);

        setTimeout(function() {
            window.location.href = "{{ $redirectUrl }}";
        }, 3000);
    </script>
</body>
</html>
