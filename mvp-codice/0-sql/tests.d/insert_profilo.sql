

select assert(insert_profilo() = 1,'insert_profilo: account esiste');
select assert(insert_profilo() = 0,'insert_profilo: account non esiste');
