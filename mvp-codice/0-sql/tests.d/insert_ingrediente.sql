

select assert(insert_ingrediente() = 1,'insert_ingrediente: ok');
select assert(insert_ingrediente() = 0,'insert_ingrediente: ristorante non esiste');
