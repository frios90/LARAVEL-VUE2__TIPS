Sistema de Gestión de Propinas para Bares y Restaurantes
Descripción del Sistema

Sistema backend construido con Laravel 5.6 que expone una API REST para la gestión de propinas en establecimientos de hospitalidad. El frontend es una SPA desarrollada con Vue 2 que se consume después de la autenticación inicial manejada por Laravel mediante sesiones.

El sistema permite al administrador generar turnos, asignar montos de propinas segmentados por labor y colaborador, agilizando la distribución de propinas al finalizar cada turno.
Características del Sistema
Módulo de Administración de Colaboradores

    Gestión de usuarios con roles (Administrador, Supervisor, Colaborador)

    Definición de puestos/labores (Camarero, Bartender, Cocinero, Ayudante, Hostess, etc.)

    Asignación de porcentajes de participación por puesto

    Historial de colaboradores por turno

Módulo de Turnos

    Creación y gestión de turnos (Mañana, Tarde, Noche, Especial)

    Asignación de colaboradores a cada turno

    Registro de hora de inicio y fin de turno

    Estado del turno: Activo, Cerrado, En Liquidación

    Capacidad de tener múltiples turnos simultáneos

Módulo de Gestión de Propinas

    Registro de monto total de propinas por turno

    Distribución automática según porcentajes predefinidos por labor

    Soporte para propinas en efectivo y tarjeta

    División equitativa dentro del mismo puesto

    Ajustes manuales permitidos por administrador

Módulo de Distribución

    Cálculo automático de propinas por colaborador

    Segmentación por:

        Labor desempeñada

        Horas trabajadas en el turno

        Porcentaje de participación predefinido

    Vista previa de distribución antes de confirmar

    Confirmación y cierre de distribución por turno

Módulo de Registros y Liquidación

    Historial de propinas por colaborador

    Liquidación por períodos (diario, semanal, mensual)

    Exportación de liquidaciones

    Registro de pagos realizados

    Comprobante individual por colaborador

Módulo de Reportes y Dashboards

    Dashboard con gráficos comparativos (Chart.js + Vue Chart.js)

    Comparativa de propinas entre colaboradores

    Evolución de propinas por turno

    Ranking de colaboradores con mayores propinas

    Comparativa por puestos/labores

    Tendencia de propinas por día/semana/mes

    Reporte de productividad por turno

Tipos de Distribución Soportados

    Por porcentaje fijo por puesto (ej: Bartender 35%, Camarero 40%, Cocina 25%)

    Por horas trabajadas (prorrateo según tiempo en turno)

    Mixto (base porcentaje + ajuste por horas)

    Distribución manual para casos especiales

Escalabilidad

    Soporte desde equipos pequeños (2-3 colaboradores) hasta equipos grandes (50+ colaboradores)

    Cálculos optimizados para procesar grandes volúmenes de datos

    Interfaz responsive para uso en dispositivos móviles (ideal para uso en barra)

Características Técnicas

    API RESTful con Laravel 5.6

    SPA con Vue 2 + Vue Router

    Estado global con Vuex

    Gráficos interactivos con Chart.js + Vue Chart.js

    Autenticación vía sesiones Laravel

    Validación de formularios con VeeValidate

    Notificaciones con SweetAlert2 y Vue Toasted

    Tablas dinámicas y ordenables con Vue Tables 2

    Formateo de moneda con Vue Currency Filter

    Formateo de fechas con Vue Moment

Estados del Flujo

Turno:

    Programado

    En Curso

    En Cierre (liquidando propinas)

    Cerrado

    Pagado

Distribución de Propinas:

    Calculada (preliminar)

    Confirmada por Administrador

    Pagada al Colaborador

Reglas de Negocio

    Un colaborador puede estar en múltiples turnos (diferentes días)

    Las propinas no pueden distribuirse hasta que el turno esté cerrado

    El sistema valida que el total distribuido no supere el monto registrado

    Soporte para propinas agrupadas (pool común) o individuales

    Registro de auditoría de todas las modificaciones en distribuciones

Seguridad

    Middleware de autenticación en todas las rutas

    Verificación de permisos por rol

    Solo Administradores pueden modificar porcentajes de distribución

    Logs de acciones críticas (apertura/cierre de turnos, distribuciones)

Dashboards y Visualizaciones

    Gráfico de barras comparativo por colaborador

    Gráfico de líneas de tendencia temporal

    Gráfico circular de distribución por puesto

    Tarjetas con indicadores clave (total propinas, promedio por colaborador, etc.)

    Filtros por rango de fechas, turno, puesto