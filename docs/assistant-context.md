# Contexto del asistente – Panel de servicio técnico

Este documento define el contexto, objetivos y reglas de trabajo para el asistente dentro del proyecto de panel de servicio técnico construido con Laravel y Filament. Su foco es dejar claros los modelos, el orden de implementación por fases y cómo deben generarse y ajustarse los Filament Resources asociados.

## Objetivo de esta etapa

- Definir y ajustar todos los modelos con sus scopes, traits y accessors según la tabla consolidada.
- Generar y homogeneizar los Filament Resources indicados por fases, usando etiquetas coherentes en español neutro.
- Dejar una base consistente para poder extender luego el proyecto (validaciones, observers/events, optimización de consultas).

---

## 1. Tabla de modelos con información consolidada

| Modelo        | Accessor | Qué muestra                        | Scopes                    | Traits                                        |
| ------------- | -------- | ---------------------------------- | ------------------------- | --------------------------------------------- |
| User          | Sí       | Nombre (Rol)                       | -                         | HasFactory, Notifiable, SoftDeletes, HasRoles |
| Type          | No       | -                                  | Active                    | -                                             |
| Brand         | No       | -                                  | Active                    | -                                             |
| Status        | No       | -                                  | Active                    | -                                             |
| PaymentMethod | No       | -                                  | Active                    | -                                             |
| Category      | No       | -                                  | Active                    | -                                             |
| Client        | Sí       | Nombre (Documento)                 | NotDeleted                | SoftDeletes                                   |
| Device        | Sí       | Tipo Marca Modelo (SN)             | NotDeleted                | SoftDeletes                                   |
| Service       | Sí       | #ID - Título (Status)              | NotDeleted                | SoftDeletes                                   |
| ServiceLog    | Sí       | Usuario:Status_old→Status_new      | -                         | -                                             |
| ServicePhoto  | Sí       | Nombre (Tipo)                      | -                         | -                                             |
| Product       | No       | -                                  | Active, NotDeleted        | SoftDeletes                                   |
| Stock         | No       | -                                  | -                         | -                                             |
| Sale          | Sí       | Nota #ID-Cliente(Documento)-Status | NotDeleted, Paid, Pending | SoftDeletes                                   |
| Item          | No       | -                                  | -                         | -                                             |
| Payment       | No       | -                                  | -                         | -                                             |
| Part          | No       | -                                  | -                         | -                                             |

---

## 2. Notas importantes sobre modelos

Imports a agregar en cada modelo:

Para modelos con scopes:

```php
use Illuminate\Database\Eloquent\Builder;
Para modelos con SoftDeletes:

php
use Illuminate\Database\Eloquent\SoftDeletes;
Para relaciones (ya presentes en los modelos):

php
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
```

### Orden de implementación recomendado (modelos)

FASE 1 – Catálogos (sin dependencias):

1. User (con accessor + HasRoles)
2. Type (con scope Active)
3. Brand (con scope Active)
4. Status (con scope Active)
5. PaymentMethod (con scope Active)
6. Category (con scope Active)

FASE 2 – Clientes y equipos:

7. Client (con accessor + SoftDeletes + scope NotDeleted)
8. Device (con accessor + SoftDeletes + scope NotDeleted)

FASE 3 – Taller:

9. Service (con accessor + SoftDeletes + scope NotDeleted)
10. ServiceLog (con accessor)
11. ServicePhoto (con accessor + agregar `name` a `$fillable`)

FASE 4 – Inventario:

12. Product (con scopes Active + NotDeleted)
13. Stock (sin cambios)

FASE 5 – Ventas:

14. Sale (con accessor + SoftDeletes + scopes NotDeleted, Paid, Pending)
15. Item (sin cambios)
16. Payment (sin cambios)
17. Part (sin cambios)

### Posibles mejoras futuras

Observers / Events:

- Crear automáticamente Stock cuando se agrega Part a Service.
- Crear automáticamente Stock cuando se agrega Item a Sale.
- Registrar automáticamente ServiceLog cuando cambia status en Service.

Validaciones:

- Agregar FormRequest o Rules en los models si es necesario.

Query optimization:

- Agregar `with()` en relaciones para eager loading en Filament.

Campos adicionales:

- Device: considerar agregar `name` (ya está en `$fillable` de la migración).

---

## 3. Comandos artisan finales (Filament Resources)

Estos comandos definen cómo deben generarse los Filament Resources para cada modelo, organizados por fases. 

### FASE 1: Catálogos

```bash
php artisan make:filament-resource User --generate --soft-deletes --attribute=title
php artisan make:filament-resource Type --simple --attribute=name
php artisan make:filament-resource Brand --simple --attribute=name
php artisan make:filament-resource Status --simple --attribute=name
php artisan make:filament-resource PaymentMethod --simple --attribute=name
php artisan make:filament-resource Category --simple --attribute=name
```

