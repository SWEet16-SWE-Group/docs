

select assert(insert_pietanza() = 1,'insert_pietanza: ok');
select assert(insert_pietanza() = 0,'insert_pietanza: ristorante non esiste');
