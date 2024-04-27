

select assert(insert_ordinazione() = 0, 'insert_ordinazione: la pietanza non esiste');
select assert(insert_ordinazione() = 0, 'insert_ordinazione: l''invitato non esiste');
select assert(insert_ordinazione() = 0, 'insert_ordinazione: la pietanza non è del ristorante collegato alla prenotazione collegata all''invito');
select assert(insert_ordinazione() = 1, 'insert_ordinazione: la pietanza è del ristorante collegato alla prenotazione collegata all''invito');
