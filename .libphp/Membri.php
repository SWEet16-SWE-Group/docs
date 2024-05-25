<?php

class Membro {
  public function __construct(public $nome) {
  }
  public function __toString() {
    return $this->nome;
  }
}

function alberto_c () { return new Membro('Alberto C.'); }
function alberto_m () { return new Membro('Alberto M.'); }
function bilal_em () { return new Membro('Bilal El M.'); }
function alex_s () { return new Membro('Alex S.'); }
function iulius_s () { return new Membro('Iulius S.'); }
function giovanni_z () { return new Membro('Giovanni Z.'); }