### FASE 2: Clientes y equipos

```bash
php artisan make:filament-resource Client --generate --soft-deletes --attribute=title
php artisan make:filament-resource Device --generate --soft-deletes --attribute=title
```

### FASE 3: Taller

```bash
php artisan make:filament-resource Service --generate --soft-deletes --attribute=title
php artisan make:filament-resource ServiceLog --simple --attribute=title
php artisan make:filament-resource ServicePhoto --simple --attribute=title
```

### FASE 4: Inventario

```bash
php artisan make:filament-resource Product --generate --soft-deletes --attribute=name
php artisan make:filament-resource Stock --simple --attribute=id
```

### FASE 5: Ventas

```bash
php artisan make:filament-resource Sale --generate --soft-deletes --attribute=title
php artisan make:filament-resource Item --simple --attribute=id
php artisan make:filament-resource Payment --simple --attribute=id
php artisan make:filament-resource Part --simple --attribute=id
```

### Script completo (ejecución por fases)

```bash
# FASE 1
php artisan make:filament-resource User --generate --soft-deletes --attribute=title && \
php artisan make:filament-resource Type --simple --attribute=name && \
php artisan make:filament-resource Brand --simple --attribute=name && \
php artisan make:filament-resource Status --simple --attribute=name && \
php artisan make:filament-resource PaymentMethod --simple --attribute=name && \
php artisan make:filament-resource Category --simple --attribute=name && \

# FASE 2
php artisan make:filament-resource Client --generate --soft-deletes --attribute=title && \
php artisan make:filament-resource Device --generate --soft-deletes --attribute=title && \

# FASE 3
php artisan make:filament-resource Service --generate --soft-deletes --attribute=title && \
php artisan make:filament-resource ServiceLog --simple --attribute=title && \
php artisan make:filament-resource ServicePhoto --simple --attribute=title && \

# FASE 4
php artisan make:filament-resource Product --generate --soft-deletes --attribute=name && \
php artisan make:filament-resource Stock --simple --attribute=id && \

# FASE 5
php artisan make:filament-resource Sale --generate --soft-deletes --attribute=title && \
php artisan make:filament-resource Item --simple --attribute=id && \
php artisan make:filament-resource Payment --simple --attribute=id && \
php artisan make:filament-resource Part --simple --attribute=id
```

---

## 4. Convenciones para el asistente

Esta sección define cómo debe comportarse el asistente al trabajar con este repositorio y este documento.

- Los modelos y Resources definidos en las fases (User, Type, Brand, Status, PaymentMethod, Category, Client, Device, Service, ServiceLog, ServicePhoto, Product, Stock, Sale, Item, Payment, Part) se consideran la fuente de verdad del proyecto.
- Si un Filament Resource de esa lista **no existe** todavía en el código, el asistente debe indicarlo explícitamente y sugerir el comando correspondiente de esta sección, por ejemplo:
    - `php artisan make:filament-resource Brand --simple --attribute=name`
    - `php artisan make:filament-resource Client --generate --soft-deletes --attribute=title`  
      reutilizando siempre la variante exacta que aparece en “Comandos artisan finales”.
- Si el Filament Resource **ya existe**, el asistente debe trabajar directamente sobre él sin pedir que se pegue el código completo, describiendo únicamente los cambios a realizar, tales como:
    - Definir o ajustar `protected static ?string $modelLabel` y `protected static ?string $pluralModelLabel` en español neutro.
    - Ajustar textos de navegación (grupo, icono, orden).
    - Ajustar el formulario (`form()`) y la tabla (`table()`), indicando qué campos agregar, mostrar, ocultar o hacer obligatorios.
- El asistente debe considerar este archivo como fuente de verdad. Si hay conflicto entre:
  - lo que “asuma” del código y
  - lo que dice este documento (tabla de modelos, traits, scopes, SoftDeletes, comandos artisan, etc.),
  **siempre debe prevalecer este documento**.
- Al proponer código para un Resource que ya existe (por ejemplo `ClientResource` o `DeviceResource`), el asistente debe:
  - Respetar el modelo, scopes y traits definidos en la tabla de modelos.
  - Respetar la estructura generada por los comandos artisan indicados.
  - Ajustar solo lo necesario (labels, navegación, columnas, filtros) sin eliminar rasgos importantes (SoftDeletes, scopes, relaciones).
- El asistente no debe reescribir completamente una clase existente “desde cero” ignorando el código ya generado, salvo que este documento lo pida explícitamente.


### Reglas específicas para Resources

