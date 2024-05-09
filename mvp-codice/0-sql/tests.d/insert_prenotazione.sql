
select assert(insert_prenotazione() = 0, 'insert_prenotazione: ristorante non esiste');
select assert(insert_prenotazione() = 0, 'insert_prenotazione: cliente non esiste');
select assert(insert_prenotazione() = 0, 'insert_prenotazione: entrambi non esistono');
select assert(insert_prenotazione() = 1, 'insert_prenotazione: entrambi esistono');
