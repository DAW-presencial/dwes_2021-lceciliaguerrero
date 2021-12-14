<section>
    <h1>Crear, Actualizar o Eliminar Contacto</h1>
    <p>Requeridos <abbr title="requeridos">*</abbr>.</p>
    <form method="post" enctype="multipart/form-data">
        <label for="nombreForm">
            Nombre: <abbr title="requerido">*</abbr>
        </label>
        <input id="nombreForm" type="text" name="nameForm" placeholder="Escribe el nombre del contacto"
               title="Tienes que escribir un nombre con los siguientes parámetros.
1. Tiene que tener un máximo de 30 caracteres alfanuméricos." aria-required="true">
        <label for="correoForm">
            Correo electrónico: <abbr title="requerido">*</abbr>
        </label>
        <input id="correoForm" type="email" name="emailForm" placeholder="Escribe el correo electrónico del contacto."
               title="Tienes que escribir una dirección de correo electrónico con los siguientes parámetros.
1. Tiene que tener un nombre.
2. Tiene que tener un dominio.
3. Tiene que tener una extensión." aria-required="true">
        <label for="telefonoForm">
            Numero de teléfono: <abbr title="requerido">*</abbr>
        </label>
        <input id="telefonoForm" type="tel" name="telephoneForm" placeholder="Escribe el numero de teléfono del contacto."
               aria-required="true">
        <input id="crearActualizarForm" type="submit" name="createUpdateForm" value="crear o actualizar">
        <input id="eliminarForm" type="submit" name="deleteForm" value="eliminar">
    </form>
</section>