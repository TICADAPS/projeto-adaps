<?php

namespace Source\Models;

use Source\Core\Model;


class CalendarioTutoria extends Model
{
/** @var array $safe no update or create */
protected static $safe = ["id", "created_at", "updated_at"];

/** @var string $entity database table */
protected static $entity = "calendariotutoria";

/** @var array $required table fileds */
protected static $required = [
 "idCalendario",
 "Edicao",
 "PeriodoInicial",
 "PeriodoFinal",
 "FlagAtivo"
];

public function bootstrap(
 string $idCalendario,
 string $Edicao,
 string $PeriodoInicial,
 string $PeriodoFinal,
 string $FlagAtivo
): ?CalendarioTutoria {
$this->idCalendario = $idCalendario;
$this->Edicao = $Edicao;
$this->PeriodoInicial = $PeriodoInicial;
$this->PeriodoFinal = $PeriodoFinal;
$this->FlagAtivo = $FlagAtivo;
return $this;
}

public function load(int $id, string $columns = "*"): ?CalendarioTutoria
{
$load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE idCalendario = :id", "id={$id}");
if ($this->fail() ||!$load->rowCount()) {
$this->message = "Calendário não encontrado para o id informado";
return null;
}
return $load->fetchObject(__CLASS__);
}
/**
 * @param string $terms
 * @param string $params
 * @param string $columns
 * @return null|User
 */
public function find(string $terms, string $params, string $columns = "*"): ?CalendarioTutoria
{
$find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
if ($this->fail() ||!$find->rowCount()) {
return null;
}
return $find->fetchObject(__CLASS__);
}


public function findById(int $id, string $columns = "*"): ?CalendarioTutoria
{
return $this->find("idCalendario = :id", "id={$id}", $columns);
}

/**
 * @param int $limit
 * @param int $offset
 * @param string $columns
 * @return array|null
 */
public function all(int $limit = 30, int $offset = 0, string $columns = "*"): ?array
{
$all = $this->read("SELECT {$columns} FROM " . self::$entity . " LIMIT :limit OFFSET :offset",
 "limit={$limit}&offset={$offset}");

if ($this->fail() ||!$all->rowCount()) {
return null;
}
return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
}


/**
 * @return null|User
 */
public function destroy(): ?CalendarioTutoria
{
if (!empty($this->id)) {
$this->delete(self::$entity, "idMedico = :id", "id={$this->id}");
}

if ($this->fail()) {
$this->message = "Não foi possível remover o usuário";
return null;
}

$this->message = "Usuário removido com sucesso";
$this->data = null;
return $this;
}
}