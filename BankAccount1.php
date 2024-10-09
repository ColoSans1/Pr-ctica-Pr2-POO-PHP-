<?php
/*
PrácƟca Pr2 – POO PHP
Crear un programa que simule las operaciones de una cuenta bancaria, incluyendo
- crear una cuenta,
- realizar transacciones (depósitos y retiros),
- manejar estados de cuenta específicos (abierto, cerrado).
- manejar los sobregiros con protección contra sobregiros
Habrá 2 cuentas con las siguientes acciones.

Cuenta bancaria1

1. Cree una nueva cuenta bancaria con un saldo inicial de 400,0.
2. Saque la balanza.
3. Cierra y vuelve a abrir la cuenta.
4. Realice un depósito de +150.0 y muestre el saldo actualizado.
5. Realice un retiro de -25.0 y muestre el saldo actualizado.
6. Intente realizar un retiro de -600,0 (que debería fallar debido a un saldo insuficiente).
7. Generar el saldo final después de todas las transacciones.
8. Cierra la cuenta.
*/

session_start();

// Crear una nueva cuenta bancaria con un saldo inicial de 400.0
if (!isset($_SESSION["cuenta"])) {
    $_SESSION["cuenta"] = [
        "balance" => 400.0,
        "status" => true // La cuenta está activa
    ];
}

// Función para mostrar el saldo
function mostrarSaldo() {
    echo "Saldo actual: " . $_SESSION["cuenta"]["balance"] . "<br>";
}

// Función para cerrar la cuenta
function cerrarCuenta() {
    $_SESSION["cuenta"]["status"] = false;
    echo "La cuenta ha sido cerrada.<br>";
}

// Función para abrir la cuenta
function abrirCuenta() {
    $_SESSION["cuenta"]["status"] = true;
    echo "La cuenta ha sido abierta nuevamente.<br>";
}

// 1. Mostrar el saldo inicial
echo "Saldo inicial [Cuenta Bancaria]: " . $_SESSION["cuenta"]["balance"] . "<br>";

// 3. Cerrar y volver a abrir la cuenta
cerrarCuenta();
abrirCuenta();

// 4. Realizar un depósito de +150.0 y mostrar el saldo actualizado
$_SESSION["cuenta"]["balance"] += 150.0;
echo "Depósito realizado: +150.0<br>";
mostrarSaldo();

// 5. Realizar un retiro de -25.0 y mostrar el saldo actualizado
$_SESSION["cuenta"]["balance"] -= 25.0;
echo "Retiro realizado: -25.0<br>";
mostrarSaldo();

// 6. Intentar realizar un retiro de -600.0 (debería fallar)
if ($_SESSION["cuenta"]["balance"] >= 600.0) {
    $_SESSION["cuenta"]["balance"];
    echo "Error: Saldo insuficiente para realizar el retiro de -600.0<br>";
}

echo "Saldo final después de todas las transacciones: " . $_SESSION["cuenta"]["balance"] . "<br>";

// 8. Cerrar la cuenta
cerrarCuenta();
?>