<?php

namespace App\Entities;

/**
 * @Entity
 * @Table(name="historico_escolar")
 */
class HistoricoEscolar
{
  /**
   * @Id @Column(type="integer")
   * @GeneratedValue(strategy="AUTO")
   **/
  private $id;
  /** @Column(type="text") **/
  private $observacoes;

  public function setObservacoes($observacoes)
  {
    $this->observacoes = $observacoes;
  }

}