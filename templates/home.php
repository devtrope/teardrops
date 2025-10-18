<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teardrops - Home Page</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
</head>
<style>
    @keyframes colorFade {
        0%   { background-color: #d1fae5; } /* emerald-100 */
        25%  { background-color: #bfdbfe; } /* blue-100 */
        50%  { background-color: #fef3c7; } /* yellow-100 */
        75%  { background-color: #fbcfe8; } /* pink-100 */
        100% { background-color: #d1fae5; }
    }
    .animate-color {
        animation: colorFade 15s infinite linear;
    }
</style>
<body class="min-h-screen flex items-center justify-center p-6 relative">
    <div class="absolute w-100 h-100 rounded-full blur-3xl z-[-1] animate-color"></div>
    <div class="max-w-3xl w-full text-center space-y-8">
        <img src="assets/images/logo.png" class="w-32 h-32 object-contain mx-auto" />
        <h1 class="text-5xl font-bold tracking-tight text-slate-800">Welcome to <span class="text-emerald-500">Teardrops</span></h1>
        <p class="text-lg">
            Your application is ready to go! Teardrops is a lightweight PHP framework designed for simplicity and performance.
        </p>
    </div>
</body>
</html>