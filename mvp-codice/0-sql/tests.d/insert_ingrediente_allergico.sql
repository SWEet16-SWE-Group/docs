


select assert(insert_ingrediente_allergico() = 0,'insert_ingrediente_allergico: ingrediente non esiste');
select assert(insert_ingrediente_allergico() = 0,'insert_ingrediente_allergico: allergene non esiste');
select assert(insert_ingrediente_allergico() = 0,'insert_ingrediente_allergico: entrambi non esistono');
select assert(insert_ingrediente_allergico() = 1,'insert_ingrediente_allergico: entrambi esistono');
