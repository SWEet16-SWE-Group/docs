

select assert(registrazione() = 1,'registrazione: nuovo');
select assert(registrazione() = 0,'registrazione: mail già registrata');
select assert(registrazione() = 0,'registrazione: null check');
