<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Sistema para Tienda-Taller

## Flujo de trabajo

El sistema gestiona dos flujos principales:

- **Ventas en tienda**: registro (opcional) del cliente, selección de productos con control de stock, cálculo de totales (descuentos e impuestos), registro de pagos y emisión de comprobante.
[Flujo de ventas en tienda](docs/workflow-ventas.md)
###

- **Servicio técnico**: ingreso de equipo, creación de orden de servicio con diagnóstico y estados, aprobación del presupuesto, registro de trabajos y repuestos utilizados, generación de venta asociada, control de inventario y entrega del equipo al cliente.
[Flujo de servicio técnico](docs/workflow-servicio-tecnico.md)


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
