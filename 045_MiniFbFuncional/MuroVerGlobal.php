<?php
    
    require_once "_com/_Varios.php";
    require_once "_com/dao.php";

    // Comprobamos si hay sesión-usuario iniciada.
    //   - Si la hay, no intervenimos. Dejamos que la pág se cargue.
    //     (Mostrar info del usuario logueado y tal...)
    //   - Si NO la hay, redirigimos a SesionInicioFormulario.php

    if (!haySesionRamIniciada() && !intentarCanjearSesionCookie()) {
        dao::redireccionar("SesionInicioFormulario.php");
    }

    $posibleClausulaWhere= "";
    $publicaciones= dao::publicacionObtenerTodas($posibleClausulaWhere);
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php dao::pintarInfoSesion(); ?>

<h1>Muro global</h1>

<form action="PublicacionNuevaCrear.php?ficha=MuroVerGlobal.php" method="POST">
    <label>Asunto:</label><br/>
    <input type="text" name="asunto" id="asunto"><br/>
    <label>Destacado Hasta:</label>
    <input type="date" name="destacadoHasta" id="destacadoHasta"><br/>
    <label>Contenido:</label><br/>
    <textarea name="nuevaPublicacion" id="nuevaPublicacion" rows="4" cols="50"></textarea>
    <input type="submit" value="Publicar">
</form>

<table border='1'>

    <tr>
        <th>Id</th>
        <th>Fecha</th>
        <th>Emisor</th>
        <th>Destinatario</th>
        <th>DestacadoHasta</th>
        <th>Asunto</th>
        <th>Contenido</th>
        <th>Eliminar</th>
    </tr>

    <?php
    foreach ($publicaciones as $publicacion) { ?>
        <tr>
            <?php $emisor= dao::usuarioObtenerPorId($publicacion->getEmisorId());
                if($publicacion->getDestinatarioId() != null) {
                    $destinatario= dao::usuarioObtenerPorId($publicacion->getDestinatarioId()); 
                } else {
                    $destinatario= null; } ?>
            <td><?= $publicacion->getId() ?></td>
            <td><?= $publicacion->getFecha() ?></td>
            <td><a href="MuroVerDe.php?id=<?= $publicacion->getEmisorId() ?>"><?= $emisor->getNombre() ?></a></td>
            <?php if($destinatario != null) { ?>
                <td><a href="MuroVerDe.php?id=<?= $destinatario->getId() ?>"><?= $destinatario->getNombre() ?></a></td>
            <?php } else {?>
                <td><?= $publicacion->getDestinatarioId() ?></td>
            <?php } ?>
            <td><?= $publicacion->getDestacadoHasta() ?></td>
            <td><?= $publicacion->getAsunto() ?></td>
            <td><?= $publicacion->getContenido() ?></td>
            <?php if($emisor->getId() == $_SESSION["id"]) { ?>
                <td><a href="PublicacionEliminar.php?ficha=MuroVerGlobal.php&id=<?= $publicacion->getId() ?>">X</a></td>
            <?php } ?>
        </tr>
    <?php } ?>

</table>

<a href="MuroVerDe.php?id=<?= $_SESSION["id"] ?>">Ir a mi muro.</a>

</body>

</html>