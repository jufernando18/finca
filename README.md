# finca
Software de facil uso. Pensado para personas con poco o casi nulo acercamiento a un computador o dispositivo movil.
Este programa está pensado para que ayudar a las personas con el registro de gastos e ingresos, de modo que puedan 
tener una percepción más directa de la forma en que están administrando su dinero.

En el front corre html, css, Vue, Vanilla y JQuery js.
En el back corre php(con la extensión mysql) y SQLServer.

Tomar el modelo de base de datos que se proporciona en SQLdb_template.sql
Actualmente, requiere una base de datos con 2 tablas, una para ingresos y otra para gastos.
Los nombres tanto de base de datos como de las tablas se pueden configurar a gusto usando 
como base el archivo Agenda/db_connect_template.php . Para usarlo, cambiar nombre por db_connect.php, el cual no tendrá 
seguimiento por parte de Git.

Los mensajes por defecto están en el archivo js/es_template.js. Para usarlos, seguir el patron que se decribió para db_connect.
