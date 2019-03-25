<?php
/**
 * Created by PhpStorm.
 * User: RAMS
 * Date: 25.03.2019
 * Time: 9:54
 */
require_once('FakeNameGeneratorAPI.php');
require_once('FakeNameGeneratorCountries.php');
require_once('FakeNameGeneratorNameSet.php');

$IdentityGenerator = new \FakeNameGenerator\FakeNameGeneratorAPI();
// get record with filters
$identity = $IdentityGenerator->CreateIdentity('Male', \FakeNameGenerator\FakeNameGeneratorNameSet::AMERICAN, \FakeNameGenerator\FakeNameGeneratorCountries::UNITED_STATES);
if ($identity['error'] == false) {
    print_r($identity['userIdentity']);
} else {
    echo 'We hot error ' . $identity['msg'];
}
//get just one random record
$identity = $IdentityGenerator->getRandom();
if ($identity['error'] == false) {
    print_r($identity['userIdentity']);
} else {
    echo 'We hot error ' . $identity['msg'];
}