
registrati :: mail -> password -> idaccount -- side effect di registrare le credenzialli, altrimenti 0
accedi :: mail -> password -> idaccount -- lettura per le credenziali
insert_profilo :: idaccount -> idprofilo -- side effect di creare un nuovo profilo per l'account, altrimenti 0
insert_cliente :: idprofilo -> ... -> bool_successo -- evolve il profilo staminale in profilo cliente
insert_ristoratore :: idprofilo -> ... -> bool_successo -- evolve il profilo staminale in profilo ristoratore
json_profili_by_idaccount :: idaccount -> json_profili -- dato l'account abbiamo il json con tutti i profili di quell'account
json_prenotazioni_by_idprofilo :: idprofilo -> prenotazioni -- dato il profilo abbiamo le prenotazioni, come stamparle è un problema del client
json_ordinazioni_by_prenotazione :: idprenotazione -> ordinazioni -- data la prenotazione ritorniamo tutte le ordinazioni di essa
insert_prenotazione :: idristoratore -> idcliente -> ... -> bool_successo -- crea la prenotazione 1 se successo, altrimenti 0
insert_invitato :: idprenotazione -> idcliente -> bool_successo -- aggiunge l'invitato alla prenotazione
insert_ordinazione :: idprenotazione -> idinvitato -> idpietanza -> idordinazione -- salvataggio dell'ordinazione
delete_ordinazione :: idordinazione -> bool_successo -- eliminazione dell'ordinazione e degli ingredienti aggiunti / rimossi associati
add_ingrediente_ordinazione :: idordinazione -> idingrediente -> bool_successo -- modifica degli ingredienti per l'ordinazione
del_ingrediente_ordinazione :: idordinazione -> idingrediente -> bool_successo -- modifica degli ingredienti per l'ordinazione


insert_ingrediente :: idristoratore -> ingrediente -> bool_successo
insert_pietanza :: idristoratore -> pietanza -> ... -> bool_successo
insert_ricetta :: idpietanza -> idingrediente -> bool_successo
insert_allergene :: idingrediente -> idallergene -> bool_successo

insert_allergia :: idcliente -> idallergene -> bool_successo

insert_recensione :: idcliente -> idristoratore -> ... -> bool_successo


