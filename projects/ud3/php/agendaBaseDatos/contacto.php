<section>
    <h1>Crear, Actualizar o Eliminar Contacto</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="nombreForm">
            Nombre:
        </label>
        <input id="nombreForm" type="text" name="nameForm"><br>
        <label for="correoForm">
            Correo electrónico:
        </label>
        <input id="correoForm" type="email" name="emailForm"><br>
        <label for="telefonoForm">
            Numero de teléfono: 
        </label>
        <input id="telefonoForm" type="tel" name="telephoneForm"><br>
        <input id="crearActualizarForm" type="submit" name="createUpdateForm" value="crear o actualizar">
        <input id="eliminarForm" type="submit" name="deleteForm" value="eliminar">
    </form>
</section>