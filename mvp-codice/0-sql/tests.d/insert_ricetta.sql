

select assert(insert_ricetta() = 0,'insert_ricetta: ingrediente non esiste');
select assert(insert_ricetta() = 0,'insert_ricetta: pietanza non esiste');
select assert(insert_ricetta() = 0,'insert_ricetta: entrambi non esistono');
select assert(insert_ricetta() = 0,'insert_ricetta: entrambi esistono ma in ristoranti diversi');
select assert(insert_ricetta() = 1,'insert_ricetta: entrambi esistono nello stesso ristorante');
