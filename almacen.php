<?php

class Almacen
{
    private $productos;

    public function __construct($productos)
    {
        $this->productos = $productos;
    }

    /**
     * Ordena la lista de productos por precio de menor a mayor.
     *
     * @return array Lista de productos ordenada por precio.
     */
    public function ordenarProductosPorPrecio(): array
    {
        usort($this->productos, function($a, $b) {
            return $a['precio'] <=> $b['precio'];
        });

        return $this->productos;
    }

    /**
     * Calcula el stock restante para cada producto dado una lista de entradas y salidas.
     *
     * @param array $entradas Lista de entradas de productos (nombre del producto => cantidad).
     * @param array $salidas Lista de salidas de productos (nombre del producto => cantidad).
     * @return array Stock restante para cada producto.
     */
    public function calcularStockRestante(array $entradas, array $salidas): array
    {
        $stock = [];

        // Inicializamos el stock con los productos actuales
        foreach ($this->productos as $producto) {
            $nombre = $producto['nombre'];
            $stock[$nombre] = $producto['stock_inicial'];
        }

        // Sumamos las entradas
        foreach ($entradas as $nombreProducto => $cantidad) {
            if (isset($stock[$nombreProducto])) {
                $stock[$nombreProducto] += $cantidad;
            }
        }

        // Restamos las salidas
        foreach ($salidas as $nombreProducto => $cantidad) {
            if (isset($stock[$nombreProducto])) {
                $stock[$nombreProducto] -= $cantidad;
            }
        }

        return $stock;
    }
}

// Ejemplo de uso

$productos = [
    ['nombre' => 'TV', 'precio' => 500, 'stock_inicial' => 100],
    ['nombre' => 'PC', 'precio' => 300, 'stock_inicial' => 150],
    ['nombre' => 'Nevera', 'precio' => 200, 'stock_inicial' => 200],
];

$almacen = new Almacen($productos);

// Ordenar productos por precio
$productosOrdenados = $almacen->ordenarProductosPorPrecio();
print_r($productosOrdenados);

// Calcular stock restante
$entradas = [
    'TV' => 20,
    'PC' => 10,
];

$salidas = [
    'TV' => 15,
    'Nevera' => 50,
];

$stockRestante = $almacen->calcularStockRestante($entradas, $salidas);
print_r($stockRestante);
