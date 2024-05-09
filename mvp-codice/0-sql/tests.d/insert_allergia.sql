

select assert(insert_allergia() = 1,'insert_allergia: entrambi esistono');
select assert(insert_allergia() = 0,'insert_allergia: entrambi non esistono');
select assert(insert_allergia() = 0,'insert_allergia: cliente non esiste');
select assert(insert_allergia() = 0,'insert_allergia: allergene non esiste');
