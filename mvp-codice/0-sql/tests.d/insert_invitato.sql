

select assert(insert_invitato() = 0,'insert_invitato: cliente non esiste');
select assert(insert_invitato() = 0,'insert_invitato: prenotazione non esiste');
select assert(insert_invitato() = 0,'insert_invitato: entrambi non esistono');
select assert(insert_invitato() = 0,'insert_invitato: entrambi esistono ma il limite di partecipanti è raggiunto');
select assert(insert_invitato() = 1,'insert_invitato: entrambi esistono');
