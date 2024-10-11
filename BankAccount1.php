<?php
session_start();

// Inicializar cuentas si no existen
if (!isset($_SESSION["cuenta"])) {
    $_SESSION["cuenta"] = [
        "balance" => 400.0, 
        "status" => true, // La cuenta está activa
        "sobregiroPermitido" => 0.0 // Sin protección contra sobregiro por defecto
    ];
}

if (!isset($_SESSION["cuenta2"])) {
    $_SESSION["cuenta2"] = [
        "balance" => 200.0, 
        "status" => true,
        "sobregiroPermitido" => 100.0 // Se permite un sobregiro de hasta 100
    ];
}

// Función para mostrar el saldo
function mostrarSaldo($cuenta) {
    echo "Saldo actual [Cuenta $cuenta]: " . $_SESSION[$cuenta]["balance"] . "<br>";
}

// Función para cerrar la cuenta
function cerrarCuenta($cuenta) {
    $_SESSION[$cuenta]["status"] = false;
    echo "La cuenta $cuenta ha sido cerrada.<br>";
}

// Función para abrir la cuenta
function abrirCuenta($cuenta) {
    $_SESSION[$cuenta]["status"] = true;
    echo "La cuenta $cuenta ha sido abierta nuevamente.<br>";
}

// Función para realizar un depósito
function depositar($cuenta, $monto) {
    if ($_SESSION[$cuenta]["status"]) {
        $_SESSION[$cuenta]["balance"] += $monto;
        echo "Depósito realizado en la cuenta $cuenta: +$monto<br>";
        mostrarSaldo($cuenta);
    } else {
        echo "Error: No se puede realizar un depósito. La cuenta $cuenta está cerrada.<br>";
    }
}

function retirar($cuenta, $monto) {
    if ($_SESSION[$cuenta]["status"]) {
        $saldoDisponible = $_SESSION[$cuenta]["balance"] + $_SESSION[$cuenta]["sobregiroPermitido"];
        if ($saldoDisponible >= $monto) {
            $_SESSION[$cuenta]["balance"] -= $monto;
            echo "Retiro realizado en la cuenta $cuenta: -$monto<br>";
        } else {
            echo "Error: Saldo insuficiente para realizar el retiro de -$monto en la cuenta $cuenta.<br>";
        }
        mostrarSaldo($cuenta);
    } else {
        echo "Error: No se puede realizar un retiro. La cuenta $cuenta está cerrada.<br>";
    }
}

// 1. Mostrar el saldo inicial de ambas cuentas
echo "<h3>Saldo inicial:</h3>";
mostrarSaldo("cuenta");
mostrarSaldo("cuenta2");

// 3. Cerrar y volver a abrir ambas cuentas
echo "<h3>Cerrar y reabrir cuentas:</h3>";
cerrarCuenta("cuenta");
abrirCuenta("cuenta");

cerrarCuenta("cuenta2");
abrirCuenta("cuenta2");

// 4. Realizar un depósito de +150.0 en ambas cuentas y mostrar el saldo actualizado
echo "<h3>Realizar depósito de +150.0:</h3>";
depositar("cuenta", 150.0);
depositar("cuenta2", 150.0);

// 5. Realizar un retiro de -25.0 en ambas cuentas y mostrar el saldo actualizado
echo "<h3>Realizar retiro de -25.0:</h3>";
retirar("cuenta", 25.0);
retirar("cuenta2", 25.0);

// 6. Intentar realizar un retiro de -600.0 (debería fallar por saldo insuficiente)
echo "<h3>Intentar retiro de -600.0:</h3>";
retirar("cuenta", 600.0);
retirar("cuenta2", 600.0);

// 7. Mostrar el saldo final después de todas las transacciones
echo "<h3>Saldo final después de todas las transacciones:</h3>";
mostrarSaldo("cuenta");
mostrarSaldo("cuenta2");

// 8. Cerrar ambas cuentas
echo "<h3>Cerrar cuentas:</h3>";
cerrarCuenta("cuenta");
cerrarCuenta("cuenta2");
?>
