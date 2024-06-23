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

function membri(){
  return [
    (string)alberto_c(),
    (string)bilal_em(),
    (string)alberto_m(),
    (string)alex_s(),
    (string)iulius_s(),
    (string)giovanni_z(),
  ];
}

$membri = membri();

