-- QUERIES ESTADISTICAS
-- Obtener estadisticas por día del mes
select day(fecha) as diaDelMes, sum(costo) as totalGastos, round(avg(costo)) as promedioValorCosto, min(costo) as costoMinimo, max(costo) as costoMaximo from tablaGastos where costo > 0 and idUsuario = 2 group by day(fecha);
-- Obtener estadisticas por día de la semana
select date_format(fecha, '%a') as diaDeLaSemana, sum(costo) as totalGastos, round(avg(costo)) as promedioValorCosto, min(costo) as costoMinimo, max(costo) as costoMaximo from tablaGastos where costo > 0 and idUsuario = 2 group by date_format(fecha, '%a') order by dayOfWeek(fecha)
-- Obtener estadisticas por mes
select month(fecha) as mes, sum(costo) as totalGastos, round(avg(costo)) as promedioValorCosto, min(costo) as costoMinimo, max(costo) as costoMaximo from tablaGastos where costo > 0 and idUsuario = 2 group by month(fecha);