- Todos los Resources que expongan modelos con timestamps deben incluir las columnas `created_at` y `updated_at` en la tabla, marcadas como columnas ocultables (toggleables) por el usuario.
- Para modelos que usen `SoftDeletes`, los Resources deben incluir el filtro de elementos eliminados (`TrashedFilter`) en sus tablas.
- El asistente no debe inventar campos, relaciones o scopes que no estén definidos en este documento o en el código existente; si algo no está claro, debe preguntarlo o marcarlo explícitamente como propuesta.

---

## 5. Convenciones de navegación en Filament

Para mantener una navegación consistente en el panel:

- Agrupar los Resources en grupos de navegación alineados con las fases de este documento, por ejemplo:
    - “Catálogos” (User, Type, Brand, Status, PaymentMethod, Category).
    - “Clientes y equipos” (Client, Device).
    - “Taller” (Service, ServiceLog, ServicePhoto).
    - “Inventario” (Product, Stock).
    - “Ventas” (Sale, Item, Payment, Part).
- Respetar el mismo orden de fases al ordenar los grupos y los Resources dentro del panel.
- Usar labels en español neutro para los grupos y Resources, evitando términos demasiado locales si no están documentados en este archivo.

---

## 6. Estilo de respuestas del asistente

- El asistente debe **proponer el código completo final** de cada Resource o sección que esté ajustando (por ejemplo, clase `ClientResource` completa, o al menos el bloque completo de propiedades estáticas + métodos `form()` y `table()`), no solo fragmentos sueltos.
- Dicho código debe estar listo para copiar/pegar y reemplazar el existente en `app/Filament/Resources/...`, respetando las convenciones de este archivo.
- El asistente no debe pedirme que pegue el código actual del Resource; debe asumir que puede leerlo directamente del repositorio y, a partir de allí, proponer la versión final ajustada.
- La explicación debe ser breve y directa, describiendo los cambios clave (labels, navegación, columnas, filtros, etc.) sin extenderse en teoría general.
- Debe seguir estrictamente las fases, el “Estado actual” y el “Siguiente paso” definidos en este archivo, sin saltar a otras partes del proyecto.
- Para patrones y buenas prácticas de Filament y Laravel, debe usar como referencia:
    - `https://demo.filamentphp.com/`
    - `https://filamentphp.com/docs/4.x/getting-started`
    - `https://laravel.com/docs/12.x`
      usando estas fuentes solo como guía de estructura y estilo, sin copiar código literal.

    ## 7. Reglas de inspección del repositorio

- Antes de afirmar que un modelo o Resource “no existe”, el asistente debe:
    - Revisar el árbol completo de `app/Models` y `app/Filament/Resources` incluyendo sus subcarpetas.
    - Buscar específicamente rutas como:
        - `app/Filament/Resources/Clients/ClientResource.php`
        - `app/Filament/Resources/Devices/DeviceResource.php`
    - Solo si después de revisar estas rutas no encuentra el archivo, puede sugerir crearlo con `php artisan make:filament-resource ...`.
- Si el archivo sí existe en el repositorio, el asistente **no debe** decir que “no existe” ni sugerir crearlo; debe trabajar sobre la versión existente y proponer el código completo ajustado.

## 8. Estado actual

Fase actual: **Fase 2 – Clientes y equipos**.

Siguiente paso: **Revisar y homogeneizar los Resources de Client y Device según las convenciones de este documento**, asegurando que:

- Ambos Resources existen y usan labels y `modelLabel` / `pluralModelLabel` coherentes en español neutro.
- Están ubicados en un grupo de navegación adecuado (por ejemplo, “Clientes y equipos”), respetando el orden de fases.
- Sus tablas incluyen `created_at` y `updated_at` como columnas ocultables (toggleables).
- Incluyen `TrashedFilter` porque sus modelos usan `SoftDeletes`, de acuerdo con la tabla de modelos.

El asistente debe continuar desde este siguiente paso, eligiendo un Resource concreto (por ejemplo `BrandResource`) y proponiendo los ajustes necesarios según las convenciones de este documento, sin salirse de lo aquí definido.

---

<!-- Proyecto: https://github.com/drfoxsoscomputer/servicio-tecnico
El contexto, reglas, fases y estado actual están en docs/assistant-context.md del repo.
Actúa siguiendo ese archivo (no inventes nada fuera de lo que ahí se define) y continúa desde la fase y el “siguiente paso” que allí se indique.
No inventes estructuras nuevas de Resources desde cero.
Parte del código existente en el repo y ajústalo para cumplir este assistant-context.md.
Si tu propuesta contradice la tabla de modelos, traits o scopes de este documento, está mal. -->
