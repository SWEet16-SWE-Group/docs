

select assert(insert_recensione() = 0, 'ristoratore non esiste');
select assert(insert_recensione() = 0, 'cliente non esiste');
select assert(insert_recensione() = 0, 'entrambi non esistono');
select assert(insert_recensione() = 0, 'entrambi esistono ma appartengono allo stesso account');
select assert(insert_recensione() = 0, 'entrambi esistono ma il cliente non ha una prenotazione pagata con il ristoratore');
select assert(insert_recensione() = 1, 'entrambi esistono');
