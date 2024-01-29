<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Entrada</title>
</head>
<body>
    <h1>Actualizar Entrada</h1>
    
    <form id="updateForm">
        <label for="id_mae">ID de mae:</label>
        <input type="text" id="id_mae" name="id_mae" required><br>

        <label for="nombre">Nuevo nombre:</label>
        <input type="text" id="nombre" name="nombre"><br>

        <label for="apodo">Nuevo apodo:</label>
        <input type="text" id="apodo" name="apodo"><br>

        <button type="button" id="putButton">Actualizar con PUT</button>
        <button type="button" id="patchButton">Actualizar con PATCH</button>
    </form>

    <div id="response"></div>

    <script>
        document.getElementById('putButton').addEventListener('click', function () {
            actualizarEntrada('PUT');
        });

        document.getElementById('patchButton').addEventListener('click', function () {
            actualizarEntrada('PATCH');
        });

        function actualizarEntrada(metodo) {
            var id_usuario = document.getElementById('id_usuario').value;
            var id_entrada = document.getElementById('id_entrada').value;
            var titulo = document.getElementById('titulo').value;
            var contenido = document.getElementById('contenido').value;

            var data = new URLSearchParams();
            data.append('id_usuario', id_usuario);
            data.append('id_entrada', id_entrada);
            data.append('titulo', titulo);
            data.append('contenido', contenido);

            fetch('method.php', {
                method: metodo,
                body: data
            })
            .then(function(response) {
                return response.text();
            })
            .then(function(data) {
                document.getElementById('response').textContent = data;
            })
            .catch(function(error) {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>
