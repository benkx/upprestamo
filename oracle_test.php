<?php
// Script de prueba para conexión a Oracle OCI8

// 1. Configuración de conexión (usando tus datos)
$host = "170.238.239.250";
$port = "1521";
$service_name = "UNIPA1N"; // El nombre de tu instancia
$user = "reporteador";
$password = "reporteador";
$vista = "ACADEMICO.V_FUNCIONARIOS";

// TNS String para la conexión directa OCI8
$tns = "(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = {$host})(PORT = {$port}))) (CONNECT_DATA = (SERVICE_NAME = {$service_name})))";

echo "Intentando conectar a Oracle con TNS: " . $tns . "\n\n";

// 2. Intentar conexión
$conn = @oci_connect($user, $password, $tns, 'AL32UTF8');

if (!$conn) {
    $e = oci_error();
    echo "❌ ERROR: Falló la conexión a Oracle.\n";
    echo "Código de Error: " . $e['code'] . "\n";
    echo "Mensaje: " . $e['message'] . "\n";
    die(1);
}

echo "✅ ÉXITO: Conexión a Oracle establecida correctamente.\n\n";

// 3. Ejecutar consulta de prueba
$sql = "SELECT COUNT(*) AS TOTAL FROM {$vista}";
echo "Ejecutando consulta de prueba: " . $sql . "\n";

$statement = oci_parse($conn, $sql);

if (!oci_execute($statement)) {
    $e = oci_error($statement);
    echo "❌ ERROR: Falló la ejecución de la consulta.\n";
    echo "Mensaje: " . $e['message'] . "\n";
    oci_close($conn);
    die(1);
}

// 4. Mostrar resultado
$row = oci_fetch_array($statement, OCI_ASSOC + OCI_RETURN_NULLS);
$total = $row['TOTAL'] ?? 0;

echo "✅ ÉXITO: Consulta ejecutada correctamente.\n";
echo "Total de registros encontrados en {$vista}: {$total}\n";

// 5. Cerrar conexión
oci_free_statement($statement);
oci_close($conn);

echo "\nPrueba finalizada.\n";
?>
