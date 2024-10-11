<?php
session_start();

// Inicializar BankAccount2 si no existe
if (!isset($_SESSION["BankAccount2"])) {
    $_SESSION["BankAccount2"] = [
        "balance" => 200.0, 
        "status" => true, // La cuenta está activa
        "overdraftLimit" => 100.0 // Sobregiro "Silver" permitido de 100.0
    ];
}

// Función para mostrar el saldo
function mostrarSaldoBankAccount2() {
    echo "Saldo actual [BankAccount2]: " . $_SESSION["BankAccount2"]["balance"] . "<br>";
}

// Función para cerrar la cuenta
function cerrarBankAccount2() {
    if ($_SESSION["BankAccount2"]["status"]) {
        $_SESSION["BankAccount2"]["status"] = false;
        echo "La cuenta BankAccount2 ha sido cerrada.<br>";
    } else {
        echo "Error: La cuenta BankAccount2 ya está cerrada.<br>";
    }
}

// Función para abrir la cuenta
function abrirBankAccount2() {
    if (!$_SESSION["BankAccount2"]["status"]) {
        $_SESSION["BankAccount2"]["status"] = true;
        echo "La cuenta BankAccount2 ha sido abierta nuevamente.<br>";
    } else {
        echo "Error: La cuenta BankAccount2 ya está abierta.<br>";
    }
}

// Función para realizar un depósito
function depositarBankAccount2($monto) {
    if ($_SESSION["BankAccount2"]["status"]) {
        $_SESSION["BankAccount2"]["balance"] += $monto;
        echo "Depósito realizado en la cuenta BankAccount2: +$monto<br>";
        mostrarSaldoBankAccount2();
    } else {
        echo "Error: No se puede realizar un depósito. La cuenta BankAccount2 está cerrada.<br>";
    }
}

// Función para realizar un retiro
function retirarBankAccount2($monto) {
    if ($_SESSION["BankAccount2"]["status"]) {
        $saldoDisponible = $_SESSION["BankAccount2"]["balance"] + $_SESSION["BankAccount2"]["overdraftLimit"];
        if ($saldoDisponible >= $monto) {
            $_SESSION["BankAccount2"]["balance"] -= $monto;
            echo "Retiro realizado en la cuenta BankAccount2: -$monto<br>";
        } else {
            echo "Error: Saldo insuficiente para realizar el retiro de -$monto en la cuenta BankAccount2.<br>";
        }
        mostrarSaldoBankAccount2();
    } else {
        echo "Error: No se puede realizar un retiro. La cuenta BankAccount2 está cerrada.<br>";
    }
}

// 1. Mostrar el saldo inicial de BankAccount2
echo "<h3>Saldo inicial [BankAccount2]:</h3>";
mostrarSaldoBankAccount2();

// 2. Aplicar un sobregiro "Silver" con un límite de 100.0
echo "<h3>Sobregiro Silver aplicado con límite de 100.0.</h3>";

// 3. Realizar un depósito de +100.0 y mostrar el saldo actualizado
echo "<h3>Depósito de +100.0:</h3>";
depositarBankAccount2(100.0);

// 4. Realizar un retiro de -300.0 y mostrar el saldo actualizado (esto debería dejar el saldo en 0.0)
echo "<h3>Retiro de -300.0:</h3>";
retirarBankAccount2(300.0);

// 5. Realizar un retiro de -50.0 (permitido debido al sobregiro), dejando el saldo en -50.0
echo "<h3>Retiro de -50.0 (dentro del sobregiro permitido):</h3>";
retirarBankAccount2(50.0);

// 6. Intentar realizar un retiro de -120.0 (debería fallar por superar el límite de sobregiro)
echo "<h3>Intentar retiro de -120.0 (debería fallar):</h3>";
retirarBankAccount2(120.0);

// 7. Realizar un retiro de -20.0 (dentro del límite de sobregiro) y mostrar el saldo actualizado
echo "<h3>Retiro de -20.0:</h3>";
retirarBankAccount2(20.0);

// 8. Cerrar la cuenta
echo "<h3>Cerrar la cuenta BankAccount2:</h3>";
cerrarBankAccount2();

// 9. Intentar cerrar la cuenta nuevamente (debería fallar)
echo "<h3>Intentar cerrar nuevamente la cuenta (debería fallar):</h3>";
cerrarBankAccount2();
?>
