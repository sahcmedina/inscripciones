<?php



// vista M (para cada deposito)
CREATE OR REPLACE VIEW vista_m_dep1 AS
SELECT mat.codigo, m.total
FROM  material mat LEFT JOIN inv_m AS m  ON mat.id = m.fk_material
WHERE m.ult= 1 AND m.fk_deposito = 1;

// vista P (para cada deposito)
CREATE OR REPLACE VIEW vista_p_dep1 AS
SELECT mat.codigo, p.total
FROM  material mat LEFT JOIN inv_p AS p  ON mat.id = p.fk_material
WHERE p.ult= 1 AND p.fk_deposito = 1;

// vista A (para cada deposito y cada arato)
CREATE OR REPLACE VIEW vista_a1_dep1 AS
SELECT mat.codigo, a.total
FROM  material mat LEFT JOIN inv_a AS a  ON mat.id = a.fk_material
WHERE a.ult= 1 AND a.fk_deposito = 1 AND a.fk_arato = 1;

CREATE OR REPLACE VIEW vista_a8_dep1 AS
SELECT mat.codigo, a.total
FROM  material mat LEFT JOIN inv_a AS a  ON mat.id = a.fk_material
WHERE a.ult= 1 AND a.fk_deposito = 1 AND a.fk_arato = 8;

CREATE OR REPLACE VIEW vista_a10_dep1 AS
SELECT mat.codigo, a.total
FROM  material mat LEFT JOIN inv_a AS a  ON mat.id = a.fk_material
WHERE a.ult= 1 AND a.fk_deposito = 1 AND a.fk_arato = 10;

// debo guardar los nombres de las vistas en una tabla.. para crear la vista_inventario

// vista INVENTARIO para deposito 1
CREATE OR REPLACE VIEW vista_inventario_1 AS
SELECT mat.codigo, vm.total as M, vp.total as P, 
       va1.total as A_1,
			 va8.total as A_8,
			 va10.total as A_10
FROM material mat 
LEFT JOIN vista_m_dep1 vm     ON mat.codigo = vm.codigo
LEFT JOIN vista_p_dep1 vp     ON mat.codigo = vp.codigo
LEFT JOIN vista_a1_dep1  va1  ON mat.codigo = va1.codigo
LEFT JOIN vista_a8_dep1  va8  ON mat.codigo = va8.codigo
LEFT JOIN vista_a10_dep1 va10 ON mat.codigo = va10.codigo;

?>