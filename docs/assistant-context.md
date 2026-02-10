# Contexto para Assistant – Proyecto Servicio Técnico

## 1. Proyecto

- Repo principal: https://github.com/drfoxsoscomputer/servicio-tecnico
- Demo de referencia (UI / navegación): https://demo.filamentphp.com/

El assistant debe alinear las sugerencias con este proyecto y no inventar módulos o estructuras fuera de lo definido aquí. [web:1][web:149]

---

## 2. Fuentes de verdad

Siempre revisar en este orden:

1. `database.dbml`
2. Documentación en `docs/` (por ejemplo, `workflow-servicio-tecnico.md`)
3. README del proyecto
4. Código actual en `app/Models` y `app/Filament/Resources`

Si algo que el assistant propone no coincide con estos archivos, se debe ajustar a lo que dicen estas fuentes. [web:1]

---

## 3. Tecnologías y estilo

- Laravel + Filament **v4**. [web:134]
- Uso de **Resources** y, cuando aplique, clases `Schemas` para formularios/tablas.
- Navegación de Filament:
    - Usar principalmente `modelLabel` y `pluralModelLabel` para los nombres visibles del recurso (singular/plural).
    - El sidebar usa por defecto `pluralModelLabel` como texto del menú.
    - Solo definir `navigationLabel` cuando se quiera un nombre distinto en el menú.
    - Usar `navigationGroup` (string o enum) para agrupar recursos.
    - Usar `navigationSort` para ordenar dentro de cada grupo. [web:149][web:134]
- Idioma: español neutro.
- Dominio: sistema de **servicio técnico + tienda**, no solo inventario.

---

## 4. Navegación actual del panel

Grupos y recursos:

- **(Sin grupo, arriba)**
    - Clientes
        - `modelLabel`: `cliente`
        - `pluralModelLabel`: `clientes`
        - Sin `navigationGroup` (aparece solo arriba).

- **Equipos**
    - Equipos (Devices)
    - Tipos
    - Marcas

- **Tienda**
    - Categorías
    - Métodos de pago
    - Estados

- **Seguridad**
    - Usuarios
    - Roles (Shield)

Reglas de navegación:

- Cada Resource debe tener `modelLabel` y `pluralModelLabel` en español.
- Cada Resource (excepto Clientes) debe tener un `navigationGroup` que coincida con uno de los grupos definidos arriba.
- Solo usar `navigationLabel` si el texto del menú debe ser distinto del `pluralModelLabel`.
- Usar `navigationSort` para que el orden dentro de cada grupo sea coherente.

---

## 5. Fases de trabajo

> Esta sección se debe ir actualizando a medida que avanza el proyecto.

### Fase 2 – Recursos base y navegación

Objetivo: tener listo el esqueleto del panel (recursos base y navegación organizada).

Incluye:

- Resources y modelos base:
    - Clients
    - Devices
    - Types
    - Brands
    - Categories
    - PaymentMethods
    - Statuses
    - Users
    - Roles / Shield
- Formularios:
    - Campos claros, labels y placeholders en español.
    - Uso de `relationship()` para selects.
    - En Device:
        - Tabs para información de cliente, detalles del equipo y notas.
        - Selects de cliente/tipo/marca con búsqueda y `createOptionForm` reutilizando sus formularios/resources.
- Tablas:
    - Columnas principales (cliente, equipo, etc.).
    - `created_at` / `updated_at` como columnas toggleables.
    - Filtros de soft delete (`TrashedFilter`) donde haya `SoftDeletes`. [web:137][web:141]
- Navegación:
    - Grupos definidos como en la sección 4.
    - `navigationSort` coherente dentro de cada grupo.

### Fase 3 – Servicio técnico (próxima)

Debe ajustarse a `workflow-servicio-tecnico.md` y `database.dbml`. [web:1]

- Modelo y migración de `Service` (u orden de servicio).
- `ServiceResource`:
    - Campos principales: cliente, equipo, estado, categoría, descripción del problema, notas internas, fechas clave, totales.
- RelationManagers:
    - Servicios dentro de Client.
    - Servicios dentro de Device. [web:34][web:167]

Fases posteriores (por ejemplo, ventas en tienda) se documentarán cuando se inicien.

---

## 6. Reglas para el Assistant

Estas reglas aplican siempre, en cualquier conversación sobre este proyecto:

1. **No salir del contexto del proyecto**
    - Verificar primero `database.dbml`, README y documentación en `docs/` antes de proponer nuevos modelos, campos, relaciones o flujos. [web:1]
    - No inventar módulos que no estén alineados con las fases o el dominio descrito.

2. **Respetar las fases**
    - Si se está trabajando en Fase 2, no diseñar Fase 3 completa salvo que el usuario lo pida explícitamente.
    - Al pasar de una fase a otra, actualizar esta sección para reflejar el nuevo objetivo.

3. **Proponer de forma puntual**
    - Un paso concreto a la vez (por ejemplo: “ajustar DeviceForm”, “definir navegación de X”), esperando validación antes de avanzar.
    - Evitar proponer muchos cambios distintos en un mismo mensaje.

4. **Nombres y UX**
    - Usar nombres y grupos coherentes con un sistema de servicio técnico + tienda, tomando como referencia también la demo de Filament. [web:149][web:160]
    - Mantener labels, placeholders y textos visibles en español neutro.
    - Seguir los patrones de Filament v4 (Resources, Schemas, navegación, etc.). [web:134]

5. **Uso de Resources y navegación**
    - Aprovechar `modelLabel` / `pluralModelLabel` como nombres por defecto para el menú.
    - Añadir `navigationGroup` y `navigationSort` en cada Resource según la estructura de la sección 4.
    - Solo usar `navigationLabel` cuando se requiera un texto de menú diferente del plural del modelo.

6. **Actualización de este documento**
   - Cada vez que se acuerde una **nueva regla**, un cambio importante de navegación o se **complete una fase o sub‑tarea importante**, este archivo (`docs/assistant-context.md`) debe actualizarse para reflejar el nuevo estado (fase actual, último trabajo realizado y siguiente paso).
   - En nuevas conversaciones, el usuario debe compartir o referenciar la versión actual de este documento para que el assistant trabaje siempre con el contexto más reciente.

## 7. Estado actual y siguiente paso

- Fase actual: Fase 2 – Recursos base y navegación.
- Último trabajo realizado:
    - Ajuste de navegación (grupos: Equipos, Tienda, Seguridad; Clientes sin grupo).
    - DeviceResource form/table refinados.
- Siguiente paso sugerido para el assistant:
    - Revisar y homogeneizar **TODOS** los Resources base (Brand, Category, PaymentMethod, Status, Type, User) para:
        - Labels en español coherentes.
        - Columnas de tabla (created_at/updated_at toggleables).
        - Filtros de soft delete donde aplique.

> IMPORTANTE: Al completar este “siguiente paso”, el assistant y el usuario deben actualizar esta sección (fase, último trabajo y próximo paso) antes de continuar con la fase siguiente.

---


<!-- Proyecto: https://github.com/drfoxsoscomputer/servicio-tecnico
El contexto, reglas, fases y estado actual están en docs/assistant-context.md del repo.
Actúa siguiendo ese archivo (no inventes nada fuera de lo que ahí se define) y continúa desde la fase y el “siguiente paso” que allí se indique. -->
