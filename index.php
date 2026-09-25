<?php
session_start();


class Estudiante {
    public string $codigo;
    public string $nombres;
    public string $apellidos;
    public string $email;
    public string $fechaNacimiento;
    public string $genero;

    public function __construct(string $codigo, string $nombres, string $apellidos, string $email, string $fechaNacimiento, string $genero) {
        $this->codigo = $codigo;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->genero = $genero;
    }
}


if (!isset($_SESSION['pila'])) {
    $_SESSION['pila'] = array_fill(0, 10, null);
    $_SESSION['tope'] = -1;                      
    $_SESSION['capacidad'] = 10;
}

$mensaje = "";
$tipo_mensaje = "";


function size() {
    return $_SESSION['tope'] + 1;
}

function agregar(Estudiante $estudiante) {
    if ($_SESSION['tope'] == $_SESSION['capacidad'] - 1) {
        return false; 
    }
    $_SESSION['tope']++;
   
    $_SESSION['pila'][$_SESSION['tope']] = serialize($estudiante);
    return true;
}

function quitar() {
    if ($_SESSION['tope'] == -1) {
        return null; 
    }
    $estudianteSerializado = $_SESSION['pila'][$_SESSION['tope']];
    $_SESSION['pila'][$_SESSION['tope']] = null;
    $_SESSION['tope']--;
    

    return unserialize($estudianteSerializado);
}

function mostrar() {
    $resultado = [];
 
    for ($i = $_SESSION['tope']; $i >= 0; $i--) {
        if ($_SESSION['pila'][$i] !== null) {
            $resultado[] = unserialize($_SESSION['pila'][$i]);
        }
    }
    return $resultado;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] === 'agregar') {
       
        $nuevoEstudiante = new Estudiante(
            $_POST['codigo'],
            $_POST['nombres'],
            $_POST['apellidos'],
            $_POST['email'],
            $_POST['fechaNacimiento'],
            $_POST['genero']
        );

        if (agregar($nuevoEstudiante)) {
            $mensaje = "Estudiante agregado con éxito a la Pila.";
            $tipo_mensaje = "success";
        } else {
            $mensaje = "Error: La Pila está llena (Stack Overflow).";
            $tipo_mensaje = "error";
        }
    }

    if (isset($_POST['accion']) && $_POST['accion'] === 'quitar') {
        $eliminado = quitar();
        if ($eliminado) {
            $mensaje = "Estudiante removido: " . $eliminado->nombres . " " . $eliminado->apellidos;
            $tipo_mensaje = "warning";
        } else {
            $mensaje = "Error: La Pila está vacía (Stack Underflow).";
            $tipo_mensaje = "error";
        }
    }
}

$estudiantes_pila = mostrar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Estudiantes - Pila en PHP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f9; }
        .container { display: flex; gap: 20px; }
        .form-box, .pila-box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 12px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group select { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn { padding: 10px 15px; border: none; cursor: pointer; color: white; border-radius: 4px; }
        .btn-add { background-color: #28a745; }
        .btn-remove { background-color: #dc3545; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; color: white; }
        .success { background-color: #28a745; }
        .error { background-color: #dc3545; }
        .warning { background-color: #ffc107; color: #212529; }
        .card { border: 1px solid #ccc; padding: 10px; margin-bottom: 8px; background: #fafafa; border-left: 5px solid #007bff; }
    </style>
</head>
<body>

    <h1>Gestión de Estudiantes en Estructura de Datos Pila (PHP Nativo)</h1>
    
    <?php if ($mensaje): ?>
        <div class="alert <?= $tipo_mensaje ?>"><?= $mensaje ?></div>
    <?php endif; ?>

    <div class="container">
   
        <div class="form-box">
            <h2>Agregar Estudiante</h2>
            <form method="POST">
                <input type="hidden" name="accion" value="agregar">
                <div class="form-group">
                    <label>Código:</label>
                    <input type="text" name="codigo" required>
                </div>
                <div class="form-group">
                    <label>Nombres:</label>
                    <input type="text" name="nombres" required>
                </div>
                <div class="form-group">
                    <label>Apellidos:</label>
                    <input type="text" name="apellidos" required>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Fecha de Nacimiento:</label>
                    <input type="date" name="fechaNacimiento" required>
                </div>
                <div class="form-group">
                    <label>Género:</label>
                    <select name="genero" required>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                        <option value="O">Otro</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-add">Agregar a la Pila</button>
            </form>

            <hr>

            <h2>Quitar Estudiante</h2>
            <form method="POST">
                <input type="hidden" name="accion" value="quitar">
                <button type="submit" class="btn btn-remove">Remover del Tope</button>
            </form>
        </div>

    
        <div class="pila-box" style="flex-grow: 1;">
            <h2>Estado de la Pila (Tamaño actual: <?= size() ?>)</h2>
            <?php if (empty($estudiantes_pila)): ?>
                <p>La pila está vacía.</p>
            <?php else: ?>
                <div class="pila-visual">
                    <?php foreach ($estudiantes_pila as $index => $est): ?>
                        <div class="card">
                            <strong>[Tope - <?= $index ?>] Código:</strong> <?= htmlspecialchars($est->codigo) ?> | 
                            <strong>Nombre:</strong> <?= htmlspecialchars($est->nombres . ' ' . $est->apellidos) ?> | 
                            <strong>Email:</strong> <?= htmlspecialchars($est->email) ?> | 
                            <strong>Género:</strong> <?= htmlspecialchars($est->genero) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
