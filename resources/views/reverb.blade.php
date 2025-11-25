<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prueba Reverb</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="p-6">

    <h1 class="text-2xl font-bold">Prueba Reverb</h1>

    <div id="mensajes" class="mt-4 border p-4 h-60 overflow-y-auto"></div>

    <script>
        window.Echo.channel('prueba-reverb')
            .listen('PruebaReverb', (e) => {
                let div = document.getElementById('mensajes');
                div.innerHTML += `<p><strong>Mensaje:</strong> ${e.mensaje}</p>`;
            });
    </script>

</body>
</html>
