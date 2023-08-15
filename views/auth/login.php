<main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesion</h1>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>     
        <form method="POST" class="formulario" action="/login">
        <fieldset>
                <legend>Email y Password</legend>

                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Tu Email" id="email" require>

                <label for="password">Teléfono</label>
                <input type="password" name="password" placeholder="Tu Password" id="password" require>
            </fieldset>

            <input type="submit" value="Iniciar Sesíon" class="boton boton-verde">
        </form>
    </main>