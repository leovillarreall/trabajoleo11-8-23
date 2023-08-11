<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Monto en Caja de Ventas</title>
</head>
<body>
    <h1>Registro de Monto en Caja de Ventas</h1>

<?php


$monto = $_POST['monto'];
// Configuración de la base de datos
$datos_bd = mysqli_connect("localhost", "root", "", "basedatos") or exit ("No se puede conectar con la base de datos");



// Verificar la conexión
if ($datos_bd->connect_error) {
    die("Conexión fallida: " . $datos_bd->connect_error);
}

// Monto límite para el aviso
$limiteAviso = 500000;

// Consulta para obtener el monto actual en la caja de ventas
$sql = "INSERT INTO caja_ventas (id, monto) VALUES (null, '$monto')";
$result = $datos_bd->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cajaVentas = $row["monto"];
    
    // Verificar si la caja de ventas ha alcanzado el monto límite para el aviso
    if ($cajaVentas >= $limiteAviso) {
        // Envío de correo electrónico al encargado
        $encargadoEmail = "encargado@example.com";
        $asunto = "Aviso: Caja de ventas llegó al monto límite";
        $mensaje = "La caja de ventas ha alcanzado el monto límite de $limiteAviso. Por favor, retire el dinero en efectivo.";
        
        mail($encargadoEmail, $asunto, $mensaje);
        
        echo "Se ha enviado un aviso al encargado.";
    } 
    else {
        echo "La caja de ventas está por debajo del monto límite. No se requiere aviso.";
    }
} 
else {
    echo "No se pudo obtener el monto de la caja de ventas.";
}

// Cerrar la conexión a la base de datos
$datos_bd->close();

?>
    <form method="POST">
        <label for="monto">Monto en la caja de ventas:</label>
        <input type="number" step="" name="monto" id="monto" required>
        <button type="submit">Actualizar Monto</button>
    </form>
</body>
</html>