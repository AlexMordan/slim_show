<?php

require_once __DIR__."/../../vendor/autoload.php";

use App\Core\EntityManager;
use App\Model\Address;
use App\Model\User;
use GuzzleHttp\Client;

$client = new Client();


$response = $client->request("GET","https://randomuser.me/api/?results=50&nat=us");
$json_users = json_decode($response->getBody()->getContents());

$entityManager = (new EntityManager())->getEntityManager();

$mask = "| %-20.20s | %-40.40s | %-20.20s |\r\n";
printf($mask, "Name", "Email", "Role");
printf($mask,
    str_repeat("-",40),
    str_repeat("-",80),
    str_repeat("-",40));

foreach($json_users->results as $json_user)
{
    $user = new User();
    $address = new Address();
    $user->setFullName( sprintf("%s %s", $json_user->name->first, $json_user->name->last));
    $user->setEmail($json_user->email);
    $user->setLogin($json_user->login->username);
    $user->setPassword(password_hash("1",PASSWORD_DEFAULT));
    $user->setRole(User::LIST_ROLES[array_rand(User::LIST_ROLES)]);
    $user->setAvatar($json_user->picture->large);

    $address->setCity($json_user->location->city);
    $address->setCountry($json_user->location->state);
    $address->setPostalCode($json_user->location->postcode);
    $address->setStreet($json_user->location->street);

    $user->setAddress($address);
    printf(
        $mask,
        $user->getFullName(),
        $user->getEmail(),
        $user->getRole()
    );

    $entityManager->persist($user);
}
printf($mask,
    str_repeat("-",40),
    str_repeat("-",80),
    str_repeat("-",40));
$entityManager->flush();
