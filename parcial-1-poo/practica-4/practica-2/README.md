# Práctica 2 – Herencia en PHP

## Objetivo
Implementar herencia en PHP reutilizando la clase Usuario y creando una clase Admin que extiende sus funcionalidades.

## Explicación de la herencia aplicada
La clase Admin hereda los atributos y métodos de la clase Usuario mediante la palabra clave `extends`.

Esto permite reutilizar código sin volver a declarar propiedades como nombre y correo.

## Diferencias entre Usuario y Admin

Usuario:
- Clase base
- Define atributos nombre y correo
- Contiene getters y setters

Admin:
- Clase derivada
- Hereda de Usuario
- Agrega el método `getRol()`

## Instrucciones de ejecución

Abrir en navegador:

http://localhost/desarrollo-web-avanzado-fimaz-uas/parcial-1-poo/practica-2/index.php