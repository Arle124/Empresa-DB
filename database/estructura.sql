CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario VARCHAR(45) NOT NULL,
    clave VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'usuario') DEFAULT 'usuario'
);

CREATE TABLE IF NOT EXISTS reporteMensual (
    id_reporte INT PRIMARY KEY AUTO_INCREMENT,
    mes VARCHAR(20) NOT NULL,
    datos TEXT
);

CREATE TABLE IF NOT EXISTS trabajadores (
    id_trabajador INT PRIMARY KEY AUTO_INCREMENT,
    cc VARCHAR(20) NOT NULL,
    primer_nombre VARCHAR(50) NOT NULL,
    segundo_nombre VARCHAR(50),
    primer_apellido VARCHAR(50) NOT NULL,
    segundo_apellido VARCHAR(50),
    telefono VARCHAR(20) NOT NULL,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo'
);

CREATE TABLE IF NOT EXISTS vehiculo (
    id_vehiculo INT PRIMARY KEY AUTO_INCREMENT,
    placa VARCHAR(20) NOT NULL,
    descripcion TEXT
);

CREATE TABLE IF NOT EXISTS origen (
    id_origen INT PRIMARY KEY AUTO_INCREMENT,
    nombre_origen VARCHAR(100) NOT NULL,
    pago_placa_base DECIMAL(10,2) NOT NULL,
    valor_tonelada DECIMAL(10,2) NOT NULL,
    valor_viaje DECIMAL(10,2) NOT NULL,
    requiere_ferry BOOLEAN DEFAULT FALSE,
    tarifa_ferry_base DECIMAL(10,2) DEFAULT 0.00
);

CREATE TABLE IF NOT EXISTS viaje (
    id_viaje INT PRIMARY KEY AUTO_INCREMENT,
    id_vehiculo INT,
    id_trabajador INT,
    id_origen INT,
    fecha DATE NOT NULL,
    tonelaje DECIMAL(10,2) NOT NULL,
    tipo_pago_conductor ENUM('placa_base', 'por_tonelada') NOT NULL,
    acpm_galones DECIMAL(10,2) NOT NULL,
    precio_acpm DECIMAL(10,2) NOT NULL,
    ferry_usado BOOLEAN DEFAULT FALSE,
    ferry_tarifa DECIMAL(10,2) DEFAULT 0.00,
    pago_placa DECIMAL(10,2) NOT NULL,
    monto_especial DECIMAL(10,2) DEFAULT 0.00,
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculo(id_vehiculo),
    FOREIGN KEY (id_trabajador) REFERENCES trabajadores(id_trabajador),
    FOREIGN KEY (id_origen) REFERENCES origen(id_origen)
);

CREATE TABLE IF NOT EXISTS audit_log (
    id_audit BIGINT PRIMARY KEY AUTO_INCREMENT,
    tabla_nombre VARCHAR(100) NOT NULL,
    accion ENUM('INSERT','UPDATE','DELETE') NOT NULL, 
    usuario_conexion VARCHAR(200),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    registro_id VARCHAR(100),
    detalle TEXT
);