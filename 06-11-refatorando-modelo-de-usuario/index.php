<?php
require __DIR__ . '/../fullstackphp/fsphp.php';
fullStackPHPClassName("06.11 - Refatorando modelo de usuário");

require __DIR__ . "/../source/autoload.php";

/*
 * [ find ]
 */
fullStackPHPClassSession("find", __LINE__);

$model = new \Source\Models\Medico();
$user = $model->find("idMedico = :id", "id=1");
var_dump($user);

/*
 * [ find by id ]
 */
fullStackPHPClassSession("find by id", __LINE__);

$user = $model->findById(2);
var_dump($user);


/*
 * [ find by email ]
 */
fullStackPHPClassSession("find by email", __LINE__);

$user = $model->findByEmail("leonardo36@email.com.br");
var_dump($user);

/*
 * [ all ]
 */
fullStackPHPClassSession("all", __LINE__);

$list = $model->all(2);
var_dump($list);


/*
 * [ save ]
 */
fullStackPHPClassSession("save create", __LINE__);

//$user = $model->bootstrap(
//    "Robson",
//    "003.456.988-44",
//    "55(99)98774-2311",
//    "cursos@upinside.com.br",
//    "2",
//    "Sim",
//    "11",
//    "1",
//    "110011"
//);
//
//if ($user->save()) {
//    echo message()->success("Cadastro realizado com sucesso!");
//} else {
//    echo $user->message();
//    echo message()->info($user->message()->json());
//}


/*
 * [ save update ]
 */
fullStackPHPClassSession("save update", __LINE__);

$user = (new \Source\Models\Medico())->findById(3356);
$user->NomeMedico = "Marcelo";
$user->email = "mljinformatica@gmail.com";
$user->Estado_idEstado = "53";
$user->Municipio_id = "530010";

if ($user->save()) {
    echo message()->success("Dados atualizados com sucesso!");
} else {
    echo $user->message();
    echo message()->info($user->message()->json());
}

var_dump($user);
